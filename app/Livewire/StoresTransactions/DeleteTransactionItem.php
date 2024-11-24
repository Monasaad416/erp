<?php

namespace App\Livewire\StoresTransactions;

use Exception;
use App\Models\Store;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\InventoryTransactionItem;
use App\Livewire\StoresTransactions\DisplayStoresTransactions;

class DeleteTransactionItem extends Component
{
    protected $listeners = ['deleteTransactionItem'];

     public $item,$trans_num,$product_name;


    public function deleteTransactionItem($id)
    {
        $this->item = InventoryTransactionItem::findOrFail($id);
        $this->trans_num = $this->item->inventoryTransaction->trans_num;
        $this->product_name = $this->item->product_name_ar;
        $this->resetValidation();
        $this->dispatch('deleteModalToggle');
    }


    public function delete()
    {
        // try{
            $item = InventoryTransactionItem::where('id',$this->item->id)->first();
            $qty = $item->qty;
            $storeId = $this->item->inventoryTransaction->from_store_id;

            $fromStoreRow = Inventory::where('product_id', $this->item->product_id)
            ->where('store_id',$storeId)->latest()->first();

            Inventory::create([
                'initial_balance' => $fromStoreRow->initial_balance ,
                'inventory_balance' => $fromStoreRow->inventory_balance + $qty,
                'in_qty'=> $qty,
                'out_qty'=> 0,
                'current_financial_year' => date("Y"),
                'is_active' => 1,
                'branch_id' => Store::where('id',$storeId)->first()->branch->id,
                'store_id' => $storeId,
                'product_id' => $this->item->product_id,
                'created_by' => Auth::user()->id,
                'notes'=>'حذف بند من التحويل المخزني وإعادتة للمخزن  ',
                'inventorable_id' => $item->inventory_transaction_id,
                'inventorable_type' => 'App\Models\InventoryTransactionItem',
            ]);

            $item ->delete();

            $trans = InventoryTransaction::where('trans_num',$this->item->inventoryTransaction->trans_num)->first();
            $itemCount = InventoryTransactionItem::where('inventory_transaction_id',$trans->id)->count();
            if($itemCount == 0){
                $trans->delete();
                $this->dispatch('refreshData')->to(DisplayStoresTransactions::class);
                $this->dispatch(
                'alert',
                    text: 'تم حذف  بند تحويل المخزن التحويل المخزني بنجاح',
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),
                );
            }

                $this->dispatch('deleteModalToggle');
                $this->dispatch('refreshData')->to(UpdateStoreTransaction::class);
                $this->dispatch(
                'alert',
                    text: 'تم حذف  بند تحويل المخزن بنجاح',
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),
                );

        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }




    public function render()
    {
        return view('livewire.stores-transactions.delete-transaction-item');
    }
}
