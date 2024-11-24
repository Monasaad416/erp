<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StatisticsOfProduct extends Component
{
    protected $listeners = ['statisticsOfProduct'];

    public $product,$branches,$categories,$units,$name,$unit,$category,$branch,
    $gtin,$serial_num,$manufactured_date,$expiry_date,$import_date,$size,$max_dose,$batch_num,$description,
    $purchase_price,$sale_price,$discount_price,$fraction ,$taxes,$inventory_balance,$is_active ,$product_id;


    // public function mount($product)
    // {
    //     $this->product = $product;
    //     $this->is_active = $this->product->is_active;
    //     $this->fraction = $this->product->fraction;
    //     $this->taxes = $this->product->taxes;
    // }

    public function statisticsOfProduct($id)
    {
        $this->product = Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'category_id','serial_num','inventory_balance','unit_id','is_active',
            'size','max_dose','manufactured_date','expiry_date',
            'import_date','taxes','fraction')->where('id',$id)->first();
        $this->product_id = $this->product->id;

        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->unit = $this->product->unit->name;
        $this->category = $this->product->category->name;
        $this->manufactured_date = $this->product->manufactured_date;
        $this->expiry_date = $this->product->expiry_date;
        $this->import_date = $this->product->import_date;
        $this->sale_price = $this->product->sale_price;
        $this->discount_price = $this->product->discount_price;
        $this->serial_num = $this->product->serial_num;
        $this->max_dose = $this->product->max_dose;
        $this->fraction = $this->product->fraction;
        $this->taxes = $this->product->taxes;
        $this->is_active = $this->product->is_active;
        $this->gtin = $this->product->gtin;
        $this->size = $this->product->size;
        $this->inventory_balance = $this->product->inventory_balance;

        $this->dispatch('statisticsModalToggle');
    }

    public function render()
    {
        return view('livewire.products.statistics-of-product');
    }
}
