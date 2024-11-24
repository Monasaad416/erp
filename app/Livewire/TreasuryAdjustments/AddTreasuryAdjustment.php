<?php

namespace App\Livewire\TreasuryAdjustments;

use Livewire\Component;

class AddTreasuryAdjustment extends Component
{
    public $type,$branch_id,$credit1,$credit_amount1,$debit,$debit_amount1;
    public function render()
    {
        return view('livewire.treasury-adjustments.add-treasury-adjustment');
    }
}
