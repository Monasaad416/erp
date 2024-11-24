<?php

namespace App\Livewire\CostCenters;

use Livewire\Component;
use App\Models\CostCenter;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
;

class DisplayCostCenters extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem='';
    public function updatingSearchItem()
    {
        $this->resetPage();
    }


    public function render()
    {
        return view('livewire.cost-centers.display-cost-centers',[
            'centers' => CostCenter::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','parent_id','code')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
