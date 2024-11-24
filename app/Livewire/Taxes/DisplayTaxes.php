<?php

namespace App\Livewire\Taxes;

use App\Models\Taxes;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayTaxes extends Component
{

    use WithPagination;
    public $from_date,$to_date,$branch_id;
        public function updatingFromDate()
    {
        $this->resetPage();
    }  
    public function updatingToDate()
    {
        $this->resetPage();
    }   
    public function updatingBranchId()
    {
        $this->resetPage();
    } 
    public function render(){
       $taxes = Taxes::where( function($query) {
            if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
        })->paginate(config('constants.paginationNo'));

         return view('livewire.taxes.display-taxes',[
            'taxes' => $taxes,
        ]);
    }
}
