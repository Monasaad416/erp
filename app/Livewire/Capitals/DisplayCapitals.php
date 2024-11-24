<?php

namespace App\Livewire\Capitals;

use App\Models\Capital;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayCapitals extends Component
{
    use WithPagination;
    public $searchItem='';
    public $listeners = ['refreshData' =>'$refresh'];

    public function render()
    {
        return view('livewire.capitals.display-capitals',[
            'capitals' => Capital::where('partner_id','like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
