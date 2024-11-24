<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SupplierInvoice;

class PurchasesReports extends Component
{
    use WithPagination;
    public $searchItem, $pending_status ,$return_status,$from_date,$to_date;

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
    public function updatinPendingStatus()
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
                $InvNum_with_prefix = $this->searchItem;
                $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);
                $query->where('supp_inv_num','like','%'.$InvNum_without_prefix.'%');
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
        return view('livewire.reports.purchases-reports',[
            'suppInvoices' => $suppInvoices
        ]);
    }
}
