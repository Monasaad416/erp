<?php

namespace App\Livewire\TAccount;

use App\Models\Ledger;
use Livewire\Component;
use App\Models\TAccount;
use Livewire\WithPagination;

class DisplayTAccounts extends Component
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
        $ledgers = Ledger::all();
    
            $tAccounts = TAccount::where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('journal_type','like','%'.$this->searchItem.'%');

            }

        })->latest()->paginate(config('constants.paginationNo'));
       return view('livewire.t-account.display-t-accounts',[
        'tAccounts' => $tAccounts,
       ]);
    }
}
