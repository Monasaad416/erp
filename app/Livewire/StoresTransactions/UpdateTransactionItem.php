<?php

namespace App\Livewire\StoresTransactions;

use Livewire\Component;
use App\Models\InventoryTransactionItem;
use App\Livewire\StoresTransactions\UpdateStoreTransaction;

class UpdateTransactionItem extends Component
{

    protected $listeners = ['updateTransactionItem'];

     public $item,$product_name_ar,$product_code,$total_price=0,$branch_id,$qty,$unit,$id,$unit_price=0;


    public function updateTransactionItem($id)
    {
        $this->item = InventoryTransactionItem::findOrFail($id);

        $this->product_code = $this->item->product_code;
        $this->product_name_ar = $this->item->product_name_ar;
        $this->unit = $this->item->unit;
        $this->qty = $this->item->qty;
        $this->unit_price = $this->item->unit_price;
        $this->total_price = $this->item->total_price;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

    public function update()
    {
        $this->item->update([
            'qty' => $this->qty,
        ]);
        $this->reset(['qty']);

        $this->dispatch('editModalToggle');

        $this->dispatch('refreshData')->to(UpdateStoreTransaction::class);

        $this->dispatch(
        'alert',
            text: trans('تم تعديل كمية البند المحولة من المخزن بنجاح'),
            icon: 'success',
            confirmButtonText: trans('admin.done')

        );

>>>>>>>>>>>>>>>>>>>>>>>>>     'inventorable_id' => $row ->id,
                    'inventorable_type' => 'App\Models\InventoryTransactionItem',
                    >>>>>>>>>>>>>>>>>>>>>>>

    }

    public function render()
    {
        return view('livewire.stores-transactions.update-transaction-item');
    }
}
