<?php

namespace App\Livewire\PartnersWithdrawals;

use App\Models\PartnerWithdrawal;
use Livewire\Component;

class DisplayWithdrawals extends Component
{
        public $searchItem='';

    public function updatingSearchItem()
    {
        $this->resetPage();
    }
    public $listeners = ['refreshData' =>'$refresh'];

    public function render()
    {
        return view('livewire.partners-withdrawals.display-withdrawals',[
            'partnersWithdrawals' => PartnerWithdrawal::where('partner_id','like','%'.$this->searchItem.'%')
            ->latest()->paginate(config('constants.paginationNo'))
        ]);
    }
}
