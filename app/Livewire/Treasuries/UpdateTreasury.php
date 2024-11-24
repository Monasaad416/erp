<?php

namespace App\Livewire\Treasuries;

use Exception;
use Livewire\Component;
use App\Models\treasury;
use Illuminate\Validation\Rule;
use App\Livewire\Treasuries\DisplayTreasuries;

class Updatetreasury extends Component
{
    protected $listeners = ['updateTreasury'];
    
    public $treasury ,$treasuries,$name_ar,$name_en,$is_parent=0,$branch_id,$id,$is_active=0;

    public function updateTreasury($id)
    {
        $this->treasury = treasury::findOrFail($id);

        $this->name_en = $this->treasury->name_en;
        $this->name_ar = $this->treasury->name_ar;
        $this->description_en = $this->treasury->description_en;
        $this->description_ar = $this->treasury->description_ar;
        $this->is_active = $this->treasury->is_active;
        $this->is_parent = $this->treasury->is_parent;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }
   

    public function rules() {
        return [
            'name_ar' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('treasuries')->ignore($this->treasury->id, 'id')
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('treasuries')->ignore($this->treasury->id, 'id')
            ],


        ];
    }

    public function messages()
    {
        return [
            'name_ar.nullable' => trans('validation.name_ar_nullable'),
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
        $data = $this->validate($this->rules() ,$this->messages());

        // try {

            $this->treasury->update($data);

            $this->reset(['name_en','name_ar','is_active','is_parent']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayTreasuries::class);

            $this->dispatch(
            'alert',
                text: trans('تم تعديل بيانات الخزينة بنجاح'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.treasuries.update-treasury');
    }
}
