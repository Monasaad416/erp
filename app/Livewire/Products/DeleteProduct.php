<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;

use App\Models\SupplierInvoiceItem;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeleteProduct extends Component
{
    protected $listeners = ['deleteProduct'];
    public $product ,$productName;

    public function deleteProduct($id)
    {
        $this->product = Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();

        $this->productName = $this->product->name;
        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        $prod = Product::where('id',$this->product->id)->first();

        $invoiceProducts = SupplierInvoiceItem::where('product_id' ,$prod->id)->get();
        if( $invoiceProducts->count() > 0 ){
           $this->dispatch('deleteModalToggle');
                $this->dispatch(
                'alert',
                text: ' عفوا لايمكن حذف المنتج لوجود فواتير  مرتبطة به ',
                icon: 'error',
                confirmButtonText: 'تم'
            );
        } else {

            $inventories = Inventory::where('product_id',$prod->id)->get();

            foreach($inventories as $inv) {
                $inv->delete();
            }
            

            $prod->delete();
            $this->reset('product');

            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayProducts::class);

            $this->dispatch(
            'alert',
                text: 'تم حذف المنتج بنجاح',
                icon: 'success',
                confirmButtonText: 'تم'

            );
        }

    }
    public function render()
    {
        return view('livewire.products.delete-product');
    }
}
