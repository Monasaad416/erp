<?php

namespace App\Livewire\Units;

use App\Models\Unit;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayUnits extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem;

    public function updatingSearchItem()
    {
        $this->resetPage();
    }  

    public function render()
    {
        return view('livewire.units.display-units',[
            'units' => Unit::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
