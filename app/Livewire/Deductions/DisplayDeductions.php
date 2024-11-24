<?php

namespace App\Livewire\Deductions;

use Livewire\Component;
use App\Models\Deduction;
use Livewire\WithPagination;

class DisplayDeductions extends Component
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
        return view('livewire.deductions.display-deductions',[
            'deductions' => Deduction::
            where('account_num','like','%'.$this->searchItem.'%')
         
            ->paginate(config('constants.paginationNo'))
        ]);
    }
}
