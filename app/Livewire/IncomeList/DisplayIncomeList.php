<?php

namespace App\Livewire\IncomeList;

use App\Models\Account;
use Livewire\Component;
use App\Models\IncomeList;
use Livewire\WithPagination;
use App\Models\CustomerReturn;
use App\Models\SupplierReturn;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayIncomeList extends Component
{
    use WithPagination;
    public $branch_id,$from_date,$to_date;
    public function render()
    {

        $incomes = IncomeList::select('id',
            'name_'.LaravelLocalization::getCurrentLocale().' as name','start_date','branch_id','end_date','balance','account_id','account_num','type')
            ->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
                ->orWhere('account_num','like','%'.$this->searchItem.'%')->with(['parent','branch','accountType']);
            }

             if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
        })->paginate(config('constants.paginationNo'));

         return view('livewire.income-list.display-income-list',[
            'incomes' => $incomes,
        ]);
    }
}
