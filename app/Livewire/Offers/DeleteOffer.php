<?php

namespace App\Livewire\Offers;

use App\Models\Product;
use Livewire\Component;
use App\Models\Inventory;

use App\Models\SupplierInvoiceItem;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DeleteOffer extends Component
{
    protected $listeners = ['deleteProduct'];
    public $offer ,$offerName;

    public function deleteProduct($id)
    {
        $this->offer = Product::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name')->where('id',$id)->first();

        $this->offerName = $this->offer->name;
        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        $prod = Product::where('id',$this->offer->id)->first();

        $invoiceOffers = SupplierInvoiceItem::where('offer_id' ,$prod->id)->get();
        if( $invoiceOffers->count() > 0 ){
           $this->dispatch('deleteModalToggle');
                $this->dispatch(
                'alert',
                text: ' عفوا لايمكن حذف المنتج لوجود فواتير  مرتبطة به ',
                icon: 'error',
                confirmButtonText: 'تم'
            );
        } else {

            $inventories = Inventory::where('offer_id',$prod->id)->get();

            foreach($inventories as $inv) {
                $inv->delete();
            }
            

            $prod->delete();
            $this->reset('offer');

            $this->dispatch('deleteModalToggle');

            $this->dispatch('refreshData')->to(DisplayOffers::class);

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
        return view('livewire.offers.delete-offer');
    }
}
