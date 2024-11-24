<?php

namespace App\Livewire\TreasuryShifts;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TreasuryShift;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayTreasuryShifts extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchStart='', $searchEnd='',$currentTreasuryShift;

    public function updatingSearchItem()
    {
        $this->resetPage();
    }


    public function render()
    {
        $currentTime = Carbon::now();
        $this->currentTreasuryShift = TreasuryShift::where("delivered_to_user_id",Auth::user()->id)
            ->where('branch_id',Auth::user()->branch_id)
            ->whereTime('start_shift_date_time', '<=', $currentTime)
            ->whereTime('end_shift_date_time', '>=', $currentTime)
            ->whereDate('start_shift_date_time', '<=', $currentTime)
            ->whereDate('end_shift_date_time', '>=', $currentTime)
            ->latest()->first();
            //dd($this->currentTreasuryShift);
        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            return view('livewire.treasury-shifts.display-treasury-shifts',[
                'treasuryShifts' => TreasuryShift::latest()->paginate(config('constants.paginationNo'))
            ]);
        } else {
              return view('livewire.treasury-shifts.display-treasury-shifts',[
                'treasuryShifts' => TreasuryShift::where('branch_id',Auth::user()->branch_id)->latest()->paginate(config('constants.paginationNo'))
            ]);
        }
    }
}
