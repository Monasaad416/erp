<?php

namespace App\Livewire\CustomerInvoices;

use Livewire\Component;

class CalculatePrices extends Component
{

    public function getPrices(){
         $this->dispatch('createModalToggle');
    }
    public function render()
    {
        return view('livewire.customer-invoices.calculate-prices');
    }
}
