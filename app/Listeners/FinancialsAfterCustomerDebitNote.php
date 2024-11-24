<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Product;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\JournalEntry;
use App\Models\TreasuryShift;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FinancialsAfterCustomerDebitNote
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

        //dd($event);
        $customerDebitNote = $event->customerDebitNote;
        //dd($customerDebitNote);
        $tax = $event->tax;
        $price = $event->price;
        $newInvoiceItem = $event->newInvoiceItem;

        $invoice = CustomerInvoice::where('id',$customerDebitNote->customer_invoice_id)->first();

        $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',$invoice->branch_id)->first();



        $creditAccount1 = Account::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();



        $entry = getNextJournalEntryNum();

        $debitAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
        $creditAccountParent1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',41)->first();//ايرادات مبيعات
        $creditAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent1->id)->where('branch_id',Auth::user()->branch_id)->first();

        $creditAccountParent2 = Account::where('account_num',1236)->first();//ضريبة القيمة المضافة على المدخلات
        $creditAccount2 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent2->id)->where('branch_id',Auth::user()->branch_id)->first();

        $debitAccountParent2 = Account::where('account_num',53)->first();//'تكلفة البضاعة المباعة '
        $debitAccount2 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent2->id)->where('branch_id',Auth::user()->branch_id)->first();

        $creditAccountParent3 = Account::where('name_ar','المخزون')->first();
        $creditAccount3 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent3->id)->where('branch_id',Auth::user()->branch_id)->first();

        //قيد اليومية المركب
        //تسجيل الخزينة مدين الي المبيعات
        $entry1 = new JournalEntry();
        $entry1->entry_num = $entry;
        $entry1->debit_account_num = $debitAccount1->account_num;
        $entry1->debit_account_id = $debitAccount1->id;
        $entry1->credit_account_num = $creditAccount1->account_num;
        $entry1->credit_account_id = $creditAccount1->id;
        $entry1->debit_amount = $price;
        $entry1->credit_amount = $price;
        $entry1->branch_id = Auth::user()->branch_id;
        $entry1->jounralable_type = 'App\Models\CustomerDebitNote';
        $entry1->jounralable_id = $newInvoiceItem->id;
        $entry1->entry_type_id =2 ;
                $entry1->created_by = Auth::user()->id;
        $entry1->updated_by = Auth::user()->id;
        $entry1->description = "/  من ح  $debitAccount1->name / إلي  ح  $creditAccount1->name";
        $entry1->date = $invoice->customer_inv_date_time;
        $entry1->save();

        //تسجيل الخزينة مدين الي ضريبة القيمة المضافة علي المخرجات
        $entry2 = new JournalEntry();
        $entry2->entry_num = $entry;
        $entry2->debit_account_num = $debitAccount1->account_num;
        $entry2->debit_account_id = $debitAccount1->id;
        $entry2->credit_account_num = $creditAccount2->account_num;
        $entry2->credit_account_id = $creditAccount2->id;
        $entry2->debit_amount = $tax;
        $entry2->credit_amount = $tax;
        $entry2->branch_id = Auth::user()->branch_id;
        $entry2->jounralable_type = 'App\Models\CustomerDebitNote';
        $entry2->jounralable_id = $newInvoiceItem->id;
        $entry2->entry_type_id =2 ;
        $entry2->created_by = Auth::user()->id;
        $entry2->updated_by = Auth::user()->id;
        $entry2->description = " / من ح  $debitAccount1->name /  إلي  ح  $creditAccount2->name";
        $entry2->date = $invoice->customer_inv_date_time;
        $entry2->save();

        //حساب تكلفة البضاعة المباعة
        $total_without_tax = 0;

        $product = Product::where('id',$newInvoiceItem->product_id)->first();
        $purchasePrice = Inventory::where('product_id',$newInvoiceItem->product_id)->latest()->first()->latest_purchase_price;
        //dd($purchasePrice);

        //تسجيل تكلفة البضاعة المباعة مدين الي المخزون
        $entry3 = new JournalEntry();
        $entry3->entry_num = $entry;
        $entry3->debit_account_num = $debitAccount2->account_num;
        $entry3->debit_account_id = $debitAccount2->id;
        $entry3->credit_account_num = $creditAccount3->account_num;
        $entry3->credit_account_id = $creditAccount3->id;
        $entry3->debit_amount = $purchasePrice * $newInvoiceItem->qty;
        $entry3->credit_amount = $purchasePrice * $newInvoiceItem->qty;
        $entry3->branch_id = Auth::user()->branch_id;
        $entry3->jounralable_type = 'App\Models\CustomerDebitNote';
        $entry3->jounralable_id = $newInvoiceItem->id;
        $entry3->entry_type_id =2 ;
        $entry3->created_by = Auth::user()->id;
        $entry3->updated_by = Auth::user()->id;
        $entry3->description = " / من ح  $debitAccount2->name / إلي  ح   $creditAccount3->name";
        $entry3->date = $invoice->customer_inv_date_time;
                $entry3->save();

            //الاستاذ العام للخزينة مدين
        $ledger1 = new Ledger();
        $ledger1->debit_amount = $entry1->debit_amount;
        $ledger1->credit_amount = 0;
        $ledger1->account_id = $debitAccount1->id;
        $ledger1->account_num = $debitAccount1->account_num;
        $ledger1->created_by = Auth::user()->id;
        $ledger1->name_ar = $debitAccount1->name;
        $ledger1->journal_entry_id = $entry1->id;
        $ledger1->type = 'journal_entry';
        $ledger1->date = $invoice->customer_inv_date_time;
        $ledger1->save();

        //الاستاذ العام للخزينة مدين
        $ledger2 = new Ledger();
        $ledger2->debit_amount = $entry2->debit_amount;
        $ledger2->credit_amount = 0 ;
        $ledger2->account_id = $debitAccount1->id;
        $ledger2->account_num = $debitAccount1->account_num;
        $ledger2->created_by = Auth::user()->id;
        $ledger2->name_ar = $debitAccount1->name;
        $ledger2->journal_entry_id = $entry2->id;
        $ledger2->type = 'journal_entry';
        $ledger2->date = $invoice->customer_inv_date_time;
        $ledger2->save();

        //الاستاذ العام للمبيعات دائن
        $ledger3 = new Ledger();
        $ledger3->debit_amount = 0;
        $ledger3->credit_amount = $entry1->credit_amount;
        $ledger3->account_id = $creditAccount1->id;
        $ledger3->account_num = $creditAccount1->account_num;
        $ledger3->created_by = Auth::user()->id;
        $ledger3->name_ar = $creditAccount1->name;
        $ledger3->journal_entry_id = $entry1->id;
        $ledger3->type = 'journal_entry';
        $ledger3->date = $invoice->customer_inv_date_time;
        $ledger3->save();

        //الاستاذ العام لضريبة القيمة المضافة علي المخرجات دائن
        $ledger4 = new Ledger();
        $ledger4->debit_amount = 0;
        $ledger4->credit_amount = $entry2->credit_amount;
        $ledger4->account_id = $creditAccount2->id;
        $ledger4->account_num = $creditAccount2->account_num;
        $ledger4->created_by = Auth::user()->id;
        $ledger4->name_ar = $creditAccount2->name;
        $ledger4->journal_entry_id = $entry2->id;
        $ledger4->type = 'journal_entry';
        $ledger4->date = $invoice->customer_inv_date_time;
        $ledger4->save();

        //الاستاذ العام لتكلفة البضاعة المباعة مدين
        $ledger5 = new Ledger();
        $ledger5->debit_amount = $entry3->debit_amount;
        $ledger5->credit_amount = 0;
        $ledger5->account_id = $debitAccount2->id;
        $ledger5->account_num = $debitAccount2->account_num;
        $ledger5->created_by = Auth::user()->id;
        $ledger5->name_ar= $debitAccount2->name;
        $ledger5->journal_entry_id = $entry3->id;
        $ledger5->type = 'journal_entry';
        $ledger5->date = $invoice->customer_inv_date_time;
        $ledger5->save();

        //الاستاذ العام للمخزون دائن
        $ledger6 = new Ledger();
        $ledger6->debit_amount = 0;
        $ledger6->credit_amount = $entry3->credit_amount;
        $ledger6->account_id = $creditAccount3->id;
        $ledger6->account_num = $creditAccount3->account_num;
        $ledger6->created_by = Auth::user()->id;
        $ledger6->name_ar= $creditAccount3->name;
        $ledger6->journal_entry_id = $entry3->id;
        $ledger6->type = 'journal_entry';
        $ledger6->date = $invoice->customer_inv_date_time;
        $ledger6->save();





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
            //debit2
            $currentDebitAccount2 = $debitAccount2->account_num ;
            $debitLevels2 = [];
            for ($k = strlen($currentDebitAccount2); $k > 0; $k--) {
                $debitLevels2[] = substr($currentDebitAccount2, 0, $k);
            }
            //dd($debitLevels2);
            foreach ($debitLevels2 as $relatedDebitLevel2) {
                $levelDebitAccount2 = Account::where('account_num',$relatedDebitLevel2)->first();
                //dd($levelDebitAccount2->current_balance);
                $levelDebitAccount2->update([
                    'current_balance' => $levelDebitAccount2->current_balance + $entry2->debit_amount,
                ]);
                //dd($levelDebitAccount2->current_balance);
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
                    'current_balance' => $levelCreditAccount1->current_balance - $entry1->credit_amount
                ]);
                //dd($levelCreditAccount->current_balance);
            }

            //credit2
            $currentCreditAccount2 = $creditAccount2->account_num ;
            $creditLevels2 = [];
            for ($k = strlen($currentCreditAccount2); $k > 0; $k--) {
                $creditLevels2[] = substr($currentCreditAccount2, 0, $k);
            }

            //  dd($creditLevels);
            foreach ($creditLevels2 as $relatedCreditLevel2) {
                $levelCreditAccount2 = Account::where('account_num',$relatedCreditLevel2)->first();
                $levelCreditAccount2->update([
                    'current_balance' => $levelCreditAccount2->current_balance - $entry2->credit_amount
                ]);
                //dd($levelCreditAccount->current_balance);
            }

            //credit3
            $currentCreditAccount3 = $creditAccount3->account_num ;
            $creditLevels3 = [];
            for ($k = strlen($currentCreditAccount3); $k > 0; $k--) {
                $creditLevels3[] = substr($currentCreditAccount3, 0, $k);
            }

           //  dd($creditLevels);
            foreach ($creditLevels3 as $relatedCreditLevel3) {

                $levelCreditAccount3 = Account::where('account_num',$relatedCreditLevel3)->first();

                $levelCreditAccount3->update([
                    'current_balance' => $levelCreditAccount3->current_balance - $entry3->credit_amount ,
                ]);
                //dd($levelCreditAccount->current_balance);
            }


            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية


    }
}
