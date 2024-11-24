<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DisplayAccounts extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem='',$branch_id =null,$level=null;


    public function updatingSearchItem()
    {
        $this->resetPage();
    }



    public function updatingBranchId()
    {
        $this->resetPage();
    }


    public function updatingLevel()
    {
        $this->resetPage();
    }

    public function render()
    {
        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            $accounts = Account::select('id',
                'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
                'is_active',
                'branch_id',
                'account_num',
                'start_balance',
                'current_balance',
                'created_by',
                'updated_by',
                'account_type_id',
                'parent_id',
                'is_parent',
                'level',
                'list',
                'deleted_at',
                'nature')
            ->withTrashed()
            ->when($this->searchItem != null, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name_' . LaravelLocalization::getCurrentLocale(), 'like', '%' . $this->searchItem . '%')
                             ->orWhere('account_num', 'like', $this->searchItem . '%');
                });
            })
            ->when($this->branch_id != null, function ($query) {
                $query->where('branch_id', $this->branch_id);
            })
           ->when($this->level != null, function ($query) {
                $query->where('level', $this->level);
            })
            ->with(['parent', 'branch', 'accountType'])
            ->orderBy(('account_num'))
            ->paginate(config('constants.paginationNo'));

return view('livewire.accounts.display-accounts', [
    'accounts' => $accounts,
]);
        }else{

            $accounts = Account::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active','branch_id','account_num','start_balance','current_balance',
                'created_by','updated_by','account_type_id','parent_id','is_parent','level','list','deleted_at','nature')->withTrashed()
                ->where('branch_id',Auth::user()->branch_id)->where( function($query) {
                if(!empty($this->searchItem )){
                    $query->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
                    ->orWhere('account_num','like',$this->searchItem.'%');
                }
                if(!empty($this->branch_id ) ){
                    $query->where('branch_id',$this->branch_id);
                }
                if(!empty($this->level) ){
                    $query->where('level',$this->level);
                }
            })->with(['parent','branch','accountType'])
            ->orderBy(('account_num'))
            ->paginate(config('constants.paginationNo'));
            return view('livewire.accounts.display-accounts',[
                'accounts' => $accounts,

            ]);

        }
    //   $accounts = Account::select('id',
    //         'name_'.LaravelLocalization::getCurrentLocale().' as name','is_active','branch_id','account_num','start_balance','current_balance',
    //         'created_by','updated_by','account_type_id','parent_id','is_parent','level')->where( function($query) {
    //         if(!empty($this->searchItem )){
    //             $query->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
    //             ->orWhere('account_num','like','%'.$this->searchItem.'%')->with(['parent','branch','accountType']);
    //         }
    //         if($this->branch_id != null ){
    //             $query->where('branch_id',$this->branch_id);
    //         }
    //         if($this->level != null ){
    //             $query->where('level',$this->level);
    //         }
    //     })->paginate(config('constants.paginationNo'));
    //     return view('livewire.accounts.display-accounts',[
    //         'accounts' => $accounts,

    //     ]);
    }
}
