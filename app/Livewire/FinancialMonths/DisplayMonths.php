<?php

namespace App\Livewire\FinancialMonths;
use App\Models\FinancialMonth;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class DisplayMonths extends Component
{
    public $searchItem;
    public $listeners = ['refreshData' =>'$refresh'];

    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {
        $companyCode = Auth::user()->code;
        $paginator = config('constants.options.paginate');
        $months = getColumns(new FinancialMonth ,$paginator ,array("*") ,array("code"=>$companyCode),"id","desc");
        return view('livewire.financial-months.display-months');
    }
}
