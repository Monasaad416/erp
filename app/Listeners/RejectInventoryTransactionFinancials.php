<?php

namespace App\Listeners;

use App\Models\Store;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\Product;
use App\Models\Setting;
use App\Models\TAccount;
use App\Models\JournalEntry;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RejectInventoryTransactionFinancials
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
        $item = $event->item;
        $inventory = $event->inventory ;
        //dd($inventory);

        //dd($item->inventory_transaction_id);
        $trans = InventoryTransaction::where('id',$item->inventory_transaction_id)->first();
        //dd($item);
        $storeFromBranchId = Store::where('id',$trans->from_store_id)->first()->branch_id;
        $storeToBranchId = Store::where('id',$trans->to_store_id)->first()->branch_id;
        $parent = Account::where('name_ar','المخزون')->first();
        $creditAccount = Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$parent->id )
        ->where('branch_id',$storeFromBranchId)->first();

         $debitAccount = Account::select('id',
        'name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')
        ->where('parent_id',$parent->id )
        ->where('branch_id',$storeToBranchId)->first();

        //dd($debitAccount,$creditAccount);
           


        $entry = getNextJournalEntryNum();



        $settings=Setting::first();
     

        $product = Product::where('id',$item->product_id)->first();
        //dd($product);
        //تسجيل  التحويل علي المركز الرئيسي دائن 
        $entry1 = new JournalEntry();
        $entry1->entry_num = $entry;
        $entry1->debit_account_num = $debitAccount->account_num;
        $entry1->debit_account_id = $debitAccount->id;
        $entry1->credit_account_num = $creditAccount->account_num;
        $entry1->credit_account_id = $creditAccount->id;
        $entry1->debit_amount = $product->taxes ? $item->unit_price * (1+$settings->vat) * $inventory->in_qty : $item->unit_price * $inventory->in_qty   ;
        $entry1->credit_amount = $product->taxes ? $item->unit_price * (1+$settings->vat) * $inventory->in_qty : $item->unit_price * $inventory->in_qty   ;
        $entry1->branch_id = $storeFromBranchId;
        $entry1->jounralable_type = 'App\Models\InventotyTransaction';
        $entry1->jounralable_id = $trans->id;
        $entry1->entry_type_id =1;
        $entry1->created_by = Auth::user()->id;
        $entry1->updated_by = Auth::user()->id;
        $entry1->description = "من ح " . $debitAccount->name . " إلي  ح /" . $creditAccount->name;
        $entry1->date = $trans->created_at;
        $entry1->save();




        //الاستاذ العام للمخزن المحول الية  مدين
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

        //الاستاذ العام للمخزن الرئيسي دائن
        $ledger2 = new Ledger();
        $ledger2->debit_amount = 0;
        $ledger2->credit_amount = $entry1->credit_amount ;
        $ledger2->account_id = $creditAccount->id;
        $ledger2->account_num = $creditAccount->account_num;
        $ledger2->created_by = Auth::user()->id;
        $ledger2->name_ar = $creditAccount->name;
        $ledger2->journal_entry_id = $entry1->id;
        $ledger2->type = 'journal_entry';
        $ledger2->date = $entry1->date;
        $ledger2->save();

        //الاستاذ المساعد للمخزن المحول اليه مدين
        $tAccount1 = new TAccount();
        $tAccount1->serial_num = getNextTAccountSerial();
        $tAccount1->account_num = $entry1->debit_account_num;
        $tAccount1->journal_type = 'مدين';
        $tAccount1->amount = $entry1->debit_amount;
        $tAccount1->description = "الي ح /" . $creditAccount->name;
        $tAccount1->journal_entry_id = $entry1->id;
        $tAccount1->account_id = $debitAccount->id;
        $tAccount1->ledger_id = Ledger::where('account_num',$entry1->debit_account_num)->first()->id;
        $tAccount1->created_by = Auth::user()->id;
        $tAccount1->save();

        //الاستاذ المساعد للمخزن الرئيسي دائن
        $tAccount2 = new TAccount();
        $tAccount2->serial_num = getNextTAccountSerial();
        $tAccount2->account_num = $entry1->credit_account_num;
        $tAccount2->journal_type = 'دائن';
        $tAccount2->amount = $entry1->credit_amount;
        $tAccount2->description = "  من ح /" .$debitAccount->name  ;
        $tAccount2->journal_entry_id = $entry1->id;
        $tAccount2->account_id = Account::where('account_num',$entry1->credit_account_num)->first()->id;
        $tAccount2->ledger_id = Ledger::where('account_num',$entry1->credit_account_num)->first()->id;
        $tAccount2->created_by = Auth::user()->id;
        $tAccount2->save();

                  


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
                    'current_balance' => $levelDebitAccount1->current_balance + $entry1->debit_amount ,
                ]);
                //dd($levelDebitAccount1->current_balance);
            }
            //credit
            $currentCreditAccount = $creditAccount->account_num ;
            $creditLevels = [];
            for ($k = strlen($currentCreditAccount); $k > 0; $k--) {
                $creditLevels[] = substr($currentCreditAccount, 0, $k);
            }
            //dd($creditLevels);
            foreach ($creditLevels as $relatedDebitLevel2) {

                $levelCreditAccount = Account::where('account_num',$relatedDebitLevel2)->first();
                //dd($levelCreditAccount->current_balance);
                $levelCreditAccount->update([
                    'current_balance' => $levelCreditAccount->current_balance - $entry1->debit_amount,
                ]);
                //dd($levelCreditAccount->current_balance);
            }


        //نهاية تحديث ارصدة حسابات الاباء بالشجرة المحاسبية




    }
}
