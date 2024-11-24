<?php

namespace App\Livewire\Depreciations;

use App\Models\Asset;
use Livewire\Component;
use App\Models\Depreciation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayDepreciations extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $asset_name,$branch_id ;

        
    public function updatingBranchId()
    {
        $this->resetPage();
    }

    
    public function updatingAssetId()
    {
        $this->resetPage();
    }
    
    
        
    public function render()
    {

        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            $depreciations = Depreciation::where( function($query) {
                $asset = Asset::where('name_' . LaravelLocalization::getCurrentLocale() ,$this->asset_name)->first();
                if($this->asset_name != null ){
                    $query->where('asset_id',$asset->id);
                }
               if ($this->branch_id != null) {
                
                    $query->whereHas('asset_id', function ($subquery) {
                        $subquery->where('asset_id', $asset->id);
                    });
                }
            })->paginate(config('constants.paginationNo'));
            return view('livewire.depreciations.display-depreciations',[
                'depreciations' => $depreciations,

            ]);
        }else{

        $depreciations = Depreciation::whereHas('asset', function ($subquery) {
                $subquery->where('branch_id', $this->branch_id);
                if ($this->asset_id != null) {
                    $subquery->where('asset_id', $this->asset_id);
                }
            })
            ->paginate(config('constants.paginationNo'));

        return view('livewire.depreciations.display-depreciations', [
            'depreciations' => $depreciations,
        ]);

        }
    }
}
