<?php

namespace App\Listeners;

use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Partner;
use App\Models\Treasury;
use App\Models\Transaction;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewPartnerWithdrawalFinancials
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
        $withdrawal = $event->partnerWithdrawal;


       // dd($event);
        $entry = getNextJournalEntryNum();

        $debitParentAccount = Account::where('account_num',35)->first();//مسحوبات الملاك
        $debitAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
        ->where('parent_id',$debitParentAccount->id)->where('account_num',"34".$withdrawal->partner_id)->first();

        //dd($debitAccount);

        if($withdrawal->sourcable_type == 'App\Models\Treasury') {


            $treasury = Treasury::where('id',$withdrawal->sourcable_id)->first();
            //dd($treasury);
            $creditAccount = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
            // dd($creditAccount);             
            $transaction = new Transaction();
            $transaction->transaction_type_id = 18;
            $transaction->transactionable_type="App\Models\PartnerWithdrawal" ;
            $transaction->transactionable_id= $withdrawal->id ;
            $transaction->account_num= $debitAccount->account_num ;
            $transaction->is_account = 1 ;
            $transaction->is_approved = 1;
            $transaction->treasury_shift_id= Auth::user()->roles_name=="سوبر ادمن" ?
            TreasuryShift::where('branch_id',$treasury->branch_id)->latest()->first()->id :
            TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
            $transaction->receipt_amount = $withdrawal->amount;
            $transaction->deserved_account_amount = 0;
            $transaction->branch_id = $treasury->branch_id;
            $transaction->treasury_id = $treasury->id;
            $transaction->description = "إيصال صرف مسحوبات للشريك  " .  $withdrawal->partner->name . " من خزينة "  . $creditAccount->name ."بغرض". $withdrawal->type;
            $transaction->serial_num = getNextSerial();
            // $transaction->inv_num = $invoice->supp_inv_num;
            $transaction->date = $withdrawal->date;
            $transaction->save();

            $treasury->last_collection_receipt = $transaction->serial_num;
            $treasury->current_balance = $treasury->current_balance - $withdrawal->amount;
            $treasury->save();



        }

        elseif($withdrawal->sourcable_type == 'App\Models\Bank') {
            $bank = Bank::where('id',$withdrawal->sourcable_id)->first();
            $bankNum = $bank->account_num;
            dd($bankNum);

            $creditAccount = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
            ->where('account_num', $bankNum)->first();

             //dd($creditAccount);

            $transaction = new BankTransaction();
            $transaction->bank_transaction_type_id = 9;
            $transaction->transactionable_type="App\Models\PartnerWithdrawal" ;
            $transaction->transactionable_id= $withdrawal->id ;
            $transaction->account_num = $$debitAccount->account_num ;
            $transaction->is_account = 1 ;
            $transaction->is_approved = 1;
            $transaction->is_confirmed = 1;
            $transaction->amount = $withdrawal->amount;
            // $transaction->deserved_account_amount= Supplier::where('id',$invoice->supplier_id)->first()->current_balance;
            // $transaction->branch_id = Auth::user()->branch_id;
            $transaction->bank_id  = $withdrawal->sourcable_id;
            $transaction->description= " صرف مسحوبات للشريك  ".  $withdrawal->partner->name . " من بنك"  . $bank->name. " بغرض" . $withdrawal->type;
            $transaction->check_num = $withdrawal->check_num;
            // $transaction->inv_num = $withdrawal->supp_inv_num;
            $transaction->date = $withdrawal->date;
            $transaction->save();


        }

        
            //قيد اليومية
            //تسجيل   الخزينة او البنك دئن - مسحوبات الشريم مدين 
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount->account_num;
            $entry1->debit_account_id = $debitAccount->id;
            $entry1->credit_account_num = $creditAccount->account_num;
            $entry1->credit_account_id = $creditAccount->id;
            $entry1->debit_amount = $withdrawal->amount;
            $entry1->credit_amount = $withdrawal->amount;
            $entry1->branch_id = $treasury->branch_id;
            $entry1->jounralable_type = 'App\Models\PartnerWithdrawal';
            $entry1->jounralable_id = $withdrawal->id;
            $entry1->entry_type_id = 1 ;
            $entry1->created_by = $withdrawal->created_by;
            $entry1->description = " من ح /  " . $debitAccount->name . "  الي ح   /  ".  $creditAccount->name  ;
            $entry1->date = $withdrawal->date;
            $entry1->save();



            //الاستاذ لمسحوبات الشريك مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount->id;
            $ledger1->account_num = $debitAccount->account_num;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $withdrawal->start_date;
            $ledger1->save();

            //الاستاذ العام للخزينه او البنك دائن
            $ledger2 = new Ledger();
            $ledger2->debit_amount = 0;
            $ledger2->credit_amount = $entry1->credit_amount;
            $ledger2->account_id = $creditAccount->id;
            $ledger2->account_num = $creditAccount->account_num;
            $ledger2->created_by = $withdrawal->created_by;
            $ledger2->name_ar = $creditAccount->name;
            $ledger2->journal_entry_id = $entry1->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $withdrawal->start_date;
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
            // $tAccount1->created_by = $withdrawal->created_by;
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
                    'current_balance' => $levelDebitAccount->current_balance + $withdrawal->amount,
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
                    'current_balance' => $levelCreditAccount->current_balance - $withdrawal->amount,
                ]);
                 //dd($levelCreditAccount->current_balance);
            }
                //نهاية ارصدة حسابات الاباء بالشجرة المحاسبية

    }
}
