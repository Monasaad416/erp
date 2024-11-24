<?php

namespace App\Livewire\Units;

use Exception;
use App\Models\Unit;
use Livewire\Component;
use Illuminate\Validation\Rule;

class AddUnit extends Component
{
    public $name_ar,$name_en,$id;

    public function rules() {
        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units')
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('units')
            ],
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => trans('validation.name_ar_required'),
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),

            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),
        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        try {

        // return dd($this->all());



            Unit::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
            ]);

            $this->reset(['name_ar','name_en']);



            //dispatch browser events (js)
            //add event to toggle create modal after save
            $this->dispatch('createModalToggle');


            //refrsh data after adding new row
            $this->dispatch('refreshData')->to(DisplayUnits::class);

            $this->dispatch(
            'alert',
                text: trans('admin.unit_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        }



    }


    public function render()
    {
        return view('livewire.units.add-unit');
    }
}
