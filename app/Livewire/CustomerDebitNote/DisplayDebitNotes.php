<?php

namespace App\Livewire\CustomerDebitNote;

use App\Models\CustomerDebitNote;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DisplayDebitNotes extends Component
{
    use WithPagination;
    public $searchItem='',$from_date,$to_date,$branch_id; 
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

    public function render()
    {
        
        if(Auth::user()->roles_name == 'سوبر-ادمن') {
            $items = CustomerDebitNote::where( function($query) {

                if($this->branch_id != null ){
                    $query->where('branch_id',$this->branch_id);
                }

                if($this->from_date != null && $this->to_date != null){
                    $query->whereBetween('created_at',[$this->from_date,$this->to_date]);
                }
                
            })->latest()->paginate(config('constants.paginationNo'));

            return view('livewire.customer-debit-note.display-debit-notes',[
                'items' => $items
            ]); 
         } else {
            $items = CustomerDebitNote::where('branch_id',Auth::user()->branch_id)->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('customer_inv_num','like','%'.$this->searchItem.'%');
                }

             if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }

            if($this->from_date != null && $this->to_date != null){
                $query->whereBetween('created_at',[$this->from_date,$this->to_date]);
            }
        })->latest()->paginate(config('constants.paginationNo'));

        return view('livewire.customer-debit-note.display-debit-notes',[
            'items' => $items
        ]);
        }

    }
}
