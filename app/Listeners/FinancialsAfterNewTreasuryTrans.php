<?php

namespace App\Listeners;

use App\Models\Ledger;
use App\Models\Account;
use App\Models\TAccount;
use App\Models\Treasury;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FinancialsAfterNewTreasuryTrans
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

        $transaction = $event->transaction;
        $invoice = $event->invoice;
        $entry = getNextJournalEntryNum();
        $debitAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$invoice->supplier->account_num)->first();

        $treasury = Treasury::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',Auth::user()->branch_id)->first();

        $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();

        //dd($debitAccount1->name);
        //قيد اليومية المركب
        //تسجيل المورد
        $entry1 = new JournalEntry();
        $entry1->entry_num = $entry;
        $entry1->debit_account_num = $debitAccount1->account_num;
        $entry1->debit_account_id = $debitAccount1->id;
        $entry1->credit_account_num = $creditAccount1->account_num;
        $entry1->credit_account_id =  Account::where('account_num', $creditAccount1->account_num)->first()->id;
        $entry1->debit_amount = $transaction->receipt_amount;
        $entry1->credit_amount = $transaction->receipt_amount;
        $entry1->branch_id = Auth::user()->branch_id;
        $entry1->jounralable_type = 'App\Models\SupplierInvoice';
        $entry1->jounralable_id = $invoice->id;
        $entry1->entry_type_id =1 ;
        $entry1->created_by = Auth::user()->id;
        $entry1->updated_by = Auth::user()->id;
        $entry1->description =  " / من ح" .   $debitAccount1->name . " / إلي ح " .$creditAccount1->name ;
        $entry1->date = $invoice->supp_inv_date_time;
        $entry1->save();



        //الاستاذ العام للمورد مدين
        $ledger1 = new Ledger();
        $ledger1->debit_amount = $entry1->debit_amount;
        $ledger1->credit_amount = 0;
        $ledger1->account_id = $debitAccount1->id;
        $ledger1->account_num = $debitAccount1->account_num;
        $ledger1->created_by = Auth::user()->id;
        $ledger1->journal_entry_id = $entry1->id;
        $ledger1->name_ar = $debitAccount1->name;
        $ledger1->type = 'journal_entry';
         $ledger1->date = $invoice->supp_inv_date_time;
        $ledger1->save();


        //الاستاذ العام للخزينة دائن
        $ledger2 = new Ledger();
        $ledger2->debit_amount = 0;
        $ledger2->credit_amount = $entry1->credit_amount;
        $ledger2->account_id = $creditAccount1->id;
        $ledger2->account_num = $creditAccount1->account_num;
        $ledger2->created_by = Auth::user()->id;
        $ledger2->journal_entry_id = $entry1->id;
        $ledger2->name_ar = $creditAccount1->name;
        $ledger2->type = 'journal_entry';
        $ledger2->date = $invoice->supp_inv_date_time;
        $ledger2->save();


        //الاستاذ المساعد للمورد مدين
        $tAccount1 = new TAccount();
        $tAccount1->serial_num = getNextTAccountSerial();
        $tAccount1->account_num = $entry1->debit_account_num;
        $tAccount1->journal_type = 'مدين';
        $tAccount1->amount = $entry1->debit_amount;
        $tAccount1->description = 'الي ح /'. $creditAccount1->name;
        $tAccount1->journal_entry_id = $entry1->id;
        $tAccount1->account_id = $debitAccount1->id;
        $tAccount1->ledger_id = Ledger::where('account_num',$debitAccount1->account_num)->first()->id;
        $tAccount1->created_by = Auth::user()->id;
        $tAccount1->save();


        //الاستاذ المساعد للخزينة دائن
        $tAccount2 = new TAccount();
        $tAccount2->serial_num = getNextTAccountSerial();
        $tAccount2->account_num = $creditAccount1->account_num;
        $tAccount2->journal_type = 'دائن';
        $tAccount2->amount = $entry1->credit_amount;
        $tAccount2->description = "من ح / ". $debitAccount1->name;
        $tAccount2->journal_entry_id = $entry1->id;
        $tAccount2->account_id = Account::where('account_num',$invoice->supplier->account_num)->first()->id;
        $tAccount2->ledger_id = Ledger::where('account_num',$invoice->supplier->account_num)->first()->id;
        $tAccount2->created_by = Auth::user()->id;
        $tAccount2->save();



            $debitAccount1->current_balance  = $debitAccount1->current_balance + $entry1->debit_amount;
            $debitAccount1->save() ;

            $creditAccount1->current_balance  = $creditAccount1->current_balance - $entry1->credit_amount;
            $debitAccount1->save() ;





            $treasury->current_balance =  $treasury->current_balance + $transaction->receipt_amount ;
            $treasury->last_collection_receipt =   $transaction->serial_num ;
            $treasury->save();











            ........................
            تحديث الشجرة

    }
}
