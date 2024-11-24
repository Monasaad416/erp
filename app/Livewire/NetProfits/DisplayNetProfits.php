<?php

namespace App\Livewire\NetProfits;

use Livewire\Component;
use App\Models\IncomeListNetProfit;
use Carbon\Carbon;

class DisplayNetProfits extends Component
{
    public $year, $branch_id;
    public function render()
    {


        $profits = IncomeListNetProfit::where(function ($query) {
            $currentYear = Carbon::now()->year;
            if (!empty($this->year != null)) {
                $query->whereWhere('start_date', $currentYear);
            }

            if ($this->branch_id != null) {
                $query->where('branch_id', $this->branch_id);
            }
        })->paginate(config('constants.paginationNo'));
        return view('livewire.net-profits.display-net-profits',compact('profits'));
    }
}
