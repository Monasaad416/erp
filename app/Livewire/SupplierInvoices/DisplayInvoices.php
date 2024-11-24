<?php

namespace App\Livewire\SupplierInvoices;

use Livewire\Component;
use App\Models\SupplierInvoice;
use Livewire\WithPagination;


class DisplayInvoices extends Component
{
    use WithPagination;
    public $searchItem, $pending_status=0 ,$return_status,$from_date,$to_date;
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
    public function updatingReturnStatus()
    {
        $this->resetPage();
    } 
    public function updatingPendingStatus()
    {
        $this->resetPage();
    }  

    public function render()
    {
            $suppInvoices = SupplierInvoice::withTrashed()->select('id',
            'supp_inv_num','serial_num','supp_inv_date_time','supplier_id','discount_value','discount_percentage',
            'total_before_discount','total_after_discount','deserved_amount','status','return_status',
            'payment_type','notes','payment_date','is_pending','supp_balance_before_invoice','paid_amount',
            'supp_balance_after_invoice','created_by','updated_by')->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('supp_inv_num','like','%'.$this->searchItem.'%');

                }

            if($this->pending_status != null ){
                $query->where('is_pending',$this->pending_status);
            }
            if($this->return_status != null ){
                $query->where('return_status',$this->return_status);
            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('supp_inv_date_time',[$this->from_date,$this->to_date]);
            }



        })->latest()->paginate(config('constants.paginationNo'));

        return view('livewire.supplier-invoices.display-invoices',[
            'suppInvoices' => $suppInvoices

        ]);

    }
}
