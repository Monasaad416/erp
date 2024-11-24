<?php

namespace App\Livewire\Stores;

use Exception;
use Livewire\Component;
use App\Models\Store;
use Illuminate\Validation\Rule;
use App\Livewire\Stores\DisplayStores;

class Updatestore extends Component
{
    protected $listeners = ['updateStore'];

     public $store,$stores,$name_ar,$name_en,$is_parent=0,$branch_id,$address_ar,$address_en,$id,$is_active=0;


    public function updateStore($id)
    {
        $this->store = Store::findOrFail($id);

        $this->name_en = $this->store->name_en;
        $this->name_ar = $this->store->name_ar;
        $this->address_en = $this->store->address_en;
        $this->address_ar = $this->store->address_ar;
        $this->is_active = $this->store->is_active;
        $this->is_parent = $this->store->is_parent;
        $this->branch_id = $this->store->branch_id;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }
    public function rules() {
        return [
            'name_ar' => ['nullable','string', 'max:255',Rule::unique('stores')->ignore($this->store->id, 'id')],
            'name_en' => ['nullable','string','max:255',Rule::unique('stores')->ignore($this->store->id, 'id')],
            'address_ar' => ['nullable','string', 'max:255'],
            'address_en' => ['nullable','string','max:255'],
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

            'addtess_ar.string' => trans('validation.addtess_ar_string'),
            'addtess_ar.max' => trans('validation.addtess_ar_max'),
            'addtess_ar.unique' => trans('validation.addtess_ar_unique'),

            'addtess_en.string' => trans('validation.addtess_en_string'),
            'addtess_en.max' => trans('validation.addtess_en_max'),
            'addtess_en.unique' => trans('validation.addtess_en_unique'),

            'branch_id.nullable_if' => 'الفرع مطلوب في حالة المخزن الفرعي',
            'branch_id.exists' => 'الفرع الذي تم ادخالة غير مسجل بقاعدة البيانات',

            // 'is_parent.nullable_if' => 'المخزن يجب ان تكون رئيسي في حالة عدم وجود فرع',
        ];

    }








    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        // try {

            $this->store->update($data);

            $this->reset(['name_en','name_ar','is_active','is_parent']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayStores::class);

            $this->dispatch(
            'alert',
                text: trans('تم تعديل بيانات المخزن بنجاح'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.stores.update-store');
    }
}
