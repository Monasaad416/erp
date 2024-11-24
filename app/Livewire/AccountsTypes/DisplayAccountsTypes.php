<?php

namespace App\Livewire\AccountsTypes;

use Livewire\Component;
use App\Models\AccountType;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DisplayAccountsTypes extends Component
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
        return view('livewire.accounts-types.display-accounts-types',[
            'accounts_types' => AccountType::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active','separate_screen')
            ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
