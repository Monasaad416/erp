<?php

namespace App\Livewire\CustomerInvoicesReturns;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerReturn;
use Illuminate\Support\Facades\Auth;

class DisplayReturns extends Component
{
    use WithPagination;
    public $searchItem='', $pending_status=0 ,$return_status,$from_date,$to_date,$branch_id; 
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
    public function updatingPendingStatus()
    {
        $this->resetPage();
    }
    public function updatingReturnStatus()
    {
        $this->resetPage();
    }
    public function render()
    {
        if(Auth::user()->roles_name == 'سوبر-ادمن') {
            $returns = CustomerReturn::where(function($query) {
                    if($this->branch_id != null) {
                        $query->where('branch_id', $this->branch_id);
                    }
                    if($this->return_status != null) {
                        $query->where('return_status', $this->return_status);
                    }
                    if($this->from_date != null && $this->to_date != null) {
                        $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
                    }
                })
                ->latest()
                ->paginate(config('constants.paginationNo'));
           

            // $groupedItems = $returns->groupBy('serial_num');

            return view('livewire.customer-invoices-returns.display-returns', [
                'returns' => $returns
            ]);
         } else {
            $returns = CustomerReturn::where('branch_id',Auth::user()->branch_id)->where( function($query) {
                if(!empty($this->searchItem )){
                    $query->where('customer_inv_num','like','%'.$this->searchItem.'%');
                    }
                if($this->pending_status != null ){
                    $query->where('is_pending',$this->pending_status);
                }
                if($this->branch_id != null ){
                    $query->where('branch_id',$this->branch_id);
                }
                if($this->return_status != null ){
                    $query->where('return_status',$this->return_status);
                }
                if($this->from_date != null && $this->to_date != null){
                    $query->whereBetween('created_at',[$this->from_date,$this->to_date]);
                }
            })->latest()->paginate(config('constants.paginationNo'));

            return view('livewire.customer-invoices-returns.display-returns',[
            'returns' => $returns
        ]);
        }

    }
}
