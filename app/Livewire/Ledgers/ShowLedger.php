<?php

namespace App\Livewire\Ledgers;

use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use Livewire\WithPagination;

class ShowLedger extends Component
{
    use WithPagination;
    protected $listeners = ['showLedger'];
    public $account,$account_id,$account_name,$account_num,$debit_account,$credit_amount,$journal_entry_id;


    public function mount($account)
    {
        $this->account = $account;
        $this->account_id = $this->account->id;
        $this->account_name = $this->account->name_ar;
        $this->account_num = $this->account->account_num;
    }


    public function render()
    {
        return view('livewire.ledgers.show-ledger',[
            'ledgers' => Ledger::where('account_num', $this->account_num)->latest()->paginate(20)
        ]);
    }
}
