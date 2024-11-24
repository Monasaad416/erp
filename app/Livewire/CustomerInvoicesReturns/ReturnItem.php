<?php

namespace App\Livewire\CustomerInvoicesReturns;

use Alert;
use Exception;
use App\Models\Store;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\CustomerReturn;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\CustomerInvItemReturnedEvent;
use App\Livewire\customerInvoices\DisplayInvoices;

class ReturnItem extends Component
{

    protected $listeners = ['returnItem'];

    public $item,$ItemNameAr,$ItemNameEn,$customerInvoice ,$customerInvoiceNum;

    public function returnItem($item_id)
    {
        $this->item = CustomerInvoiceItem::where('id',$item_id)->first();
        $this->ItemNameAr = $this->item->product_name_ar;
        $this->ItemNameEn = $this->item->product_name_en ? $this->item->product_name_en : $this->item->product_name_ar;
        //dd($this->customer);
        $this->customerInvoiceNum = $this->item->customerInvoice->customer_inv_num;
        $this->customerInvoice = customerInvoiceItem::where('customer_invoice_id',$this->item->customer_invoice_id)->first();

        $this->dispatch('returnModalToggle');

    }

    public function returnInvoiceItem()
    {
        try{
            DB::beginTransaction();
            $customerInvoice = CustomerInvoice::where('id',$this->customerInvoice->id)->first();
            $item = CustomerInvoiceItem::where('id',$this->item->id)->first();

            $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
            Inventory::create([
                'inventory_balance' => $inventory->inventory_balance + $item->qty,
                'initial_balance' => $inventory->initial_balance,
                'in_qty' => $item->qty,
                'out_qty' => 0,
                'notes' => 'رد بند من فاتورة عميل',
                'current_financial_year' => date("Y"),
                'product_id' => $item->product_id,
                'is_active' => $inventory->is_active,
                'branch_id' => Auth::user()->branch_id,
                'store_id' => Store::where('branch_id',Auth::user()->branch_id)->first()->id,
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
            $invoiceItemReturn->return_status = 2;
            $invoiceItemReturn->save();



            $item->update([
                'return_status' => 1,
                'Return_qty' => $item->qty,
            ]);

            $settings = Setting::findOrFail(1);
            $product = Product::where('id',$item->product_id)->first();
            if($product->taxes == 1 ) {
                $tax = $settings->vat * $item->sale_price * $item->qty;
            } else {
                $tax = 0;
            }

            $item->qty = 0;
            $item->total = 0;
            $item->return_status = 1;// item returned totally in suppliers invoices items table
            $item->return_qty = $this->item->qty;
            $item->save();


            $price = $item->sale_price * $item->qty;


            $customerInvoice->tax_value = $customerInvoice->tax_value - $tax;
            $customerInvoice->total_before_discount = $customerInvoice->total_before_discount -($item->sale_price * $item->qty) + $tax;
            $customerInvoice->total_after_discount = $customerInvoice->discount_percentage * ($customerInvoice->total_after_discount -($item->sale_price * $item->qty) + $tax);
            $customerInvoice->return_status = 11;


            $customerInvoice->save();

            $totalReturnPrice = $price + $tax;

            event(new CustomerInvItemReturnedEvent($customerInvoice,$item,$totalReturnPrice));



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
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.customer-invoices-returns.return-item');
    }
}
