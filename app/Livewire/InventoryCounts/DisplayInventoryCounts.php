<?php

namespace App\Livewire\InventoryCounts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InventoryCount;
use Illuminate\Support\Facades\Auth;

class DisplayInventoryCounts extends Component
{
    use WithPagination;
    public $searchItem='',$is_settled,$branch_id,$from_date,$to_date;
    public $listeners = ['refreshData' =>'$refresh'];


    public function updatingBranchId()
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
    public function updatingIsSettled()
    {
        $this->resetPage();
    }
    public function updatingReturnStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        if(Auth::user()->roles_name == "سوبر-ادمن"){
            $invCounts = InventoryCount::where( function($query) {
                if(!empty($this->searchItem )){
                    $query->where('name_ar','like','%'.$this->searchItem.'%');
                    }
                if($this->is_settled == 1){
                    $query->where('is_settled', 1);
                }
                if($this->branch_id != null ){
                    $query->where('branch_id',$this->branch_id);
                }
                if($this->from_date != null ){
                    $query->where('from_date', ">=" ,$this->from_date);
                }
                if($this->to_date != null ){
                    $query->where('to_date', "<=" ,$this->to_date);
                }
            })->latest()->paginate(config('constants.paginationNo'));

            return view('livewire.inventory-counts.display-inventory-counts',[
                'invCounts' => $invCounts, 
            ]);
        }
        else {
            $invCounts = InventoryCount::where( function($query) {
                if(!empty($this->searchItem )){
                    $query->where('name_ar','like','%'.$this->searchItem.'%');
                    }
                if($this->is_settled == 1){
                    $query->where('is_settled', 1);
                }
                if($this->branch_id != null ){
                    $query->where('branch_id',$this->branch_id);
                }
                if($this->from_date != null ){
                    $query->where('from_date', ">=" ,$this->from_date);
                }
                if($this->to_date != null ){
                    $query->where('to_date', "<=" ,$this->to_date);
                }
            })->where('branch_id',Auth::user()->branch_id)->latest()->paginate(config('constants.paginationNo'));

            return view('livewire.inventory-counts.display-inventory-counts',[
                'invCounts' => $invCounts, 
            ]);
        }
}

}
