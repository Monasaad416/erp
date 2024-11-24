<?php

namespace App\Livewire\CustomerInvoicesReturns;

use Livewire\Component;
use App\Models\CustomerReturnItem;

class ShowReturns extends Component
{
    public $invoiceReturn;


    public function mount($invoiceReturn)
    {
        $this->invoiceReturn = $invoiceReturn;
        //dd($this->invoiceReturn);
    }
    public function render()
    {
        // dd($this->invoice->id);
        $items = CustomerReturnItem::where('customer_return_id', $this->invoiceReturn->id)->paginate(config('constants.paginationNo'));

        //dd($items);
    
        return view('livewire.customer-invoices-returns.show-returns',['items'=>$items]);
    }

}
