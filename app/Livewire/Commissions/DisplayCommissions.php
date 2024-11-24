<?php

namespace App\Livewire\Commissions;

use Livewire\Component;
use App\Models\Commission;

class DisplayCommissions extends Component
{
    public $product_id;
    public function updatingProductId()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.commissions.display-commissions',[
            'products' => Commission::where('product_id','like','%'.$this->product_id.'%')
            ->latest()->paginate(config('constants.paginationNo')),
        ]);
    }
}
