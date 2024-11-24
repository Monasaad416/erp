<?php

namespace App\Livewire\SupplierInvoices;

use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\SupplierInvoice;
use Illuminate\Validation\Rule;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Livewire\SupplierInvoices\UpdateInvoice;

class UpdateInvoiceItem extends Component
{
    protected $listeners = ['editSuppInvItem'];
    public $settings,$item_id,$product_name_ar,$product_name_en,$supplier_invoice_id,$qty,$taxes,$supplier_id,$id, $purchase_price,$wholesale_inc_vat,
    $tax_value,$total,$batch_num,$unit,$item,$product_code,$invoice,$discount_value,$discount_percentage,$sale_price,$unit_total,$item_total;

    // public function mount($invoice)
    // {

    //     $this->item = SupplierInvoiceItem::where('id',$this->item_id)->get();
    //     //dd($this->invoice);
    // }

    // public function mount()
    // {
    //     $supplierInv = SupplierInvoice::where('id',$this->item->supplier_invoice_id)->first();
    //     $this->supplier_id = $this->item->supplier_id;
    //     dd($supplierInv);
    // }


    public function editSuppInvItem($item_id)
    {
        $this->item = SupplierInvoiceItem::findOrFail($item_id);

        //dd($item);
        $this->product_name_en = $this->item->product_name_en;
        $this->product_name_ar = $this->item->product_name_ar;
        $this->product_code = $this->item->product_code;
        $this->supplier_invoice_id = $this->item->supplier_invoice_id;
        $this->qty = $this->item->qty;
        $this->purchase_price = $this->item->purchase_price;
        $this->wholesale_inc_vat = $this->item->wholesale_inc_vat;
        $this->tax_value = $this->item->tax_value;
        $this->discount_percentage = $this->item->discount_percentage;
        $this->total = $this->item->total;
        $this->batch_num = $this->item->batch_num;
        $this->unit = $this->item->unit;


        $supplierInv = SupplierInvoice::where('id', $this->item->supplier_invoice_id)->first();
        $supplier= Supplier::where('id', $supplierInv->supplier_id)->first();
       $this->supplier_id = $supplier->id;
       $this->settings = Setting::first();


        $this->resetValidation();

        $this->dispatch('editInvoiceModalToggle');

    }


    public function rules() {
        return [
            'qty' => "nullable|numeric",
            'discount_percentage' =>'nullable|numeric',
            'batch_num' => ['nullable','string',Rule::unique('supplier_invoice_items')->ignore($this->item->id, 'id')],
        ];
    }

    public function messages()
    {
        return [
            'product_code.string' => trans('validation.product_code_string'),
            'product_code.max' => trans('validation.product_code_max'),
            'product_code.exists' => trans('validation.product_code_exists'),
            'wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'purchase_price.min' => trans('validation.purchase_price_min'),
            'discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'discount_value.numeric' => trans('validation.discount_value_numeric'),
            'qty.numeric' => trans('validation.qty_numeric'),
        ];
    }


    public function update() {

        $this->validate($this->rules(),$this->messages());

            $inventory = Inventory::where('product_id',$this->item->product_id)->where('branch_id',1)->latest()->first();
           //dd($inventory);
            $oldQty = $inventory->inventory_balance ;
            //dd($oldQty);


            // dd($this->qty);
            $inventory->update([
                'inventory_balance' => $inventory->inventory_balance -$this->item->qty + $this->qty,
                'in_qty' => $this->qty,
                'out_qty' => 0 ,
                'latest_purchase_price' =>  $this->purchase_price,
                'latest_price_price' => $inventory->latest_purchase_price,
            ]);



                $invoice = SupplierInvoice::where('id',$this->item->supplier_invoice_id)->first();
                //dd($invoice);
                $invoice->updated_by = Auth::user()->id;

                $invoiceBeforeDiscount =  $invoice->total_before_discount -($this->item->total) +  ($this->qty * $this->purchase_price * (1- $this->settings->vat));
                //dd($this->item->total ,$this->qty * $this->purchase_price * (1- $this->settings->vat));
                $invoice->total_before_discount = $invoiceBeforeDiscount;
                $invoice->total_after_discount = $invoiceBeforeDiscount  * (1- $invoice->discount_percentage /100);

                $invoice->discount_percentage = $this->discount_percentage;
                $invoice->discount_value = ($invoice->total_before_discount +  $this->qty* ( $this->unit_total))* $this->discount_percentage/100;
                $invoice->supp_balance_after_invoice = $invoice->supp_balance_after_invoice - ($this->item->total) +  ($this->qty * $this->purchase_price * (1- $this->settings->vat));
                $invoice->save();


                $supplier = Supplier::where('id',$this->supplier_id)->first();



                $supplier->update([
                    'current_balance' => $invoice->supp_balance_after_invoice
                ]);


            $this->item->update([
                'qty' => $this->qty,
                'product_code'=> $this->product_code,
                'supplier_invoice_id'=> $this->supplier_invoice_id,
                'unit' => $this->unit,
                'inventory_balance' => $inventory->inventory_balance - $this->item->qty + $this->qty,
                'purchase_price' => $this->purchase_price,
                'wholesale_inc_vat' => $this->wholesale_inc_vat ? $this->wholesale_inc_vat : 0,
                'batch_num' => $this->batch_num === "" ? null : $this->batch_num,
                'tax_value' => $this->qty * $this->purchase_price * $this->settings->vat,
                'total' => $this->qty * $this->purchase_price * (1- $this->settings->vat),
                // 'inventorable_id' => $invoice->id,
                // 'inventorable_type' => 'App\Models\SupplierInvoice',
            ]);




         $this->dispatch('editInvoiceModalToggle');
         $this->dispatch('refreshData')->to(UpdateInvoice::class);


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

        return view('livewire.supplier-invoices.update-invoice-item');
    }
}
