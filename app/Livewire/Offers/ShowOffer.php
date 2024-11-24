<?php

namespace App\Livewire\Offers;

use App\Models\Product;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShowOffer extends Component
{
  
    public $offer,$branches,$categories;


    public function mount($offer)
    {
        //dd($this->offer);
        $this->offer = $offer;

    }


    public function render()
    {
        return view('livewire.offers.show-offer');
    }
}
