<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class PrintCode extends Component
{

    protected $listeners = ['printProductCode'];

    public $product,$product_code;



    public function printProductCode($id,$code)
    {

        $this->product = Product::findOrFail($id);

        $this->product_code = $code;

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('printModalToggle');



    }

    public function render()
    {
        return view('livewire.products.print-code');
    }
}
