<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Capital;
use App\Models\Partner;
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

class NewCapitAlAddedFinancials
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
        $capital = $event->capital;

        //dd($capital);


        $creditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
        ->where('account_num',$capital->account_num)->first();

        //dd($creditAccount);
        $debitAccount= null ;

        $oldCapitalEntry = JournalEntry::where('jounralable_id',$capital->id)->where('jounralable_type','App\Models\Capital')->first();
        $oldCapitalAmount = $oldCapitalEntry ? $oldCapitalEntry->debit_amount : 0;

        //dd($oldCapitalEntry);
        if($oldCapitalEntry) {

            if($capital->capitalizable_type == 'App\Models\Treasury') {

                $treasury = Treasury::where('id',$capital->capitalizable_id)->first();
                //dd($treasury);
                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();

                $oldTransaction = Transaction::where('transactionable_type',"App\Models\Capital")->where('transactionable_id', $capital->id );
                $oldTransaction->receipt_amount = $capital->amount;
                $oldTransaction->treasury_id = $treasury->id;
                $oldTransaction->date = $capital->start_date;
                $oldTransaction->save();

                //تعديل رصيد الخزينة
                $treasury->current_balance = $treasury->current_balance  - $oldCapitalAmount + $capital->amount;
                $treasury->save();


            } elseif($capital->capitalizable_type == 'App\Models\Bank') {
                $bank = Bank::where('id',$capital->capitalizable_id)->first();

                //dd($bank->account_num);
                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                ->where('account_num', $bank->account_num)->first();

                $oldBankTransaction = BankTransaction::where('transactionable_type',"App\Models\Capital")->where('transactionable_id', $capital->id )->first();

                // dd($oldBankTransaction);
                $oldBankTransaction->amount = $capital->amount;
                $oldBankTransaction->bank_id = $bank->id;
                $oldBankTransaction->date = $capital->start_date;
                $oldBankTransaction->save();

                //تعديل رصيد البنك
                $bank->current_balance = $bank->current_balance  - $oldCapitalAmount + $capital->amount;
                $bank->save();

            }

            //تعديل قيد اليومية
            //تسجيل   الخزينة او البنك مدين -راس المال دائن
            $oldCapitalEntry->debit_amount = $capital->amount;
            $oldCapitalEntry->credit_amount = $capital->amount;
            $oldCapitalEntry->date = $capital->start_date;
            $oldCapitalEntry->save();


            //الاستاذ العام للخزينة او البنك مدين
            $ledger1 = Ledger::where('account_id',  $debitAccount->id)->where('journal_entry_id', $oldCapitalEntry->id)->first();
            $ledger1->debit_amount = $oldCapitalEntry->debit_amount;
            $ledger1->updated_by = Auth::user()->id;
            $ledger1->save();

           // dd($ledger1);

            //الاستاذ العام لراس المال دائن
            $ledger2 = Ledger::where('account_id',  $creditAccount->id)->where('journal_entry_id', $oldCapitalEntry->id)->first();
            $ledger2->credit_amount = $oldCapitalEntry->credit_amount;
            $ledger1->updated_by = Auth::user()->id;
            $ledger1->save();

            //تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            $currentDebitAccount = $debitAccount->account_num ;
            $debitLevels = [];
            for ($k = strlen($currentDebitAccount); $k > 0; $k--) {
                $debitLevels[] = substr($currentDebitAccount, 0, $k);
            }
            //dd($debitLevels);
            foreach ($debitLevels as $relatedDebitLevel) {

                $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();

                $levelDebitAccount->update([
                    'current_balance' => $levelDebitAccount->current_balance - $oldCapitalAmount + $capital->amount,
                ]);
                 //dd($levelDebitAccount->current_balance);
            }

            $currentCreditAccount = $creditAccount->account_num ;
            $creditLevels = [];
            for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount, 0, $k);
            }



            //dd($creditLevels);
            foreach ($creditLevels as $relatedCreditLevel) {

                $levelCreditAccount = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount->update([
                    'current_balance' => $levelCreditAccount->current_balance + $oldCapitalAmount - $capital->amount,
                ]);
                 //dd($levelCreditAccount->current_balance);
            }
                //نهاية ارصدة حسابات الاباء بالشجرة المحاسبية

        }else {

            $entry = getNextJournalEntryNum();
            if($capital->capitalizable_type == 'App\Models\Treasury') {

                $treasury = Treasury::where('id',$capital->capitalizable_id)->first();
                //dd($treasury);
                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();

                $transaction = new Transaction();
                $transaction->transaction_type_id = 11;
                $transaction->transactionable_type="App\Models\Capital" ;
                $transaction->transactionable_id= $capital->id ;
                $transaction->account_num= $capital->account_num ;
                $transaction->is_account = 1 ;
                $transaction->is_approved = 1;
                $transaction->treasury_shift_id= TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                $transaction->receipt_amount=$capital->amount;
                $transaction->deserved_account_amount=  Account::where('account_num',$capital->account_num)->first()->current_balance;
                $transaction->branch_id = $treasury->branch_id;
                $transaction->treasury_id = $treasury->id;
                $transaction->description= "إيصال تحصيل رأس مال " .  $capital->partner->name ."من الشريك". $capital->partner->name ;
                $transaction->serial_num = getNextSerial();
                // $transaction->inv_num = $invoice->supp_inv_num;
                $transaction->date = $capital->start_date;
                $transaction->save();

                $treasury->last_collection_receipt = $transaction->serial_num;
                $treasury->current_balance = $treasury->current_balance + $capital->amount;

                $treasury->save();



            }

            elseif($capital->capitalizable_type == 'App\Models\Bank') {
                $bank = Bank::where('id',$capital->capitalizable_id)->first();

                //dd($bank->account_num);
                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                ->where('account_num', $bank->account_num)->first();

                //dd($debitAccount);

                $transaction = new BankTransaction();
                $transaction->bank_transaction_type_id = 9;
                $transaction->transactionable_type="App\Models\Capital" ;
                $transaction->transactionable_id= $capital->id ;
                $transaction->account_num = $capital->account_num ;
                $transaction->is_account = 1 ;
                $transaction->is_approved = 1;
                $transaction->is_confirmed = 1;
                $transaction->amount=$capital->amount;
                // $transaction->deserved_account_amount= Supplier::where('id',$invoice->supplier_id)->first()->current_balance;
                // $transaction->branch_id = Auth::user()->branch_id;
                $transaction->bank_id  = $capital->capitalizable_id;
                $transaction->description= "شيك تحصيل رأس مال من  ".  $capital->partner->name ;
                $transaction->check_num = $capital->check_num;
                // $transaction->inv_num = $capital->supp_inv_num;
                $transaction->date = $capital->start_date;
                $transaction->save();


            }

            //dd($debitAccount);


            //قيد اليومية
            //تسجيل   الخزينة او البنك مدين -راس المال دائن
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount->account_num;
            $entry1->debit_account_id = $debitAccount->id;
            $entry1->credit_account_num = $creditAccount->account_num;
            $entry1->credit_account_id = $creditAccount->id;
            $entry1->debit_amount = $capital->amount;
            $entry1->credit_amount = $capital->amount;

            $entry1->jounralable_type = 'App\Models\Capital';
            $entry1->jounralable_id = $capital->id;
            $entry1->entry_type_id = 1 ;
            $entry1->created_by = $capital->created_by;
            $entry1->description = " من ح /  " . $debitAccount->name . "  الي ح   /  ".  $creditAccount->name  ;
            $entry1->date = $capital->start_date;
            $entry1->save();



            //الاستاذ العام للخزينة او البنك مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount->id;
            $ledger1->account_num = $debitAccount->account_num;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $capital->start_date;
            $ledger1->save();

            //الاستاذ العام لراس المال دائن
            $ledger2 = new Ledger();
            $ledger2->debit_amount = 0;
            $ledger2->credit_amount = $entry1->credit_amount;
            $ledger2->account_id = $creditAccount->id;
            $ledger2->account_num = $creditAccount->account_num;
            $ledger2->created_by = $capital->created_by;
            $ledger2->name_ar = $creditAccount->name;
            $ledger2->journal_entry_id = $entry1->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $capital->start_date;
            $ledger2->save();

            // //الاستاذ المساعد للخزينة او البنك مدين
            // $tAccount1 = new TAccount();
            // $tAccount1->serial_num = getNextTAccountSerial();
            // $tAccount1->account_num = $entry1->debit_account_num;
            // $tAccount1->journal_type = 'مدين';
            // $tAccount1->amount = $entry1->debit_amount;
            // $tAccount1->description = " الي ح / ". $creditAccount->name  ;
            // $tAccount1->journal_entry_id = $entry1->id;
            // $tAccount1->account_id = $debitAccount->id;
            // $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
            // $tAccount1->created_by = $capital->created_by;
            // $tAccount1->save();

            // //الاستاذ راس المال دائن
            // $tAccount2 = new TAccount();
            // $tAccount2->serial_num = getNextTAccountSerial();
            // $tAccount2->account_num = $entry1->credit_account_num;
            // $tAccount2->journal_type = 'دائن';
            // $tAccount2->amount = $entry1->credit_amount;
            // $tAccount2->description = "من ح  / " . $debitAccount->name;
            // $tAccount2->journal_entry_id = $entry1->id;
            // $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
            // $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
            // $tAccount2->created_by = Auth::user()->id;
            // $tAccount2->save();


            //تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            $currentDebitAccount = $debitAccount->account_num ;
            $debitLevels = [];
            for ($k = strlen($currentDebitAccount); $k > 0; $k--) {
                $debitLevels[] = substr($currentDebitAccount, 0, $k);
            }
            //dd($debitLevels);
            foreach ($debitLevels as $relatedDebitLevel) {

                $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();

                $levelDebitAccount->update([
                    'current_balance' => $levelDebitAccount->current_balance + $capital->amount,
                ]);
                 //dd($levelDebitAccount->current_balance);
            }

            $currentCreditAccount = $creditAccount->account_num ;
            $creditLevels = [];
            for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount, 0, $k);
            }



            //dd($creditLevels);
            foreach ($creditLevels as $relatedCreditLevel) {

                $levelCreditAccount = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount->update([
                    'current_balance' => $levelCreditAccount->current_balance - $capital->amount,
                ]);
                 //dd($levelCreditAccount->current_balance);
            }
                //نهاية ارصدة حسابات الاباء بالشجرة المحاسبية


            //إضافة حساب جديد لارباح الشريك من مبلغ توزيع الارباح والخسائر
            $partner = Partner::where('id', $capital->partner_id)->first();
            $account2 =  new Account();
            $account2->name_ar="ارباح الشريك" . " " .$partner->name_ar;
            $account2->account_num='36'.$partner->id;
            $account2->parent_account_num= 36;
            $account2->start_balance="0";
            $account2->current_balance="0";
            $account2->created_by=1;
            $account2->account_type_id=1;
            $account2->notes =' ارباح الشريك';
            $account2->is_active=1;
            $account2->is_parent=1;
            $account2->parent_id=366;
            $account2->branch_id= null;
            $account2->nature="دائن";
            $account2->list = "مركز-مالي";
            $account2->level = 3 ;
            $account2->save();

            $ledger21= new Ledger();
            $ledger21->debit_amount = 0;
            $ledger21->credit_amount = 0;
            $ledger21->account_id = $account2->id;
            $ledger21->account_num = $account2->account_num;
            $ledger21->created_by = Auth::user()->id;
            $ledger21->name_ar = $account2->name_ar;
            $ledger21->journal_entry_id = $entry1->id;
            $ledger21->type = 'journal_entry';
            $ledger21->save();


            //إضافة حساب جديد لمسحوبات الشريك
            $account3 =  new Account();
            $account3->name_ar=" مسحوبات الشريك" . " " .$partner->name_ar;
            $account3->account_num='34'.$partner->id;
            $account3->parent_account_num= 34;
            $account3->start_balance="0";
            $account3->current_balance="0";
            $account3->created_by=1;
            $account3->account_type_id=1;
            $account3->notes ='مسحوبات الشريك';
            $account3->is_active=1;
            $account3->is_parent=1;
            $account3->parent_id=364;
            $account3->branch_id= null;
            $account3->nature="مدين";
            $account3->list = "مركز-مالي";
            $account3->level = 3 ;
            $account3->save();

            $ledger31= new Ledger();
            $ledger31->debit_amount = 0;
            $ledger31->credit_amount = 0;
            $ledger31->account_id = $account2->id;
            $ledger31->account_num = $account2->account_num;
            $ledger31->created_by = Auth::user()->id;
            $ledger31->name_ar = $account2->name_ar;
            $ledger31->journal_entry_id = $entry1->id;
            $ledger31->type = 'journal_entry';
            $ledger31->save();

        }
    }
}
