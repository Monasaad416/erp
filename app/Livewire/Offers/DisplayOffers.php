<?php

namespace App\Livewire\Offers;

use Excel;
use App\Models\Offer;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayOffers extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $product_id,$branch_id;

    public function updatingProductId()
    {
        $this->resetPage();
    }
    public function updatingBranchId()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.offers.display-offers',[
            'offers' => Offer::where('product_id','like','%'.$this->product_id.'%')
            ->latest()->paginate(config('constants.paginationNo')),
        ]);
    }
}
