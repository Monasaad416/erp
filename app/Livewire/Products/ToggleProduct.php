<?php

namespace App\Livewire\Products;

use Exception;
use App\Models\Product;
use Livewire\Component;
use App\Livewire\Products\DisplayProducts;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToggleProduct extends Component
{
    public $id,$product ,$is_active,$productName;
    protected $listeners = ['toggleProduct'];
    public function toggleProduct($id)
    {
        $this->id = $id;
        $this->product = Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->productName = $this->product->name;
        // return dd($this->product);
        $this->is_active = $this->product->is_active;


        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        try{
            if( $this->product->is_active == 1 ){
                $this->product->is_active = 0;
                $this->product->save();
            }else {
                $this->product->is_active = 1;
                $this->product->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayProducts::class);

            $this->dispatch(
            'alert',
                text: trans('admin.product_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.products.toggle-product',['product' => $this->product]);
    }
}
