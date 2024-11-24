<?php

namespace App\Livewire\TreasuryShifts;

use Exception;
use Livewire\Component;
use App\Models\TreasuryShift;
use App\Livewire\TreasuryShifts\DisplayTreasuryShifts;


class ApproveRecievingShift extends Component
{

    public $id,$treasuryShift ,$is_approved,$deliveredToShift;
    protected $listeners = ['recieveShift'];
    public function recieveShift($id)
    {
        $this->id = $id;
        $this->treasuryShift = TreasuryShift::where('id',$id)->first();

        $this->deliveredToShift = $this->treasuryShift->deliveredToShiftType->label();
        // return dd($this->treasuryShift);
        $this->is_approved = $this->treasuryShift->is_approved;


        $this->dispatch('changeStateModalToggle');
    }


    public function changeShiftApprovalState()
    {
        try{
            if( $this->treasuryShift->is_approved == 1 ){
                $this->treasuryShift->is_approved = 0;
                $this->treasuryShift->save();
            }else {
                $this->treasuryShift->is_approved = 1;
                $this->treasuryShift->save();
            }
            $this->dispatch('changeStateModalToggle');

            $this->dispatch('refreshData')->to(DisplayTreasuryShifts::class);

            $this->dispatch(
            'alert',
                text: trans('admin.user_shift_state_changed_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.treasury-shifts.approve-recieving-shift');
    }
}
