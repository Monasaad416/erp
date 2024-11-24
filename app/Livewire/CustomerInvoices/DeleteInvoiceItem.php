<?php

namespace App\Livewire\CustomerInvoices;

use Exception;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\CustomerInvoice;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;


class DeleteInvoiceItem extends Component
{

    protected $listeners = ['deleteCustomerInvItem'];
    public $customerInvoiceItem ,$customerInvoiceNum,$itemNameAr,$itemNameEn;

    public function deleteCustomerInvItem($item_id)
    {
        $this->customerInvoiceItem = CustomerInvoiceItem::where('id',$item_id)->first();
        //dd($this->customerInvoiceItem->product_name_ar);
        $this->customerInvoiceNum = $this->customerInvoiceItem->customerInvoice->customer_inv_num;
        //dd($this->customerInvoiceNum);
        $this->itemNameAr = $this->customerInvoiceItem->product_name_ar;
        $this->itemNameEn = $this->customerInvoiceItem->product_name_en;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $item = CustomerInvoiceItem::where('id',$this->customerInvoiceItem->id)->first();

            $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',Auth::user()->branch_id)->latest()->first();


            Inventory::create([
                'inventory_balance' => $inventory->inventory_balance - $item->qty,
                'initial_balance' => $inventory->initial_balance,
                'in_qty' => 0,
                'out_qty' => $item->qty,
                'current_financial_year' => date("Y"),
                'product_id' => $item->product_id,
                'is_active' => $inventory->is_active,
                'branch_id' => Auth::user()->branch_id,
                'store_id' => 1,
                'notes' => 'حذف بند من فاتورة مورد',
                'inventorable_id' => $item->customer_invoice_id,
                'inventorable_type' => 'App\Models\CustomerInvoice',
            ]);


            $item->delete();




            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(UpdateInvoice::class);

            $this->dispatch(
            'alert',
                text: trans('admin.customer_invoice_Item_deleted_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }

    public function render()
    {
        return view('livewire.customer-invoices.delete-invoice-item');
    }
}
