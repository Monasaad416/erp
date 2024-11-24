<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Setting;
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

class FinancialsAfterSuppInvoiceReturned
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

        $invoice = $event->invoice;
       // dd($invoice->supp_inv_num);
        $bankId = $event->bank_id ?? null;





        $supplier = Supplier::where('id',$invoice->supplier_id)->first();
        $supplierAccount = Supplier::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$supplier->account_num)->first();



        $entry = getNextJournalEntryNum();




        //update supplier and supplier account balance
        if($invoice->return_payment_type == 'cash') {

            if($invoice->payment_type == 'cash' || $invoice->payment_type == 'by_check'){

                $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',Auth::user()->branch_id)->first();
                $debitAccount = Account::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
                $creditAccountParent1 = Account::where('name_ar','المخزون')->first();
                $creditAccount1 = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent1->id )->where('branch_id',Auth::user()->branch_id)->first();
                $creditAccountParent2 = Account::where('name_ar','ضريبة القيمة المضافة على المدخلات')->first();
                $creditAccount2 = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent2->id )->where('branch_id',Auth::user()->branch_id)->first();

                $transaction = new Transaction();
                $transaction->transaction_type_id = 10;
                $transaction->transactionable_type="App\Models\Supplier" ;
                $transaction->transactionable_id= $invoice->supplier_id ;
                $transaction->account_num = $debitAccount->account_num ;
                $transaction->is_account = 1 ;
                $transaction->is_approved = 1;
                $transaction->treasury_shift_id = TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
                $transaction->receipt_amount =  $invoice->total_after_discount;
                $transaction->deserved_account_amount = Supplier::where('id',$invoice->supplier_id)->first()->current_balance;
                $transaction->branch_id = Auth::user()->branch_id;
                $transaction->treasury_id = $treasury->id;
                $transaction->description = "إيصال تحصيل مردودات مشتريات من مورد عن فاتورة توريد رقم $invoice->supp_inv_num ";
                $transaction->serial_num = getNextSerial();
                $transaction->inv_num = $invoice->supp_inv_num;
                $transaction->date = Carbon::now();
                $transaction->save();

                //يضاف للخزينة كامل مبلغ الفاتورة

                //قيد اليومية المركب
                //تسجيل مردودات المشتريات علي المخزون دائن
                $entry1 = new JournalEntry();
                $entry1->entry_num = $entry;
                $entry1->debit_account_num = $debitAccount->account_num;
                $entry1->debit_account_id = $debitAccount->id;
                $entry1->credit_account_num = $creditAccount1->account_num;
                $entry1->credit_account_id = $creditAccount1->id;
                $entry1->debit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $entry1->credit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $entry1->branch_id = Auth::user()->branch_id;
                $entry1->jounralable_type = 'App\Models\SupplierInvoice';
                $entry1->jounralable_id = $invoice->id;
                $entry1->entry_type_id =2 ;
                $entry1->created_by = Auth::user()->id;
                $entry1->updated_by = Auth::user()->id;
                $entry1->description = " من ح / $debitAccount->name "  . " إلي ح / $creditAccount1->name" ;
                $entry1->date = $invoice->supp_inv_date_time;
                $entry1->save();


                // ء تسجيل الضريبة علي المدخلات دائن

                $entry2 = new JournalEntry();
                $entry2->entry_num = $entry;
                $entry2->debit_account_num = $debitAccount->account_num;
                $entry2->debit_account_id = $debitAccount->id;
                $entry2->credit_account_num = $creditAccount2->account_num;
                $entry2->credit_account_id = $creditAccount2->id;
                $entry2->debit_amount = $invoice->tax_value;
                $entry2->credit_amount = $invoice->tax_value;
                $entry2->branch_id = Auth::user()->branch_id;
                $entry2->jounralable_type = 'App\Models\SupplierInvoice';
                $entry2->jounralable_id = $invoice->id;
                $entry2->entry_type_id =2 ;
                $entry2->created_by = Auth::user()->id;
                $entry2->updated_by = Auth::user()->id;
                $entry2->description = "من ح / $debitAccount->name ". " إلي ح /  $creditAccount2->name " ;
                $entry2->date = $invoice->supp_inv_date_time;
                $entry2->save();


                // $creditAccount1->current_balance = $creditAccount1->current_balance - $entry1->credit_amount;
                // $creditAccount1->save();

                // $creditAccount2->current_balance = $creditAccount2->current_balance - $entry2->credit_amount;
                // $creditAccount2->save();



                //الاستاذ العام للبنك مدين
                $ledger1 = new Ledger();
                $ledger1->debit_amount = $entry1->debit_amount;
                $ledger1->credit_amount = 0;
                $ledger1->account_id = $debitAccount->id;
                $ledger1->account_num = $debitAccount->account_num;
                $ledger1->created_by = Auth::user()->id;
                $ledger1->name_ar = $debitAccount->name;
                $ledger1->journal_entry_id = $entry1->id;
                $ledger1->type = 'journal_entry';
                $ledger1->date = $invoice->supp_inv_date_time;
                $ledger1->save();

                //الاستاذ العام للبنك مدين
                $ledger2 = new Ledger();
                $ledger2->debit_amount = $entry2->debit_amount;
                $ledger2->credit_amount = 0;
                $ledger2->account_id = $debitAccount->id;
                $ledger2->account_num = $debitAccount->account_num;
                $ledger2->created_by = Auth::user()->id;
                $ledger2->name_ar = $debitAccount->name;
                $ledger2->journal_entry_id = $entry2->id;
                $ledger2->type = 'journal_entry';
                $ledger2->date = $invoice->supp_inv_date_time;
                $ledger2->save();

                //الاستاذ العام لضريبة القيمة المضافة علي المدخلات دائن
                $ledger3 = new Ledger();
                $ledger3->debit_amount = 0;
                $ledger3->credit_amount = $entry2->credit_amount ;
                $ledger3->account_id = $creditAccount2->id;
                $ledger3->account_num = $creditAccount2->account_num;
                $ledger3->created_by = Auth::user()->id;
                $ledger3->name_ar = $creditAccount2->name;
                $ledger3->journal_entry_id = $entry2->id;
                $ledger3->type = 'journal_entry';
                $ledger3->date = $invoice->supp_inv_date_time;
                $ledger3->save();

                        // dd(Ledger::where('account_num',$treasury->account_num)->first());

                //الاستاذ العام للمخزون دائن
                $ledger4 = new Ledger();
                $ledger4->debit_amount = 0;
                $ledger4->credit_amount = $entry1->credit_amount;
                $ledger4->account_id = $creditAccount1->id;
                $ledger4->account_num = $creditAccount1->account_num;
                $ledger4->created_by = Auth::user()->id;
                $ledger4->name_ar = $creditAccount1->name;
                $ledger4->journal_entry_id = $entry1->id;
                $ledger4->type = 'journal_entry';
                $ledger4->date = $invoice->supp_inv_date_time;
                $ledger4->save();

                //الاستاذ المساعد للخزينة مدين
                $tAccount1 = new TAccount();
                $tAccount1->serial_num = getNextTAccountSerial();
                $tAccount1->account_num = $entry1->debit_account_num;
                $tAccount1->journal_type = 'مدين';
                $tAccount1->amount = $entry1->debit_amount;
                $tAccount1->description = "الي ح / $creditAccount1->name";
                $tAccount1->journal_entry_id = $entry1->id;
                $tAccount1->account_id = $debitAccount->id;
                $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
                $tAccount1->created_by = Auth::user()->id;
                $tAccount1->save();

                //الاستاذ المساعد للمخزون دائن
                $tAccount2 = new TAccount();
                $tAccount2->serial_num = getNextTAccountSerial();
                $tAccount2->account_num = $entry1->credit_account_num;
                $tAccount2->journal_type = 'دائن';
                $tAccount2->amount = $entry1->credit_amount;
                $tAccount2->description = " / من ح  $debitAccount->name  ";
                $tAccount2->journal_entry_id = $entry1->id;
                $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
                $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
                $tAccount2->created_by = Auth::user()->id;
                $tAccount2->save();

                //الاستاذ المساعد للخزينة مدين
                $tAccount3 = new TAccount();
                $tAccount3->serial_num = getNextTAccountSerial();
                $tAccount3->account_num = $entry2->debit_account_num;
                $tAccount3->journal_type = 'مدين';
                $tAccount3->amount = $entry2->debit_amount;
                $tAccount3->description = "الي ح / $creditAccount2->name";
                $tAccount3->journal_entry_id = $entry2->id;
                $tAccount3->account_id = $debitAccount->id;
                $tAccount3->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
                $tAccount3->created_by = Auth::user()->id;
                $tAccount3->save();



                //الاستاذ المساعد ضر يبة القيمة المضافة دائن
                $tAccount4 = new TAccount();
                $tAccount4->serial_num = getNextTAccountSerial();
                $tAccount4->account_num = $entry2->credit_account_num;
                $tAccount4->journal_type = 'دائن';
                $tAccount4->amount = $entry2->credit_amount;
                $tAccount4->description = " / من ح  $debitAccount->name  ";
                $tAccount4->journal_entry_id = $entry2->id;
                $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
                $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
                $tAccount4->created_by = Auth::user()->id;
                $tAccount4->save();


                // $creditAccount1->current_balance  = $creditAccount1->current_balance - $entry1->credit_amount;
                // $creditAccount1->save() ;


                // $creditAccount2->current_balance  = $creditAccount2->current_balance - $entry2->credit_amount;
                // $creditAccount2->save() ;

                // $debitAccount->current_balance  = $debitAccount->current_balance - $entry2->credit_amount;
                // $debitAccount->save() ;

                $treasury->current_balance = $treasury->current_balance + $invoice->total_after_discount;
                $treasury->save();



                //fill row in supplier return table

                $InvNum_with_prefix = $invoice->supp_inv_num;
                $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);



            //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            //debit
            $currentDebitAccount1 = $debitAccount->account_num ;
            $debitLevels1 = [];
            for ($k = strlen($currentDebitAccount1); $k > 0; $k--) {
                $debitLevels1[] = substr($currentDebitAccount1, 0, $k);
            }
            //dd($debitLevels1);
            foreach ($debitLevels1 as $relatedDebitLevel1) {

                $levelDebitAccount1 = Account::where('account_num',$relatedDebitLevel1)->first();
                //dd($levelDebitAccount1->current_balance);
                $levelDebitAccount1->update([
                    'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount + $entry2->debit,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }
            //credit1
            $currentCreditAccount1 = $creditAccount1->account_num ;
            $creditLevels1 = [];
            for ($k = strlen($currentCreditAccount1); $k > 0; $k--) {
                $creditLevels1[] = substr($currentCreditAccount1, 0, $k);
            }
            //dd($creditLevels1);
            foreach ($creditLevels1 as $relatedDebitLevel2) {

                $levelCreditAccount1 = Account::where('account_num',$relatedDebitLevel2)->first();
                //dd($levelCreditAccount1->current_balance);
                $levelCreditAccount1->update([
                    'current_balance' => $levelCreditAccount1->current_balance + $entry1->debit_amount,
                ]);
                //dd($levelCreditAccount1->current_balance);
            }

            //credit2
            $currentCreditAccount2 = $creditAccount2->account_num ;
            $creditLevels2 = [];
            for ($k = strlen($currentCreditAccount2); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount2, 0, $k);
            }

            //dd($creditLevels);
            foreach ($creditLevels2 as $relatedCreditLevel) {

                $levelCreditAccount2 = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount2->update([
                    'current_balance' => $levelCreditAccount2->current_balance +   $entry2->debit_amount,
                ]);
                 //dd($levelCreditAccount2->current_balance);
            }

        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية



            }elseif($invoice->payment_type == 'by_installments'){

                $supplier = Supplier::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('id',$invoice->supplier_id)->first();
                $debitAccount = Account::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$supplier->account_num)->first();
                $creditAccountParent1 = Account::where('name_ar','المخزون')->first();
                $creditAccount1 = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent1->id )->where('branch_id',Auth::user()->branch_id)->first();
                $creditAccountParent2 = Account::where('name_ar','ضريبة القيمة المضافة على المدخلات')->first();
                $creditAccount2 = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent2->id )->where('branch_id',Auth::user()->branch_id)->first();


                /////////////
                //قيد اليومية المركب
                //تسجيل مردودات المشتريات علي المخزون دائن
                $entry1 = new JournalEntry();
                $entry1->entry_num = $entry;
                $entry1->debit_account_num = $debitAccount->account_num;
                $entry1->debit_account_id = $debitAccount->id;
                $entry1->credit_account_num = $creditAccount1->account_num;
                $entry1->credit_account_id = $creditAccount1->id;
                $entry1->debit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $entry1->credit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $entry1->branch_id = Auth::user()->branch_id;
                $entry1->jounralable_type = 'App\Models\SupplierInvoice';
                $entry1->jounralable_id = $invoice->id;
                $entry1->entry_type_id =2 ;
                $entry1->created_by = Auth::user()->id;
                $entry1->updated_by = Auth::user()->id;
                $entry1->description = " من ح / $debitAccount->name "  . " إلي ح / $creditAccount1->name" ;
                $entry1->date = $invoice->supp_inv_date_time;
                $entry1->save();


                // ء تسجيل الضريبة علي المدخلات دائن

                $entry2 = new JournalEntry();
                $entry2->entry_num = $entry;
                $entry2->debit_account_num = $debitAccount->account_num;
                $entry2->debit_account_id = $debitAccount->id;
                $entry2->credit_account_num = $creditAccount2->account_num;
                $entry2->credit_account_id = $creditAccount2->id;
                $entry2->debit_amount = $invoice->tax_value;
                $entry2->credit_amount = $invoice->tax_value;
                $entry2->branch_id = Auth::user()->branch_id;
                $entry2->jounralable_type = 'App\Models\SupplierInvoice';
                $entry2->jounralable_id = $invoice->id;
                $entry2->entry_type_id =2 ;
                $entry2->created_by = Auth::user()->id;
                $entry2->updated_by = Auth::user()->id;
                $entry2->description = "من ح / $debitAccount->name ". " إلي ح /  $creditAccount2->name " ;
                $entry2->date = $invoice->supp_inv_date_time;
                $entry2->save();


                $creditAccount1->current_balance = $creditAccount1->current_balance - $entry1->credit_amount;
                $creditAccount1->save();

                $creditAccount2->current_balance = $creditAccount2->current_balance - $entry2->credit_amount;
                $creditAccount2->save();



                //الاستاذ العام للمورد مدين
                $ledger1 = new Ledger();
                $ledger1->debit_amount = $entry1->debit_amount;
                $ledger1->credit_amount = 0;
                $ledger1->account_id = $debitAccount->id;
                $ledger1->account_num = $debitAccount->account_num;
                $ledger1->created_by = Auth::user()->id;
                $ledger1->name_ar = $debitAccount->name;
                $ledger1->journal_entry_id = $entry1->id;
                $ledger1->type = 'journal_entry';
                $ledger1->save();

                //الاستاذ العام للمورد مدين
                $ledger2 = new Ledger();
                $ledger2->debit_amount = $entry2->debit_amount;
                $ledger2->credit_amount = 0;
                $ledger2->account_id = $debitAccount->id;
                $ledger2->account_num = $debitAccount->account_num;
                $ledger2->created_by = Auth::user()->id;
                $ledger2->name_ar = $debitAccount->name;
                $ledger2->journal_entry_id = $entry2->id;
                $ledger2->type = 'journal_entry';
                $ledger2->save();

                //الاستاذ العام لضريبة القيمة المضافة علي المدخلات دائن
                $ledger3 = new Ledger();
                $ledger3->debit_amount = 0;
                $ledger3->credit_amount = $entry2->credit_amount ;
                $ledger3->account_id = $creditAccount2->id;
                $ledger3->account_num = $creditAccount2->account_num;
                $ledger3->created_by = Auth::user()->id;
                $ledger3->name_ar = $creditAccount2->name;
                $ledger3->journal_entry_id = $entry2->id;
                $ledger3->type = 'journal_entry';
                $ledger3->save();

                //الاستاذ العام للمخزون دائن
                $ledger4 = new Ledger();
                $ledger4->debit_amount = 0;
                $ledger4->credit_amount = $entry1->credit_amount;
                $ledger4->account_id = $creditAccount1->id;
                $ledger4->account_num = $creditAccount1->account_num;
                $ledger4->created_by = Auth::user()->id;
                $ledger4->name_ar = $creditAccount1->name;
                $ledger4->journal_entry_id = $entry1->id;
                $ledger4->type = 'journal_entry';
                $ledger4->save();

                //الاستاذ المساعد للخزينة مدين
                $tAccount1 = new TAccount();
                $tAccount1->serial_num = getNextTAccountSerial();
                $tAccount1->account_num = $entry1->debit_account_num;
                $tAccount1->journal_type = 'مدين';
                $tAccount1->amount = $entry1->debit_amount;
                $tAccount1->description = "الي ح / $creditAccount1->name";
                $tAccount1->journal_entry_id = $entry1->id;
                $tAccount1->account_id = $debitAccount->id;
                $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
                $tAccount1->created_by = Auth::user()->id;
                $tAccount1->save();

                //الاستاذ المساعد للمخزون دائن
                $tAccount2 = new TAccount();
                $tAccount2->serial_num = getNextTAccountSerial();
                $tAccount2->account_num = $entry1->credit_account_num;
                $tAccount2->journal_type = 'دائن';
                $tAccount2->amount = $entry1->credit_amount;
                $tAccount2->description = " / من ح  $debitAccount->name  ";
                $tAccount2->journal_entry_id = $entry1->id;
                $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
                $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
                $tAccount2->created_by = Auth::user()->id;
                $tAccount2->save();

                //الاستاذ المساعد للمورد مدين
                $tAccount3 = new TAccount();
                $tAccount3->serial_num = getNextTAccountSerial();
                $tAccount3->account_num = $entry2->debit_account_num;
                $tAccount3->journal_type = 'مدين';
                $tAccount3->amount = $entry2->debit_amount;
                $tAccount3->description = "الي ح / $creditAccount2->name";
                $tAccount3->journal_entry_id = $entry2->id;
                $tAccount3->account_id = $debitAccount->id;
                $tAccount3->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
                $tAccount3->created_by = Auth::user()->id;
                $tAccount3->save();



                //الاستاذ المساعد ضر يبة القيمة المضافة دائن
                $tAccount4 = new TAccount();
                $tAccount4->serial_num = getNextTAccountSerial();
                $tAccount4->account_num = $entry2->credit_account_num;
                $tAccount4->journal_type = 'دائن';
                $tAccount4->amount = $entry2->credit_amount;
                $tAccount4->description = " / من ح  $debitAccount->name  ";
                $tAccount4->journal_entry_id = $entry2->id;
                $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
                $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
                $tAccount4->created_by = Auth::user()->id;
                $tAccount4->save();


                $creditAccount1->current_balance  = $creditAccount1->current_balance - $entry1->credit_amount;
                $creditAccount1->save() ;


                $creditAccount2->current_balance  = $creditAccount2->current_balance - $entry2->credit_amount;
                $creditAccount2->save() ;

                $debitAccount->current_balance  = $debitAccount->current_balance - $entry2->credit_amount;
                $debitAccount->save() ;

                $supplier->current_balance = $supplier->current_balance + $invoice->total_after_discount;
                $supplier->save();



                //fill row in supplier return table



                /////////////





                //fill row in supplier return table

                $InvNum_with_prefix = $invoice->supp_inv_num;
                $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);




            }

        } if($invoice->return_payment_type == 'by_check') {
            if($invoice->payment_type == 'cash' || $invoice->payment_type == 'by_check'){
                //يضاف للبنك كامل مبلغ الفاتورة
                    $bank = Bank::where('id',$bankId)->first();
                    $debitAccount = Bank::select('id',
                    'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$bankId)->first();
                    // $debitAccount->current_balance = $bank->current_balanc + $invoice->total_after_discount;
                    // $debitAccount->save();


                    $bank->current_balance = $bank->current_balance + $invoice->total_after_discount;
                    $bank->last_exchange_receipt = $transaction->serial_num;
                    $bank->save();

                //bank transaction

                    $transaction = new BankTransaction();
                    $transaction->transaction_type_id = 8;
                    $transaction->transactionable_type="App\Models\Supplier" ;
                    $transaction->transactionable_id= $invoice->supplir_id ;
                    $transaction->account_num=  $debitAccount->account_num ;
                    $transaction->is_account=1 ;
                    $transaction->is_approved=1;
                    $transaction->is_confirmed=1;
                    $transaction->amount = $invoice->total_after_discount;
                    $transaction->deserved_account_amount = Supplier::where('id',$invoice->supplier_id)->first()->current_balance;
                    $transaction->branch_id = Auth::user()->branch_id;
                    $transaction->bank_id = $bank->id;
                    $transaction->description = "شيك تحصيل مردودات مشتريات من مورد عن فاتورة توريد رقم $invoice->supp_inv_num ";
                    $transaction->check_num = $invoice->check_num;
                    $transaction->inv_num = $invoice->supp_inv_num;
                    $transaction->save();

                //قيد اليومية المركب
                    //تسجيل مردودات المشتريات علي المخزون دائن
                    $entry1 = new JournalEntry();
                    $entry1->entry_num = $entry;
                    $entry1->debit_account_num = $debitAccount->account_num;
                    $entry1->debit_account_id = $debitAccount->id;
                    $entry1->credit_account_num = $creditAccount1->account_num;
                    $entry1->credit_account_id = $creditAccount1->id;
                    $entry1->debit_amount = $invoice->total_after_discount - $invoice->tax_value;
                    $entry1->credit_amount = $invoice->total_after_discount - $invoice->tax_value;
                    $entry1->branch_id = Auth::user()->branch_id;
                    $entry1->jounralable_type = 'App\Models\SupplierInvoice';
                    $entry1->jounralable_id = $invoice->id;
                    $entry1->entry_type_id =2 ;
                    $entry1->created_by = Auth::user()->id;
                    $entry1->updated_by = Auth::user()->id;
                    $entry1->description = "/ من ح " . $debitAccount->name . "/ إلي ح " . $creditAccount1->name ;
                    $entry1->date = $invoice->supp_inv_date_time;
                    $entry1->save();


                    // ء تسجيل الضريبة علي المدخلات دائن

                    $entry2 = new JournalEntry();
                    $entry2->entry_num = $entry;
                    $entry2->debit_account_num = $debitAccount->account_num;
                    $entry2->debit_account_id = $debitAccount->id;
                    $entry2->credit_account_num = $creditAccount2->account_num;
                    $entry2->credit_account_id = $creditAccount2->id;
                    $entry2->debit_amount = $invoice->tax_value;
                    $entry2->credit_amount = $invoice->tax_value;
                    $entry2->branch_id = Auth::user()->branch_id;
                    $entry2->jounralable_type = 'App\Models\SupplierInvoice';
                    $entry2->jounralable_id = $invoice->id;
                    $entry2->entry_type_id =2 ;
                    $entry2->created_by = Auth::user()->id;
                    $entry2->updated_by = Auth::user()->id;
                    $entry2->description = "/ من ح " . $debitAccount->name . "/ إلي ح " . $creditAccount2->name ;
                    $entry2->date = $invoice->supp_inv_date_time;
                    $entry2->save();


                    // $creditAccount1->current_balance = $creditAccount1->current_balance - $entry1->credit_amount;
                    // $creditAccount1->save();

                    // $creditAccount2->current_balance = $creditAccount2->current_balance - $entry2->credit_amount;
                    // $creditAccount2->save();



                    //الاستاذ العام للبنك مدين
                    $ledger1 = new Ledger();
                    $ledger1->debit_amount = $entry1->debit_amount;
                    $ledger1->credit_amount = 0;
                    $ledger1->account_id = $debitAccount->id;
                    $ledger1->account_num = $debitAccount->account_num;
                    $ledger1->created_by = Auth::user()->id;
                    $ledger1->name_ar = $debitAccount->name;
                    $ledger1->journal_entry_id = $entry1->id;
                    $ledger1->type = 'journal_entry';
                    $ledger1->save();

                    //الاستاذ العام للبنك مدين
                    $ledger2 = new Ledger();
                    $ledger2->debit_amount = $entry2->debit_amount;
                    $ledger2->credit_amount = 0;
                    $ledger2->account_id = $debitAccount->id;
                    $ledger2->account_num = $debitAccount->account_num;
                    $ledger2->created_by = Auth::user()->id;
                    $ledger2->name_ar = $debitAccount->name;
                    $ledger2->journal_entry_id = $entry2->id;
                    $ledger2->type = 'journal_entry';
                    $ledger2->save();

                    //الاستاذ العام لضريبة القيمة المضافة علي المدخلات دائن
                    $ledger3 = new Ledger();
                    $ledger3->debit_amount = 0;
                    $ledger3->credit_amount = $entry2->credit_amount ;
                    $ledger3->account_id = $creditAccount2->id;
                    $ledger3->account_num = $creditAccount2->account_num;
                    $ledger3->created_by = Auth::user()->id;
                    $ledger3->name_ar = $creditAccount2->name;
                    $ledger3->journal_entry_id = $entry2->id;
                    $ledger3->type = 'journal_entry';
                    $ledger3->save();

                            // dd(Ledger::where('account_num',$treasury->account_num)->first());

                    //الاستاذ العام للمخزون دائن
                    $ledger4 = new Ledger();
                    $ledger4->debit_amount = 0;
                    $ledger4->credit_amount = $entry1->credit_amount;
                    $ledger4->account_id = $creditAccount1->id;
                    $ledger4->account_num = $creditAccount1->account_num;
                    $ledger4->created_by = Auth::user()->id;
                    $ledger4->name_ar = $creditAccount1->name;
                    $ledger4->save();

                    //الاستاذ المساعد للخزينة مدين
                    $tAccount1 = new TAccount();
                    $tAccount1->serial_num = getNextTAccountSerial();
                    $tAccount1->account_num = $entry1->debit_account_num;
                    $tAccount1->journal_type = 'مدين';
                    $tAccount1->amount = $entry1->debit_amount;
                    $tAccount1->description = "الي ح / $creditAccount1->name";
                    $tAccount1->journal_entry_id = $entry1->id;
                    $tAccount1->account_id = $debitAccount->id;
                    $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
                    $tAccount1->created_by = Auth::user()->id;
                    $tAccount1->save();

                    //الاستاذ المساعد للمخزون دائن
                    $tAccount2 = new TAccount();
                    $tAccount2->serial_num = getNextTAccountSerial();
                    $tAccount2->account_num = $entry1->credit_account_num;
                    $tAccount2->journal_type = 'دائن';
                    $tAccount2->amount = $entry1->credit_amount;
                    $tAccount2->description = " / من ح  $debitAccount->name  ";
                    $tAccount2->journal_entry_id = $entry1->id;
                    $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
                    $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
                    $tAccount2->created_by = Auth::user()->id;
                    $tAccount2->save();

                    //الاستاذ المساعد للخزينة مدين
                    $tAccount3 = new TAccount();
                    $tAccount3->serial_num = getNextTAccountSerial();
                    $tAccount3->account_num = $entry2->debit_account_num;
                    $tAccount3->journal_type = 'مدين';
                    $tAccount3->amount = $entry2->debit_amount;
                    $tAccount3->description = "الي ح / $creditAccount2->name";
                    $tAccount3->journal_entry_id = $entry2->id;
                    $tAccount3->account_id = $debitAccount->id;
                    $tAccount3->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
                    $tAccount3->created_by = Auth::user()->id;
                    $tAccount3->save();



                    //الاستاذ المساعد ضر يبة القيمة المضافة دائن
                    $tAccount4 = new TAccount();
                    $tAccount4->serial_num = getNextTAccountSerial();
                    $tAccount4->account_num = $entry2->credit_account_num;
                    $tAccount4->journal_type = 'دائن';
                    $tAccount4->amount = $entry2->credit_amount;
                    $tAccount4->description = " / من ح  $debitAccount->name  ";
                    $tAccount4->journal_entry_id = $entry2->id;
                    $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
                    $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
                    $tAccount4->created_by = Auth::user()->id;
                    $tAccount4->save();



                // $creditAccount1->current_balance  = $creditAccount1->current_balance - $entry1->credit_amount;
                // $creditAccount1->save() ;


                // $creditAccount2->current_balance  = $creditAccount2->current_balance - $entry2->credit_amount;
                // $creditAccount2->save() ;

                // $debitAccount->current_balance  = $debitAccount->current_balance - $entry2->credit_amount;
                // $debitAccount->save() ;

                $bank->current_balance = $bank->current_balance + $invoice->total_after_discount;
                $bank->save();




            //fill row in supplier return table

            $InvNum_with_prefix = $invoice->supp_inv_num;
            $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);

            // createSupplierTotalReturn($InvNum_without_prefix );


                        //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            //debit
            $currentDebitAccount1 = $debitAccount->account_num ;
            $debitLevels1 = [];
            for ($k = strlen($currentDebitAccount1); $k > 0; $k--) {
                $debitLevels1[] = substr($currentDebitAccount1, 0, $k);
            }
            //dd($debitLevels1);
            foreach ($debitLevels1 as $relatedDebitLevel1) {

                $levelDebitAccount1 = Account::where('account_num',$relatedDebitLevel1)->first();
                //dd($levelDebitAccount1->current_balance);
                $levelDebitAccount1->update([
                    'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount + $entry2->debit,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }
            //credit1
            $currentCreditAccount1 = $creditAccount1->account_num ;
            $creditLevels1 = [];
            for ($k = strlen($currentCreditAccount1); $k > 0; $k--) {
                $creditLevels1[] = substr($currentCreditAccount1, 0, $k);
            }
            //dd($creditLevels1);
            foreach ($creditLevels1 as $relatedDebitLevel2) {

                $levelCreditAccount1 = Account::where('account_num',$relatedDebitLevel2)->first();
                //dd($levelCreditAccount1->current_balance);
                $levelCreditAccount1->update([
                    'current_balance' => $levelCreditAccount1->current_balance - $entry1->debit_amount,
                ]);
                //dd($levelCreditAccount1->current_balance);
            }

            //credit2
            $currentCreditAccount2 = $creditAccount2->account_num ;
            $creditLevels2 = [];
            for ($k = strlen($currentCreditAccount2); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount2, 0, $k);
            }

            //dd($creditLevels);
            foreach ($creditLevels2 as $relatedCreditLevel) {

                $levelCreditAccount2 = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount2->update([
                    'current_balance' => $levelCreditAccount2->current_balance +  $entry2->debit_amount,
                ]);
                 //dd($levelCreditAccount2->current_balance);
            }

        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية



            }elseif($invoice->payment_type == 'by_installments'){

            }


        } if($invoice->return_payment_type == 'by_installments') {

            //update supplier balance
            $supplier = Supplier::where('id',$invoice->supplier_id)->first();


                       //يضاف للمورد كامل مبلغ الفاتورة

            $debitAccount = Bank::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$supplier->id)->first();



            $supplier->current_balance = $supplier->current_balance + $invoice->total_after_discount;
            $supplier->save();





            $creditAccountParent1 = Account::where('name_ar','المخزون')->first();
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent1->id )->where('branch_id',Auth::user()->branch_id)->first();
            $creditAccountParent2 = Account::where('name_ar','ضريبة القيمة المضافة على المدخلات')->first();
            $creditAccount2 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent2->id )->where('branch_id',Auth::user()->branch_id)->first();



            //قيد اليومية المركب
                //تسجيل مردودات المشتريات علي المخزون دائن
                $entry1 = new JournalEntry();
                $entry1->entry_num = $entry;
                $entry1->debit_account_num = $debitAccount->account_num;
                $entry1->debit_account_id = $debitAccount->id;
                $entry1->credit_account_num = $creditAccount1->account_num;
                $entry1->credit_account_id = $creditAccount1->id;
                $entry1->debit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $entry1->credit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $entry1->branch_id = Auth::user()->branch_id;
                $entry1->jounralable_type = 'App\Models\SupplierInvoice';
                $entry1->jounralable_id = $invoice->id;
                $entry1->entry_type_id =2 ;
                $entry1->created_by = Auth::user()->id;
                $entry1->updated_by = Auth::user()->id;
                $entry1->description = "/ من ح " . $debitAccount->name . "/ إلي ح " . $creditAccount1->name ;
                $entry1->date = $invoice->supp_inv_date_time;
                $entry1->save();


                // ء تسجيل الضريبة علي المدخلات دائن

                $entry2 = new JournalEntry();
                $entry2->entry_num = $entry;
                $entry2->debit_account_num = $debitAccount->account_num;
                $entry2->debit_account_id = $debitAccount->id;
                $entry2->credit_account_num = $creditAccount2->account_num;
                $entry2->credit_account_id = $creditAccount2->id;
                $entry2->debit_amount = $invoice->tax_value;
                $entry2->credit_amount = $invoice->tax_value;
                $entry2->branch_id = Auth::user()->branch_id;
                $entry2->jounralable_type = 'App\Models\SupplierInvoice';
                $entry2->jounralable_id = $invoice->id;
                $entry2->entry_type_id =2 ;
                $entry2->created_by = Auth::user()->id;
                $entry2->updated_by = Auth::user()->id;
                $entry2->description = "/ من ح " . $debitAccount->name . "/ إلي ح " . $creditAccount2->name ;
                $entry2->date = $invoice->supp_inv_date_time;
                $entry2->save();






                    //الاستاذ العام للمورد مدين
                    $ledger1 = new Ledger();
                    $ledger1->debit_amount = $entry1->debit_amount;
                    $ledger1->credit_amount = 0;
                    $ledger1->account_id = $debitAccount->id;
                    $ledger1->account_num = $debitAccount->account_num;
                    $ledger1->created_by = Auth::user()->id;
                    $ledger1->name_ar = $debitAccount->name;
                    $ledger1->journal_entry_id = $entry1->id;
                    $ledger1->type = 'journal_entry';
                    $ledger1->save();

                    //الاستاذ العام للمورد مدين
                    $ledger2 = new Ledger();
                    $ledger2->debit_amount = $entry2->debit_amount;
                    $ledger2->credit_amount = 0;
                    $ledger2->account_id = $debitAccount->id;
                    $ledger2->account_num = $debitAccount->account_num;
                    $ledger2->created_by = Auth::user()->id;
                    $ledger2->name_ar = $debitAccount->name;
                    $ledger2->journal_entry_id = $entry2->id;
                    $ledger2->type = 'journal_entry';
                    $ledger2->save();

                    //الاستاذ العام لضريبة القيمة المضافة علي المدخلات دائن
                    $ledger3 = new Ledger();
                    $ledger3->debit_amount = 0;
                    $ledger3->credit_amount = $entry2->credit_amount ;
                    $ledger3->account_id = $creditAccount2->id;
                    $ledger3->account_num = $creditAccount2->account_num;
                    $ledger3->created_by = Auth::user()->id;
                    $ledger3->name_ar = $creditAccount2->name;
                    $ledger3->journal_entry_id = $entry2->id;
                    $ledger3->type = 'journal_entry';
                    $ledger3->save();

                            // dd(Ledger::where('account_num',$treasury->account_num)->first());

                    //الاستاذ العام للمخزون دائن
                    $ledger4 = new Ledger();
                    $ledger4->debit_amount = 0;
                    $ledger4->credit_amount = $entry1->credit_amount;
                    $ledger4->account_id = $creditAccount1->id;
                    $ledger4->account_num = $creditAccount1->account_num;
                    $ledger4->created_by = Auth::user()->id;
                    $ledger4->name_ar = $creditAccount1->name;
                    $ledger4->journal_entry_id = $entry1->id;
                    $ledger4->type = 'journal_entry';
                    $ledger4->save();

                    //الاستاذ المساعد للمورد مدين
                    $tAccount1 = new TAccount();
                    $tAccount1->serial_num = getNextTAccountSerial();
                    $tAccount1->account_num = $entry1->debit_account_num;
                    $tAccount1->journal_type = 'مدين';
                    $tAccount1->amount = $entry1->debit_amount;
                    $tAccount1->description = "الي ح / $creditAccount1->name";
                    $tAccount1->journal_entry_id = $entry1->id;
                    $tAccount1->account_id = $debitAccount->id;
                    $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
                    $tAccount1->created_by = Auth::user()->id;
                    $tAccount1->save();

                    //الاستاذ المساعد للمخزون دائن
                    $tAccount2 = new TAccount();
                    $tAccount2->serial_num = getNextTAccountSerial();
                    $tAccount2->account_num = $entry1->credit_account_num;
                    $tAccount2->journal_type = 'دائن';
                    $tAccount2->amount = $entry1->credit_amount;
                    $tAccount2->description = " / من ح  $debitAccount->name  ";
                    $tAccount2->journal_entry_id = $entry1->id;
                    $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
                    $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
                    $tAccount2->created_by = Auth::user()->id;
                    $tAccount2->save();

                    //الاستاذ المساعد للمورد مدين
                    $tAccount3 = new TAccount();
                    $tAccount3->serial_num = getNextTAccountSerial();
                    $tAccount3->account_num = $entry2->debit_account_num;
                    $tAccount3->journal_type = 'مدين';
                    $tAccount3->amount = $entry2->debit_amount;
                    $tAccount3->description = "الي ح / $creditAccount2->name";
                    $tAccount3->journal_entry_id = $entry2->id;
                    $tAccount3->account_id = $debitAccount->id;
                    $tAccount3->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
                    $tAccount3->created_by = Auth::user()->id;
                    $tAccount3->save();



                    //الاستاذ المساعد ضر يبة القيمة المضافة دائن
                    $tAccount4 = new TAccount();
                    $tAccount4->serial_num = getNextTAccountSerial();
                    $tAccount4->account_num = $entry2->credit_account_num;
                    $tAccount4->journal_type = 'دائن';
                    $tAccount4->amount = $entry2->credit_amount;
                    $tAccount4->description = " / من ح  $debitAccount->name  ";
                    $tAccount4->journal_entry_id = $entry2->id;
                    $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
                    $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
                    $tAccount4->created_by = Auth::user()->id;
                    $tAccount4->save();



                // $creditAccount1->current_balance  = $creditAccount1->current_balance - $entry1->credit_amount;
                // $creditAccount1->save() ;


                // $creditAccount2->current_balance  = $creditAccount2->current_balance - $entry2->credit_amount;
                // $creditAccount2->save() ;

                // $debitAccount->current_balance  = $debitAccount->current_balance - $entry2->credit_amount;
                // $debitAccount->save() ;

                $supplier->current_balance = $supplier->current_balance + $invoice->total_after_discount;
                $supplier->save();




            //fill row in supplier return table

            $InvNum_with_prefix = $invoice->supp_inv_num;
            $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);

            // createSupplierTotalReturn($InvNum_without_prefix );


          //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
            //debit
            $currentDebitAccount1 = $debitAccount->account_num ;
            $debitLevels1 = [];
            for ($k = strlen($currentDebitAccount1); $k > 0; $k--) {
                $debitLevels1[] = substr($currentDebitAccount1, 0, $k);
            }
            //dd($debitLevels1);
            foreach ($debitLevels1 as $relatedDebitLevel1) {

                $levelDebitAccount1 = Account::where('account_num',$relatedDebitLevel1)->first();
                //dd($levelDebitAccount1->current_balance);
                $levelDebitAccount1->update([
                    'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount + $entry2->debit,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }
            //credit1
            $currentCreditAccount1 = $creditAccount1->account_num ;
            $creditLevels1 = [];
            for ($k = strlen($currentCreditAccount1); $k > 0; $k--) {
                $creditLevels1[] = substr($currentCreditAccount1, 0, $k);
            }
            //dd($creditLevels1);
            foreach ($creditLevels1 as $relatedDebitLevel2) {

                $levelCreditAccount1 = Account::where('account_num',$relatedDebitLevel2)->first();
                //dd($levelCreditAccount1->current_balance);
                $levelCreditAccount1->update([
                    'current_balance' => $levelCreditAccount1->current_balance - $entry1->debit_amount,
                ]);
                //dd($levelCreditAccount1->current_balance);
            }

            //credit2
            $currentCreditAccount2 = $creditAccount2->account_num ;
            $creditLevels2 = [];
            for ($k = strlen($currentCreditAccount2); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount2, 0, $k);
            }

            //dd($creditLevels);
            foreach ($creditLevels2 as $relatedCreditLevel) {

                $levelCreditAccount2 = Account::where('account_num',$relatedCreditLevel)->first();

                $levelCreditAccount2->update([
                    'current_balance' => $levelCreditAccount2->current_balance -  $entry2->debit_amount,
                ]);
                 //dd($levelCreditAccount2->current_balance);
            }

        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية


        }

    }
}

