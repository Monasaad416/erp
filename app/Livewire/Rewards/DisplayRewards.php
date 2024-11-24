<?php

namespace App\Livewire\Rewards;

use App\Models\Reward;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayRewards extends Component
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
        return view('livewire.rewards.display-rewards',[
            'rewards' => Reward::
            where('account_num','like','%'.$this->searchItem.'%')

            ->paginate(config('constants.paginationNo'))
        ]);
    }
}
