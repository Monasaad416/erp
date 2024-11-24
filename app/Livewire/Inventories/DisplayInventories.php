<?php

namespace App\Livewire\Inventories;

use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayInventories extends Component
{
        use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $product,$name,$product_codes,$unit_id,$tension,$price ,$product_id,$filter,$branch_id;


    public function mount($filter = null)
    {
        $this->filter = $filter;
    }

    public function changeFilter($value)
    {
        $this->filter = $value;
        $this->emit('updateQueryString', ['filter' => $value]);
    }




    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {

        if(Auth::user()->roles_name == 'سوبر-ادمن') {
            $products = Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','category_id','serial_num','unit_id','is_active','alert_main_branch','alert_branch',
            'sale_price')->where( function($query) {

                if($this->branch_id != null ){
                    $query->where('branch_id',$this->branch_id);
                }
                if($this->product_id != null ){
                    $query->where('product_id',$this->product_id);
                }
                })->latest()->paginate(config('constants.paginationNo'));

                return view('livewire.inventories.display-inventories',[
                    'products' => $products
                ]);
        } else {

            $products = Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','category_id','serial_num','unit_id','is_active','alert_main_branch','alert_branch',
            'sale_price','commission_rate')->where( function($query) {

                if($this->branch_id != null ){
                    $query->where('branch_id',$this->branch_id);
                }
                if($this->product_id != null ){
                    $query->where('product_id',$this->product_id);
                }
                })->latest()->paginate(config('constants.paginationNo'));

                return view('livewire.inventories.display-inventories',[
                    'products' => $products
                ]);

    }


}
}
