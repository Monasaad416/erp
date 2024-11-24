<?php

namespace App\Livewire\SupplierInvoicesReturns;

use Alert;
use Exception;
use App\Models\Bank;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\SupplierReturn;
use App\Models\SupplierInvoice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Events\SuppInvoicePartiallyReturnedEvent;
use App\Events\SupplierInvoiceItemPartReturnEvent;
use App\Livewire\SupplierInvoices\DisplayInvoices;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ReturnItemPartially extends Component
{

    protected $listeners = ['returnItemPartially'];

    public $banks,$bank_id,$check_num,$item,$itemNameAr,$itemNameEn,$supplierInvoice ,$supplierInvoiceNum,$qty,$itemQty,$suppInvoice,$return_payment_type;

    // public function mount()
    // {
    //     $this->banks = Bank::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name')->get();
    //     //dd($this->banks);
    // }

    public function returnItemPartially($item_id)
    {

        //dd($item_id);
            $this->item = SupplierInvoiceItem::where('id',$item_id)->first();
         // dd( $this->item->id );
            $this->itemNameAr = $this->item->product_name_ar;
            $this->itemNameEn = $this->item->product_name_en ? $this->item->product_name_en : $this->item->product_name_ar;
            $this->itemQty = $this->item->qty;
            //dd($this->itemQty);
            $this->supplierInvoiceNum = $this->item->SupplierInvoice->supp_inv_num;
            $this->supplierInvoice = SupplierInvoice::where('id',$this->item->supplier_invoice_id)->first();

            $this->dispatch('returnPartiallyModalToggle');


    }

    public function rules()
    {
        return [
            'qty' => [
                'required',
                'numeric',
                // Rule::exists('supplier_invoice_items', 'qty')->where(function ($query) {
                //     $query->where('id', $this->item->id);
                // }),
                'max:'.$this->itemQty
            ],
            'return_payment_type' => 'required',
            'bank_id' => 'required_if:return_payment_type,"by_check"',
            'check_num' => 'required_if:return_payment_type,"by_check"',
        ];
    }

    public function messages()
    {
        return [
            'qty.required' => 'الكمية المردود مطلوبة',
            'qty.max' => 'الكمية المردود يجب الا تتعدي كمية البند بالفاتورة',
            'return_payment_type.required' => 'طريقة دفع الرد مطلوبة',
            'bank_id.required_if' => 'إسم البنك مطلوب',
            'check_num.required_if' => 'رقم الشيك مطلوب',
        ];
    }


    public function returnInvoiceItemPartially()
    {
        //dd("ll");
        $this->validate($this->rules() ,$this->messages());

        // try {
            DB::beginTransaction();

            $this->suppInvoice = SupplierInvoice::where('id',$this->item->supplier_invoice_id)->first();
            //dd($this->suppInvoice );
            $item = SupplierInvoiceItem::where('id',$this->item->id)->first();
            

            $suppInv = SupplierInvoice::where('id',$this->item->supplier_invoice_id)->first();
            //dd($suppInv );
            $settings = Setting::findOrFail(1);
            $product = Product::where('id',$item->product_id)->first();
            if($product->taxes ==1) {
                $tax = $settings->vat * $item->purchase_price * $this->qty;
            } else {
                $tax = 0;
            }

            $price = $item->purchase_price * $this->qty;

            $totalReturnPrice = $price + $tax;

            $inventory = Inventory::where('product_id',$this->item->product_id)->where('branch_id',1)->latest()->first();
            //dd($inventory );
            $newInv = new Inventory();
            $newInv->inventory_balance = $this->item->inventory_balance - $this->qty;
            $newInv->initial_balance = $inventory->initial_balance;
            $newInv->in_qty = 0;
            $newInv->out_qty = $this->qty;
            $newInv->notes = 'رد  لبند من فاتورة مورد';
            $newInv->current_financial_year = date("Y");
            $newInv->product_id = $this->item->product_id;
            $newInv->is_active = $inventory->is_active;
            $newInv->branch_id =  null;
            // $newInv->store_id = 1;
            $newInv->inventorable_id = $this->suppInvoice->id;
            $newInv->inventorable_type = 'App\Models\SupplierInvoice';
            $newInv->save();

            $suppInv->return_status = 11; // item returned in suppliers invoices table
            $suppInv->save();

            $item->last_return_qty = $this->qty;
            $item->qty = $this->item->qty - $this->qty;
            $item->return_payment_type = $this->return_payment_type;

            $item->tax_value = ($this->item->qty - $this->qty) * $item->purchase_price * $settings->vat;
            $item->total = ($this->item->qty - $this->qty) * $item->purchase_price;
            $item->inventory_balance = $this->item->inventory_balance - $this->qty;

            $item->save();

            $item->return_status = 2;//
            $item->last_return_qty = $this->qty;
            $item->return_payment_type = $this->return_payment_type;
            $item->save();

            $suppInv->tax_value = $suppInv->tax_value - $tax;
            $suppInv->total_before_discount = ($item->purchase_price * $item->qty) + $tax;
            $suppInv->total_after_discount = $suppInv->discount_percentage * ($item->purchase_price * $item->qty + $tax);
            $suppInv->return_status = 11;
            $suppInv->save();

            //dd($this->item->qty);
            $bankId = $this->bank_id;
            if($this->item->qty == 1  || $this->item->qty == $this->qty) {
                dd("llllaaaaaaa");

                $item->return_status = 1;
                $item->save();


                $settings = Setting::first();
                $product = Product::where('id', $item->product_id )->first();

                event(new SupplierInvoiceItemPartReturnEvent($suppInv,$item,$bankId ?? null, $totalReturnPrice));

                $invoiceItem = new SupplierReturn();
                $invoiceItem->product_id = $item->product_id;
                $invoiceItem->product_name_ar = $item->product_name_ar;
                $invoiceItem->product_name_en = $item->product_name_en ?? null;
                $invoiceItem->product_code = $item->product_code;
                $invoiceItem->unit = $item->unit;
                $invoiceItem->supplier_invoice_id = $suppInv->id;
                $invoiceItem->tax_value = $totalReturnPrice * $settings->vat;
                $invoiceItem->total =  $totalReturnPrice;
                $invoiceItem->batch_num = $item->batch_num;
                $invoiceItem->return_status = 1;
                $invoiceItem->return_qty = $this->qty;
                $invoiceItem->purchase_price = $item->purchase_price;
                $invoiceItem->return_payment_type = $this->return_payment_type;
                $invoiceItem->save();

                
                
                $this->item->delete();




                if(SupplierInvoiceItem::where('supplier_invoice_id' ,$this->suppInvoice->id)->count() == 0) {
                    $suppInv->return_payment_type = $this->return_payment_type;
                    $suppInv->return_status = 10; // ALL Invoice returned in suppliers invoices table
                    $suppInv->save();

                    $suppInv->delete();
                    $suppInv->save();


                    $item->return_status = 1;// item returned totally in suppliers invoices items table
                    $item->save();

                    $this->suppInvoice->delete();

                } else {
                
                    $item->return_status = 1;// item returned totally in suppliers invoices items table
                    $item->save();
                }

            } else {
             //dd("kkk");

                $item->return_status = 2;// item returned partially in suppliers invoices items table
                $item->save();
//dd($item);
                $invoiceItem = new SupplierReturn();
                $invoiceItem->product_id = $item->product_id;
                $invoiceItem->product_name_ar = $item->product_name_ar;
                $invoiceItem->product_name_en = $item->product_name_en ?? null;
                $invoiceItem->product_code = $item->product_code;
                $invoiceItem->unit = $item->unit;
                $invoiceItem->purchase_price = $item->purchase_price;
                $invoiceItem->supplier_invoice_id = $suppInv->id;
                $invoiceItem->tax_value = $totalReturnPrice * $settings->vat;
                $invoiceItem->total =  $totalReturnPrice;
                $invoiceItem->batch_num = $item->batch_num;
                $invoiceItem->return_status = 2;
                $invoiceItem->return_qty = $this->qty;
                $invoiceItem->return_payment_type = $item->return_payment_type;
                $invoiceItem->save();
                //dd($item);


                // $item = SupplierInvoiceItem::withTrashed()->where('id',$this->item->id)->first();
      
                event(new SupplierInvoiceItemPartReturnEvent($suppInv,$invoiceItem,$bankId ?? null, $totalReturnPrice));

            }

           
            DB::commit();
            
            Alert::success('تم استرجاع البند بنجاح');
            return redirect()->route('suppliers.invoices');



        

        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }
    public function render()
    {
        return view('livewire.supplier-invoices-returns.return-item-partially');
    }
}
