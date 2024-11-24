<?php

namespace App\Livewire\UniTrailBalancesBefore;

use Excel;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\AccountsExport;
use App\Models\TrailBalanceBefore;
use Illuminate\Support\Facades\DB;
use App\Models\UniTrailBalanceBefore;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayUniTrailBalancesBefore extends Component
{
    use WithPagination;
    public $page=1,$searchItem,$from_date,$to_date,$levels=[],$branch_id;

    public function updatingFromDate()
    {
        $this->resetPage();
    }
    public function updatingToDate()
    {
        $this->resetPage();
    }
    public function updatingSearchItem()
    {
        $this->resetPage();
    }
    public function updatingLevels()
    {
        $this->resetPage();
    }

    public function updatingBranchId()
    {
        $this->resetPage();
    }


    public function render()
    {
      $balances = UniTrailBalanceBefore::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','start_date','end_date','debit','credit','balance','account_id','account_num')

        ->when($this->searchItem != null, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name_' . LaravelLocalization::getCurrentLocale(), 'like', '%' . $this->searchItem . '%')
                             ->orWhere('account_num', 'like', $this->searchItem );
                });
        
            })->get();



    // $accounts = Account::select('id',
    //     'name_'.LaravelLocalization::getCurrentLocale().' as name',
    //     'account_num','level')
    //     ->where(function ($query) {
    //         if (!empty($this->searchItem)) {
    //             $query->where('name_'.LaravelLocalization::getCurrentLocale(), 'like', '%'.$this->searchItem.'%')
    //                 ->orWhere('account_num', 'like', '%'.$this->searchItem.'%');
    //         }
    //          if (!empty($this->levels)) {
    //             $query->whereIn('level',$this->levels );
    //         }
    //         // if ($this->from_date != null && $this->to_date != null) {
    //         //     $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
    //         // }
    //     })->paginate(config('constants.paginationNo'));

    return view('livewire.uni-trail-balances-before.display-uni-trail-balances-before', [
        'balances' => $balances,
    ]);
}

}
