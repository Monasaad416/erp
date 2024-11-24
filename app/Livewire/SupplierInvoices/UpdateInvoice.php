<?php

namespace App\Livewire\SupplierInvoices;

use Alert;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\ProductCode;
use App\Models\ShortComing;
use App\Models\SupplierInvoice;
use Illuminate\Validation\Rule;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateInvoice extends Component
{
    public $suppliers,$units,$product, $products=[],$product_id,$product_name_ar,$product_name_en,$purchase_price,$wholesale_inc_vat,
    $qty='',$price,$rows=[],$invoice_products=[],$invoice,$batch_num,
    $discount_percentage=0,$discount_value=0,$taxes,$product_code,$supplier_id,$supp_inv_date_time,$supp_inv_num
    ,$payment_type,$notes,$is_pending=0,$unit,$supplier_invoice_id,$settings;


    public $listeners = ['refreshData' =>'$refresh'];

    public function mount($invoice)
    {
        $this->invoice = $invoice;
    //dd($this->invoice);
        $this->invoice_products = SupplierInvoiceItem::where('supplier_invoice_id', $this->invoice->id)->get();

        $this->is_pending = $this->invoice->is_pending;
        $this->supp_inv_num = $this->invoice->supp_inv_num;
        $this->supplier_id = $this->invoice->supplier_id;
        $this->supp_inv_date_time = Carbon::parse($this->invoice->supp_inv_date_time)->format('Y-m-d H:i:s');
        $this->payment_type = $this->invoice->payment_type;
        $this->discount_percentage = $this->invoice->discount_percentage;
        $this->notes = $this->invoice->notes;
        // $this->discount_value = $this->invoice->discount_value;

        $this->products = Product::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','unit_id','sale_price')->where('is_active',1)->get();


        $this->settings = Setting::first();

        if($this->invoice->is_pending == 1 ) {
            $this->addRow(0);
        }

        $this->dispatch('newRowAdded');
    }

    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name_ar = "";
        $this->product_name_en = "";
        $this->purchase_price = "";
        $this->wholesale_inc_vat = "";
        $this->product_id = "";
        $this->discount_value = "";
        $this->discount_percentage = "";
        $this->taxes = "";
        $this->batch_num = "";
    }

    public function fetchByCode($index)
    {

        $codeExclude01 = substr($this->rows[$index]['product_code'], 2);
        $finalCode = substr($codeExclude01, 0, 14);

        $this->rows[$index]['product_code'] = $finalCode;

        //dd($this->rows[$index]['product_code']);

        $this->validate([
            'rows.' . $index . '.product_code' => 'required|string|max:100|exists:product_codes,code',
        ]);

        // Retrieve the product name based on the product code
        $productCode = ProductCode::where('code', $this->rows[$index]['product_code'])->first();

        $product = Product::where('id', $productCode->product_id)->first();

        $this->rows[$index]['product_name_ar'] = $product ? $product->name_ar : null;
        $this->rows[$index]['product_name_en'] = $product ? $product->name_en : null;
        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['sale_price'] = $product ? $product->sale_price : null;
    }

    public function calculateUnitPrice($index)
    {
        if ($this->rows[$index]['qty'] !== null) {
            $wholesalePriceWithVat = (float) $this->rows[$index]['wholesale_inc_vat'];
            $wholesalePriceWithoutVat = $wholesalePriceWithVat / 1.15;

            $qty = (float) $this->rows[$index]['qty'];

            $unitPrice = $wholesalePriceWithoutVat / $qty;
            $formattedUnitPrice = number_format($unitPrice, 2);

            $this->rows[$index]['purchase_price'] = $formattedUnitPrice;
        }
    }

    public function fetchByName($index, $selectedProductId)
    {
        // Fetch data and update properties
        //dd('dd');
        $product = Product::where('id', $selectedProductId)->first();

        $this->rows[$index]['product_id'] = $product ? $product->id : trans('admin.not_found');
        $this->rows[$index]['unit'] = $product ? $product->unit->name : null;
        $this->rows[$index]['sale_price'] = $product ? $product->sale_price : null;
        $this->rows[$index]['product_name_ar'] = $product ? $product->product_name_ar : null;

        $this->rows[$index]['product_code'] = ProductCode::where('product_id', $selectedProductId)->latest()->first()->code;
    }
    public function rules()
    {
        return [
            'product_code' => "nullable|string|max:20|exists:products,product_code",
            'qty' => "nullable|numeric",
            // 'purchase_price' => 'nullable_if:wholesale_inc_vat,null',
            // 'wholesale_inc_vat' => 'nullable_if:purchase_price,null',
            'discount_value' =>'nullable|numeric',
            'discount_percentage' =>'nullable|numeric',
            'batch_num' =>'nullable|string',
            'payment_type' => "nullable|string",
            // 'status' => 'nullable',
            'notes' =>'nullable|string',
            'is_pending' =>'nullable',

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
            'payment_type.required' => trans('validation.payment_type_required'),
        ];
    }

    public function focusNextRowInput($event, $index)
    {
        if ($index === count($this->rows) - 1) {

            $this->addRow();
            $this->dispatch('newRowAdded');
        }

        $nextIndex = $index + 1;
        $nextInputId = "input-" . $nextIndex;

        $this->dispatch('focus-input', ['inputId' => $nextInputId]);
    }


    public function addRow()
    {
        // $this->clearInputs();
        $this->rows[] = [
            'product_code' => '',
            'qty' => 0,
            'product_name_ar' => '',
            // 'product_name_en' => '',
            'product_id' => '',
            'unit' => '',
            'purchase_price' => 0,
            'sale_price' => 0,
            'wholesale_inc_vat' => 0,
            'batch_num' => '',
            'taxes' => 0,
            'unit_total' => 0,

        ];
    }
    public function removeItem($index)
    {
        unset($this->rows[$index -1]);
    }

    public function getTaxes($index)
    {
        $product = Product::where('id', $this->rows[$index]['product_id'])->first();
        $this->rows[$index]['taxes'] = $product->taxes == 1 ? $this->rows[$index]['purchase_price'] * $this->settings->vat : 0;
        $this->rows[$index]['unit_total'] = $this->rows[$index]['taxes']  + $this->rows[$index]['purchase_price'] ;
    }

    public function update() {
        //dd($this->all());


        $this->validate($this->rules(),$this->messages());

        foreach($this->rows as $row) {
       // dd($row);

    //     $code = ProductCode::where('code',$row['product_code'])->first();//add or update item
    //    // dd($code);
    //     $pivotRow = SupplierInvoiceItem::where('product_id',$row['product_id'])->where('supplier_invoice_id',$this->invoice->id)->first();
    //         if(!$pivotRow) {
            if($this->is_pending == 1) {
                $product = Product::where('id', $row['product_id'] )->first();
                $price = 0;

                $settings = Setting::first();
                $invTotal = $this->invoice->total_without_tax;
                $taxTotal = $this->invoice->tax_value;
                $total_before_discount = $this->invoice->total_before_discount;



                if($row['wholesale_inc_vat'] > 0) {
                    $price = ($row['wholesale_inc_vat'] / 1.15) / $row['qty'];
                }


                if($row['product_id'] != null && $row['product_code']) {
                    $product = Product::where('id', $row['product_id'] )->first();
                    foreach ($this->rows as $index => $row) {


                            $invoiceItem = new SupplierInvoiceItem();
                            $invoiceItem->product_id = $row['product_id'];
                            $invoiceItem->product_name_ar = $product->name_ar;
                            $invoiceItem->product_name_en = $product->name_ar ?? null;
                            $invoiceItem->product_code = $row['product_code'];
                            $invoiceItem->unit = $row['unit'];
                            $invoiceItem->supplier_invoice_id = $this->invoice->id;
                            $invoiceItem->qty = $row['qty'];
                            $invoiceItem->purchase_price = $row['purchase_price'] ? $row['purchase_price'] : $price;
                            $invoiceItem->sale_price = $row['sale_price'] ;
                            $invoiceItem->wholesale_inc_vat = $row['wholesale_inc_vat'] ? $row['wholesale_inc_vat'] : 0 ;
                            $invoiceItem->tax_value = $row['purchase_price'] * $row['qty'] * $settings->vat * $product->taxes;//////////////////////////////////////////check
                            $invoiceItem->total =  $row['wholesale_inc_vat'] > 0 ?  $row['wholesale_inc_vat'] : $row['unit_total'] * $row['qty'];
                            //dd($row['product_name_ar']);


                    $invTotal += $invoiceItem->total;
                    $taxTotal += $invoiceItem->tax_value;

                    //increase inventory amount

                    $inventory  = Inventory::where('product_id',$row['product_id'])->where('branch_id',1)->latest()->first();
                        // dd( $row['product_id']);
                    $inv = new Inventory();
                    $inv->inventory_balance = $inventory ? $inventory->inventory_balance + $row['qty'] :  $row['qty'];
                    $inv->initial_balance = $inventory ? $inventory->initial_balance : 0 ;
                    $inv->in_qty = $row['qty'];
                    $inv->out_qty = 0;
                    $inv->current_financial_year = date("Y");
                    $inv->is_active = 1;
                    $inv->branch_id = 1;
                    $inv->store_id = 1;
                    $inv->product_id = $product->id;
                    $inv->updated_by = Auth::user()->id;
                    $inv->notes ='توريد كمية جديدة للمخزن الرئيسي';
                    $inv->latest_purchase_price =  $invoiceItem->purchase_price;
                    $inv->latest_sale_price = $inventory->latest_sale_price;
                    $inv->inventorable_id = $this->invoice->id;
                    $inv->inventorable_type = 'App\Models\SupplierInvoice';
                    $inv->save();

                    $invoiceItem->inventory_balance  = $inv->inventory_balance;
                    $invoiceItem->save();



                $shortcomings = ShortComing::where('product_id',$row['product_id'])->where('branch_id',1)->get();
                if($shortcomings) {
                    foreach($shortcomings as $shortcoming) {
                        if($invoiceItem->qty > $product->alert_main_branch){
                            $shortcoming->delete();
                        }
                    }

                }
                    }

                    $this->invoice->tax_value += $taxTotal;
                    $this->invoice->total_before_discount = $invTotal;
                    $this->invoice->total_after_discount = $invTotal *(1- $this->discount_percentage / 100);
                    $this->invoice->discount_value = $invTotal * $this->discount_percentage / 100;
                    $this->invoice->tax_after_discount = $this->invoice->tax_value * $this->discount_percentage / 100;
                    $this->invoice->supp_balance_after_invoice = $invTotal * (1- $this->discount_percentage / 100) *(1- $this->discount_percentage / 100) + $this->invoice->supp_balance_before_invoice;

                    $invoiceItem->inventory_balance  = $inv->inventory_balance;
                    $invoiceItem->save();
                    $this->invoice->save();

                    $supplier_id = $this->supplier_id;
                }



                $this->clearInputs();

                $this->reset(['product_code','qty','product_name_ar','product_name_en','purchase_price','wholesale_inc_vat','discount_value','discount_percentage']);

                $invoice = SupplierInvoice::where('id',$this->invoice->id)->first();
                $invoice->updated_by = Auth::user()->id;
                $invoice->supp_inv_date_time = $this->supp_inv_date_time;
                $invoice->payment_type = $this->payment_type;
                $invoice->total_before_discount = $invoice->total_before_discount +  $row['qty']* $row['unit_total'];
                $invoice->total_after_discount = $invoice->total_before_discount +  $row['qty']* $row['unit_total'] * (1- $invoice->discount_percentage /100);

                $invoice->discount_percentage = $this->discount_percentage;
                $invoice->discount_value = ($invoice->total_before_discount +  $row['qty']* ( $row['unit_total']))* $this->discount_percentage/100;
                $invoice->supp_balance_after_invoice = $invoice->supp_balance_after_invoice +  $row['qty']*  $row['unit_total'] * (1- $invoice->discount_percentage /100);
                $invoice->save();


                $supplier = Supplier::where('id',$this->supplier_id)->first();
                $invoice->supp_balance_before_invoice = $supplier->current_balance;
                $invoice->supp_balance_after_invoice = $supplier->current_balance + $invoice->total_after_discount;
                $invoice->save();

                $supplier->update([
                    'current_balance' => $invoice->supp_balance_after_invoice
                ]);



                redirect()->route('suppliers.edit_invoice',['inv_num' =>$this->invoice->supp_inv_num]);
                    $this->dispatch(
                    'alert',
                        text: trans('admin.item_added_to_invoice_successfully'),
                        icon: 'success',
                        confirmButtonText:  trans('admin.done'),
                        timer : 5000

                );

            } else {
                //dd('else');
                // $pivotRow->qty = $pivotRow->qty + $row['qty'];
                // $pivotRow->tax_value = $pivotRow->tax_value + $row['taxes'];
                // $pivotRow->total = $pivotRow->total + $row['unit_total'] * $row['qty'];
                // $pivotRow->save();






            }
            //dd($this->discount_percentage);

            $invoice = SupplierInvoice::where('id',$this->invoice->id)->first();
            //

                $invoice->supp_inv_date_time= Carbon::parse($this->supp_inv_date_time)->format('Y-m-d H:i:s');
                $invoice->supplier_id = $this->supplier_id;
                $invoice->is_pending = $this->is_pending;
                $invoice->updated_by = Auth::user()->id;
                $invoice->payment_type = $this->payment_type;
                $invoice->discount_percentage = $this->discount_percentage;
                $invoice->discount_value =($this->invoice->total_before_discount)* ($this->discount_percentage/100);
                $invoice->total_before_discount = $this->invoice->total_before_discount;
                $invoice->total_after_discount =  $this->invoice->total_before_discount *  (1- ($this->discount_percentage/100)) ;
                $invoice->notes = $this->notes;
                $invoice->save();






                // $inv = Inventory::create([
                // 'inventory_balance' => $inventory ? $inventory->inventory_balance + $row['qty'] :  $row['qty'],
                // 'initial_balance' => $inventory ? $inventory->initial_balance : 0 ,
                // 'in_qty' => $row['qty'],
                // 'out_qty' => 0,
                // 'current_financial_year' => date("Y"),
                // 'is_active' => 1,
                // 'branch_id' => 1,
                // 'store_id' => 1,
                // 'product_id' => $product->id,
                // 'updated_by' => Auth::user()->id,
                // 'notes' => ' تعديل فاتورة مورد',
                // 'latest_purchase_price' =>  $invoiceItem->purchase_price,
                // 'latest_price_price' => $inventory->latest_purchase_price,
                // 'inventorable_id' => $invoice->id,
                // 'inventorable_type' =>'App\Models\SupplierInvoice',
            // ]);



            $this->clearInputs();



                Alert::success('تم تعديل فاتورة المورد بنجاح');
            return redirect()->route('suppliers.edit_invoice',['inv_num'=>$this->invoice->supp_inv_num]);
            $this->mount($this->invoice);


        }





    }    public function render()
    {
        return view('livewire.supplier-invoices.update-invoice');
    }
}
