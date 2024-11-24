<?php

namespace App\Livewire\Products;

use Excel;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayProducts extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $product,$name,$product_codes,$unit_id,$price ,$searchItem,$filter;





    public function updatingSearchItem()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.products.display-products',[
            'products' => Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','category_id','serial_num','unit_id','is_active','alert_main_branch','alert_branch',
            'sale_price','taxes')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo')),
        ]);
    }
}
