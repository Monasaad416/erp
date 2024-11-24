<?php

namespace App\Livewire\TreasuryAdjustments;

use App\Models\AdjustingEntry;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayTreasuryAdjustments extends Component
{
    use WithPagination;
    public $page = 1, $creditAccount,$debitAccount, $from_date, $to_date, $branch_id;

    public function updatingFromDate()
    {
        $this->resetPage();
    }
    public function updatingToDate()
    {
        $this->resetPage();
    }
    public function updatingCreditAccount()
    {
        $this->resetPage();
    }
    
    public function updatingDebitAccount()
    {
        $this->resetPage();
    }

    public function updatingBranchId()
    {
        $this->resetPage();
    }



    public function render()
    {
            $adjustments = AdjustingEntry::

            when($this->creditAccount!= null, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('credit_account_name_ar', 'like', '%' . $this->creditAccount. '%');
                });
            })
            ->when($this->debitAccount!= null, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('debit_account_name_ar', 'like', '%' . $this->debitAccount. '%');
                });
            })
            ->when($this->from_date != null && $this->to_date != null , function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->whereBetween('created_at', [$this->from_date,$this->to_date]);
                });
            })
            ->when($this->branch_id != null, function ($query) {
                $query->where('branch_id', $this->branch_id);
            })
            ->where('jounralable_type',"App\Models\Treasury")->paginate(config('constants.paginationNo'));

            return view('livewire.treasury-adjustments.display-treasury-adjustments', [
            'adjustments' => $adjustments,
        ]);
    }
}
