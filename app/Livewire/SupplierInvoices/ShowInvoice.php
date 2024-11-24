<?php

namespace App\Livewire\SupplierInvoices;

use App\Models\Product;
use Livewire\Component;
use App\Models\SupplierInvoiceItem;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class ShowInvoice extends Component
{
    public $product, $product_id,$product_name,$purchase_price,$wholesale_inc_vat,
    $qty='',$price,$invoice_products=[],$invoice,$batch_num,
       $discount_percentage=0,$discount_value=0,$taxes ,
    $invoice_discount_percentage=0,$invoice_discount_value=0,$product_code;


    
    public $listeners = ['refreshData' =>'$refresh'];
    
    public function mount($invoice)
    {
        //dd($this->invoice);
        $this->invoice = $invoice;
        $this->invoice_products = SupplierInvoiceItem::where('supplier_invoice_id',$this->invoice->id)->get();
        //dd($this->invoice_products);
    }
    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name = "";
        $this->purchase_price = "";
        $this->wholesale_inc_vat = "";
        $this->discount_value = "";
        $this->discount_percentage = "";
        $this->taxes = "";
    }

    public function fetchProductName()
    {
        //retrieve the product name based on the product code
        $product = Product::where('product_code', $this->product_code)
        ->select('id','name_'.LaravelLocalization::getCurrentLocale().' as product_name','product_code')->first();
              // dd($product);
        $this->product_name = $product ? $product->product_name : null;
    }
    public function rules() {
        return [
            'product_code' => "required|string|max:20|exists:products,product_code",
            'qty' => "required|numeric",
            'purchase_price' => 'required_if:wholesale_inc_vat,null',
            'wholesale_inc_vat' => 'required_if:purchase_price,null',
            'discount_value' =>'nullable|numeric',
            'discount_percentage' =>'nullable|numeric',
            'batch_num' =>'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            
            'product_code.required' => trans('validation.product_code_required'),
            'product_code.string' => trans('validation.product_code_string'),
            'product_code.max' => trans('validation.product_code_max'),
            'product_code.exists' => trans('validation.product_code_exists'),
            'purchase_price.required_if' => trans('validation.purchase_price_required_if'),
            'wholesale_inc_vat.required_if' => trans('validation.wholesale_inc_vat_required_if'),
            'wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'purchase_price.min' => trans('validation.purchase_price_min'),
            'discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'discount_value.numeric' => trans('validation.discount_value_numeric'),
            'qty.required' => trans('validation.qty_required'),
            'qty.numeric' => trans('validation.qty_numeric'),
        ];
    }


    public function update() {
    
        $this->validate($this->rules(),$this->messages());
        $this->product = Product::where('product_code',$this->product_code)->select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as product_name','unit_id')->first();

        $pivotRow = SupplierInvoiceItem::where('product_id',$this->product->id)->where('supplier_invoice_id',$this->invoice->id)->first();
        if($pivotRow) {
            $pivotRow->update([
                'qty' => $pivotRow->qty + $this->qty
            ]);
        } else {
            SupplierInvoiceItem::create([
               'product_id'=> $this->product->id,
                'product_code'=> $this->product_code,
                'product_name'=> $this->product->product_name,
                'supplier_invoice_id'=> $this->invoice->id,
                'unit' => $this->product->unit->name,
                'qty' => $this->qty ,
                'purchase_price' => $this->purchase_price ? $this->purchase_price : 0,
                'wholesale_inc_vat' => $this->wholesale_inc_vat ? $this->wholesale_inc_vat : 0,
                'item_discount_percentage' => $this->discount_percentage ? $this->discount_percentage : 0,
                // 'discount_value' => $this->discount_value ? $this->discount_value : 0,
                'batch_num' => $this->batch_num ? $this->batch_num : "---",
                'tax_value' => $this->taxes ? $this->taxes."%" : 0,


  
            ]);


        }

        $this->mount($this->invoice);

        $this->dispatch(
           'alert',
            text: trans('admin.item_added_to_invoice_successfully'),
            icon: 'success',
            confirmButtonText: 'تم',
            timer : 5000

        );


         $this->clearInputs();

    }
    public function render()
    {
        return view('livewire.supplier-invoices.show-invoice');
    }
}
