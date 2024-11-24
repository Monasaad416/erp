<?php

namespace App\Livewire\FinancialPositions;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FinancialPosition;
use App\Models\StatementOfFinancialPosition;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayFinancialPositions extends Component
{

    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];
    

    public $searchItem='',$branch_id;

    public function updatingBranchId()
    {
        $this->resetPage();
    }
    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {
      $balances = FinancialPosition::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','start_date','branch_id','end_date','balance','account_id','account_num')
            ->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
                ->orWhere('account_num','like','%'.$this->searchItem.'%')->with(['parent','branch','accountType']);
            }


             if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
        })->paginate(config('constants.paginationNo'));
    return view('livewire.financial-positions.display-financial-positions', [
        'balances' => $balances,
    ]);
}

}
