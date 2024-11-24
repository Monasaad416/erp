<?php

namespace App\Livewire\Partners;

use App\Models\Partner;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayPartners extends Component
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
        return view('livewire.partners.display-partners',[
            'partners' => Partner::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name',
            'address' ,
            'email','phone')
             ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
