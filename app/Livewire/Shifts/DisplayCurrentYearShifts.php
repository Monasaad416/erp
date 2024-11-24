<?php

namespace App\Livewire\Shifts;

use App\Models\FinancialMonth;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\MonthShifts;
use App\Models\FinancialYear;
use Alert;

class DisplayCurrentYearShifts extends Component
{
 public $rows=[],$branch_id,$i,$year,$shift_type_id,$shift_hours,$shift_start,$shift_end,$user_attend_at,$user_leave_at,$attended,$financial_year_id,
 $financial_month_id;
    // public function fillInfo($branch_id ,$user_id ,$i) {

    //     if( $this->rows[$branch_id.$user_id.$i]['shift_type_id'] == 1) {
    //         $this->rows[$branch_id.$user_id.$i]['shift_hours'] = 8;
    //     }
    // }


    public function mount()
    {
        $this->financial_year_id = FinancialYear::where('year',Carbon::now()->format('Y'))->first()->id;
        $this->financial_month_id = FinancialMonth::where('month_id',Carbon::now()->format('m'))->first()->id;
        $rows = MonthShifts::where('financial_year_id',$this->financial_year_id)->
        where('financial_month_id',$this->financial_month_id)

        ->get();

    }


    public function render()
    {
        return view('livewire.shifts.display-current-year-shifts');
    }
}
