<?php

namespace App\Livewire\Taxes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdjustedTaxes;

class AdjustedTaxesWithZatca extends Component
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
       $taxes = AdjustedTaxes::where( function($query) {
            if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
        })->paginate(config('constants.paginationNo'));

         return view('livewire.taxes.adjusted-taxes-with-zatca',[
            'taxes' => $taxes,
        ]);
    }
}
