<?php

namespace App\Livewire\CostCenters;

use Exception;
use Livewire\Component;
use App\Models\CostCenter;
use Illuminate\Validation\Rule;
use Alert;

class UpdateCostCenter extends Component
{
    protected $listeners = ['updateCenter'];
    public $code,$name_ar,$name_en,$parent_id,$is_parent=0,$center;

    public function updateCenter($id)
    {
        $this->center = CostCenter::findOrFail($id);

        $this->name_en = $this->center->name_en;
        $this->name_ar = $this->center->name_ar;
        $this->code = $this->center->code;
        $this->is_parent = $this->center->is_parent;
        $this->parent_id = $this->center->parent_id;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

        public function rules() {
        return [
            'name_ar' => ['nullable','string','max:255', Rule::unique('cost_centers')->ignore($this->center->id, 'id')],
            'name_en' => ['nullable','string','max:255',Rule::unique('cost_centers')->ignore($this->center->id, 'id')],
            'parent_id' => "nullable|exists:cost_centers,id",
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

            'parent_id.exists' => trans('validation.parent_id_exists'),
        ];

    }

    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {

            $this->center->update($data);

            $this->reset(['name_en','name_ar','code','parent_id','is_parent']);

            $this->dispatch('editModalToggle');

            // $this->dispatch('refreshData')->to(DisplayCostCenters::class);

            // $this->dispatch(
            // 'alert',
            //     text: 'تم تعديل مركز التكلفة بنجاح',
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done')

            // );

            Alert::succes('تم تعديل مركز التكلفة بنجاح');
            return redirect()->route('cost.centers');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.cost-centers.update-cost-center');
    }
}
