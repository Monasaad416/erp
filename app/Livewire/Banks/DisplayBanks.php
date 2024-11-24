<?php

namespace App\Livewire\Banks;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayBanks extends Component
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
        return view('livewire.banks.display-banks',[
            'banks' => Bank::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'is_active','account_num','last_check','current_balance')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->paginate(config('constants.paginationNo'))
        ]);
    }
}
