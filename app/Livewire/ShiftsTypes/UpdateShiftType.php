<?php

namespace App\Livewire\ShiftsTypes;

use Exception;
use Livewire\Component;
use App\Models\Category;
use App\Models\ShiftType;
use Illuminate\Validation\Rule;
use App\Livewire\ShiftsType\DisplayShifts;

class UpdateShiftType extends Component
{
    protected $listeners = ['updateShift'];
    public $shiftType,$shift,$type,$start,$end,$total_hours;

    public function updateShift($id)
    {
        $this->shiftType = ShiftType::findOrFail($id);

        $this->type = $this->shiftType->type;
        $this->start = $this->shiftType->start;
        $this->end = $this->shiftType->end;
        $this->total_hours = $this->shiftType->total_hours;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }



    public function rules() {
        $types = ShiftType::types();
        return [
            'type' => 'nullable|numeric|in:'.implode(',',$types),
            'start' => 'nullable',
            'end' => 'nullable',
            'total_hours' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'type.nullable' => trans('validation.type_nullable'),
            'type.numeric' => trans('validation.type_numeric'),
            'type.in' => trans('validation.type_in'),

            'start.nullable' => trans('validation.start_nullable'),
            'start.numeric' => trans('validation.start_numeric'),

            'end.nullable' => trans('validation.end_nullable'),
            'end.numeric' => trans('validation.end_numeric'),

            'total_hours.nullable' => trans('validation.total_hours_nullable'),
            'total_hours.numeric' => trans('validation.total_hours_numeric'),
        ];

    }


    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        // try {

            $this->shiftType->update($data);

            $this->reset(['type','start','end','total_hours']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayShiftsTypes::class);

            $this->dispatch(
            'alert',
                text: trans('admin.shift_type_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.shifts-types.update-shift-type');
    }
}
