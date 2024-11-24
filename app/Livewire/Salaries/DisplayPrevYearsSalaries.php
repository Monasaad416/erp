<?php

namespace App\Livewire\Salaries;

use Carbon\Carbon;
use App\Models\Salary;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FinancialYear;

class DisplayPrevYearsSalaries extends Component
{
    public $branch_id,$finacial_year_id;
    use WithPagination;
    public function render()
    {
        $currentYear = Carbon::now()->format('Y');
        $financialYear = FinancialYear::where('year',$currentYear)->first();


        $salaries = Salary::where( function($query) {
            if(!empty($this->year )){
                $query->where('financial_year_id',$this->year);
            }
            if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
        })->whereNot('financial_year_id',$financialYear->year)->paginate(config('constants.paginationNo'));
        return view('livewire.salaries.display-prev-years-salaries',[
            'salaries' => $salaries,
        ]);

    }
}
