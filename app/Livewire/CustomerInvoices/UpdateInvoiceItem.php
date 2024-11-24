<?php

namespace App\Livewire\CustomerInvoices;

use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\CustomerInvoice;
use Illuminate\Validation\Rule;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Livewire\CustomerInvoices\UpdateInvoice;

class UpdateInvoiceItem extends Component
{
    protected $listeners = ['editSuppInvItem'];
    public $item_id,$product_name_ar,$product_name_en,$customer_invoice_id,$qty,$id, $sale_price,$wholesale_inc_vat,
    $tax_value,$item_discount_percentage,$total,$batch_num,$unit,$item,$product_code,$invoice,$discount_value,$discount_percentage;

    // public function mount($invoice)
    // {

    //     $this->item = CustomerInvoiceItem::where('id',$this->item_id)->get();
    //     //dd($this->invoice);
    // }


        public function mount($invoice)
    {
        $this->invoice = $invoice;


    }
    public function editSuppInvItem($item_id)
    {
        $this->item = CustomerInvoiceItem::findOrFail($item_id);
        //dd($item_id);

        $this->invoice = CustomerInvoice::where('id', $this->item->customer_invoice_id)->first();
       // dd($this->invoice);

        //dd($this->item);
        $this->product_name_en = $this->item->product_name_en;
        $this->product_name_ar = $this->item->product_name_ar;
        $this->product_code = $this->item->product_code;
        $this->customer_invoice_id = $this->item->customer_invoice_id;
        $this->qty = $this->item->qty;
        $this->sale_price = $this->item->sale_price;
        $this->wholesale_inc_vat = $this->item->wholesale_inc_vat;
        $this->tax_value = $this->item->tax_value;
        $this->item_discount_percentage = $this->item->item_discount_percentage;
        $this->total = $this->item->total;
        $this->batch_num = $this->item->batch_num ?? null;
        $this->unit = $this->item->unit;

        $this->resetValidation();

        $this->dispatch('editInvoiceModalToggle');

    }

    public function fetchProductName()
    {
        //retrieve the product name based on the product code
        $product = Product::where('product_code', $this->product_code)->first();
              // dd($product);
        $this->product_name_ar = $product ? $product->name_ar : null;
        $this->product_name_en = $product ? $product->name_en : null;
    }


    public function rules() {
        return [

            'qty' => "nullable|numeric",
            'wholesale_inc_vat' => "nullable|numeric",
            'sale_price' => "nullable|numeric",
            'batch_num' =>'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'sale_price.min' => trans('validation.sale_price_min'),
            'qty.numeric' => trans('validation.qty_numeric'),
        ];
    }


    public function updateItem() {

        $this->validate($this->rules(),$this->messages());
        //dd($this->all());
        $item = CustomerInvoiceItem::findOrFail($this->item_id);
        dd($item);
        $oldItemQty = $item->qty;
        $inventory = Inventory::where('product_id',$this->item->product_id)->where('branch_id',Auth::user()->branch_id)->latest()->first();

        //dd($oldQty);

        $this->item->qty = $this->qty;
        $this->item->batch_num = $this->batch_num ==  "" ? null : $this->batch_num;
        $this->item->sale_price = $this->sale_price;
        $this->item->save();

         dd($this->item);
        $inventory->inventory_balance =  $inventory->inventory_balance - $oldItemQty + $this->qty;
        $inventory->save();


        if($this->invoice->payment_type == 'by_installments') {
            dd('by_installments');
        } elseif($this->invoice->payment_type == 'cash') {
            dd('cash');
        }


        $this->dispatch('editInvoiceModalToggle');
    


        $this->dispatch(
        'alert',
            text: trans('admin.invoice_item_updated_successfully'),
            icon: 'success',
            confirmButtonText: trans('admin.done'),
            timer : 5000

        );


    }


    public function render()
    {

        return view('livewire.customer-invoices.update-invoice-item');
    }
}
