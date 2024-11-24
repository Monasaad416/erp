<?php

namespace App\Livewire\StoresTransactions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InventoryTransaction;
use App\Models\InventoryTransactionItem;

class TransactionItems extends Component
{
    use WithPagination;

    public $transaction;


    public function mount($transaction)
    {
        $this->transaction = $transaction;
        //dd($this->transaction);
        // $this->transaction_items = InventoryTransactionItem::where('inventory_transaction_id',$this->transaction->id)->paginate(config('constants.paginationNo'));
        // //dd($this->transaction_items);
    }
    public function render()
    {
        $transaction_items = InventoryTransactionItem::where( function($query) {
            if(!empty($this->from_store )){
                $query->where('from_store_id',$this->from_store)->where('to_store_id',$this->to_store);
            }
        })->where('inventory_transaction_id',$this->transaction->id)->latest()->paginate(config('constants.paginationNo'));
        return view('livewire.stores-transactions.transaction-items',[
            'transaction_items' => $transaction_items,
        ]);
    }

    
}
