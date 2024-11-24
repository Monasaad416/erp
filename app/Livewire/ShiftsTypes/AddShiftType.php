<?php

namespace App\Livewire\ShiftsTypes;

use Exception;
use App\Models\shift;
use Livewire\Component;
use App\Models\ShiftType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Shifts\DisplayShifts;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddShiftType extends Component
{
    public $shifts,$type,$start,$total_hours,$end;

    public function rules() {
        $types = ShiftType::types();
        return [
            'type' => 'required|numeric|in:'.implode(',',$types),
            'start' => 'required',
            'end' => 'required',
            'total_hours' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => trans('validation.type_required'),
            'type.numeric' => trans('validation.type_numeric'),
            'type.in' => trans('validation.type_in'),

            'start.required' => trans('validation.start_required'),
            'start.numeric' => trans('validation.start_numeric'),

            'end.required' => trans('validation.end_required'),
            'end.numeric' => trans('validation.end_numeric'),

            'total_hours.required' => trans('validation.total_hours_required'),
            'total_hours.numeric' => trans('validation.total_hours_numeric'),
        ];

    }


    public function create()
    {
        //dd($this->all());
        $this->validate($this->rules() ,$this->messages());
        // try {

            shiftType::create([
                'type' => $this->type,
                'start' => $this->start,
                'end' => $this->end,
                'total_hours' => $this->total_hours,
                'is_active' => 1,
                'created_by' => Auth::user()->id,
            ]);

            $this->reset(['type','start','end','total_hours']);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayShiftsTypes::class);

            $this->dispatch(
            'alert',
                text: trans('admin.shift_type_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
    //     } catch (Exception $e) {
    //         return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
    //     }
    }
    public function render()
    {
        return view('livewire.shifts-types.add-shift-type');
    }
}
