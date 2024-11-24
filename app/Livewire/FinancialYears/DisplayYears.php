<?php

namespace App\Livewire\FinancialYears;

use Livewire\Component;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Auth;

class DisplayYears extends Component
{
    public $searchItem;
    public $listeners = ['refreshData' =>'$refresh'];

    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {


        return view('livewire.financial-years.display-years',[
            'years' => FinancialYear::
             where('year','like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
