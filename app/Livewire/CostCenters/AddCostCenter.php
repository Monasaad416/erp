<?php

namespace App\Livewire\CostCenters;

use Exception;
use Livewire\Component;
use App\Models\CostCenter;
use Illuminate\Validation\Rule;
use Alert;

class AddCostCenter extends Component
{
    public $code,$name_ar,$name_en,$parent_id,$is_parent;
    public static function getNextCode()
    {
        $costCenter = CostCenter::latest()->first();
        $code = $costCenter ? $costCenter->code : null;
        if($code) {
            return $code + 1;
        }

        return  '1';
    }

    public function mount()
    {
        $this->code = $this->getNextCode();
    }

        public function rules() {
        return [
            'name_ar' => ['required','string','max:255', Rule::unique('cost_centers')],
            'name_en' => ['nullable','string','max:255',Rule::unique('cost_centers')],
            'parent_id' => "nullable|exists:cost_centers,id",
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

            'parent_id.exists' => trans('validation.parent_id_exists'),
        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        try {

            CostCenter::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'code' => $this->getNextCode(),
                'parent_id' => $this->parent_id ? $this->parent_id :null,
                'is_parent' => $this->is_parent ,
            ]);

            $this->reset(['name_ar','name_en','code','parent_id']);

            $this->dispatch('createModalToggle');

            // $this->dispatch('refreshData')->to(DisplayCostCenters::class);

            // $this->dispatch(
            // 'alert',
            //     text: 'تم إضافة مركز تكلفة جديد بنجاح',
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done')
            // );

            Alert::success('تم إضافة مركز تكلفة جديد بنجاح');
            return redirect()->route('cost.centers');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.cost-centers.add-cost-center');
    }
}
