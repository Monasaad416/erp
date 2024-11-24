<?php

namespace App\Livewire\CustomerInvoices;

use Livewire\Component;
use App\Models\Customer;

class PayInvoice extends Component
{
    public $invoice,$reason,$payment_method;
    public function mount($invoice)
    {
        //dd($this->invoice);
        $this->invoice = $invoice;
        $this->reason = "مدفوعات مبيعات للعميل";
    }
  
    public function render()
    {
        return view('livewire.customer-invoices.pay-invoice');
    }
}
