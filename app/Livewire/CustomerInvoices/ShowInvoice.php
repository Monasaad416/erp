<?php

namespace App\Livewire\CustomerInvoices;

use App\Models\Product;
use Livewire\Component;
use App\Models\CustomerReturn;
use App\Models\CustomerDebitNote;
use App\Models\CustomerReturnItem;
use App\Models\CustomerInvoiceItem;
use App\Models\CustomerDebitNoteItem;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class ShowInvoice extends Component
{
    public $invoice;


    public function mount($invoice)
    {
        $this->invoice = $invoice;
    }
    public function render()
    {
        // dd($this->invoice->id);
        $items = CustomerInvoiceItem::where('customer_invoice_id', $this->invoice->id)->get();
        //dd($items);

        $debitNotes = CustomerDebitNote::where('customer_invoice_id',$this->invoice->id)->get();
        $debitNotesItems = CustomerDebitNoteItem::where('customer_inv_num', $this->invoice->customer_inv_num)->get();
         //dd($debitNotes);
        $returnsItems = CustomerReturnItem::where('customer_inv_num', $this->invoice->customer_inv_num)->get();
        return view('livewire.customer-invoices.show-invoice',['items'=>$items,'debitNotes'=>$debitNotes,'debitNotesItems'=>$debitNotesItems,'returns'=>$returnsItems]);
    }
}
