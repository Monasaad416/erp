<?php

namespace App\Livewire\Asset;

use App\Models\Asset;
use Livewire\Component;
use App\Models\Depreciation;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShowAsset extends Component
{
    protected $listeners = ['showDepreciations'];
    public $asset,$assetName,$depreciations;

    public function showDepreciations($id)
    {
        //($id);
        $this->asset = Asset::findOrFail($id);
        $this->assetName = $this->asset->name_ar;
        //dd($this->asset);

        $this->depreciations = Depreciation::where('asset_id',$id)->get();
        //dd($this->depreciations);


        $this->resetValidation();

        $this->dispatch('showModalToggle');

    }
    public function render()
    {
        return view('livewire.asset.show-asset');
    }
}
