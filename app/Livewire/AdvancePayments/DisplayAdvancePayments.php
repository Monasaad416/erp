<?php

namespace App\Livewire\AdvancePayments;

use Livewire\Component;
use App\Models\AdvancePayment;
use Illuminate\Support\Facades\Auth;


class DisplayAdvancePayments extends Component
{

    public $listeners = ['refreshData' =>'$refresh'];

    public $searchItem='';
    public function updatingSearchItem()
    {
        $this->resetPage();
    }

    public function render()
    {
        if(Auth::user()->roles_name == 'سوبر-ادمن'){
            return view('livewire.advance-payments.display-advance-payments',[
                'advancePayments' => AdvancePayment::where('account_num','like','%'.$this->searchItem.'%')

                ->paginate(config('constants.paginationNo'))
            ]);
        }else{
            return view('livewire.advance-payments.display-advance-payments',[
                'advancePayments' => AdvancePayment::where('branch_id',Auth::user()->branch_id)->where('account_num','like','%'.$this->searchItem.'%')

                ->paginate(config('constants.paginationNo'))
            ]);
        }

    }
}
