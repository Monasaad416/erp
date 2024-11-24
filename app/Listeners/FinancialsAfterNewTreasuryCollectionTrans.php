<?php

namespace App\Listeners;

use App\Models\Ledger;
use App\Models\Account;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TAccount;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\JournalEntry;
use App\Models\CustomerInvoiceItem;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FinancialsAfterNewTreasuryCollectionTrans
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
         // dd($transaction);
        $invoice = $event->invoice;
    //dd($invoice->customer_inv_date_time);
        $type = $event->type;

        $treasury = Treasury::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('branch_id',$invoice->branch_id)->first();
        $debitAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',$treasury->account_num)->first();
        $creditAccountParent1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('account_num',41)->first();//ايرادات مبيعات
        $creditAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent1->id)->where('branch_id',$invoice->branch_id)->first();

        $creditAccountParent2 = Account::where('account_num',2231)->first();//ضريبة القيمة المضافة على المخرجات
        $creditAccount2 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent2->id)->where('branch_id',$invoice->branch_id)->first();

        $debitAccountParent2 = Account::where('account_num',53)->first();//'تكلفة البضاعة المباعة '
        $debitAccount2 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$debitAccountParent2->id)->where('branch_id',$invoice->branch_id)->first();

        $creditAccountParent3 = Account::where('account_num',1224)->first();//المخزون
        $creditAccount3 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$creditAccountParent3->id)->where('branch_id',$invoice->branch_id)->first();

        $oldJournalEntries = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)->get();
        //dd($oldJournalEntries);
        $oldJournalEntry1 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
            ->where('debit_account_num',$debitAccount1->account_num)->where('credit_account_num',$creditAccount1->account_num)->first();

        $oldJournalEntry2 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
            ->where('debit_account_num',$debitAccount1->account_num)->where('credit_account_num',$creditAccount2->account_num)->first();

        $oldJournalEntry3 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
            ->where('debit_account_num',$debitAccount2->account_num)->where('credit_account_num',$creditAccount3->account_num)->first();
        //dd($oldJournalEntries);
        if($oldJournalEntries->count() > 0){
            if($type == "CustomerInvoice") {
               //dd($debitAccount1->account_num,$creditAccount1->account_num);

               //الخزينة مدين- ايرادات المبيعات دائن
                $existingJournalEntry1 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
                ->where('debit_account_num',$debitAccount1->account_num)->where('credit_account_num',$creditAccount1->account_num)->first();
                //dd($existingJournalEntry1);
                $existingJournalEntry1->debit_amount = $transaction->receipt_amount - $invoice->tax_value;
                $existingJournalEntry1->credit_amount = $transaction->receipt_amount - $invoice->tax_value;
                $existingJournalEntry1->date = $invoice->customer_inv_date_time;
                $existingJournalEntry1->save();

                //الخزينة مدين-ضريب المخرجات  دائن
                $existingJournalEntry2 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
                ->where('debit_account_num',$debitAccount1->account_num)->where('credit_account_num',$creditAccount2->account_num)->first();
                //dd($existingJournalEntry2);
                $existingJournalEntry2->debit_amount = $invoice->tax_value;
                $existingJournalEntry2->credit_amount = $invoice->tax_value;
                $existingJournalEntry2->date = $invoice->customer_inv_date_time;
                $existingJournalEntry2->save();

                //حساب تكلفة البضاعة المباعة

                $total_without_tax = 0;


                foreach(CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get() as $item) {
                    $product = Product::where('id',$item->product_id)->first();
                    $purchasePrice = Inventory::where('product_id',$item->product_id)->latest()->first()->latest_purchase_price;
                    //dd($purchasePrice);
                    $total_without_tax += $purchasePrice * $item->qty;
                }
                //تسجيل تكلفة البضاعة المباعة مدين - المخزون دائن

                $existingJournalEntry3 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
                ->where('debit_account_num',$debitAccount2->account_num)->where('credit_account_num',$creditAccount3->account_num)->first();
                //dd($existingJournalEntry3);
                $existingJournalEntry3->debit_amount = $total_without_tax;
                $existingJournalEntry3->credit_amount = $total_without_tax;
                $existingJournalEntry3->date = $invoice->customer_inv_date_time;
                $existingJournalEntry3->save();

                //الاستاذ العام للخزينة مدين
                $ledger1 = Ledger::where('journal_entry_id',$existingJournalEntry1->id)->where('account_num',$debitAccount1->account_num)->first();
                $ledger1->debit_amount = $existingJournalEntry1->debit_amount;
                $ledger1->credit_amount = 0;
                $ledger1->name_ar = $debitAccount1->name;
                $ledger1->save();

                // //الاستاذ العام للخزينة مدين

                $ledger2 = Ledger::where('journal_entry_id',$existingJournalEntry2->id)->where('account_num',$debitAccount1->account_num)->first();
                // dd($ledger2);
                $ledger2->debit_amount = $existingJournalEntry2->debit_amount;
                $ledger2->credit_amount = 0;
                $ledger2->name_ar = $debitAccount1->name;
                $ledger2->save();

                $ledger3 = Ledger::where('journal_entry_id',$existingJournalEntry1->id)->where('account_num',$creditAccount1->account_num)->first();
                //dd($ledger3);
                $ledger3->debit_amount = 0;
                $ledger3->credit_amount = $existingJournalEntry1->credit_amount;
                $ledger3->name_ar = $creditAccount1->name;
                $ledger3->save();

                $ledger4 = Ledger::where('journal_entry_id',$existingJournalEntry2->id)->where('account_num',$creditAccount2->account_num)->first();
                //dd($ledger4);
                $ledger4->debit_amount = 0;
                $ledger4->credit_amount = $existingJournalEntry2->credit_amount;
                $ledger4->name_ar = $creditAccount2->name;
                $ledger4->save();

                $ledger5 = Ledger::where('journal_entry_id',$existingJournalEntry3->id)->where('account_num',$debitAccount2->account_num)->first();
                //dd($ledger5);
                $ledger5->debit_amount = $existingJournalEntry3->debit_amount;
                $ledger5->credit_amount = 0;
                $ledger5->name_ar = $debitAccount2->name;
                $ledger5->save();

                $ledger6 = Ledger::where('journal_entry_id',$existingJournalEntry3->id)->where('account_num',$creditAccount3->account_num)->first();
                //dd($ledger6);
                $ledger6->debit_amount = 0;
                $ledger6->credit_amount = $existingJournalEntry3->credit_amount;
                $ledger6->name_ar = $creditAccount3->name;
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
                        'current_balance' => $levelDebitAccount1->current_balance - $oldJournalEntry1->debit_amount + $existingJournalEntry1->debit_amount,
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
                        'current_balance' => $levelDebitAccount2->current_balance + $oldJournalEntry2->debit_amount + $existingJournalEntry2->debit_amount,
                    ]);
                    //dd($levelDebitAccount2->current_balance);
                }



                //credit1
                $currentCreditAccount1 = $creditAccount1->account_num ;
                $creditLevels1 = [];
                for ($k = strlen($currentCreditAccount1); $k > 0; $k--) {
                    $creditLevels1[] = substr($currentCreditAccount1, 0, $k);
                }

                //dd($creditLevels1);
                foreach ($creditLevels1 as $relatedCreditLevel1) {

                    $levelCreditAccount1 = Account::where('account_num',$relatedCreditLevel1)->first();

                    $levelCreditAccount1->update([
                        'current_balance' => $levelCreditAccount1->current_balance + $oldJournalEntry1->credit_amount -  $existingJournalEntry1->credit_amount,
                    ]);
                    //dd($levelCreditAccount->current_balance);
                }

                //credit2
                $currentCreditAccount2 = $creditAccount2->account_num ;
                $creditLevels2 = [];
                for ($k = strlen($currentCreditAccount2); $k > 0; $k--) {
                    $creditLevels2[] = substr($currentCreditAccount2, 0, $k);
                }

                dd($creditLevels2);
                foreach ($creditLevels2 as $relatedCreditLevel2) {

                    $levelCreditAccount2 = Account::where('account_num',$relatedCreditLevel2)->first();

                    $levelCreditAccount2->update([
                        'current_balance' => $levelCreditAccount2->current_balance  + $oldJournalEntry2->credit_amount -  $existingJournalEntry2->credit_amount,
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
                        'current_balance' => $levelCreditAccount3->current_balance  + $oldJournalEntry3->credit_amount -  $existingJournalEntry3->credit_amount,
                    ]);
                    //dd($levelCreditAccount->current_balance);
                }


            //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية

            $treasury->current_balance =  $treasury->current_balance - $oldJournalEntry1->debit_amount- $oldJournalEntry2->debit_amount+ $transaction->receipt_amount ;
            $treasury->last_collection_receipt =   $transaction->serial_num ;
            $treasury->save();
            }

        }else {


            $entry = getNextJournalEntryNum();
        

            //قيد اليومية المركب
            //تسجيل الخزينة مدين ايرادات المبيعات دائن
            $entry1 = new JournalEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $debitAccount1->account_num;
            $entry1->debit_account_id = $debitAccount1->id;
            $entry1->credit_account_num = $creditAccount1->account_num;
            $entry1->credit_account_id = $creditAccount1->id;
            $entry1->debit_amount = $transaction->receipt_amount - $invoice->tax_value;
            $entry1->credit_amount = $transaction->receipt_amount - $invoice->tax_value;
            $entry1->branch_id = Auth::user()->branch_id;
            $entry1->jounralable_type = $transaction->transactionable_type;
            $entry1->jounralable_id = $invoice->id;
            $entry1->entry_type_id =2 ;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description = "/  من ح  $debitAccount1->name / إلي  ح  $creditAccount1->name";
            $entry1->date = $invoice->customer_inv_date_time;
            $entry1->save();

            //تسجيل الخزينة  مدين - ضريبة القيمة المضافة علي المخرجات دائن
            $entry2 = new JournalEntry();
            $entry2->entry_num = $entry;
            $entry2->debit_account_num = $debitAccount1->account_num;
            $entry2->debit_account_id = $debitAccount1->id;
            $entry2->credit_account_num = $creditAccount2->account_num;
            $entry2->credit_account_id = $creditAccount2->id;
            $entry2->debit_amount = $invoice->tax_value;
            $entry2->credit_amount = $invoice->tax_value;
            $entry2->branch_id = Auth::user()->branch_id;
            $entry2->jounralable_type = $transaction->transactionable_type;
            $entry2->jounralable_id = $invoice->id;
            $entry2->entry_type_id =2 ;
            $entry2->created_by = Auth::user()->id;
            $entry2->updated_by = Auth::user()->id;
            $entry2->description = " / من ح  $debitAccount1->name /  إلي  ح  $creditAccount2->name";
            $entry2->date = $invoice->customer_inv_date_time;
            $entry2->save();

            //حساب تكلفة البضاعة المباعة
            $total_without_tax = 0;


            foreach(CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get() as $item) {
                $product = Product::where('id',$item->product_id)->first();
                $purchasePrice = Inventory::where('product_id',$item->product_id)->latest()->first()->latest_purchase_price;
                //dd($purchasePrice);
                $total_without_tax += $purchasePrice * $item->qty;
            }


        


            //تسجيل تكلفة البضاعة المباعة مدين الي المخزون
            $entry3 = new JournalEntry();
            $entry3->entry_num = $entry;
            $entry3->debit_account_num = $debitAccount2->account_num;
            $entry3->debit_account_id = $debitAccount2->id;
            $entry3->credit_account_num = $creditAccount3->account_num;
            $entry3->credit_account_id = $creditAccount3->id;
            $entry3->debit_amount = $total_without_tax;
            $entry3->credit_amount = $total_without_tax;
            $entry3->branch_id = Auth::user()->branch_id;
            $entry3->jounralable_type = $transaction->transactionable_type;
            $entry3->jounralable_id = $invoice->id;
            $entry3->entry_type_id =2 ;
            $entry3->created_by = Auth::user()->id;
            $entry3->updated_by = Auth::user()->id;
            $entry3->description = " / من ح  $debitAccount2->name / إلي  ح   $creditAccount3->name";
            $entry3->date = $invoice->customer_inv_date_time;
            $entry3->save();

            //الاستاذ العام للخزينة  مدين بقيمة المبيعات 
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

            //الاستاذ العام للخزينة  مدين بقيمة الضريبة 
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


            //الاستاذ العام تكلفة البضاعة  المباعة مدين
            $ledger3 = new Ledger();
            $ledger3->debit_amount = $entry3->debit_amount;
            $ledger3->credit_amount = 0 ;
            $ledger3->account_id = $debitAccount2->id;
            $ledger3->account_num = $debitAccount2->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->name_ar = $debitAccount2->name;
            $ledger3->journal_entry_id = $entry3->id;
            $ledger3->type = 'journal_entry';
            $ledger3->date = $invoice->customer_inv_date_time;
            $ledger3->save();

            //الاستاذ العام للمبيعات دائن
            $ledger4 = new Ledger();
            $ledger4->debit_amount = 0;
            $ledger4->credit_amount = $entry1->credit_amount;
            $ledger4->account_id = $creditAccount1->id;
            $ledger4->account_num = $creditAccount1->account_num;
            $ledger4->created_by = Auth::user()->id;
            $ledger4->name_ar = $creditAccount1->name;
            $ledger4->journal_entry_id = $entry1->id;
            $ledger4->type = 'journal_entry';
            $ledger4->date = $invoice->customer_inv_date_time;
            $ledger4->save();

            //الاستاذ العام لضريبة القيمة المضافة علي المخرجات دائن
            $ledger5 = new Ledger();
            $ledger5->debit_amount = 0;
            $ledger5->credit_amount = $entry2->credit_amount;
            $ledger5->account_id = $creditAccount2->id;
            $ledger5->account_num = $creditAccount2->account_num;
            $ledger5->created_by = Auth::user()->id;
            $ledger5->name_ar = $creditAccount2->name;
            $ledger5->journal_entry_id = $entry2->id;
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

            //الاستاذ المساعد للخزينة مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry1->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry1->debit_amount;
            $tAccount1->description = " الي حساب $creditAccount1->name ";
            $tAccount1->journal_entry_id = $entry1->id;
            $tAccount1->account_id = $debitAccount1->id;
            $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
            $tAccount1->created_by = Auth::user()->id;
            $tAccount1->save();

            //الاستاذ المساعد للخزينة مدين
            $tAccount1 = new TAccount();
            $tAccount1->serial_num = getNextTAccountSerial();
            $tAccount1->account_num = $entry2->debit_account_num;
            $tAccount1->journal_type = 'مدين';
            $tAccount1->amount = $entry2->debit_amount;
            $tAccount1->description = " الي حساب $creditAccount2->name ";
            $tAccount1->journal_entry_id = $entry2->id;
            $tAccount1->account_id = $debitAccount1->id;
            $tAccount1->ledger_id = Ledger::where('account_num',$entry2->debit_account_num)->first()->id;
            $tAccount1->created_by = Auth::user()->id;
            $tAccount1->save();

            //الاستاذ المساعد للمبيعات دائن
            $tAccount3 = new TAccount();
            $tAccount3->serial_num = getNextTAccountSerial();
            $tAccount3->account_num = $entry1->credit_account_num;
            $tAccount3->journal_type = 'دائن';
            $tAccount3->amount = $entry1->credit_amount;
            $tAccount3->description = "من ح / $debitAccount1->name";
            $tAccount3->journal_entry_id = $entry1->id;
            $tAccount3->account_id = $creditAccount1->id;
            $tAccount3->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
            $tAccount3->created_by = Auth::user()->id;
            $tAccount3->save();

            //الاستاذ المساعد للضريبة المخرجات دائن
            $tAccount4 = new TAccount();
            $tAccount4->serial_num = getNextTAccountSerial();
            $tAccount4->account_num = $entry2->credit_account_num;
            $tAccount4->journal_type = 'دائن';
            $tAccount4->amount = $entry2->credit_amount;
            $tAccount4->description = "من ح / $debitAccount1->name";
            $tAccount4->journal_entry_id = $entry2->id;
            $tAccount4->account_id = $creditAccount1->id;
            $tAccount4->ledger_id = Ledger::where('account_num',$entry2->credit_account_num)->first()->id;
            $tAccount4->created_by = Auth::user()->id;
            $tAccount4->save();

            //الاستاذ المساعد لتكلفة الباضاعة المباعة مدين
            $tAccount5 = new TAccount();
            $tAccount5->serial_num = getNextTAccountSerial();
            $tAccount5->account_num = $entry3->debit_account_num;
            $tAccount5->journal_type = 'مدين';
            $tAccount5->amount = $entry3->debit_amount;
            $tAccount5->description = " الي حساب $creditAccount3->name ";
            $tAccount5->journal_entry_id = $entry3->id;
            $tAccount5->account_id = $debitAccount2->id;
            $tAccount5->ledger_id = Ledger::where('account_num',$entry3->debit_account_num)->first()->id;
            $tAccount5->created_by = Auth::user()->id;
            $tAccount5->save();

            //الاستاذ المساعد للمخزون  دائن
            $tAccount6 = new TAccount();
            $tAccount6->serial_num = getNextTAccountSerial();
            $tAccount6->account_num = $entry3->credit_account_num;
            $tAccount6->journal_type = 'دائن';
            $tAccount6->amount = $entry3->credit_amount;
            $tAccount6->description = "من ح / $debitAccount2->name";
            $tAccount6->journal_entry_id = $entry3->id;
            $tAccount6->account_id = $creditAccount1->id;
            $tAccount6->ledger_id = Ledger::where('account_num',$entry3->credit_account_num)->first()->id;
            $tAccount6->created_by = Auth::user()->id;
            $tAccount6->save();

   


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


            //تحديث رصيد الخزينة
            $treasury->current_balance = $treasury->current_balance + $transaction->receipt_amount;
            $treasury->last_collection_receipt = $transaction->serial_num;
            $treasury->save();


            
        }
    }
}
