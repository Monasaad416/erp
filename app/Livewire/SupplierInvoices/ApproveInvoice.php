<?php

namespace App\Livewire\SupplierInvoices;

use Exception;
use Livewire\Component;
use App\Models\SupplierInvoice;

class ApproveInvoice extends Component
{
    public $id,$invoice ,$is_approved,$suppInvNum;
    protected $listeners = ['approveInvoice'];
    public function approveInvoice($id)
    {
        $this->id = $id;
        $this->invoice = SupplierInvoice::where('id',$id)->first();

        $this->suppInvNum = $this->invoice->supp_inv_num;
        // return dd($this->invoice);
        $this->is_approved = $this->invoice->is_approved;


        $this->dispatch('changeStateModalToggle');
    }


    public function changeApprovalState()
    {
        try{
            if( $this->invoice->is_approved == 0 ){
                $this->invoice->is_approved = 1;
                $this->invoice->save();


                $

                $this->dispatch(
                'alert',
                    text: trans('admin.invoice_approval_state_changed_successfully'),
                    icon: 'success',
                    confirmButtonText: trans('admin.done')

                );
            }else {
                $this->dispatch(
                'alert',
                    text: trans('admin.sorry_cannot_reject_invoice'),
                    icon: 'error',
                    confirmButtonText: trans('admin.done')

                );
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayInvoices::class);



        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.supplier-invoices.approve-invoice');
    }
}
