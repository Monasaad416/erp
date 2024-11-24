<?php
namespace App\Livewire\TreasuryShifts;

use App\Models\Product;
use Livewire\Component;
use App\Models\ShiftType;
use App\Models\TreasuryShift;
use SebastianBergmann\Template\Exception;
use App\Livewire\TreasuryShifts\DisplayTreasuryShifts;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DeleteTreasuryShift extends Component
{
    protected $listeners = ['deleteTreasuryShift'];
    public $shift ,$shiftType,$delivered_to;

    public function deleteTreasuryShift($id)
    {
        $this->shift = TreasuryShift::where('id',$id)->first();
       //dd($this->shift);

        $this->delivered_to = $this->shift->deliveredTo->name;


        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $shift = TreasuryShift::where('id',$this->shift->id)->first();


                $shift->delete();


                $this->dispatch('deleteModalToggle');

                $this->dispatch('refreshData')->to(DisplayTreasuryShifts::class);

                $this->dispatch(
                'alert',
                    text: trans('admin.treasury_shift_deleted_successfully'),
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),

            );

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.treasury-shifts.delete-treasury-shift');
    }
}

