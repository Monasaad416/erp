<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShowProduct extends Component
{
  
    public $product,$branches,$categories;


    public function mount($product)
    {
        //dd($this->product);
        $this->product = $product;

    }


    public function render()
    {
        return view('livewire.products.show-product');
    }
}
