<?php

namespace App\Livewire\Stores;

use Livewire\Component;
use App\Models\Store;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Displaystores extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem='';
    public function render()
    {
        return view('livewire.stores.display-stores',[
            'stores' => Store::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'is_active','is_parent')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->paginate(config('constants.paginationNo'))
        ]);
    }
}
