<?php

namespace App\Livewire\Asset;

use App\Models\Asset;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DisplayAssets extends Component
{
    use WithPagination;
    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem='';

    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (Auth::user()->roles_name == 'سوبر-ادمن'){
            return view('livewire.asset.display-assets', [
                'assets' => Asset::select(
                    'id',
                    'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
                    'purchase_price',
                    'current_price',
                    'scrap_price',
                    'life_span',
                    'parent_account_id',
                    'purchase_date',
                    'account_num',
                    'branch_id'
                )
                    ->where('name_' . LaravelLocalization::getCurrentLocale(), 'like', '%' . $this->searchItem . '%')
                    ->paginate(config('constants.paginationNo'))
            ]);

        } else {
            return view('livewire.asset.display-assets', [
                'assets' => Asset::select(
                    'id',
                    'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
                    'purchase_price',
                    'current_price',
                    'scrap_price',
                    'life_span',
                    'parent_account_id',
                    'purchase_date',
                    'account_num',
                    'branch_id'
                )
                    ->where('branch_id',$this->branch_id)
                    ->paginate(config('constants.paginationNo'))
            ]);

        }

    }
}
