<?php

namespace App\Livewire\CustomerInvoices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\Auth;


class DisplayInvoices extends Component
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
            $customerInvoices = CustomerInvoice::withTrashed()->select('id',
                'customer_inv_num','customer_inv_date_time','customer_id','discount_percentage',
                'total_before_discount','total_after_discount','return_status',
                'payment_type','notes','is_pending','created_by','updated_by','branch_id')->where( function($query) {
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

            return view('livewire.customer-invoices.display-invoices',[
                'customerInvoices' => $customerInvoices
            ]); 
         } else {
            $customerInvoices = CustomerInvoice::withTrashed()->where('branch_id',Auth::user()->branch_id)->select('id',
            'customer_inv_num','customer_inv_date_time','customer_id','discount_percentage',
            'total_before_discount','total_after_discount','return_status',
            'payment_type','notes','is_pending','created_by','updated_by','branch_id')->where( function($query) {
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

        return view('livewire.customer-invoices.display-invoices',[
            'customerInvoices' => $customerInvoices
        ]);
    }

    }
}
