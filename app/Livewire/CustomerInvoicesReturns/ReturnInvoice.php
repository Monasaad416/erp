<?php

namespace App\Livewire\CustomerInvoicesReturns;

use Alert;
use Exception;
use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\CustomerReturn;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\CustomerInvoiceReturnedEvent;
use App\Livewire\CustomerInvoices\DisplayInvoices;

class ReturnInvoice extends Component
{


    protected $listeners = ['returnInvItems'];

    public $customerInvoice ,$customerInvoiceNum;

    public function returnInvItems($id)
    {
        $this->customerInvoice = CustomerInvoice::where('id',$id)->first();
    //dd($this->customer);
        $this->customerInvoiceNum = $this->customerInvoice->customer_inv_num;

        $this->dispatch('returnModalToggle');

    }


    public function returnInvoice()
    {
        // try{
            DB::beginTransaction();
            $customerInvoice = CustomerInvoice::where('id',$this->customerInvoice->id)->first();
            $items = CustomerInvoiceItem::where('customer_invoice_id',$this->customerInvoice->id)->get();
            foreach($items as $item){
                $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
                Inventory::create([
                    'inventory_balance' => $inventory->inventory_balance + $item->qty,
                    'initial_balance' => $inventory->initial_balance,
                    'in_qty' => $item->qty,
                    'out_qty' => 0,
                    'notes' => 'رد كامل بنود فاتورة عميل',
                    'current_financial_year' => date("Y"),
                    'product_id' => $item->product_id,
                    'is_active' => $inventory->is_active,
                    'branch_id' => Auth::user()->branch_id,
                    'store_id' => 1,
                    'latest_purchase_price' => $inventory->latest_purchase_price,
                    'latest_price_price' => $inventory->latest_purchase_price,
                    'inventorable_id' => $item->id,
                    'inventorable_type' => 'App\Models\CustomerInvoiceItem',
                ]);

                    $invoiceItemReturn = new CustomerReturn();
                    $invoiceItemReturn->product_id = $item->product_id ;
                    $invoiceItemReturn->product_name_ar =$item->product_name_ar;
                    $invoiceItemReturn->product_name_en =$item->product_name_en ?? null;
                    $invoiceItemReturn->product_code =$item->product_code;
                    $invoiceItemReturn->unit =$item->unit;
                    $invoiceItemReturn->customer_invoice_id = $customerInvoice->id;
                    $invoiceItemReturn->sale_price =$item->sale_price;
                    $invoiceItemReturn->total_without_tax =$item->total_without_tax;
                    $invoiceItemReturn->tax =$item->tax;
                    $invoiceItemReturn->total_with_tax =$item->total_with_tax;
                    $invoiceItemReturn->return_qty =$item->qty;
                    $invoiceItemReturn->return_status = 1;
                    $invoiceItemReturn->save();



                $item->delete();
            }
             //dd($customerInvoice);
            $customerInvoice->update([
                'return_status' => 10,
            ]);

            event(new CustomerInvoiceReturnedEvent($customerInvoice));
            $customerInvoice->delete();

            // $this->reset('customer');

            $this->dispatch('returnModalToggle');

            $this->dispatch('refreshData')->to(DisplayInvoices::class);

            $this->dispatch(
            'alert',
                text: trans('admin.customer_invoice_returned_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done'),
            );
            DB::commit();





    }
    public function render()
    {
        return view('livewire.customer-invoices-returns.return-invoice');
    }
}
