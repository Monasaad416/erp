<?php

namespace App\Livewire\BankTransactions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BankTransaction;
use Illuminate\Support\Facades\Auth;

class DisplayTransactions extends Component
{
    use WithPagination;
    public $searchItem,$branch_id,$state,$bank_id,$accountNum,$from_date,$to_date;
    public $listeners = ['refreshData' =>'$refresh'];

    public function updatingSearchItem()
    {
        $this->resetPage();
    }


    
    public function updatingBankId()
    {
        $this->resetPage();
    }

    
    public function updatingState()
    {
        $this->resetPage();
    }
    public function updatingAccountNum()
    {
        $this->resetPage();
    }
    public function updatingFromDate()
    {
        $this->resetPage();
    }
    public function updatingToDate()
    {
        $this->resetPage();
    }
    public function render()
    {
    
        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            $transactions = BankTransaction::where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('chech_num','like','%'.$this->searchItem.'%');

                }

            if($this->state != null ){
                $query->where('state',$this->state);

            }
                if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);

            }
            if($this->bank_id != null ){
                $query->where('bank_id',$this->bank_id);

            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('date',[$this->from_date,$this->to_date]);

            }
        })->latest()->paginate(config('constants.paginationNo'));
        return view('livewire.bank-transactions.display-transactions',[
            'transactions' => BankTransaction::latest()->paginate(config('constants.paginationNo'))
        ]);
    } else {
            $transactions = BankTransaction::where('branch_id',Auth::user()->branch_id)->where( function($query) {
            if(!empty($this->searchItem )){
                $query->where('chech_num','like','%'.$this->searchItem.'%');

                }

            if($this->state != null ){
                $query->where('state',$this->state);

            }
                if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);

            }
            if($this->bank_id != null ){
                $query->where('bank_id',$this->bank_id);

            }
            if($this->from_date && $this->to_date  ){
                $query->whereBetween('date',[$this->from_date,$this->to_date]);

            }
        })->latest()->paginate(config('constants.paginationNo'));
        return view('livewire.bank-transactions.display-transactions',[
            'transactions' => BankTransaction::latest()->paginate(config('constants.paginationNo'))
        ]);

    }
    }
}
