<?php

namespace App\Livewire\Units;

use Exception;
use App\Models\Unit;
use Livewire\Component;
use Illuminate\Validation\Rule;

class UpdateUnit extends Component
{
    protected $listeners = ['updateUnit'];
    public $name_en,$name_ar, $unit;

    public function updateUnit($id)
    {
        $this->unit = Unit::findOrFail($id);

        $this->name_en = $this->unit->name_en;
        $this->name_ar = $this->unit->name_ar;



        //return dd($this->is_active);

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('editModalToggle');

    }

    public function rules() {
        return [
            'name_ar' => [
                'string',
                'max:255',
                Rule::unique('units')->ignore($this->unit->id, 'id')
            ],
            'name_en' => [
                'string',
                'max:255',
                Rule::unique('units')->ignore($this->unit->id, 'id')
            ],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),

            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),
        ];

    }

    public function update()
    {
        try {
            $data = $this->validate($this->rules() ,$this->messages());



            $this->unit->update($data);

            $this->reset(['name_en','name_ar']);
            //dispatch browser events (js)
            //add event to toggle update modal after save
            $this->dispatch('editModalToggle');

            //refrsh data after adding update row
            $this->dispatch('refreshData')->to(DisplayUnits::class);

            $this->dispatch(
            'alert',
                text: trans('admin.unit_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        }
    }
    public function render()
    {
        return view('livewire.units.update-unit');
    }
}
