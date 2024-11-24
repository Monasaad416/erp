<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\TAccount;
use App\Models\Treasury;
use App\Models\Transaction;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewAssetAddedFinancilas
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

        $asset = $event->asset;
        //dd($asset);
        $supplier_id = $event->supplier_id;
        $supplier =  Supplier::where('id',$supplier_id)->first();
        $assetDepreciationsSum = $event->accountDepreciationsSum;//مخصص اهلاك الاصل
        $assetDepreciationExpenses= $event->accountDepreciationExpenses;//مصروفات اهلاك الاصل

        $entry = getNextJournalEntryNum();

        $debitAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$asset->account_num)->first();
      //  dd($debitAccount1);
            if ($asset->payment_type == 'cash') {
            $treasury = Treasury::where('branch_id',$asset->branch_id)->first();
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();


            $transaction = new Transaction();
            $transaction->transaction_type_id = 9;
            $transaction->transactionable_type="App\Models\Asset" ;
            $transaction->transactionable_id= $asset->id ;
            $transaction->account_num= $asset->account_num ;
            $transaction->is_account=1 ;
            $transaction->is_approved=1;
            $transaction->treasury_shift_id= TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
            $transaction->receipt_amount= $asset->purchase_price;
            $transaction->deserved_account_amount=  0;
            $transaction->treasury_id = $treasury->id;
            $transaction->description= "إيصال صرف شراء الاصل الثابت  $asset->name_ar " . "من المورد" .$supplier->name_ar;
            $transaction->serial_num = getNextSerial();
            $transaction->inv_num = $asset->supp_inv_num;
            $transaction->date = Carbon::now();
            $transaction->save();


            $treasury->last_exchange_receipt = $transaction->serial_num;
            $treasury->current_balance = $treasury->current_balance + $asset->purchase_price;
            $treasury->save();


        } if($asset->payment_type == 'by_check') {

            $bank = Bank::where('id',$asset->bank_id)->first();
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$bank->account_num)->first();

            $transaction = new BankTransaction();
            $transaction->bank_transaction_type_id = 7;
            $transaction->transactionable_type="App\Models\Asset" ;
            $transaction->transactionable_id= $asset->id ;
            $transaction->account_num= $bank->account_num ;
            $transaction->is_account=1 ;
            $transaction->is_approved=1;
            $transaction->is_confirmed=1;
            $transaction->amount=$asset->purchase_price;
            $transaction->deserved_account_amount =  0;
            // $transaction->branch_id = Auth::user()->branch_id;
            $transaction->bank_id = $bank->id;
            $transaction->description= "  شيك صرف مستحقات للمورد عن شراء الاصل الثابت  $asset->name_ar " ."  من المورد" .$supplier->name_ar;
            $transaction->check_num = $asset->check_num;
            $transaction->inv_num = $asset->supp_inv_num;
            $transaction->date = $asset->purchase_date;
            $transaction->save();


            $bank->current_balance = $bank->current_balance + $asset->purchase_price;
            $bank->save();

        } if($asset->payment_type == 'by_installments') {
            //update supplier balance
            $supplier = Supplier::where('id',$asset->supplier_id)->first();
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$supplier->account_num)->first();
            //dd($creditAccount);


            $supplier->current_balance = $supplier->current_balance + $asset->purchase_price;
            $supplier->save();

        }

        
            //قيد اليومية المركب
            //تسجيل قيد شراء الاصل- الخزينة
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount1->account_num;
            $entry1->debit_account_id = $debitAccount1->id;
            $entry1->credit_account_num = $creditAccount1->account_num;
            $entry1->credit_account_id = $creditAccount1->id;
            $entry1->debit_amount = $asset->purchase_price;
            $entry1->credit_amount = $asset->purchase_price;
            $entry1->branch_id = Auth::user()->branch_id;
            $entry1->jounralable_type = 'App\Models\Asset';
            $entry1->jounralable_id = $asset->id;
            $entry1->entry_type_id =1 ;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description = " من ح  /  $debitAccount1->name   الي ح  /  $creditAccount1->name " ;
            $entry1->date = $asset->purchase_date;
            $entry1->save();


            //الاستاذ العام للاصول مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount1->id;
            $ledger1->account_num = $debitAccount1->account_num;
            $ledger1->name_ar = $debitAccount1->name;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $asset->purchase_date;
            $ledger1->save();
            //dd( $ledger1);

            //الاستاذ العام للخزينة او البنك او المورد دائن 
            $ledger2 = new Ledger();
            $ledger2->debit_amount = 0;
            $ledger2->credit_amount = $entry1->credit_amount;
            $ledger2->account_id = $creditAccount1->id;
            $ledger2->account_num = $creditAccount1->account_num;
            $ledger2->name_ar = $creditAccount1->name;
            $ledger2->created_by = Auth::user()->id;
            $ledger2->journal_entry_id = $entry1->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $asset->purchase_date;
            $ledger2->save();


            //الاستاذ العام  لمخصص اهلاك الاصل
            $ledger3 = new Ledger();
            $ledger3->debit_amount = 0;
            $ledger3->credit_amount = 0;
            $ledger3->account_id = $assetDepreciationsSum->id;
            $ledger3->account_num = $assetDepreciationsSum->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->name_ar = $assetDepreciationsSum->name_ar;
            $ledger3->journal_entry_id = $entry1->id;
            $ledger3->type = 'journal_entry';
            $ledger3->date = $asset->purchase_date;
            $ledger3->save();

            //الاستاذ العام  لمصروفات اهلاك الاصل
            $ledger4 = new Ledger();
            $ledger4->debit_amount = 0;
            $ledger4->credit_amount = 0;
            $ledger4->account_id = $assetDepreciationExpenses->id;
            $ledger4->account_num = $assetDepreciationExpenses->account_num;
            $ledger4->created_by = Auth::user()->id;
            $ledger4->name_ar = $assetDepreciationExpenses->name_ar;
            $ledger4->journal_entry_id = $entry1->id;
            $ledger4->type = 'journal_entry';
            $ledger4->date = $asset->purchase_date;
            $ledger4->save();


            //الاستاذ المساعد للاصول مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry1->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry1->debit_amount;
            $tAccount1->description = " الي ح / $creditAccount1->name  ";
            $tAccount1->journal_entry_id = $entry1->id;
            $tAccount1->account_id = $debitAccount1->id;
            $tAccount1->ledger_id = $ledger1->id;
            $tAccount1->created_by = Auth::user()->id;
            $tAccount1->save();

             //الاستاذ   للخزينة او البنك او المورد دائن
            $tAccount2 = new TAccount();
            $tAccount2->serial_num = getNextTAccountSerial();
            $tAccount2->account_num = $assetDepreciationExpenses->account_num;
            $tAccount2->journal_type = 'دائن';
            $tAccount2->amount = $assetDepreciationExpenses->credit_amount;
            $tAccount2->description  = "من  ح/   $debitAccount1->name";
            $tAccount2->journal_entry_id = null;
            $tAccount2->account_id = $assetDepreciationExpenses->id;
            $tAccount2->ledger_id = $ledger2->id;
            $tAccount2->created_by = Auth::user()->id;
            $tAccount2->save();

            //الاستاذ لمخصص الاهلاك  دائن
            $tAccount3 = new TAccount();
            $tAccount3->serial_num = getNextTAccountSerial();
            $tAccount3->account_num = $assetDepreciationsSum->account_num;
            $tAccount3->journal_type = 'دائن';
            $tAccount3->amount = $assetDepreciationsSum->debit_amount;
            $tAccount3->description =  "   من ح / $debitAccount1->name";
            $tAccount3->journal_entry_id = null;
            $tAccount3->account_id = $assetDepreciationsSum->id;
            $tAccount3->ledger_id = $ledger3->id;
            $tAccount3->created_by = Auth::user()->id;
            $tAccount3->save();

            // //الاستاذ لمصروفات الاهلاك  مدين
            $tAccount4 = new TAccount();
            $tAccount4->serial_num = getNextTAccountSerial();
            $tAccount4->account_num = $assetDepreciationExpenses->account_num;
            $tAccount4->journal_type = 'مدين';
            $tAccount4->amount = $assetDepreciationExpenses->credit_amount;
            $tAccount4->description  = "الي  ح/   $creditAccount1->name";
            $tAccount4->journal_entry_id = null;
            $tAccount4->account_id = $assetDepreciationExpenses->id;
            $tAccount4->ledger_id = $ledger4->id;
            $tAccount4->created_by = Auth::user()->id;
            $tAccount4->save();



            //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            //debit1
            $currentDebitAccount1 = $debitAccount1->account_num ;
            $debitLevels1 = [];
            for ($k = strlen($currentDebitAccount1); $k > 0; $k--) {
                $debitLevels1[] = substr($currentDebitAccount1, 0, $k);
            }
            //dd($debitLevels1);
            foreach ($debitLevels1 as $relatedDebitLevel1) {

                $levelDebitAccount1 = Account::where('account_num',$relatedDebitLevel1)->first();
                //dd($levelDebitAccount1->current_balance);
                $levelDebitAccount1->update([
                    'current_balance' => $levelDebitAccount1->current_balance + $asset->purchase_price,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }

            //credit
            $currentCreditAccount = $creditAccount1->account_num ;
            $creditLevels = [];
            for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount, 0, $k);
            }

            //dd($creditLevels);
            foreach ($creditLevels as $relatedCreditLevel) {

                $levelCreditAccount = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount->update([
                    'current_balance' => $levelCreditAccount->current_balance - $asset->purchase_price,
                ]);
                 //dd($levelCreditAccount->current_balance);
            }

            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية


    }
}
