<?php

namespace App\Livewire\Ledgers;

use App\Models\Ledger;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Livewire\WithPagination;

class DisplayLedgers extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.ledgers.display-ledgers',[
            'ledgers' => Ledger::latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
