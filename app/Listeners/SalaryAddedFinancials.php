<?php

namespace App\Listeners;

use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Treasury;
use App\Models\Transaction;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SalaryAddedFinancials
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
        $user = $event->user;
        $salary = $event->salary;
        $bank_id = $event->bank_id;

        $oldJournalEntry = JournalEntry::where('jounralable_type','App\Models\Salary')->where('jounralable_id',$salary->id)->first();
        if($oldJournalEntry){
          // dd("kkk");
            $oldTotal = $oldJournalEntry->debit_amount;
            if($salary->receiving_type == 'cash') {
                //dd($salary);
                 $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                 ->where('branch_id',$user->branch_id)->first();
                 //dd($treasury);
                $creditAccount = Account::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
                         $debitAccountParentParent = Account::where('name_ar',"اجور و مرتبات")->first();
        
                $debitAccountParent = Account::where('parent_id',$debitAccountParentParent->id)->where('branch_id',$salary->user->branch_id)->first();

                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent->id )
                ->where('account_num',$user->account_num)->first();

                $total = $salary->salary + $salary->total_overtime - $salary->medical_insurance_deduction
                + $salary->transfer_allowance + $salary->housin_allowance + $salary->total_commission_rate
                - $salary->deductions + $salary->rewards - $salary->advance_payment_deduction - $salary->total_delay;
            //dd($debitAccount);


            

                $oldTreasuryTrans = Transaction::where('transactionable_id',$salary->id)->first();
                if($oldTreasuryTrans) {
                $oldTreasuryTrans->delete();
                }
                $oldBankTrans = BankTransaction::where('transactionable_id',$salary->id)->first();
                if($oldBankTrans) {
                    $oldBankTrans->delete();
                };

        
                $transaction = new Transaction();
                $transaction->transaction_type_id = 16;
                $transaction->transactionable_type="App\Models\Salary" ;
                $transaction->transactionable_id= $salary->id ;
                $transaction->account_num = $user->account_num ;
                $transaction->is_account = 1 ;
                $transaction->is_approved = 1;
                $transaction->treasury_shift_id = TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                $transaction->receipt_amount = number_format($total,2);
                $transaction->deserved_account_amount = 0 ;
                $transaction->branch_id = Auth::user()->branch_id;
                $transaction->treasury_id = $treasury->id;
                $transaction->description = "إيصال صرف راتب الموظف " . $user->name ;
                $transaction->serial_num = getNextSerial();
                $transaction->inv_num = null;
                $transaction->date = $salary->to_date;
                $transaction->save();

                $treasury->current_balance = $treasury->current_balance + $oldTotal - $total;
                $treasury->save();


                $existingJournalEntry = JournalEntry::where('jounralable_type','App\Models\Salary')->where('jounralable_id',$salary->id)->first();
                $existingJournalEntry->debit_amount = $total;
                $existingJournalEntry->credit_amount = $total;
                $existingJournalEntry->date = $salary->updated_at;
                $existingJournalEntry->save();



               // dd($debitAccount);

                //الاستاذ العام للموظف مدين
                $ledger1 = Ledger::where('journal_entry_id',$existingJournalEntry->id)->where('account_num',$debitAccount->account_num)->first();
                $ledger1->debit_amount = $existingJournalEntry->debit_amount;
                $ledger1->credit_amount = 0;
                $ledger1->name_ar = $debitAccount->name;
                $ledger1->save();



                //الاستاذ العام للخزينة دائن
                $ledger2 = Ledger::where('journal_entry_id',$existingJournalEntry->id)->whereNot('account_num',$debitAccount->account_num)->first();;
                $ledger2->debit_amount = 0;
                $ledger2->credit_amount = $existingJournalEntry->credit_amount;
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

                    $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();
                    //dd($levelDebitAccount->current_balance);
                    $levelDebitAccount->update([
                        'current_balance' => $levelDebitAccount->current_balance + $oldTotal + $total,
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
                        'current_balance' => $levelCreditAccount->current_balance + $oldTotal - $total,
                    ]);
                    //dd($levelCreditAccount->current_balance);
                }

                //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية

            }elseif($salary->receiving_type == 'visa'){
                //dd($salary);
                $bank = Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                 ->where('id',$bank_id)->first();
                 //dd($bank);
                $creditAccount = Account::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$bank->account_num)->first();
                 $debitAccountParentParent = Account::where('name_ar',"اجور و مرتبات")->first();
        
                $debitAccountParent = Account::where('parent_id',$debitAccountParentParent->id)->where('branch_id',$salary->user->branch_id)->first();

                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent->id )
                ->where('account_num',$user->account_num)->first();

                $total = $salary->salary + $salary->total_overtime - $salary->medical_insurance_deduction
                + $salary->transfer_allowance + $salary->housin_allowance + $salary->total_commission_rate
                - $salary->deductions + $salary->rewards - $salary->advance_payment_deduction - $salary->total_delay;
                //dd($total);



                
                $oldTreasuryTrans = Transaction::where('transactionable_id',$salary->id)->first();
                if($oldTreasuryTrans) {
                $oldTreasuryTrans->delete();
                }
                $oldBankTrans = BankTransaction::where('transactionable_id',$salary->id)->first();
                if($oldBankTrans) {
                    $oldBankTrans->delete();
                };

                $transaction = new BankTransaction();
                $transaction->bank_transaction_type_id = 14;
                $transaction->transactionable_type="App\Models\Salary" ;
                $transaction->transactionable_id= $salary->id ;
                $transaction->account_num= $bank->account_num ;
                $transaction->is_account=1 ;
                $transaction->is_approved=1;
                $transaction->is_confirmed=1;
                $transaction->amount = number_format($total,2);
                $transaction->deserved_account_amount=  0;
                // $transaction->branch_id = Auth::user()->branch_id;
                $transaction->bank_id = $bank->id;
                $transaction->description= "شيك صرف راتب الموظف $user->name ";
                $transaction->check_num = null;
                $transaction->inv_num = null;
                $transaction->date = $salary->to_date;
                $transaction->save();


                $bank->current_balance = $bank->current_balance + $oldTotal - $total;
                $bank->save();

                
                $existingJournalEntry = JournalEntry::where('jounralable_type','App\Models\Salary')->where('jounralable_id',$salary->id)->first();
                $existingJournalEntry->debit_amount = $total;
                $existingJournalEntry->credit_amount = $total;
                $existingJournalEntry->date = $salary->updated_at;
                $existingJournalEntry->save();



               // dd($debitAccount);

                //الاستاذ العام للموظف مدين
                $ledger1 = Ledger::where('journal_entry_id',$existingJournalEntry->id)->where('account_num',$debitAccount->account_num)->first();
                $ledger1->debit_amount = $existingJournalEntry->debit_amount;
                $ledger1->credit_amount = 0;
                $ledger1->name_ar = $debitAccount->name;
                $ledger1->save();



                //الاستاذ العام للبنك دائن
                $ledger2 = Ledger::where('journal_entry_id',$existingJournalEntry->id)->whereNot('account_num',$debitAccount->account_num)->first();;
                
                $ledger2->debit_amount = 0;
                $ledger2->credit_amount = $existingJournalEntry->credit_amount;
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

                    $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();
                    //dd($levelDebitAccount->current_balance);
                    $levelDebitAccount->update([
                        'current_balance' => $levelDebitAccount->current_balance - $oldTotal + $total,
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
                        'current_balance' => $levelCreditAccount->current_balance + $oldTotal - $total,
                    ]);
                    //dd($levelCreditAccount->current_balance);
                }

                //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
                }
        
        } else {
                if($salary->receiving_type == 'cash') {
                //dd($salary);
                 $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                 ->where('branch_id',$user->branch_id)->first();
                 //dd($treasury);
                $creditAccount = Account::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
                $debitAccountParentParent = Account::where('name_ar',"اجور و مرتبات")->first();
        
                $debitAccountParent = Account::where('parent_id',$debitAccountParentParent->id)->where('branch_id',$salary->user->branch_id)->first();

                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent->id )
                ->where('account_num',$user->account_num)->first();
        //dd($debitAccount);
                $newTotal = $salary->salary + $salary->total_overtime - $salary->medical_insurance_deduction
                + $salary->transfer_allowance + $salary->housin_allowance + $salary->total_commission_rate
                - $salary->deductions + $salary->rewards - $salary->advance_payment_deduction - $salary->total_delay;
                //dd($newTotal);


                $transaction = new Transaction();
                $transaction->transaction_type_id = 16;
                $transaction->transactionable_type="App\Models\Salary" ;
                $transaction->transactionable_id= $salary->id ;
                $transaction->account_num = $user->account_num ;
                $transaction->is_account = 1 ;
                $transaction->is_approved = 1;
                $transaction->treasury_shift_id = TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                $transaction->receipt_amount = number_format($newTotal,2);
                $transaction->deserved_account_amount = 0 ;
                $transaction->branch_id = Auth::user()->branch_id;
                $transaction->treasury_id = $treasury->id;
                $transaction->description = "إيصال صرف راتب الموظف " . $user->name ;
                $transaction->serial_num = getNextSerial();
                $transaction->inv_num = null;
                $transaction->date = $salary->to_date;
                $transaction->save();


            $treasury->last_exchange_receipt = $transaction->serial_num;
            $treasury->save();

            $treasury->current_balance = $treasury->current_balance - $newTotal;
            $treasury->save();



            $entry = getNextJournalEntryNum();
            //تسجيل قيد  صرف راتب موظف- الخزينة
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount->account_num;
            $entry1->debit_account_id = $debitAccount->id;
            $entry1->credit_account_num = $creditAccount->account_num;
            $entry1->credit_account_id = $creditAccount->id;
            $entry1->debit_amount = $newTotal;
            $entry1->credit_amount = $newTotal;
            $entry1->branch_id = Auth::user()->branch_id;
            $entry1->jounralable_type = 'App\Models\Salary';
            $entry1->jounralable_id = $salary->id;
            $entry1->entry_type_id =1 ;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description = " من ح  /  $debitAccount->name   الي ح  /  $creditAccount->name " ;
            $entry1->date = $salary->created_at;
            $entry1->save();


            //الاستاذ العام للموظف مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id =$debitAccount->id;
            $ledger1->account_num = $debitAccount->account_num;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $entry1->date;
            $ledger1->save();



            //الاستاذ العام للخزينة دائن
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

                $levelDebitAccount = Account::where('account_num',$relatedDebitLevel)->first();
                //dd($levelDebitAccount->current_balance);
                $levelDebitAccount->update([
                    'current_balance' => $levelDebitAccount->current_balance + $newTotal,
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
                    'current_balance' => $levelCreditAccount->current_balance - $newTotal,
                ]);
                 //dd($levelCreditAccount->current_balance);
            }

            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية

        }elseif($salary->receiving_type == 'visa'){
                //dd($salary);
                $bank = Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
                 ->where('id',$bank_id)->first();
                 //dd($bank);
                $creditAccount = Account::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$bank->account_num)->first();
                
                $debitAccountParentParent = Account::where('name_ar',"اجور و مرتبات")->first();
        
                $debitAccountParent = Account::where('parent_id',$debitAccountParentParent->id)->where('branch_id',$salary->user->branch_id)->first();

                $debitAccount = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent->id )
                ->where('account_num',$user->account_num)->first();

                $newTotal = $salary->salary + $salary->total_overtime - $salary->medical_insurance_deduction
                + $salary->transfer_allowance + $salary->housin_allowance + $salary->total_commission_rate
                - $salary->deductions + $salary->rewards - $salary->advance_payment_deduction - $salary->total_delay;
                //dd($total);


            $transaction = new BankTransaction();
            $transaction->bank_transaction_type_id = 14;
            $transaction->transactionable_type="App\Models\Salary" ;
            $transaction->transactionable_id= $salary->id ;
            $transaction->account_num= $bank->account_num ;
            $transaction->is_account=1 ;
            $transaction->is_approved=1;
            $transaction->is_confirmed=1;
            $transaction->amount = number_format($newTotal,2);
            $transaction->deserved_account_amount=  0;
            // $transaction->branch_id = Auth::user()->branch_id;
            $transaction->bank_id = $bank->id;
            $transaction->description= "شيك صرف راتب الموظف $user->name ";
            $transaction->check_num = null;
            $transaction->inv_num = null;
            $transaction->date = $salary->to_date;
            $transaction->save();




            $bank->current_balance = $bank->current_balance - $newTotal;
            $bank->save();



            $entry = getNextJournalEntryNum();
            //تسجيل قيد  صرف راتب موظف- للبنك
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount->account_num;
            $entry1->debit_account_id = $debitAccount->id;
            $entry1->credit_account_num = $creditAccount->account_num;
            $entry1->credit_account_id = $creditAccount->id;
            $entry1->debit_amount = $newTotal;
            $entry1->credit_amount = $newTotal;
            $entry1->branch_id = Auth::user()->branch_id;
            $entry1->jounralable_type = 'App\Models\Asset';
            $entry1->jounralable_id = $salary->id;
            $entry1->entry_type_id =1 ;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description = " من ح  /  $debitAccount->name   الي ح  /  $creditAccount->name " ;
            $entry1->date = $salary->created_at;
            $entry1->save();


            //الاستاذ العام للموظف مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id =$debitAccount->id;
            $ledger1->account_num = $debitAccount->account_num;
            $ledger1->name_ar = $debitAccount->name;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $entry1->date;
            $ledger1->date = $entry1->date;
            $ledger1->save();



            //الاستاذ العام للبنك دائن
            $ledger3 = new Ledger();
            $ledger3->debit_amount = 0;
            $ledger3->credit_amount = $entry1->credit_amount;
            $ledger3->account_id = $creditAccount->id;
            $ledger3->account_num = $creditAccount->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->name_ar = $creditAccount->name;
            $ledger3->journal_entry_id = $entry1->id;
            $ledger3->type = 'journal_entry';
            $ledger3->date = $entry1->date;
            $ledger3->date = $entry1->date;
            $ledger3->save();



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
                    'current_balance' => $levelDebitAccount->current_balance + $newTotal,
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
                    'current_balance' => $levelCreditAccount->current_balance - $newTotal,
                ]);
                 //dd($levelCreditAccount->current_balance);
            }

            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
        }
        }


    }
}
