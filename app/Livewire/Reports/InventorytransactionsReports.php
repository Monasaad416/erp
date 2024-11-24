<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InventoryTransaction;

class InventorytransactionsReports extends Component
{
    public $searchItem,$from_store_id,$to_store_id,$from_date,$to_date;
    use WithPagination;
        
    public function updatingFromStoreId()
    {
        $this->resetPage();
    }

    public function updatingToStoreId()
    {
        $this->resetPage();
    }
    public function updatingFromDate()
    {
        $this->resetPage();
    }
    
    public function updatingToDate()
    {
        $this->resetPage();
    }
    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {
        
        $transactions = InventoryTransaction::where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('product_name_ar','like','%'.$this->searchItem.'%');

                }

            if($this->from_store_id != null ){
                $query->where('from_store_id',$this->from_store_id);

            }
            if($this->to_store_id != null ){
                $query->where('to_store_id',$this->to_store_id);

            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('created_at',[$this->from_date,$this->to_date]);

            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('created_at',[$this->from_date,$this->to_date]);

            }
        })->latest()->paginate(config('constants.paginationNo'));
        return view('livewire.reports.inventorytransactions-reports',
    [
        'transactions'=> $transactions
    ]);
    }
}
