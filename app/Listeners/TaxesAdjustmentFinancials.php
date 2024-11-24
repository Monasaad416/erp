<?php

namespace App\Listeners;

use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Treasury;
use App\Models\JournalEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TaxesAdjustmentFinancials
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
        $taxes = $event->taxes;
        $adjust_date = $event->adjust_date;
        //dd($taxes);

        if($taxes->payment_method == 'treasury') {
            $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',$taxes->branch_id)->first();
            $creditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
            //dd($creditAccount);
        } elseif($taxes->payment_method == 'bank') {
                $bank = Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('id',$taxes->bank_id)->first();
                $creditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$bank->account_num)->first();
                //dd($creditAccount);
        }


        $debitAccountParent = Account::where('account_num',2232)->where('name_ar',"تسوية ضريبة القيمة المضافة")->first();
        $debitAccount =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent->id)->where('branch_id',$taxes->branch_id)->first();
        //dd($debitAccount);



        $oldJournalEntry = JournalEntry::where('jounralable_type','App\Models\TaxAdjustment')->where('jounralable_id',$taxes->id)
            ->where('debit_account_num',$debitAccount->account_num)->where('credit_account_num',$creditAccount->account_num)->first();

        //dd($oldJournalEntries);
        if($oldJournalEntry){
            //dd($debitAccount->account_num,$creditAccount->account_num);

            $existingJournalEntry = JournalEntry::where('jounralable_type','App\Models\TaxAdjustment')->where('jounralable_id',$taxes->id)
            ->where('debit_account_num',$debitAccount->account_num)->where('credit_account_num',$creditAccount->account_num)->first();
            //dd($existingJournalEntry);
            $existingJournalEntry->debit_amount = $taxes->amount;
            $existingJournalEntry->credit_amount = $taxes->amount;
            $existingJournalEntry->date = $adjust_date;
            $existingJournalEntry->save();




            $ledger1 = Ledger::where('journal_entry_id',$existingJournalEntry->id)->where('account_num',$debitAccount->account_num)->first();
            $ledger1->debit_amount = $existingJournalEntry->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->save();

            $ledger2 = Ledger::where('journal_entry_id',$existingJournalEntry->id)->where('account_num',$creditAccount->account_num)->first();
            $ledger2->debit_amount = $existingJournalEntry->credit_amount;
            $ledger2->credit_amount = 0;
            $ledger2->name_ar = $creditAccount->name;
            $ledger2->save();


            //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            //debit
            $currentDebitAccount = $debitAccount->account_num ;
            $debitLevels = [];
            for ($k = strlen($currentDebitAccount); $k > 0; $k--) {
                $debitLevels[] = substr($currentDebitAccount, 0, $k);
            }
            //dd($debitLevels);
            foreach ($debitLevels as $relatedDebitLevel) {

                $levelDebitAccount1 = Account::where('account_num',$relatedDebitLevel)->first();
                //dd($levelDebitAccount1->current_balance);
                $levelDebitAccount1->update([
                    'current_balance' => $levelDebitAccount1->current_balance - $oldJournalEntry->debit_amount + $existingJournalEntry->debit_amount,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }

            //credit
            $currentCreditAccount = $creditAccount->account_num ;
            $creditLevels = [];
            for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount, 0, $k);
            }

           //  dd($creditLevels);
            foreach ($creditLevels as $relatedCreditLevel) {

                $levelCreditAccount1 = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount1->update([
                    'current_balance' => $levelCreditAccount1->current_balance + $oldJournalEntry->credit_amount - $existingJournalEntry->credit_amount,
                ]);
                //dd($levelCreditAccount->current_balance);
            }

            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
        } else {
            $entry = getNextJournalEntryNum();



            //تسجيل تسوية الضريبة المضافة مدين و الخزينة او البنك دائن 
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount->account_num;
            $entry1->debit_account_id = $debitAccount->id;
            $entry1->credit_account_num = $creditAccount->account_num;
            $entry1->credit_account_id = $creditAccount->id;
            $entry1->debit_amount = $taxes->amount;
            $entry1->credit_amount = $taxes->amount;
            $entry1->branch_id = $taxes->branch_id;
            $entry1->jounralable_type = 'App\Models\TaxAdjustment';
            $entry1->jounralable_id = $taxes->id;
            $entry1->entry_type_id =2 ;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description = "/  من ح  $debitAccount->name / إلي  ح  $creditAccount->name";
            $entry1->date = $adjust_date;
            $entry1->save();
        
            //الاستاذ العام لتسوية الضريبة مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount->id;
            $ledger1->account_num = $debitAccount->account_num;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $entry1->date;
            $ledger1->save();

            //الاستاذ العام للخزينة او البنك دائن
            $ledger2 = new Ledger();
            $ledger2->debit_amount = 0;
            $ledger2->credit_amount = $entry1->credit_amount;
            $ledger2->account_id = $creditAccount->id;
            $ledger2->account_num = $creditAccount->account_num;
            $ledger2->created_by = Auth::user()->id;
            $ledger2->name_ar = $creditAccount->name;
            $ledger2->journal_entry_id = $entry1->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $entry1->date;
            $ledger2->save();

            //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            //debit
            $currentDebitAccount = $debitAccount->account_num ;
            $debitLevels = [];
            for ($k = strlen($currentDebitAccount); $k > 0; $k--) {
                $debitLevels[] = substr($currentDebitAccount, 0, $k);
            }
            //dd($debitLevels);
            foreach ($debitLevels as $relatedDebitLevel) {

                $levelDebitAccount1 = Account::where('account_num',$relatedDebitLevel)->first();
                //dd($levelDebitAccount1->current_balance);
                $levelDebitAccount1->update([
                    'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }

            //credit
            $currentCreditAccount = $creditAccount->account_num ;
            $creditLevels = [];
            for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount, 0, $k);
            }

           //  dd($creditLevels);
            foreach ($creditLevels as $relatedCreditLevel) {

                $levelCreditAccount1 = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount1->update([
                    'current_balance' => $levelCreditAccount1->current_balance - $entry1->credit_amount
                ]);
                //dd($levelCreditAccount->current_balance);
            }

            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
        }


    }
}
