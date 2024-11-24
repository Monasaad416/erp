<?php

namespace App\Livewire\SupplierInvoices;

use Exception;
use App\Models\Account;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\SupplierInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierInvoiceItem;
use Illuminate\Support\Facades\Auth;
use Alert;


class DeleteInvoiceItem extends Component
{

    protected $listeners = ['deleteSuppInvItem'];
    public $supplierInvoiceItem ,$supplierInvoiceNum,$itemNameAr,$itemNameEn;

    public function deleteSuppInvItem($item_id)
    {
        $this->supplierInvoiceItem = SupplierInvoiceItem::where('id',$item_id)->first();
        //dd($this->supplierInvoiceItem->product_name_ar);
        $this->supplierInvoiceNum = $this->supplierInvoiceItem->supplierInvoice->supp_inv_num;
        //dd($this->supplierInvoiceNum);
        $this->itemNameAr = $this->supplierInvoiceItem->product_name_ar;
        $this->itemNameEn = $this->supplierInvoiceItem->product_name_en;

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $item = SupplierInvoiceItem::where('id',$this->supplierInvoiceItem->id)->first();


            $inventory = Inventory::where('product_id',$item->product_id)->where('branch_id',Auth::user()->branch_id,)->latest()->first();

            DB::beginTransaction();
            $inv = new Inventory();
            $inv->inventory_balance = $inventory->inventory_balance - $item->qty;
            $inv->initial_balance = $inventory->initial_balance;
            $inv->in_qty = 0;
            $inv->out_qty = $item->qty;
            $inv->current_financial_year = date("Y");
            $inv->product_id = $item->product_id;
            $inv->is_active = $inventory->is_active;
            $inv->branch_id = Auth::user()->branch_id;
            $inv->store_id = 1;
            $inv->notes = 'حذف بند من فاتورة مورد';
            $inv->inventorable_id = $item->supplier_invoice_id;
            $inv->inventorable_type = 'App\Models\SupplierInvoice';
            $inv->save();

            $invoice = SupplierInvoice::where('id',$item->supplier_invoice_id)->first();
            $itemPrice =0 ;
            if ($invoice->supplierInvoiceItems->count() == 1) {
                $item->delete();
                $invoice->delete();

                DB::commit();
                Alert::success('تم حذف البند وفاتوره المورد بنجاح');
                return redirect()->route('suppliers.invoices');

            } else {

                $discountPercent = $invoice->discount_percentage;
                $discountPercent > 0 ? $itemPrice = $item->total : $itemPrice = $item->total * $discountPercent /100;
                $item->delete();

                $this->dispatch('deleteModalToggle');

                $invTotalWithVat = 0;
                $taxTotal = 0;

                //update invoice
                foreach(SupplierInvoiceItem::where('supplier_invoice_id',$invoice->id)->get() as $item) {

                    $invTotalWithVat += $item->total;
                    $taxTotal += $item->tax_value;
                }

                $invoice->tax_value = $taxTotal;
                $invoice->total_before_discount = $invTotalWithVat;
                $invoice->total_after_discount = $invoice->discount_percentage > 0 ? $invoice->discount_percentage/100 * $invTotalWithVat : $invTotalWithVat;
                //dd($taxTotal ,$invoice->total_before_discount  ,$invoice->total_after_discount );
                $invoice->save();


                //update supplier balance

                $supplier =  Supplier::where('id', $invoice->supplier_id)->first();

                if($invoice->payment_type == 'by_installments') {
                    $supplier->current_balance = $supplier->current_balance - $itemPrice;

                    $supplierAccount = Account::where('account_number', $supplier->account_number)->first();
                    $supplierAccount->current_balance = $supplierAccount->current_balance - $itemPrice;
                    $supplierAccount->save();
                }


                $InvNum_with_prefix = $invoice->supp_inv_num;
                $InvNum_without_prefix =  str_replace("S-", "", $InvNum_with_prefix);
                DB::commit();

                Alert::success('تم حذف البند  بنجاح');
                    return redirect()->route('suppliers.edit_invoice',['inv_number' => $InvNum_without_prefix]);



            }


        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }

    public function render()
    {
        return view('livewire.supplier-invoices.delete-invoice-item');
    }
}
