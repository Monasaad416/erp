<?php

namespace App\Livewire\BankAccounts;

use Livewire\Component;
use App\Models\BankAccount;
use Livewire\WithPagination;

class DisplayBankAccounts extends Component
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
        return view('livewire.bank-accounts.display-bank-accounts',[
            'bankAccounts' => BankAccount::
            where('bank_account_num','like','%'.$this->searchItem.'%')
            ->paginate(config('constants.paginationNo'))
        ]);
    }
}
