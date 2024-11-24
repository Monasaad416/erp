<?php

namespace App\Livewire\SupplierInvoicesReturns;

use Exception;
use App\Models\Bank;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\SupplierReturn;
use App\Models\SupplierInvoice;
use App\Events\ItemReturnedEvent;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use App\Events\SuppItemReturnedEvent;
use App\Livewire\SupplierInvoices\DisplayInvoices;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;

class ReturnItem extends Component
{

    protected $listeners = ['returnItem'];

    public $ItemNameAr,$ItemNameEn,$bank_id,$banks, $item,$itemNameAr,$itemNameEn,$supplierInvoice ,$supplierInvoiceNum,$qty,$itemQty,$return_payment_type;



    public function returnItem($item_id)
    {
        $this->item = SupplierInvoiceItem::where('id',$item_id)->first();
        $this->ItemNameAr = $this->item->product_name_ar;

        $this->ItemNameEn = $this->item->product_name_en ? $this->item->product_name_en : $this->item->product_name_ar;
        //dd($this->supplier);
        $this->supplierInvoiceNum = $this->item->SupplierInvoice->supp_inv_num;
        $this->supplierInvoice = SupplierInvoice::where('id',$this->item->supplier_invoice_id)->first();
        //dd($this->supplierInvoice);
        $this->dispatch('returnModalToggle');

    }

    public function returnInvoiceItem()
    {

        // try{
            DB::beginTransaction();
            $suppInvoice = SupplierInvoice::where('id',$this->supplierInvoice->id)->first();
            //dd($suppInvoice);
            $item = SupplierInvoiceItem::where('id',$this->item->id)->first();

            //dd($this->item->id);
            $inventory = Inventory::where('product_id',$this->item->product_id)->where('branch_id',1)->latest()->first();

            $newInv = new Inventory();
            $newInv->inventory_balance =  $inventory->inventory_balance - $item->qty;
            $newInv->initial_balance = $inventory->initial_balance;
            $newInv->in_qty = 0;
            $newInv->out_qty = $item->qty;
            $newInv->notes = 'رد بند من فاتورة مورد';
            $newInv->current_financial_year = date("Y");
            $newInv->product_id = $item->product_id;
            $newInv->is_active = $inventory->is_active;
            $newInv->branch_id = 1;
            $newInv->store_id =1;
            $newInv->inventorable_id = $this->supplierInvoice->id;
            $newInv->inventorable_type = 'App\Models\SupplierInvoice';
            $newInv->save();

            $suppInvoice->return_status = 11;

            $suppInvoice->save();
            $bankId = $this->bank_id;

            $item->return_status = 1;
            $item->inventory_balance = $this->item->inventory_balance - $this->item->qty;


            $settings = Setting::findOrFail(1);
            $product = Product::where('id',$item->product_id)->first();
            if($product->taxes ==1) {
                $tax = $settings->vat * $item->purchase_price * $item->qty;
            } else {
                $tax = 0;
            }

            $item->qty = 0;
            $item->total = 0;
            $item->return_status = 1;// item returned totally in suppliers invoices items table
            $item->last_return_qty = $this->qty;
            $item->return_payment_type = $this->return_payment_type;
            $item->save();


            $price = $item->purchase_price * $item->qty;

            $suppInvoice->return_payment_type = $this->return_payment_type;
            $suppInvoice->tax_value = $suppInvoice->tax_value - $tax;
            $suppInvoice->total_before_discount = $suppInvoice->total_before_discount -($item->purchase_price * $item->qty) + $tax;

            $suppInvoice->total_after_discount = $suppInvoice->discount_percentage > 0 ?
            $suppInvoice->discount_percentage * ($suppInvoice->total_before_discount -($item->purchase_price * $item->qty) + $tax) :
            $suppInvoice->total_before_discount -($item->purchase_price * $item->qty);


            $suppInvoice->tax_after_discount = $suppInvoice->discount_percentage  > 0 ?
             ($suppInvoice->discount_percentage / 100 ) * $suppInvoice->tax_value :
              $suppInvoice->tax_value;
            $suppInvoice->return_status = 11;


            $suppInvoice->save();
            $bankId = $this->bank_id;
            $totalReturnPrice = $price + $tax;


            $settings = Setting::first();
            $product = Product::where('id', $item->product_id )->first();

            $invoiceItem = new SupplierReturn();
            $invoiceItem->product_id = $item->product_id;
            $invoiceItem->product_name_ar = $item->product_name_ar;
            $invoiceItem->product_name_en = $item->product_name_en ?? null;
            $invoiceItem->product_code = $item->product_code;
            $invoiceItem->unit = $item->unit;
            $invoiceItem->supplier_invoice_id = $suppInvoice->id;
            $invoiceItem->tax_value = $item->tax_value;
            $invoiceItem->total =  $item->total;
            $invoiceItem->batch_num = $item->batch_num;
            $invoiceItem->purchase_price = $item->purchase_price;
            $invoiceItem->return_status = 1;
            $invoiceItem->return_qty = $item->qty;
            $invoiceItem->return_payment_type = $this->return_payment_type;
            $invoiceItem->save();

            $returnItem = $this->item;

             event(new SuppItemReturnedEvent($suppInvoice,$bankId ?? null,$totalReturnPrice,$returnItem));


            $returnedItem = SupplierInvoiceItem::withTrashed()->where('id',$this->item->id)->first();
            //dd($returnedItem);





            $item->delete();
            if($suppInvoice->supplierInvoiceItems->count() == 0) {
                $suppInvoice->delete();
            }



            // $this->reset('supplier');

            $this->dispatch('returnModalToggle');

            // $this->dispatch('refreshData')->to(DisplayInvoices::class);

            // $this->dispatch(
            // 'alert',
            //     text: trans('admin.supplier_invoice_returned_successfully'),
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done'),
            // );





             DB::commit();
                Alert::success('تم رد البند كليا بنجاح');
                return redirect()->route('suppliers');


            //  event(new ItemReturnedEvent($suppInvoice,$bankId ?? null));
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }
    public function render()
    {
        return view('livewire.supplier-invoices-returns.return-item');
    }
}
