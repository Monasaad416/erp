<?php

namespace App\Livewire\customerInvoicesReturns;

use Alert;
use Exception;
use App\Models\Store;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\CustomerReturn;
use App\Models\CustomerInvoice;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use Illuminate\Support\Facades\Auth;
use App\Livewire\customerInvoices\DisplayInvoices;
use App\Events\CustomerInvoicePartiallyReturnedEvent;

class ReturnItemPartially extends Component
{

    protected $listeners = ['returnItemPartially'];

    public $item,$itemNameAr,$itemNameEn,$customerInvoice ,$customerInvoiceNum,$qty,$itemQty;


    public function returnItemPartially($item_id)
    {

            $this->item = CustomerInvoiceItem::where('id',$item_id)->first();
            //dd( $this->item );
            $this->itemNameAr = $this->item->product_name_ar;
            $this->itemNameEn = $this->item->product_name_en ? $this->item->product_name_en : $this->item->product_name_ar;
            $this->itemQty = $this->item->qty;
            //dd($this->customer);
            $this->customerInvoiceNum = $this->item->CustomerInvoice->customer_inv_num;
            $this->customerInvoice = CustomerInvoice::where('id',$this->item->customer_invoice_id)->first();


            $this->dispatch('returnPartiallyModalToggle');


    }
public function rules()
{
    return [
          'qty' => [
                'required',
                'numeric',
                'max:'.$this->itemQty
            ],
    ];
}

    public function messages()
    {
        return [
            'qty.required' => 'الكمية المردود مطلوبة',
            'qty.exists' => 'الكمية المردود يجب الا تتعدي كمية البند بالفاتورة',
        ];
    }
    public function returnInvoiceItemPartially()
    {
          //dd("ll");
        $this->validate($this->rules() ,$this->messages());

        // try {
            DB::beginTransaction();

            $this->customerInvoice = CustomerInvoice::where('id',$this->item->customer_invoice_id)->first();
            //dd($this->customerInvoice );
            $item = CustomerInvoiceItem::where('id',$this->item->id)->first();
            //dd($item );
            $customerInv = CustomerInvoice::where('id',$this->item->customer_invoice_id)->first();

            $settings = Setting::findOrFail(1);
            $product = Product::where('id',$item->product_id)->first();
            if($product->taxes ==1) {
                $tax = $settings->vat * $item->sale_price * $this->qty;
            } else {
                $tax = 0;
            }

            $price = $item->sale_price * $this->qty;

            $totalReturnPrice = $price + $tax;

            $inventory = Inventory::where('product_id',$this->item->product_id)->where('branch_id',Auth::user()->branch_id)->latest()->first();
              //dd($inventory );
            $newInv = new Inventory();
            $newInv->inventory_balance = $inventory->inventory_balance + $this->qty;
            $newInv->initial_balance = $inventory->initial_balance;
            $newInv->in_qty = $this->qty;
            $newInv->out_qty = 0;
            $newInv->notes = 'رد جزئي لبند من فاتورة عميل';
            $newInv->current_financial_year = date("Y");
            $newInv->product_id = $this->item->product_id;
            $newInv->is_active = $inventory->is_active;
            $newInv->branch_id = Auth::user()->branch_id;
            $newInv->store_id = Store::where('branch_id',Auth::user()->branch_id)->first()->id;
            $newInv->latest_purchase_price = $inventory->latest_purchase_price;
            $newInv->latest_sale_price = $inventory->latest_sale_price;
            $newInv->inventorable_id = $item->id;
            $newInv->inventorable_type = 'App\Models\CustomerInvoiceItem';
            $newInv->save();

            $customerInv->return_status = 11; // item returned in customers invoices table
            $customerInv->save();

            $item->return_qty = $this->qty;
            $item->qty = $this->item->qty - $this->qty;

            $item->tax = ($this->item->qty - $this->qty) * $item->sale_price * $settings->vat;
            $item->total_with_tax = ($this->item->qty - $this->qty) * $item->sale_price;
            $item->total_with_tax = (($this->item->qty - $this->qty) * $item->sale_price) + (($this->item->qty - $this->qty) * $settings->vat);
            // $item->inventory_balance = $this->item->inventory_balance - $this->qty;

            $item->save();

            $item->return_status = 2;// item returned partially in customers invoices items table

            $item->save();

            $customerInv->tax_value = $customerInv->tax_value - $tax;
            $customerInv->total_after_discount = $customerInv->total_after_discount -($item->sale_price * $this->qty) + $tax;
            $customerInv->return_status = 11;
            $customerInv->save();

            $invoiceItemReturn = new CustomerReturn();
            $invoiceItemReturn->product_id = $item->product_id ;
            $invoiceItemReturn->product_name_ar =$item->product_name_ar;
            $invoiceItemReturn->product_name_en =$item->product_name_en ?? null;
            $invoiceItemReturn->product_code =$item->product_code;
            $invoiceItemReturn->unit =$item->unit;
            $invoiceItemReturn->customer_invoice_id = $this->customerInvoice->id;
            $invoiceItemReturn->sale_price =$item->sale_price;
            $invoiceItemReturn->total_without_tax =$item->total_without_tax;
            $invoiceItemReturn->tax =$item->tax;
            $invoiceItemReturn->total_with_tax =$item->total_with_tax;
            $invoiceItemReturn->return_qty =$this->qty;
            $invoiceItemReturn->return_status = 3;
            $invoiceItemReturn->save();


            if($this->item->qty == 1  || $this->item->qty == $this->qty) {

                $item->return_status = 1;
                $item->save();

                $this->item->delete();




                if(CustomerInvoiceItem::where('customer_invoice_id' ,$this->customerInvoice->id)->count() == 0) {
                    $customerInv->return_status = 10; // ALL Invoice returned in customers invoices table
                    $customerInv->save();

                    $customerInv->delete();
                    $customerInv->save();


                    $item->return_status = 1;// item returned totally in customers invoices items table
                    $item->save();


                    $this->customerInvoice->delete();


                event(new CustomerInvoicePartiallyReturnedEvent($customerInv, $totalReturnPrice,$item));


                    DB::commit();

                    Alert::success('تم استرجاع البند و حذف الفاتورة بنجاح');
                    return redirect()->route('customers.invoices');
                } else {

                       $item->return_status = 1;// item returned totally in customers invoices items table
                        $item->save();
                          event(new CustomerInvoicePartiallyReturnedEvent($customerInv, $totalReturnPrice,$item));
                        DB::commit();

                        Alert::success('تم استرجاع البند بالكامل بنجاح');
                    return redirect()->route('customers.edit_invoice',['inv_num'=> $customerInv->customer_inv_num]);

                }

            } else {

                    $item->return_status = 2;// item returned partially in customers invoices items table
                    $item->save();
                    event(new CustomerInvoicePartiallyReturnedEvent($customerInv, $totalReturnPrice,$item));
                DB::commit();

                Alert::success('تم استرجاع البند جزئيا بنجاح');
                return redirect()->route('customers.edit_invoice',['inv_num'=> $customerInv->customer_inv_num]);
                // $this->reset('customer');
            }



        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }    public function render()
    {
        return view('livewire.customer-invoices-returns.return-item-partially');
    }
}
