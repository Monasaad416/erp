<?php

namespace App\Livewire\CustomerDebitNote;

use Livewire\Component;
use App\Models\CustomerReturnItem;
use App\Models\CustomerDebitNoteItem;

class ShowDebitNote extends Component
{
    public $invoiceDebitNote;


    public function mount($invoiceDebitNote)
    {
        $this->invoiceDebitNote = $invoiceDebitNote;
        //dd($this->invoiceDebitNote);
    }
    public function render()
    {
        // dd($this->invoice->id);
        $items = CustomerDebitNoteItem::where('customer_debit_note_id', $this->invoiceDebitNote->id)->paginate(config('constants.paginationNo'));

        //dd($items);
    
        return view('livewire.customer-debit-note.show-debit-note',['items'=>$items]);
    }

}
