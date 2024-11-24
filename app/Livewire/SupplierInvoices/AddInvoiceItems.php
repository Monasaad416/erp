<?php
namespace App\Livewire\SupplierInvoices;

use Alert;
use App\Models\ProductCode;
use Exception;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Product;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Livewire\SupplierInvoices\DisplayInvoices;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddInvoiceItems extends Component
{

    public $listeners = ['refreshData' =>'$refresh'];


    public $invoice,$supp_inv_num,$suppliers,$units,$product, $product_id,$product_name_ar,$product_name_en, $product_code, $unit,
    $discount_percentage=0,$discount_value=0,$purchase_price,$batch_num,$qty='',
    $invoice_discount_percentage=0,$invoice_discount_value=0,$price,$code_type,$invoice_products=[]
    ,$wholesale_inc_vat,$payment_type,$status,$supp_inv_date_time,$is_approved,$is_pending=0,$notes,$supplier_id,$item_discount_percentage=0;


    public function mount($invoice){
        $this->invoice = $invoice ;
        $this->invoice_products = SupplierInvoiceItem::where('supplier_invoice_id',$invoice->id)->latest()->get();


    }

    public function rules() {
        return [
            'product_code' => "required|string|max:100|exists:product_codes,code",
            'qty' => "required|numeric",
            'purchase_price' => 'required_if:wholesale_inc_vat,null',
            'wholesale_inc_vat' => 'required_if:purchase_price,null',
            'discount_value' =>'nullable|numeric',
            'discount_percentage' =>'nullable|numeric',
            'batch_num' =>'nullable|string',
            'is_pending' =>'required',
            'supp_inv_date_time' => 'required',

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

    // public function updatedProductCode()
    // {
    //     $codeExclude01 = substr($this->this->product_code, 2);
    //     $finalCode = substr($codeExclude01, 0, 14);
    //     $this->product_code = $finalCode;
    // }

    public function fetchProductName()
    {
        $codeExclude01 = substr($this->product_code, 2);
        $finalCode = substr($codeExclude01, 0, 14);
        $this->product_code = $finalCode;

        $this->validate([
            'product_code' => 'required|string|max:100|exists:product_codes,code',
        ]);

        //retrieve the product name based on the product code
        $productCode = ProductCode::where('code', $this->product_code)->first();
        $product = Product::where('id', $productCode->product_id)->first();

        $this->product_name_ar = $product ? $product->name_ar : null;
        $this->product_name_en = $product ? $product->name_en : null;
        $this->product_id = $product ? $product->id : trans('admin.not_found');
        $this->unit = $product ? $product->unit->name : null;
    }


    public function clearInputs ()
    {
        $this->product_code = "";
        $this->qty = "";
        $this->product_name_ar = "";
        $this->product_name_en = "";
        $this->purchase_price = "";
        $this->wholesale_inc_vat = "";
        $this->discount_value = "";
        $this->discount_percentage = "";

    }




    public function removeItem($index)
    {
        unset($this->invoice_products[$index -1]);
    }

    public static function getNextInvoiceNumber()
    {
        $year = Carbon::now()->year;
        $currentInvoiceNumber = SupplierInvoice::whereYear('created_at',$year)->max('supp_inv_num');
        if($currentInvoiceNumber) {
            return $currentInvoiceNumber + 1;
        }

        return $year. '0000001';
    }


    public static function getNextSerial()
    {
        $currentSerial = SupplierInvoice::max('serial_num');
        if($currentSerial) {
            return $currentSerial + 1;
        }

        return '1';
    }

    public function pendingInvoice()
    {
       $this->is_pending = false;
    }

    public function saveInvoice()
    {
       $this->is_pending = true;
    }
    public function create() {
        DB::beginTransaction();
        // try{

         $ids = $this->invoice_products->pluck('product_id')->toArray();
         if(in_array($this->product_id,$ids) ){
            foreach($this->invoice_products as $item ){
                if($item->product_code == $this->product_code){
                    //dd($item);
                    $item->update([
                        'qty' => $item->qty + $this->qty ,
                    ]);
                } else {

                SupplierInvoiceItem::create([
                    'product_id'=> $this->product_id,
                    'product_name_ar'=> $this->product_name_ar,
                    'product_name_en'=> $this->product_name_en,
                    'product_code'=> $this->product_code,
                    'supplier_invoice_id'=> $this->invoice->id,
                    'unit' => $this->unit,
                    'qty' => $this->qty ,
                    'purchase_price' => $this->purchase_price ? $this->purchase_price : 0 ,
                    'wholesale_inc_vat' => $this->wholesale_inc_vat ? $this->wholesale_inc_vat : 0,
                    'batch_num' => $this->batch_num == "" ? null : $this->batch_num ,
                    'item_discount_percentage' => $this->item_discount_percentage ? $this->item_discount_percentage : 0 ,
                ]);

                $product = Product::where('id', $this->product_id)->first();
                $product->update([
                    'inventory_balance' => $product->inventory_balance  + $this->qty,
                ]);

                }
            }


         } else {
                SupplierInvoiceItem::create([
                    'product_id'=> $this->product_id,
                    'product_name_ar'=> $this->product_name_ar,
                    'product_name_en'=> $this->product_name_en,
                    'product_code'=> $this->product_code,
                    'supplier_invoice_id'=> $this->invoice->id,
                    'unit' => $this->unit,
                    'qty' => $this->qty ,
                    'purchase_price' => $this->purchase_price ? $this->purchase_price : 0 ,
                    'wholesale_inc_vat' => $this->wholesale_inc_vat ? $this->wholesale_inc_vat : 0,
                    'batch_num' => $this->batch_num == "" ? null : $this->batch_num ,
                    'item_discount_percentage' => $this->item_discount_percentage ? $this->item_discount_percentage : 0 ,
                ]);

         }

        $latestInvoiceItem  = SupplierInvoiceItem::orderBy('updated_at','DESC')->latest()->first();
          // dd($latestInvoiceItem);


        $inventory= Inventory::where('product_id', $latestInvoiceItem->product_id)->where('branch_id',null)->latest()->first();
        $inventoryQty = $inventory ? $inventory->inventory_balance  : 0 ;
        $initialQty = $inventory ? $inventory->initial_balance  : 0 ;
        //dd($inventoryQty);
        Inventory::create([
            'initial_balance' => $initialQty,
            'inventory_balance' => $inventoryQty + $latestInvoiceItem->qty,
            'current_financial_year' => date('Y'),
            'is_active' =>1,
            'product_id' => $latestInvoiceItem->product_id,
            'branch_id' => Auth::user()->branch_id,
            'updated_by' => Auth::user()->id,
            'store_id' => 1 ,
            'notes' => 'شراء بند من مورد',
        ]);

        $latestInvoiceItem->update([
            'inventory_balance' => $latestInvoiceItem->qty + $inventoryQty,
        ]);


        $products = Product::whereIn('id',$ids)->get();


        DB::commit();

        $this->clearInputs();

        $this->mount($this->invoice);

        $this->dispatch(
        'alert',
            text: trans('admin.supplier_invoice_Item_created_successfully'),
            icon: 'success',
            confirmButtonText: trans('admin.done')
        );

            // return redirect()->route('suppliers.create_invoice_items',['invoice_num' => $this->invoice->supp_inv_num]) ;




    //  } catch (Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }


    public function render()
    {
        return view('livewire.supplier-invoices.add-invoice-items');
    }
}
