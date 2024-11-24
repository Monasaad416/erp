<?php

namespace App\Livewire\Stores;

use Exception;
use Livewire\Component;
use App\Models\Store;
use Illuminate\Validation\Rule;
use App\Livewire\stores\DisplayStores;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddStore extends Component
{
    public $stores,$name_ar,$name_en,$is_parent,$branch_id,$address_ar,$address_en,$id,$is_active;

    public function rules() {
        return [
            'name_ar' => ['required','string', 'max:255',Rule::unique('stores')],
            'name_en' => ['nullable','string','max:255',Rule::unique('stores')],
            'address_ar' => ['required','string', 'max:255',Rule::unique('stores')],
            'address_en' => ['nullable','string','max:255',Rule::unique('stores')],
            'branch_id' => 'required_without:is_parent',
            'is_parent' => 'required_without:branch_id',


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

            'addtess_ar.string' => trans('validation.addtess_ar_string'),
            'addtess_ar.max' => trans('validation.addtess_ar_max'),
            'addtess_ar.unique' => trans('validation.addtess_ar_unique'),

            'addtess_en.string' => trans('validation.addtess_en_string'),
            'addtess_en.max' => trans('validation.addtess_en_max'),
            'addtess_en.unique' => trans('validation.addtess_en_unique'),

            'branch_id.required_if' => 'الفرع مطلوب في حالة المخزن الفرعي',
            'branch_id.exists' => 'الفرع الذي تم ادخالة غير مسجل بقاعدة البيانات',
        
            'is_parent.required_if' => 'المخزن يجب ان تكون رئيسي في حالة عدم وجود فرع',
        ];

    }


    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        // try {

            Store::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'address_ar' => $this->address_ar,
                'address_en' => $this->address_en,
                'branch_id' => $this->branch_id == "" ? null :  $this->branch_id ,
                'is_parent' => $this->is_parent,
                'is_active' => 1,
            ]);

            $this->reset(['name_ar','name_en','address_ar','address_en','branch_id','is_parent','is_active' ]);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayStores::class);

            $this->dispatch(
            'alert',
                text: 'تم إضافة مخزن جديد بنجاح',
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.stores.add-store');
    }
}
