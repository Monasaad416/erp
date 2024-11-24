<?php

namespace App\Livewire\Offers;

use Exception;
use App\Models\Offer;
use Livewire\Component;
use App\Livewire\Offers\DisplayOffers;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToggleOffer extends Component
{
    public $id,$offer ,$is_active,$offerName;
    protected $listeners = ['toggleOffer'];
    public function toggleOffer($id)
    {
        $this->id = $id;
        $this->offer = Offer::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active')->where('id',$id)->first();

        $this->offerName = $this->offer->name;
        // return dd($this->offer);
        $this->is_active = $this->offer->is_active;


        $this->dispatch('changeStateModalToggle');
    }


    public function toggle()
    {
        try{
            if( $this->offer->is_active == 1 ){
                $this->offer->is_active = 0;
                $this->offer->save();
            }else {
                $this->offer->is_active = 1;
                $this->offer->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayOffers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.offer_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.offers.toggle-offer',['offer' => $this->offer]);
    }
}
