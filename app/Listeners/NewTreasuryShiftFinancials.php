<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Treasury;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewTreasuryShiftFinancials
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
        $treasuryShift = $event->treasuryShift;


       //dd($treasuryShift);

        $oldTrans = BankTransaction::where("transactionable_id",$treasuryShift->id)->first();
        if($oldTrans){
            if($treasuryShift->bank_id) {
                if($treasuryShift->bank_id) {

                    $oldTrans->amount = $treasuryShift->end_shift_bank_balance;
                    $oldTrans->save();

                    // dd("ll");

                    $bank = Bank::where('id',$oldTrans->bank_id)->first();
                    $bank->current_balance = $bank->current_balance + $oldTrans->current_balance;
                    $bank->save();

                    $debitAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                    ->where('account_num',$bank->account_num )->first();
                    //dd($debitAccount);



                    $creditAccountParent = Account::where('account_num',115)->first();//اجهزة الدفع الالكتروني
                    $creditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                    ->where('parent_id',$creditAccountParent->id )->where('branch_id',Auth::user()->branch_id)->first();

                    //dd($creditAccount);

                    $entry = getNextJournalEntryNum();
                    //  تسجيل البنك  مدين-جهاز الدفع الالكتروني  دائن
                    $entry1 = JournalEntry::where('jounralable_id',$oldTrans->id)->first();
                    $entry1->debit_amount = $oldTrans->amount;
                    $entry1->credit_amount = $oldTrans->amount;
                    $entry1->save();



                    //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
                    //debit
                    $currentDebitAccount = $debitAccount->account_num ;
                    $debitLevels = [];
                    for ($k = strlen($currentDebitAccount); $k > 0; $k--) {
                        $debitLevels[] = substr($currentDebitAccount, 0, $k);
                    }
                    //dd($debitLevels);
                    foreach ($debitLevels as $relatedDebitLevel) {

                        $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();
                        //dd($levelDebitAccount->current_balance);
                        $levelDebitAccount->update([
                            'current_balance' => $levelDebitAccount->current_balance + $oldTrans->amount,
                        ]);
                        //dd($levelDebitAccount->current_balance);
                    }

                    //credit
                    $currentCreditAccount = $creditAccount->account_num ;
                    $creditLevels = [];
                    for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                        $creditLevels[] = substr($currentCreditAccount, 0, $k);
                    }

                    //dd($creditLevels);
                    foreach ($creditLevels as $relatedCreditLevel) {

                        $levelCreditAccount = Account::where('account_num',$relatedCreditLevel)->first();

                        $levelCreditAccount->update([
                            'current_balance' => $levelCreditAccount->current_balance - $oldTrans->amount,
                        ]);
                        //dd($levelCreditAccount->current_balance);
                    }

                    //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية


                }
            }
        } else {
            if($treasuryShift->bank_id) {
                $transaction = new BankTransaction();
                $transaction->bank_transaction_type_id = 1;
                $transaction->transactionable_type="App\Models\TreasuryShift" ;
                $transaction->transactionable_id= $treasuryShift->id ;
                $transaction->account_num=  null ;
                $transaction->is_account=1 ;
                $transaction->is_approved=1;
                $transaction->is_confirmed=1;
                $transaction->amount = $treasuryShift->end_shift_bank_balance;
                $transaction->deserved_account_amount = 0;
                $transaction->branch_id = Auth::user()->branch_id;
                $transaction->bank_id = $treasuryShift->bank_id;
                $transaction->description =  "إغلاق الوردية- ترحيل رصيد الشبكة إلي البنك";
                $transaction->check_num = null;
                $transaction->inv_num = null;
                $transaction->date = Carbon::now();
                $transaction->save();

                // dd("ll");

                $bank = Bank::where('id',$transaction->bank_id)->first();
                $bank->current_balance = $bank->current_balance + $transaction->current_balance;
                $bank->save();

                $debitAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                ->where('account_num',$bank->account_num )->first();
                //dd($debitAccount);



                $creditAccountParent = Account::where('account_num',115)->first();//اجهزة الدفع الالكتروني
                $creditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                ->where('parent_id',$creditAccountParent->id )->where('branch_id',Auth::user()->branch_id)->first();

                //dd($creditAccount);

                $entry = getNextJournalEntryNum();
                //  تسجيل البنك  مدين-جهاز الدفع الالكتروني  دائن
                $entry1 = new JournalEntry();
                $entry1->entry_num = $entry;
                $entry1->debit_account_num = $debitAccount->account_num;
                $entry1->debit_account_id = $debitAccount->id;
                $entry1->credit_account_num = $creditAccount->account_num;
                $entry1->credit_account_id = $creditAccount->id;
                $entry1->debit_amount = $transaction->amount;
                $entry1->credit_amount = $transaction->amount;
                $entry1->branch_id = Auth::user()->branch_id;
                $entry1->jounralable_type = 'App\Models\TreasuryShift';
                $entry1->jounralable_id = $transaction->id;
                $entry1->entry_type_id = 1 ;
                $entry1->created_by = Auth::user()->id;
                $entry1->updated_by = Auth::user()->id;
                $entry1->description = " / من ح " . $debitAccount->name . "/ إلي ح  ". $creditAccount->name;
                $entry1->date = Carbon::now();
                $entry1->save();

                //الاستاذ العام للبنك  مدين
                $ledger1 = new Ledger();
                $ledger1->debit_amount = $entry1->debit_amount;
                $ledger1->credit_amount = 0;
                $ledger1->account_id = $debitAccount->id;
                $ledger1->account_num = $debitAccount->account_num;
                $ledger1->name_ar = $debitAccount->name;
                $ledger1->created_by = Auth::user()->id;
                $ledger1->journal_entry_id = $entry1->id;
                $ledger1->type = 'journal_entry';
                $ledger1->date = Carbon::now();
                $ledger1->save();

                //الاستاذ العام لجهاز الدفه الالكتروني دائن  
                $ledger2 = new Ledger();
                $ledger2->debit_amount = 0;
                $ledger2->credit_amount = $entry1-> credit_amount;
                $ledger2->account_id = $creditAccount->id;
                $ledger2->account_num = $creditAccount->account_num;
                $ledger2->name_ar = $creditAccount->name;
                $ledger2->created_by = Auth::user()->id;
                $ledger2->journal_entry_id = $entry1->id;
                $ledger2->type = 'journal_entry';
                $ledger2->date = Carbon::now();
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

                    $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();
                    //dd($levelDebitAccount->current_balance);
                    $levelDebitAccount->update([
                        'current_balance' => $levelDebitAccount->current_balance + $transaction->amount,
                    ]);
                    //dd($levelDebitAccount->current_balance);
                }

                //credit
                $currentCreditAccount = $creditAccount->account_num ;
                $creditLevels = [];
                for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                    $creditLevels[] = substr($currentCreditAccount, 0, $k);
                }

                //dd($creditLevels);
                foreach ($creditLevels as $relatedCreditLevel) {

                    $levelCreditAccount = Account::where('account_num',$relatedCreditLevel)->first();

                    $levelCreditAccount->update([
                        'current_balance' => $levelCreditAccount->current_balance - $transaction->amount,
                    ]);
                    //dd($levelCreditAccount->current_balance);
                }

                //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية


            }
        }







    }
}
