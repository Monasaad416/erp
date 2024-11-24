<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class TreasuryTransactionsReports extends Component
{
    public $searchItem,$branch_id,$state,$accountNum,$from_date,$to_date;
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

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
    public function updatingAccountNum()
    {
        $this->resetPage();
    } 
    public function updatingStatus()
    {
        $this->resetPage();
    } 
    public function updatingBranchId()
    {
        $this->resetPage();
    }  
 
    public function render()
    {
        $transactions = Transaction::where( function($query) {
            if(!empty($this->searchItem )){
                $InvNum_with_prefix = $this->searchItem;
                $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);
                $query->where('inv_num','like','%'.$InvNum_without_prefix.'%');
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

        return view('livewire.reports.treasury-transactions-reports',[
            'transactions' => $transactions,
        ]);
    }
}
