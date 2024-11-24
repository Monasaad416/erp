<?php

namespace App\Livewire\TrailBalancesAfter;

use Excel;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\AccountsExport;
use App\Models\TrailBalanceAfter;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayTrailBalancesAfter extends Component
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

    // public function exportTrailReport()
    // {

    //     $from_date= $this->from_date;
    //     $to_date = $this->to_date;
    //     $searchItem = $this->searchItem;
    //     $levels = $this->levels;

    //     //dd($filter);

    //     return Excel::download(new AccountsExport( $from_date,$to_date,$searchItem,$levels), 'ميزان المراجعة.xlsx');
    // }

    // public function performSearch ()
    // {
    //     $this->resetPage();
    // }


    public function render()
    {
      $balances = TrailBalanceAfter::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','start_date','branch_id','end_date','debit','credit','account_id','account_num')
            ->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
                ->orWhere('account_num','like','%'.$this->searchItem.'%')->with(['parent','branch','accountType']);
            }


             if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
        })->paginate(config('constants.paginationNo'));

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

    return view('livewire.trail-balances-after.display-trail-balances-after', [
        'balances' => $balances,
    ]);
}

}
