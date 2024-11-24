<?php

namespace App\Livewire\TreasuryTransactions;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DisplayTransactions extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];
    public $searchItem,$branch_id,$state,$accountNum,$from_date,$to_date;


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
    public function updatingState()
    {
        $this->resetPage();
    } 

    public function updatingBranchId()
    {
        $this->resetPage();
    } 
    
 
    public function updatingLevels()
    {
        $this->resetPage();
    } 

    public function updatingAccountNum()
    {
        $this->resetPage();
    } 

    public function render()
    {

        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            $transactions = Transaction::where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('inv_num','like','%'.$this->searchItem.'%');
            }

            if($this->state != null ){
                $query->where('state',$this->state);
            }
             if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('created_at',[$this->from_date,$this->to_date]);
            }
        })->latest()->paginate(config('constants.paginationNo'));
        return view('livewire.treasury-transactions.display-transactions',[
            'transactions' => $transactions
        ]);
    } else {
            $transactions = Transaction::where('branch_id',Auth::user()->branch_id)->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('inv_num','like','%'.$this->searchItem.'%');
            }

            if($this->state != null ){
                $query->where('state',$this->state);
            }
             if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('created_at',[$this->from_date,$this->to_date]);
            }
        })->latest()->paginate(config('constants.paginationNo'));
        return view('livewire.treasury-transactions.display-transactions',[
            'transactions' => $transactions
        ]);
    }
    }
}
