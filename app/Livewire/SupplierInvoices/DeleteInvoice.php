<?php

namespace App\Livewire\SupplierInvoices;

use Exception;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\SupplierInvoice;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Livewire\SupplierInvoices\DisplayInvoices;

class DeleteInvoice extends Component
{

    protected $listeners = ['deleteSuppInvoice'];
    public $supplierInvoice ,$supplierInvoiceNum;

    public function deleteSuppInvoice($id)
    {
        $this->supplierInvoice = SupplierInvoice::where('id',$id)->first();
    //dd($this->supplier);
        $this->supplierInvoiceNum = $this->supplierInvoice->supp_inv_num;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $suppInvoice = SupplierInvoice::where('id',$this->supplierInvoice->id);
            $items = SupplierInvoiceItem::where('supplier_invoice_id',$this->supplierInvoice->id)->get();
            foreach($items as $item){

                $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',1)->latest()->first();
                Inventory::create([
                    'inventory_balance' => $inventory->inventory_balance - $item->qty,
                    'initial_balance' => $inventory->initial_balance,
                    'in_qty' => 0,
                    'out_qty' => $item->qty,
                    'current_financial_year' => date("Y"),
                    'product_id' => $item->product_id,
                    'is_active' => $inventory->is_active,
                    'branch_id' => Auth::user()->branch_id,
                    'notes' => 'حذف فاتورة مورد',
                    'inventorable_id' => $suppInvoice->id,
                    'inventorable_type' => 'App\Models\SupplierInvoice',
                ]);

                $item->delete();
            }
            $suppInvoice->delete();

            // $this->reset('supplier');

            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayInvoices::class);

            $this->dispatch(
            'alert',
                text: trans('admin.supplier_invoice_deleted_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.supplier-invoices.delete-invoice');
    }
}
