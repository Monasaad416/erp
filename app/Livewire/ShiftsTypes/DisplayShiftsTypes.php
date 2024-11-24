<?php

namespace App\Livewire\ShiftsTypes;

use Livewire\Component;
use App\Models\ShiftType;
use Livewire\WithPagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayShiftsTypes extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchStart='';
    public $searchEnd='';
    public function render()
    {
        return view('livewire.shifts-types.display-shifts-types',[
            'shiftsTypes' => ShiftType::where('start','like','%'.$this->searchStart.'%')->where('end','like','%'.$this->searchEnd.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
