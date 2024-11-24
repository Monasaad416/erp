<?php

namespace App\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplaySuppliers extends Component
{
    use WithPagination;
    public $searchItem='';

    public function updatingSearchItem()
    {
        $this->resetPage();
    }  
    public $listeners = ['refreshData' =>'$refresh'];

    public function render()
    {
        return view('livewire.suppliers.display-suppliers',[
            'suppliers' => Supplier::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'address' ,
            'email','gln','phone','tax_num','balance_state','start_balance','current_balance','account_num')
             ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
