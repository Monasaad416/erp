<?php

namespace App\Livewire\Branches;

use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Branch;

class DisplayBranches extends Component
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
        return view('livewire.branches.display-branches',[
            'branches' => Branch::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'street_name_'.LaravelLocalization::getCurrentLocale().' as streetName',
            'city_'.LaravelLocalization::getCurrentLocale().' as city' ,
            'region_'.LaravelLocalization::getCurrentLocale().' as region' ,
            'email','gln','is_active','phone','branch_num','postal_code','plot_identification','building_number')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
