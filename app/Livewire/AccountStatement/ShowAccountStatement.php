<?php

namespace App\Livewire\AccountStatement;

use Livewire\Component;
use App\Models\JournalEntry;

class ShowAccountStatement extends Component
{

    public $account,$account_id,$account_name,$account_num,$debit_account,$credit_amount,$journal_entry_id,$from_date,$to_date,
    $credit,$debit,$entries,$entriesCredits,$entriesDebits;


    public function mount($account)
    {
        $this->account = $account;
        $this->account_id = $this->account->id;
        $this->account_name = $this->account->name_ar;
        $this->account_num = $this->account->account_num;
    }

    public function render()
{
        $this->credit = JournalEntry::where('credit_account_num',$this->account_num)->where(function($query){
            if(!empty($this->from_date) && !empty($this->to_date)){
                $query->whereBetween('date' ,[ $this->from_date,$this->to_date]);
            }

        })->sum('credit_amount');
       

        $this->debit = JournalEntry::where('debit_account_num',$this->account_num)->where(function($query){
            if(!empty($this->from_date) && !empty($this->to_date)){
                $query->whereBetween('date' ,[ $this->from_date,$this->to_date]);
            }
        })->sum('debit_amount');


        $this->entries = JournalEntry::where(function($query) {
            $query->where('debit_account_num', $this->account_num)
                ->orWhere('credit_account_num', $this->account_num);
        })
        ->when($this->from_date && $this->to_date, function($query) {
            $query->whereBetween('date', [$this->from_date, $this->to_date]);
        })
        ->get();
                        
        $this->entriesCredits = JournalEntry::where('credit_account_num',$this->account_num)
        ->where(function($query){
        if(!empty($this->from_date) && !empty($this->to_date)){
                $query->whereBetween('date' ,[ $this->from_date,$this->to_date]);
            }
        })->sum('credit_amount') ;
        $this->entriesDebits = JournalEntry::where('debit_account_num',$this->account_num)
        ->where(function($query){
        if(!empty($this->from_date) && !empty($this->to_date)){
                $query->whereBetween('date' ,[ $this->from_date,$this->to_date]);
            }
        })->sum('debit_amount') ;
        return view('livewire.account-statement.show-account-statement');
    }
}
