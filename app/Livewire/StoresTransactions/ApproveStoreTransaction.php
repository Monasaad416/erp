<?php

namespace App\Livewire\StoresTransactions;

use Alert;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ShortComing;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryTransactionItem;
use App\Events\InventoryTransactionEvent;
use Illuminate\Support\Facades\Notification;
use App\Events\RejectInventoryTransactionEvent;
use App\Notifications\ApproveStoreTransNotification;


class ApproveStoreTransaction extends Component
{

    public $transaction,$transaction_id,$approval=[],$transactionItems=[],$accepted_qty=[],$from_store_id,$to_store_id;
    public function mount($transaction)
    {
        $this->transaction = $transaction;
        $this->from_store_id = $this->transaction->from_store_id;
        $this->to_store_id = $this->transaction->to_store_id;
        //dd($transaction);
        $this->transactionItems = InventoryTransactionItem::where('inventory_transaction_id',$transaction->id)->get();
        //dd($this->transactionItems);

        // foreach ($this->transactionItems as $index => $transaction) {
        //     $this->approval[$index] = ''; // Initialize each index with an empty string or the default value you desire
        // }
    }



    public function approve()
    {
        // try {
        DB::beginTransaction();
        foreach ($this->transactionItems as $index => $item) {


            $toStore = Store::where('id', $this->transaction->to_store_id)->first();

            $product = Product::where('id', $item->product_id)->first();
            $shortcomings = ShortComing::where('product_id',$product->id)->where('branch_id',Auth::user()->branch_id)->get();
            //dd($toStore);

            $fromStoreRow = Inventory::where('product_id', $item['product_id'])
            ->where('store_id',$this->from_store_id)->latest()->first();
            $qtyInFromStore = $fromStoreRow->inventory_balance;
            //dd( $qtyInFromStore );

            $toStoreRow = Inventory::where('product_id', $item['product_id'])
            ->where('store_id',$this->to_store_id)->latest()->first();
            $qtyInToStore = $toStoreRow ? $toStoreRow->inventory_balance : 0;

                $transItem = InventoryTransactionItem::where('id',$item->id)->first();



            if($this->approval[$index] == "accepted") {

                //to store inventory
                $inventory = new Inventory();
                $inventory->initial_balance = $fromStoreRow->initial_balance ;
                $inventory->inventory_balance =  $qtyInToStore + $item->qty;
                $inventory->in_qty = $item->qty;
                $inventory->out_qty = 0;
                $inventory->current_financial_year = date("Y");
                $inventory->is_active = 1;
                $inventory->branch_id = Store::where('id',$this->to_store_id)->first()->branch->id;
                $inventory->store_id = $this->to_store_id;
                $inventory->product_id = $item->product_id;
                $inventory->created_by = Auth::user()->id;
                $inventory->notes = 'استلام مخزني';
                $inventory->inventorable_id =  $transItem->inventory_transaction_id;
                $inventory->inventorable_type = 'App\Models\InventoryTransactionItem';
                $inventory->save();

                $transItem->approval = 'accepted';
                $transItem->accepted_qty = $item->qty;
                $transItem->save();


                event(new InventoryTransactionEvent($item,$inventory,'accepted'));


                if($shortcomings) {
                    foreach($shortcomings as $shortcoming) {
                        if($inventory->current_balance > $product->alert_main_branch){
                            $shortcoming->delete();
                        }
                    }
                }

            } elseif($this->approval[$index] == "partially_accepted") {

                //from store inventory
                $inventory1 = new Inventory();
                $inventory1->initial_balance = $fromStoreRow->initial_balance ;
                $inventory1->inventory_balance =  $qtyInFromStore + $item->qty - $this->accepted_qty[$index];
                $inventory1->in_qty = $item->qty - $this->accepted_qty[$index];
                $inventory1->out_qty =  0;
                $inventory1->current_financial_year = date("Y");
                $inventory1->is_active = 1;
                $inventory1->branch_id = Store::where('id',$this->from_store_id)->first()->branch->id;
                $inventory1->store_id = $this->from_store_id;
                $inventory1->product_id = $item->product_id;
                $inventory1->created_by = Auth::user()->id;
                $inventory1->notes = ' بضاعة مردودة';
                $inventory1->inventorable_id = $transItem->inventory_transaction_id;
                $inventory1->inventorable_type = 'App\Models\InventoryTransactionItem';
                $inventory1->save();

                //to store inventory
                $inventory2 = new Inventory();
                $inventory2->initial_balance = $fromStoreRow->initial_balance ;
                $inventory2->inventory_balance =  $qtyInToStore + $this->accepted_qty[$index];
                $inventory2->in_qty = $this->accepted_qty[$index];
                $inventory2->out_qty = 0;
                $inventory2->current_financial_year = date("Y");
                $inventory2->is_active = 1;
                $inventory2->branch_id = Store::where('id',$this->to_store_id)->first()->branch->id;
                $inventory2->store_id = $this->to_store_id;
                $inventory2->product_id = $item->product_id;
                $inventory2->created_by = Auth::user()->id;
                $inventory2->notes = 'استلام مخزني';
                $inventory2->inventorable_id =  $transItem->inventory_transaction_id;
                $inventory2->inventorable_type = 'App\Models\InventoryTransactionItem';
                $inventory2->save();


                $transItem->approval = 'partially_accepted';
                $transItem->accepted_qty = $this->accepted_qty[$index];
                $transItem->save();


                event(new InventoryTransactionEvent($item,$inventory2,'partially_accepted'));


                if($shortcomings) {
                    foreach($shortcomings as $shortcoming) {
                        if($inventory2->current_balance > $product->alert_main_branch){
                            $shortcoming->delete();
                        }
                    }
                }

            } elseif($this->approval[$index]  == "rejected") {
                //dd('rejected');
                //from store inventory
                $inventory = new Inventory();
                $inventory->initial_balance  = $fromStoreRow->initial_balance ;
                $inventory->inventory_balance  =  $qtyInFromStore + $item->qty;
                $inventory->in_qty = $item->qty;
                $inventory->out_qty = 0;
                $inventory->current_financial_year  = date("Y");
                $inventory->is_active  = 1;
                $inventory->branch_id  = Store::where('id',$this->from_store_id)->first()->branch->id;
                $inventory->store_id  = $this->from_store_id;
                $inventory->product_id  = $item->product_id;
                $inventory->created_by  = Auth::user()->id;
                $inventory->notes = 'تحويل مخزني مرفوض-رد البضاعة';
                $inventory->inventorable_id =  $transItem->inventory_transaction_id;
                $inventory->inventorable_type = 'App\Models\InventoryTransactionItem';
                $inventory->save();


                event(new RejectInventoryTransactionEvent($item,$inventory,'rejected'));




                $transItem->approval = 'rejected';
                $transItem->accepted_qty = 0;
                $transItem->save();





            }
        }


        $users= User::where('roles_name','سوبر-ادمن')->orWhere('branch_id',$this->to_store_id)->get();
        //dd($users);

        $trans = $this->transaction ;
        Notification::send($users, new ApproveStoreTransNotification($trans));

        DB::commit();
        Alert::success('تمت عملية الفحص وتحديد المقبول من التحويل المخزني بنجاح.  ');
        return redirect()->route('stores.transactions');
                //  } catch (Exception $e) {
        //         DB::rollback();
        //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        //     }

    }
    public function render()
    {
        return view('livewire.stores-transactions.approve-store-transaction');
    }
}
