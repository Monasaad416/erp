<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Branch;
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

class FinancialsAfterNewSuppInvoice
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

        $entry = getNextJournalEntryNum();

        //update invoice & supplier balance
        $supplier = Supplier::where('id',$invoice->supplier_id)->first();

        $invoice->supp_balance_before_invoice = $supplier->current_balance;
        $invoice->supp_balance_after_invoice = $supplier->current_balance ;
        $invoice->status = 2;
        $invoice->paid_amount = $invoice->total_after_discount;
        $invoice->save();


        //debit accounts المخزون+ ضريبة المدخلات
        $debitAccountParent1 = Account::select(
            'id',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'account_num'
        )->where('account_num', 1224)->first();
        $debitAccount1 = Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num')->where('parent_id', $debitAccountParent1->id)->where('branch_id', Auth::user()->branch_id)->first();
        $debitAccountParent2 = Account::select(
            'id',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'account_num'
        )->where('account_num', 1236)->first();
        $debitAccount2 = Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num')->where('parent_id', $debitAccountParent2->id)->where('branch_id', Auth::user()->branch_id)->first();


        $debitAccountParent3 = Account::select(
            'id',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'account_num'
        )->where('account_num', 55)->first(); // مصروفات المشتريات - النقل
        $debitAccount3 = Account::select('id', 'name_' . LaravelLocalization::getCurrentLocale() . ' as name', 'account_num')->where('parent_id', $debitAccountParent3->id)->where('branch_id', Auth::user()->branch_id)->first();


        dd($invoice->branch_id);

        if($invoice->payment_type == 'cash') {

            //credit account الخزينة

            $treasury = Treasury::where('branch_id',$invoice->branch_id)->first();
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();

            $transaction = new Transaction();
            $transaction->transaction_type_id = 9;
            $transaction->transactionable_type="App\Models\Supplier" ;
            $transaction->transactionable_id= $invoice->id ;
            $transaction->account_num= $treasury->account_num ;
            $transaction->is_account=1 ;
            $transaction->is_approved=1;
            $transaction->state = 'صرف';
            $transaction->treasury_shift_id= TreasuryShift::where('delivered_to_user_id',Auth::user()->id)->where('branch_id',Auth::user()->branch_id)->latest()->first()->id;
            $transaction->receipt_amount= $invoice->total_after_discount;
            $transaction->deserved_account_amount=  Supplier::where('id',$invoice->supplier_id)->first()->current_balance;
            $transaction->branch_id = 1;
            $transaction->treasury_id = $treasury->id;
            $transaction->description= "إيصال صرف مستحقات للمورد عن فاتورة توريد رقم $invoice->supp_inv_num ";
            $transaction->serial_num = getNextSerial();
            $transaction->inv_num = $invoice->supp_inv_num;
            $transaction->date = Carbon::now();
            $transaction->save();


            $treasury->last_exchange_receipt = $transaction->serial_num;
            $treasury->save();




            //قيد اليومية المركب
            //تسجيل المخزون
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount1->account_num;
            $entry1->debit_account_id = $debitAccount1->id;
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
            $entry1->description = " من ح  /  $debitAccount1->name   الي ح  /  $creditAccount1->name " ;
            $entry1->date = $invoice->supp_inv_date_time;
            $entry1->save();

            //تسجيل الضريبة


            $entry2 = new JournalEntry();
            $entry2->entry_num = $entry;
            $entry2->debit_account_num = $debitAccount2->account_num;
            $entry2->debit_account_id = $debitAccount2->id;
            $entry2->credit_account_num = $creditAccount1->account_num;
            $entry2->credit_account_id = Account::where('account_num',$creditAccount1->account_num)->first()->id;
            $entry2->debit_amount = $invoice->tax_value;
            $entry2->credit_amount = $invoice->tax_value;
            $entry2->branch_id = Auth::user()->branch_id;
            $entry2->jounralable_type = 'App\Models\SupplierInvoice';
            $entry2->jounralable_id = $invoice->id;
            $entry2->entry_type_id =2 ;
            $entry2->created_by = Auth::user()->id;
            $entry2->updated_by = Auth::user()->id;
            $entry2->description  = "من ح  /  $debitAccount2->name   الي ح / $creditAccount1->name " ;
            $entry2->date = $invoice->supp_inv_date_time;
            $entry2->save();



            //تحديث رصيد الخزنة
            $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',Auth::user()->branch_id)->first();
            $treasury->current_balance = $treasury->current_balance - $invoice->total_after_discount;
            $treasury->save();

            //الاستاذ العام للمخزون مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount1->id;
            $ledger1->account_num = $debitAccount1->account_num;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->name_ar = $debitAccount1->name;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $invoice->supp_inv_date_time;
            $ledger1->save();

            //الاستاذ العام لضريبة القيمة المضافة علي المدخلات مدين
            $ledger2 = new Ledger();
            $ledger2->debit_amount = $entry2->debit_amount;
            $ledger2->credit_amount = 0 ;
            $ledger2->account_id = $debitAccount2->id;
            $ledger2->account_num = $debitAccount2->account_num;
            $ledger2->name_ar = $debitAccount2->name;
            $ledger2->created_by = Auth::user()->id;
            $ledger2->journal_entry_id = $entry2->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $invoice->supp_inv_date_time;
            $ledger2->save();

            //الاستاذ العام للخزينة دائن
            $ledger3 = new Ledger();
            $ledger3->debit_amount = 0;
            $ledger3->credit_amount = $entry1->credit_amount;
            $ledger3->account_id = $creditAccount1->id;
            $ledger3->account_num = $creditAccount1->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->name_ar = $creditAccount1->name;
            $ledger3->journal_entry_id = $entry1->id;
            $ledger3->type = 'journal_entry';
            $ledger3->date = $invoice->supp_inv_date_time;
            $ledger3->save();

            $ledger4 = new Ledger();
            $ledger4->debit_amount = 0;
            $ledger4->credit_amount = $entry2->credit_amount;
            $ledger4->account_id = $creditAccount1->id;
            $ledger4->account_num = $creditAccount1->account_num;
            $ledger4->created_by = Auth::user()->id;
            $ledger4->name_ar = $creditAccount1->name;
            $ledger4->journal_entry_id = $entry2->id;
            $ledger4->type = 'journal_entry';
            $ledger4->date = $invoice->supp_inv_date_time;
            $ledger4->save();

            //الاستاذ المساعد للمخزون مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry1->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry1->debit_amount;
            $tAccount1->description = " الي ح / $creditAccount1->name  ";
            $tAccount1->journal_entry_id = $entry1->id;
            $tAccount1->account_id = $debitAccount1->id;
            $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
            $tAccount1->created_by = Auth::user()->id;
            $tAccount1->save();

            //الاستاذ المساعد للضريبة مدين
            $tAccount2 = new TAccount();
            $tAccount2->serial_num = getNextTAccountSerial();
            $tAccount2->account_num = $entry2->debit_account_num;
            $tAccount2->journal_type = 'مدين';
            $tAccount2->amount = $entry2->debit_amount;
            $tAccount2->description =  "   الي ح / $creditAccount1->name";
            $tAccount2->journal_entry_id = $entry2->id;
            $tAccount2->account_id = $debitAccount2->id;
            $tAccount2->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
            $tAccount2->created_by = Auth::user()->id;
            $tAccount2->save();

                //الاستاذ المساعد للخزينة دائن
            $tAccount3 = new TAccount();
            $tAccount3->serial_num = getNextTAccountSerial();
            $tAccount3->account_num = $entry1->credit_account_num;
            $tAccount3->journal_type = 'دائن';
            $tAccount3->amount = $entry1->credit_amount;
            $tAccount3->description = "من ح/  $debitAccount1->name";
            $tAccount3->journal_entry_id = $entry1->id;
            $tAccount3->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount3->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount3->created_by = Auth::user()->id;
            $tAccount3->save();

            //الاستاذ المساعد للخزينة دائن
            $tAccount4 = new TAccount();
            $tAccount4->serial_num = getNextTAccountSerial();
            $tAccount4->account_num = $entry2->credit_account_num;
            $tAccount4->journal_type = 'دائن';
            $tAccount4->amount = $entry2->credit_amount;
            $tAccount4->description  = "من ح/  $debitAccount2->name";
            $tAccount4->journal_entry_id = $entry2->id;
            $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
            $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
            $tAccount4->created_by = Auth::user()->id;
            $tAccount4->save();

        } if($invoice->payment_type == 'by_check') {


            //credit account البنك
            $bank = Bank::where('id',$invoice->bank_id)->first();

           
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$bank->account_num)->first();

            $transaction = new BankTransaction();
            $transaction->bank_transaction_type_id = 7;
            $transaction->transactionable_type="App\Models\Supplier" ;
            $transaction->transactionable_id= $invoice->id ;
            $transaction->account_num= $supplier->account_num ;
            $transaction->is_account=1 ;
            $transaction->is_approved=1;
            $transaction->is_confirmed=1;
            $transaction->amount=$invoice->total_after_discount;
            $transaction->deserved_account_amount=  Supplier::where('id',$invoice->supplier_id)->first()->current_balance;
            $transaction->branch_id = Auth::user()->branch_id;
            $transaction->bank_id = $bank->id;
            $transaction->description= "شيك صرف مستحقات للمورد عن فاتورة توريد رقم $invoice->supp_inv_num ";
            $transaction->check_num = $invoice->check_num;
            $transaction->inv_num = $invoice->supp_inv_num;
            $transaction->date = Carbon::now();
            $transaction->save();


            //قيد اليومية المركب
            //تسجيل المخزون
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount1->account_num;
            $entry1->debit_account_id = $debitAccount1->id;
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
            $entry1->description = " من ح  / $debitAccount1->name الي ح   /   $creditAccount1->name " ;
            $entry1->date = $invoice->supp_inv_date_time;
            $entry1->save();

            //تسجيل الضريبة
            $entry2 = new JournalEntry();
            $entry2->entry_num = $entry;
            $entry2->debit_account_num = $debitAccount2->account_num;
            $entry2->debit_account_id = $debitAccount2->id;
            $entry2->credit_account_num = $creditAccount1->account_num;
            $entry2->credit_account_id = Account::where('account_num',$creditAccount1->account_num)->first()->id;
            $entry2->debit_amount = $invoice->tax_value;
            $entry2->credit_amount = $invoice->tax_value;
            $entry2->branch_id = Auth::user()->branch_id;
            $entry2->jounralable_type = 'App\Models\SupplierInvoice';
            $entry2->jounralable_id = $invoice->id;
            $entry2->entry_type_id =2 ;
            $entry2->created_by = Auth::user()->id;
            $entry2->updated_by = Auth::user()->id;
            $entry2->description  = " من ح /  $debitAccount2->name   الي ح / $creditAccount1->name " ;
            $entry2->date = $invoice->supp_inv_date_time;
            $entry2->save();
            dd($invoice->transportation_fees);



            //تحديث رصيد البنك

            $bank->current_balance = $bank->current_balance - $invoice->total_after_discount;
            $bank->last_check = $transaction->check_num;
            $bank->save();


            //الاستاذ العام للمخزون مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount1->id;
            $ledger1->account_num = $debitAccount1->account_num;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->name_ar = $debitAccount1->name;
            $ledger1->journal_entry_id = $entry1->id;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $invoice->supp_inv_date_time;
            $ledger1->save();


            //الاستاذ العام لضريبة القيمة المضافة علي المدخلات مدين
            $ledger2 = new Ledger();
            $ledger2->debit_amount = $entry2->debit_amount;
            $ledger2->credit_amount = 0 ;
            $ledger2->account_id = $debitAccount2->id;
            $ledger2->account_num = $debitAccount2->account_num;
            $ledger2->created_by = Auth::user()->id;
            $ledger2->name_ar = $debitAccount2->name;
            $ledger2->journal_entry_id = $entry2->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $invoice->supp_inv_date_time;
            $ledger2->save();


            //الاستاذ العام للبنك دائن
            $ledger3 = new Ledger();
            $ledger3->debit_amount = 0;
            $ledger3->credit_amount = $entry1->credit_amount;
            $ledger3->account_id = $creditAccount1->id;
            $ledger3->account_num =$creditAccount1->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->name_ar = $creditAccount1->name;
            $ledger3->journal_entry_id = $entry1->id;
            $ledger3->type = 'journal_entry';
            $ledger3->date = $invoice->supp_inv_date_time;
            $ledger3->save();

            $ledger4 = new Ledger();
            $ledger4->debit_amount = 0;
            $ledger4->credit_amount = $entry2->credit_amount;
            $ledger4->account_id = $creditAccount1->id;
            $ledger4->account_num = $creditAccount1->account_num;
            $ledger4->created_by = Auth::user()->id;
            $ledger4->name_ar = $creditAccount1->name;
            $ledger4->journal_entry_id = $entry2->id;
            $ledger4->type = 'journal_entry';
            $ledger4->date = $invoice->supp_inv_date_time;
            $ledger4->save();

            //الاستاذ المساعد للمخزون مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry1->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry1->debit_amount;
            $tAccount1->description = "  الي ح  / $creditAccount1->name";
            $tAccount1->journal_entry_id = $entry1->id;
            $tAccount1->account_id = $debitAccount1->id;
            $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
            $tAccount1->created_by = Auth::user()->id;
            $tAccount1->save();

                //الاستاذ المساعد للضريبة مدين
            $tAccount2 = new TAccount();
            $tAccount2->serial_num = getNextTAccountSerial();
            $tAccount2->account_num = $entry2->debit_account_num;
            $tAccount2->journal_type = 'مدين';
            $tAccount2->amount = $entry2->debit_amount;
            $tAccount2->description =   "  الي ح  / $creditAccount1->name";
            $tAccount2->journal_entry_id = $entry2->id;
            $tAccount2->account_id = $debitAccount2->id;
            $tAccount2->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
            $tAccount2->created_by = Auth::user()->id;
            $tAccount2->save();

                //الاستاذ المساعد للخزينة دائن
            $tAccount3 = new TAccount();
            $tAccount3->serial_num = getNextTAccountSerial();
            $tAccount3->account_num = $entry1->credit_account_num;
            $tAccount3->journal_type = 'دائن';
            $tAccount3->amount = $entry1->credit_amount;
            $tAccount3->description = "من ح/   $debitAccount1->name";
            $tAccount3->journal_entry_id = $entry1->id;
            $tAccount3->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount3->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount3->created_by = Auth::user()->id;
            $tAccount3->save();

            //الاستاذ المساعد للخزينة دائن
            $tAccount4 = new TAccount();
            $tAccount4->serial_num = getNextTAccountSerial();
            $tAccount4->account_num = $entry2->credit_account_num;
            $tAccount4->journal_type = 'دائن';
            $tAccount4->amount = $entry2->credit_amount;
            $tAccount4->description  = "من ح/  $debitAccount2->name";
            $tAccount4->journal_entry_id = $entry2->id;
            $tAccount4->account_id = Account::where('account_num',$entry2->credit_account_num)->first()->id;
            $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
            $tAccount4->created_by = Auth::user()->id;
            $tAccount4->save();




        } if($invoice->payment_type == 'by_installments') {
            //update supplier balance
            $supplier = Supplier::where('id',$invoice->supplier_id)->first();
            $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$supplier->account_num)->first();
            //dd($creditAccount1);

            $invoice->supp_balance_before_invoice = $supplier->current_balance;
            $invoice->supp_balance_after_invoice = $supplier->current_balance - $invoice->total_after_discount;
            $invoice->status = 1;
            $invoice->paid_amount = 0 ;

            $invoice->save();

            $supplier->current_balance = $invoice->supp_balance_after_invoice;
            $supplier->save();

            // $creditAccount1->current_balance = $creditAccount1->current_balance - $invoice->total_after_discount;
            // $creditAccount1->save();


            //قيد اليومية المركب
            //تسجيل المخزون
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount1->account_num;
            $entry1->debit_account_id = $debitAccount1->id;
            $entry1->credit_account_num = $supplier->account_num;
            $entry1->credit_account_id =  $creditAccount1->id;
            $entry1->debit_amount = $invoice->total_after_discount - $invoice->tax_value;
            $entry1->credit_amount = $invoice->total_after_discount - $invoice->tax_value;
            $entry1->branch_id = Auth::user()->branch_id;
            $entry1->jounralable_type = 'App\Models\SupplierInvoice';
            $entry1->jounralable_id = $invoice->id;
            $entry1->entry_type_id =2 ;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description =  "من ح   /  $debitAccount1->name  الي ح  /   $creditAccount1->name " ;
            $entry1->date = $invoice->supp_inv_date_time;
            $entry1->save();

            //تسجيل الضريبة

            $entry2 = new JournalEntry();
            $entry2->entry_num = $entry;
            $entry2->debit_account_num = $debitAccount2->account_num;
            $entry2->debit_account_id = $debitAccount2->id;
            $entry2->credit_account_num = $creditAccount1->account_num;
            $entry2->credit_account_id = Account::where('account_num',$creditAccount1->account_num)->first()->id;
            $entry2->debit_amount = $invoice->tax_value;
            $entry2->credit_amount = $invoice->tax_value;
            $entry2->branch_id = Auth::user()->branch_id;
            $entry2->jounralable_type = 'App\Models\SupplierInvoice';
            $entry2->jounralable_id = $invoice->id;
            $entry2->entry_type_id =2 ;
            $entry2->created_by = Auth::user()->id;
            $entry2->updated_by = Auth::user()->id;
            $entry2->description =   "  من ح  / $debitAccount2->name  الي ح /  $creditAccount1->name " ;
            $entry2->date = $invoice->supp_inv_date_time;
            $entry2->save();



            //الاستاذ العام للمخزون مدين
            $ledger1 = new Ledger();
            $ledger1->debit_amount = $entry1->debit_amount;
            $ledger1->credit_amount = 0;
            $ledger1->account_id = $debitAccount1->id;
            $ledger1->account_num = $debitAccount1->account_num;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->name_ar = $debitAccount1->name;
            $ledger1->type = 'journal_entry';
            $ledger1->date = $invoice->supp_inv_date_time;
            $ledger1->save();


            //الاستاذ العام لضريبة القيمة المضافة علي المدخلات مدين
            $ledger2 = new Ledger();
            $ledger2->debit_amount = $entry2->debit_amount;
            $ledger2->credit_amount = 0 ;
            $ledger2->account_id = $debitAccount2->id;
            $ledger2->account_num = $debitAccount2->account_num;
            $ledger2->created_by = Auth::user()->id;
            $ledger2->name_ar = $debitAccount2->name;
            $ledger2->journal_entry_id = $entry2->id;
            $ledger2->type = 'journal_entry';
            $ledger2->date = $invoice->supp_inv_date_time;
            $ledger2->save();

            // dd(Ledger::where('account_num',$treasury->account_num)->first());
            $supplierLedger = Ledger::where('account_num',$creditAccount1->account_num)->first();
            //الاستاذ العام للمورد دائن
            $ledger3 = new Ledger();
            $ledger3->debit_amount = 0;
            $ledger3->credit_amount = $entry1->credit_amount;
            $ledger3->account_id = $creditAccount1->id;
            $ledger3->account_num = $creditAccount1->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->name_ar = $creditAccount1->name;
            $ledger3->journal_entry_id = $entry1->id;
            $ledger3->type = 'journal_entry';
            $ledger3->date = $invoice->supp_inv_date_time;
            $ledger3->save();

            $ledger4 = new Ledger();
            $ledger4->debit_amount = 0;
            $ledger4->credit_amount = $entry2->credit_amount;
            $ledger4->account_id = $creditAccount1->id;
            $ledger4->account_num = $creditAccount1->account_num;
            $ledger4->created_by = Auth::user()->id;
            $ledger4->name_ar = $creditAccount1->name;
            $ledger4->journal_entry_id = $entry2->id;
            $ledger4->type = 'journal_entry';
            $ledger4->date = $invoice->supp_inv_date_time;
            $ledger4->save();

            //الاستاذ المساعد للمخزون مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry1->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry1->debit_amount;
            $tAccount1->description = 'الي ح /'. $creditAccount1->name;
            $tAccount1->journal_entry_id = $entry1->id;
            $tAccount1->account_id = $debitAccount1->id;
            $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
            $tAccount1->created_by = Auth::user()->id;
            $tAccount1->save();

                //الاستاذ المساعد للضريبة مدين
            $tAccount2 = new TAccount();
            $tAccount2->serial_num = getNextTAccountSerial();
            $tAccount2->account_num = $entry2->debit_account_num;
            $tAccount2->journal_type = 'مدين';
            $tAccount2->amount = $entry2->debit_amount;
            $tAccount2->description = 'الي ح /'. $creditAccount1->name;
            $tAccount2->journal_entry_id = $entry2->id;
            $tAccount2->account_id = $debitAccount2->id;
            $tAccount2->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
            $tAccount2->created_by = Auth::user()->id;
            $tAccount2->save();

            //الاستاذ المساعد للمورد دائن
            $tAccount3 = new TAccount();
            $tAccount3->serial_num = getNextTAccountSerial();
            $tAccount3->account_num = $supplier->account_num;
            $tAccount3->journal_type = 'دائن';
            $tAccount3->amount = $entry1->credit_amount;
            $tAccount3->description = 'من ح /'.$debitAccount1->name;
            $tAccount3->journal_entry_id = $entry1->id;
            $tAccount3->account_id = Account::where('account_num',$supplier->account_num)->first()->id;
            $tAccount3->ledger_id = Ledger::where('account_num',$supplier->account_num)->first()->id;
            $tAccount3->created_by = Auth::user()->id;
            $tAccount3->save();

            //الاستاذ المساعد للمورد دائن
            $tAccount4 = new TAccount();
            $tAccount4->serial_num = getNextTAccountSerial();
            $tAccount4->account_num = $supplier->account_num;
            $tAccount4->journal_type = 'دائن';
            $tAccount4->amount = $entry2->credit_amount;
            $tAccount4->description =  'من ح /'.$debitAccount2->name;
            $tAccount4->journal_entry_id = $entry2->id;
            $tAccount4->account_id = Account::where('account_num',$supplier->account_num)->first()->id;
            $tAccount4->ledger_id = Ledger::where('account_num',$supplier->account_num)->first()->id;
            $tAccount4->created_by = Auth::user()->id;
            $tAccount4->save();



        }




        if ($invoice->transportation_fees > 0) {
            //تسجيل مصروفات النقل
            $entry3 = new JournalEntry();
            $entry3->entry_num = $entry;
            $entry3->debit_account_num = $debitAccount3->account_num;
            $entry3->debit_account_id = $debitAccount3->id;
            $entry3->credit_account_num = $creditAccount1->account_num;
            $entry3->credit_account_id = Account::where('account_num', $creditAccount1->account_num)->first()->id;
            $entry3->debit_amount = $invoice->transportation_fees;
            $entry3->credit_amount = $invoice->transportation_fees;
            $entry3->branch_id = Auth::user()->branch_id;
            $entry3->jounralable_type = 'App\Models\SupplierInvoice';
            $entry3->jounralable_id = $invoice->id;
            $entry3->entry_type_id = 2;
            $entry3->created_by = Auth::user()->id;
            $entry3->updated_by = Auth::user()->id;
            $entry3->description = " من ح /  $debitAccount3->name   الي ح / $creditAccount1->name ";
            $entry3->date = $invoice->supp_inv_date_time;
            $entry3->save();


            //الاستاذ العام لمصروفات النقل مدين
            $ledger5 = new Ledger();
            $ledger5->debit_amount = $entry3->debit_amount;
            $ledger5->credit_amount = 0;
            $ledger5->account_id = $debitAccount3->id;
            $ledger5->account_num = $debitAccount3->account_num;
            $ledger5->created_by = Auth::user()->id;
            $ledger5->name_ar = $debitAccount3->name;
            $ledger5->journal_entry_id = $entry3->id;
            $ledger5->type = 'journal_entry';
            $ledger5->date = $invoice->supp_inv_date_time;
            $ledger5->save();

            //الاستاذ العام للخزينة دائن
            $ledger6 = new Ledger();
            $ledger6->debit_amount = 0;
            $ledger6->credit_amount = $entry3->credit_amount;
            $ledger6->account_id = $creditAccount1->id;
            $ledger6->account_num = $creditAccount1->account_num;
            $ledger6->name_ar = $creditAccount1->name;
            $ledger6->created_by = Auth::user()->id;
            $ledger6->journal_entry_id = $entry2->id;
            $ledger6->type = 'journal_entry';
            $ledger6->date = $invoice->supp_inv_date_time;
            $ledger6->save();

            //debit3 
            //تحديث الاباء في الشجرة المحاسبية المتعلقة بمصاريف نقل المشتريات
            $currentDebitAccount3 = $debitAccount3->account_num;
            $debitLevels3 = [];
            for ($k = strlen($currentDebitAccount3); $k > 0; $k--) {
                $debitLevels3[] = substr($currentDebitAccount3, 0, $k);
            }
            //dd($debitLevels3);
            foreach ($debitLevels3 as $relatedDebitLevel3) {

                $levelDebitAccount3 = Account::where('account_num', $relatedDebitLevel3)->first();
                //dd($levelDebitAccount3->current_balance);
                $levelDebitAccount3->update([
                    'current_balance' => $levelDebitAccount3->current_balance + $entry3->debit_amount,
                ]);
                //dd($levelDebitAccount3->current_balance);
            }


        }




        //بداية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية
        //debit1
        $currentDebitAccount1 = $debitAccount1->account_num;
        $debitLevels1 = [];
        for ($k = strlen($currentDebitAccount1); $k > 0; $k--) {
            $debitLevels1[] = substr($currentDebitAccount1, 0, $k);
        }
        //dd($debitLevels1);
        foreach ($debitLevels1 as $relatedDebitLevel1) {

            $levelDebitAccount1 = Account::where('account_num', $relatedDebitLevel1)->first();
            //dd($levelDebitAccount1->current_balance);
            $levelDebitAccount1->update([
                'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount,
            ]);
            //dd($levelDebitAccount1->current_balance);
        }
        //debit2
        $currentDebitAccount2 = $debitAccount2->account_num;
        $debitLevels2 = [];
        for ($k = strlen($currentDebitAccount2); $k > 0; $k--) {
            $debitLevels2[] = substr($currentDebitAccount2, 0, $k);
        }
        //dd($debitLevels2);
        foreach ($debitLevels2 as $relatedDebitLevel2) {

            $levelDebitAccount2 = Account::where('account_num', $relatedDebitLevel2)->first();
            //dd($levelDebitAccount2->current_balance);
            $levelDebitAccount2->update([
                'current_balance' => $levelDebitAccount2->current_balance + $entry2->debit_amount,
            ]);
            //dd($levelDebitAccount2->current_balance);
        }


        //credit
        $currentCreditAccount = $creditAccount1->account_num;
        $creditLevels = [];
        for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
            $creditLevels[] = substr($currentCreditAccount, 0, $k);
        }

        //  dd($creditLevels);
        foreach ($creditLevels as $relatedCreditLevel) {

            $levelCreditAccount = Account::where('account_num', $relatedCreditLevel)->first();

            $levelCreditAccount->update([
                'current_balance' => $levelCreditAccount->current_balance - ($entry1->debit_amount + $entry2->debit_amount),
            ]);
            //dd($levelCreditAccount->current_balance);
        }

        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية

    }
}
