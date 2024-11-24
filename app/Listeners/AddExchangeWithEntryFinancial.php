<?php

namespace App\Listeners;

use App\Models\Ledger;
use App\Models\Account;
use App\Models\Treasury;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddExchangeWithEntryFinancial
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

        $type = $event->type;
        $transaction = $event->transaction;
        $debit = $event->debit;
        $credit = $event->credit;
     //dd($transaction);


        $entry = getNextJournalEntryNum();

        $debitAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('id',$debit)->first();

        $creditAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('id',$credit)->first();

        $entry1 = new JournalEntry();
        $entry1->entry_num = $entry;
        $entry1->debit_account_num = $debitAccount1->account_num;
        $entry1->debit_account_id = $debitAccount1->id;
        $entry1->credit_account_num = $creditAccount1->account_num;
        $entry1->credit_account_id = $creditAccount1->id;
        $entry1->debit_amount = $transaction->receipt_amount;
        $entry1->credit_amount = $transaction->receipt_amount;;
        $entry1->branch_id = $transaction->branch_id;
        $entry1->jounralable_type = 'App\Models\Transaction';
        $entry1->jounralable_id = $transaction->id;
        $entry1->entry_type_id =2 ;
        $entry1->created_by = Auth::user()->id;
        $entry1->updated_by = Auth::user()->id;
        $entry1->description = " / من ح  $debitAccount1->name / إلي  ح   $creditAccount1->name";
        $entry1->date = $transaction->date;
        $entry1->save();

        //الاستاذ العام للحساب المدين
        $ledger1 = new Ledger();
        $ledger1->debit_amount = $entry1->debit_amount;
        $ledger1->credit_amount = 0;
        $ledger1->account_id = $debitAccount1->id;
        $ledger1->account_num = $debitAccount1->account_num;
        $ledger1->name_ar= $debitAccount1->name;
        $ledger1->created_by = Auth::user()->id;
        $ledger1->journal_entry_id = $entry1->id;
        $ledger1->type = 'journal_entry';
        $ledger1->date = $transaction->date;
        $ledger1->save();


        //الاستاذ العام للحساب الدائن
        $ledger2 = new Ledger();
        $ledger2->debit_amount = 0;
        $ledger2->credit_amount = $entry1->credit_amount;
        $ledger2->account_id = $creditAccount1->id;
        $ledger2->account_num = $creditAccount1->account_num;
        $ledger2->name_ar= $creditAccount1->name;
        $ledger2->created_by = Auth::user()->id;
        $ledger2->journal_entry_id = $entry1->id;
        $ledger2->type = 'journal_entry';
        $ledger2->date = $transaction->date;
        $ledger2->save();



        //تحديث رصيد الخزينة 
        $treasury = Treasury::where('branch_id',$transaction->branch_id)->first();
       
        $treasury->current_balance =  $treasury->current_balance - $transaction->receipt_amount;
        $treasury->save();
        //dd($treasury->current_balance);

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
                'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount,
            ]);
            //dd($levelDebitAccount1->current_balance);
        }


        //credit1
        $currentCreditAccount1 = $creditAccount1->account_num ;
        $creditLevels1 = [];
        for ($k = strlen($currentCreditAccount1); $k > 0; $k--) {
            $creditLevels1[] = substr($currentCreditAccount1, 0, $k);
        }

        //  dd($creditLevels);
        foreach ($creditLevels1 as $relatedCreditLevel1) {

            $levelCreditAccount1 = Account::where('account_num',$relatedCreditLevel1)->first();

            $levelCreditAccount1->update([
                'current_balance' => $levelCreditAccount1->current_balance - $entry1->credit_amount ,
            ]);
            //dd($levelCreditAccount->current_balance);
        }


        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية


    }
}
