<?php

namespace App\Livewire\SupplierInvoicesReturns;

use Alert;
use Exception;
use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\SupplierReturn;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use App\Events\InvoiceReturnedEvent;
use Illuminate\Support\Facades\Auth;
use App\Events\SuppInvoiceReturnedEvent;
use App\Livewire\SupplierInvoices\DisplayInvoices;

class ReturnInvoice extends Component
{


    protected $listeners = ['returnInvItems'];

    public $supplierInvoice ,$supplierInvoiceNum,$return_payment_type,$bank_id;
    public function returnInvItems($id)
    {
        $this->supplierInvoice = SupplierInvoice::where('id',$id)->first();
    //dd($this->supplier);
        $this->supplierInvoiceNum = $this->supplierInvoice->supp_inv_num;

        $this->dispatch('returnModalToggle');

    }


    public function returnInvoice()
    {
        // try{
            DB::beginTransaction();
            $suppInvoice = SupplierInvoice::where('id',$this->supplierInvoice->id)->first();
            $items = SupplierInvoiceItem::where('supplier_invoice_id',$this->supplierInvoice->id)->get();
            foreach($items as $item){
                $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',1)->latest()->first();
                // dd($inventory);
                Inventory::create([
                    'inventory_balance' => $inventory->inventory_balance - $item->qty,
                    'initial_balance' => $inventory->initial_balance,
                    'in_qty' => 0,
                    'out_qty' => $item->qty,
                    'notes' => 'رد كامل بنود فاتورة مورد',
                    'current_financial_year' => date("Y"),
                    'product_id' => $item->product_id,
                    'is_active' => $inventory->is_active,
                    'branch_id' => Auth::user()->branch_id,
                    // 'store_id' => 1,
                    'inventorable_id' => $suppInvoice->id,
                    'inventorable_type' => 'App\Models\SupplierInvoice',
                ]);

                $settings = Setting::first();
                $product = Product::where('id', $item->product_id )->first();

                $invoiceItem = new SupplierReturn();
                $invoiceItem->product_id = $item->product_id;
                $invoiceItem->product_name_ar = $item->product_name_ar;
                $invoiceItem->product_name_en = $item->product_name_en ?? null;
                $invoiceItem->product_code = $item->product_code;
                $invoiceItem->unit = $item->unit;
                $invoiceItem->supplier_invoice_id = $suppInvoice->id;
                $invoiceItem->purchase_price = $item->purchase_price;
                $invoiceItem->tax_value = $item->tax_value;
                $invoiceItem->total =  $item->total;
                $invoiceItem->batch_num = $item->batch_num;
                $invoiceItem->return_status = 1;
                $invoiceItem->return_qty = $item->qty;
                $invoiceItem->return_payment_type = $this->return_payment_type;
                $invoiceItem->save();


                $item->delete();


            }

            $suppInvoice->return_payment_type = $this->return_payment_type;
            $suppInvoice->return_status = 10;
            $suppInvoice->save();
            $bankId = $this->bank_id;

            event(new SuppInvoiceReturnedEvent($suppInvoice,$bankId ?? null));

            $suppInvoice->delete();

            // $this->reset('supplier');

            $this->dispatch('returnModalToggle');

            $this->dispatch('refreshData')->to(DisplayInvoices::class);

            // $this->dispatch(
            // 'alert',
            //     text: trans('admin.supplier_invoice_returned_successfully'),
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done'),
            // );
             DB::commit();

            Alert::success('تم إسترجاع كامل بنود فاتورة المورد بنجاح');
            return redirect()->route('suppliers.invoices');

        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


    }
    public function render()
    {
        return view('livewire.supplier-invoices-returns.return-invoice');
    }
}
