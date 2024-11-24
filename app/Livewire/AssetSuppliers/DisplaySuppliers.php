<?php

namespace App\Livewire\AssetSuppliers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AssetSupplier;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DisplaySuppliers extends Component
{
    use WithPagination;
    public $searchItem='';

    public function updatingSearchItem()
    {
        $this->resetPage();
    }
    public $listeners = ['refreshData' =>'$refresh'];

    public function render()
    {
        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            return view('livewire.asset-suppliers.display-suppliers',[
                'suppliers' => AssetSupplier::select('id',
                'name_'.LaravelLocalization::getCurrentLocale().' as name',
                'address' ,
                'email','phone','tax_num','balance_state','start_balance','current_balance','account_num','branch_id')
                ->where('name_'.LaravelLocalization::getCurrentLocale(),'like','%'.$this->searchItem.'%')
                ->latest()->paginate(config('constants.paginationNo'))
            ]);
        } else {
            return view('livewire.asset-suppliers.display-suppliers', [
                'suppliers' => AssetSupplier::select(
                    'id',
                    'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
                    'address',
                    'email',
                    'phone',
                    'tax_num',
                    'balance_state',
                    'start_balance',
                    'current_balance',
                    'account_num',
                    'branch_id'
                )
                    ->where('branch_id',Auth::user()->branch_id)
                    ->where('name_' . LaravelLocalization::getCurrentLocale(), 'like', '%' . $this->searchItem . '%')
                    ->latest()->paginate(config('constants.paginationNo'))
            ]);
        }
    }
}
