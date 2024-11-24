<?php

namespace App\Livewire\Salaries;

use Carbon\Carbon;
use App\Models\Salary;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FinancialYear;

class DisplayCurrentYearSalaries extends Component
{
    use WithPagination;
    public function render()
    {
        $currentYear = Carbon::now()->format('Y');
        $financialYear = FinancialYear::where('year',$currentYear)->first();
        return view('livewire.salaries.display-current-year-salaries',[
            'salaries' => Salary::where('financial_year_id',$financialYear->year)->paginate(config('constants.paginationNo'))
        ]);
    }
}
