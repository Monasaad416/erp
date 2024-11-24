<?php

namespace App\Livewire\CustomerInvoices;

use Exception;
use App\Models\Store;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\DeleteCustomerInvoice;
use App\Livewire\CustomerInvoices\DisplayInvoices;
use Alert;

class DeleteInvoice extends Component
{

    protected $listeners = ['deleteCustomerInvoice'];
    public $customerInvoice ,$customerInvoiceNum;

    public function deleteCustomerInvoice($id)
    {
       // dd($id);
        $this->customerInvoice = CustomerInvoice::where('id',$id)->first();
        //dd($this->customerInvoice);
        $this->customerInvoiceNum = $this->customerInvoice->customer_inv_num;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        // try{
            DB::beginTransaction();
            $customerInvoice = CustomerInvoice::where('id',$this->customerInvoice->id)->first();
            //dd($customerInvoice);
            $items = CustomerInvoiceItem::where('customer_invoice_id',$this->customerInvoice->id)->get();
            foreach($items as $item){

            $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
            Inventory::create([
                'initial_balance' => $inventory->initial_balance,
                'inventory_balance' => $inventory->inventory_balance, - $item->qty,
                'current_financial_year' => date('Y'),
                'is_active' =>1,
                'product_id' => $item->product_id,
                'branch_id' => $customerInvoice->branch_id,
                'updated_by' => Auth::user()->id,
                'store_id' => Store::where('branch_id',$customerInvoice->branch_id)->first()->id ,
                'notes' => 'حذف فاتورة عميل',
                'latest_purchase_price' => $inventory->latest_purchase_price,
                'latest_sale_price' => $item->sale_price ,
                'inventorable_id' => $customerInvoice->id,
                'inventorable_type' => 'App\Models\CustomerInvoice',
                'in_qty' =>0,
                'out_qty' => $item->qty,
            ]);

                $item->delete();
            }

              event(new DeleteCustomerInvoice($customerInvoice));
            $customerInvoice->return_status = 12;
            $customerInvoice->save();
            $customerInvoice->delete();

            // $this->reset('customer');

            $this->dispatch('deleteModalToggle');

          
                DB::commit();
                // $this->dispatch('refreshData')->to(AddInvoice::class);
                Alert::success('تم حذف فاتورة العميل بنجاح');
                return redirect()->route('customers.invoices');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }
    public function render()
    {
        return view('livewire.customer-invoices.delete-invoice');
    }
}
