<?php

namespace App\Livewire\Treasuries;

use Livewire\Component;
use App\Models\Treasury;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayTreasuries extends Component
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
        return view('livewire.treasuries.display-treasuries',[
            'treasuries' => Treasury::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'is_active','is_parent','account_num','last_exchange_receipt','last_collection_receipt','current_balance')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->paginate(config('constants.paginationNo'))
        ]);
    }
}
