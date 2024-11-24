<?php

namespace App\Livewire\ClosingEntries;

use Livewire\Component;
use App\Models\ClosingEntry;
use Livewire\WithPagination;

class DisplayEntries extends Component
{
    use WithPagination;
    public $branch_id,$start_date,$end_date;

    public function updatingBranchId()
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

        $entries = ClosingEntry::where( function($query) {
            if($this->branch_id != null ){
                $query->where('branch_id',$this->branch_id);
            }
            if($this->start_date != null && $this->end_date != null){
                $query->where('start_date',$this->start_date)->
                $query->where('end_date',$this->end_date);
            }
        })->paginate(config('constants.paginationNo'));

         return view('livewire.closing-entries.display-entries',[
            'entries' => $entries,
        ]);
    }

}
