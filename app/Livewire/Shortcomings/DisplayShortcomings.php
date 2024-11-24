<?php

namespace App\Livewire\Shortcomings;

use App\Models\Product;
use App\Models\ShortComing;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayShortcomings extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $product,$name,$product_codes,$unit_id,$tension,$price ,$searchItem,$filter;


    public function mount($filter = null)
    {
        $this->filter = $filter;
    }


    public function updatingSearchItem()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.shortcomoings.display-shortcomings',[
            'shortcomings' => ShortComing::distinct()->
            where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo')),
        ]);
    }
}
