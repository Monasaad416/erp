<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayCustomers extends Component
{
    use WithPagination;
    public $searchItem='';
    public function updatingearchItem()
    {
        $this->resetPage();
    }
    public $listeners = ['refreshData' =>'$refresh'];

    public function render()
    {
        return view('livewire.customers.display-customers',[
            'customers' => Customer::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'address' ,
            'email','phone','balance_state','start_balance','current_balance','account_num','pos')
             ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
