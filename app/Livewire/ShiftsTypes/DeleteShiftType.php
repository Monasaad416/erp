<?php

namespace App\Livewire\ShiftsTypes;

use App\Models\Product;
use Livewire\Component;
use App\Models\shift;
use App\Models\ShiftType;
use SebastianBergmann\Template\Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DeleteShiftType extends Component
{
    protected $listeners = ['deleteShift'];
    public $shift ,$shiftType;

    public function deleteShift($id)
    {
        $this->shift = shiftType::where('id',$id)->first();
    //dd($this->shift);
        $this->shiftType = $this->shift->label();

        $this->dispatch('deleteModalToggle');

    }


    public function delete()
    {
        try{
            $shift = ShiftType::where('id',$this->shift->id)->first();

            $shiftType = ShiftType::where('id',$this->shift->id)->first();
  
                $shiftType->delete();


                $this->dispatch('deleteModalToggle');

                $this->dispatch('refreshData')->to(DisplayShiftsTypes::class);

                $this->dispatch(
                'alert',
                    text: trans('admin.shift_type_deleted_successfully'),
                    icon: 'success',
                    confirmButtonText: trans('admin.done'),

            );
            
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }


    }
    public function render()
    {
        return view('livewire.shifts-types.delete-shift-type');
    }
}

