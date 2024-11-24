<?php

namespace App\Listeners;

use App\Models\Ledger;
use App\Models\Account;
use App\Models\Product;
use App\Models\Customer;
use App\Models\TAccount;
use App\Models\Treasury;
use App\Models\Inventory;
use App\Models\JournalEntry;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomerInvoiceInstallmentFinancials
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

            $customer = Customer::where('id',$invoice->customer_id)->first();
            $creditAccount1 = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
            ->where('account_num',$customer->account_num)->first();


            $oldJournalEntries = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)->get();
            //dd($oldJournalEntries);
            $oldJournalEntry1 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
                ->where('debit_account_num',$debitAccount1->account_num)->where('credit_account_num',$creditAccount1->account_num)->first();

        //dd($oldJournalEntries);
        if($oldJournalEntries = []){
            if($type == "CustomerInvoice") {


               //dd($debitAccount1->account_num,$creditAccount1->account_num);

                $existingJournalEntry1 = JournalEntry::where('jounralable_type','App\Models\CustomerInvoice')->where('jounralable_id',$invoice->id)
                ->where('debit_account_num',$debitAccount1->account_num)->where('credit_account_num',$creditAccount1->account_num)->first();
                //dd($existingJournalEntry1);
                $existingJournalEntry1->debit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $existingJournalEntry1->credit_amount = $invoice->total_after_discount - $invoice->tax_value;
                $existingJournalEntry1->date = $invoice->customer_inv_date_time;
                $existingJournalEntry1->save();


                    //حساب تكلفة البضاعة المباعة

                    $total_without_tax = 0;


                    foreach(CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get() as $item) {
                        $product = Product::where('id',$item->product_id)->first();
                        $purchasePrice = Inventory::where('product_id',$item->product_id)->latest()->first()->latest_purchase_price;
                        //dd($purchasePrice);
                        $total_without_tax += $purchasePrice * $item->qty;
                    }




                    $ledger1 = Ledger::where('journal_entry_id',$existingJournalEntry1->id)->where('account_num',$debitAccount1->account_num)->first();
                    $ledger1->debit_amount = $existingJournalEntry1->debit_amount;
                    $ledger1->credit_amount = 0;
                    $ledger1->name_ar = $debitAccount1->name;
                    $ledger1->save();



                    $ledger3 = Ledger::where('journal_entry_id',$existingJournalEntry1->id)->where('account_num',$creditAccount1->account_num)->first();
                    //dd($ledger3);
                    $ledger3->debit_amount = $existingJournalEntry1->credit_amount;
                    $ledger3->credit_amount = 0;
                    $ledger3->name_ar = $creditAccount1->name;
                    $ledger3->save();


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
                                'current_balance' => $levelCreditAccount1->current_balance + $oldJournalEntry1->credit_amount +  $existingJournalEntry1->credit_amount,
                            ]);
                            //dd($levelCreditAccount->current_balance);
                        }


                        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية

                        $treasury->current_balance =  $treasury->current_balance - $oldJournalEntry1->debit_amount- $oldJournalEntry2->debit_amount+ $transaction->receipt_amount ;
                        $treasury->last_collection_receipt =   $transaction->serial_num ;
                        $treasury->save();
            }

        }

        if($type == "CustomerInvoice") {
            $entry = getNextJournalEntryNum();



                //تسجيل الخزينة مدين الي العميل
                $entry1 = new JournalEntry();
                $entry1->entry_num = $entry;
                $entry1->debit_account_num = $debitAccount1->account_num;
                $entry1->debit_account_id = $debitAccount1->id;
                $entry1->credit_account_num = $creditAccount1->account_num;
                $entry1->credit_account_id = $creditAccount1->id;
                $entry1->debit_amount = $transaction->receipt_amount;
                $entry1->credit_amount = $transaction->receipt_amount;
                $entry1->branch_id = $invoice->branch_id;
                $entry1->jounralable_type = $transaction->transactionable_type;
                $entry1->jounralable_id = $invoice->id;
                $entry1->entry_type_id =2 ;
                $entry1->created_by = Auth::user()->id;
                $entry1->updated_by = Auth::user()->id;
                $entry1->description = "/  من ح  $debitAccount1->name / إلي  ح  $creditAccount1->name";
                $entry1->date = $invoice->customer_inv_date_time;
                $entry1->save();



                $total_without_tax = 0;


                foreach(CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get() as $item) {
                    $product = Product::where('id',$item->product_id)->first();
                    $purchasePrice = Inventory::where('product_id',$item->product_id)->latest()->first()->latest_purchase_price;
                    //dd($purchasePrice);
                    $total_without_tax += $purchasePrice * $item->qty;
                }

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


                //الاستاذ العام للعميل دائن
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

                // dd("jj");
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
                            'current_balance' => $levelCreditAccount1->current_balance - $entry1->credit_amount
                        ]);
                        //dd($levelCreditAccount->current_balance);
                    }





                    //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية

                    $treasury->current_balance =  $treasury->current_balance + $transaction->receipt_amount ;
                    $treasury->last_collection_receipt =   $transaction->serial_num ;
                    $treasury->save();
        }
    }
}
