<?php

namespace App\Livewire\Branches;

use Exception;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Alert;
class AddBranch extends Component
{
    public $branch_num,$street_name_ar,$street_name_en,$name_ar,$name_en,$gln,$email,$phone,$is_active,$id,
    $city_ar,$city_en,$region_ar,$region_en,$building_number,$postal_code,$plot_identification;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:100',Rule::unique('branches')],
            'name_en' => ['nullable','string','max:100',Rule::unique('branches')],
            'street_name_ar' => 'required|string',
            'street_name_en' => 'nullable|string',
            'gln' => ['nullable','string','gln_length',Rule::unique('branches')],
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'branch_num' => 'required|numeric',
            'city_ar' => 'required|string',
            'city_en' => 'nullable|string',
            'region_ar' => 'required|string',
            'region_en' => 'nullable|string',
            'plot_identification' => 'required|string',
            'postal_code' => 'required|string|postal_code_length',
            'building_number' => 'required|string|building_number_length',

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

            'street_name_ar.required' => 'اسم الشارع باللغة العربية مطلوب',
            'street_name_ar.string' => 'اسم الشارع باللغة العربية لابد ان يتكون من احرف',
            'street_name_en.string' => 'اسم الشارع باللغة الانجليزية لابد ان يتكون من احرف',

            'city_ar.required' => 'اسم الشارع باللغة العربية مطلوب',
            'city_ar.string' => 'اسم الشارع باللغة العربية لابد ان يتكون من احرف',
            'city_en.string' => 'اسم الشارع باللغة الانجليزية لابد ان يتكون من احرف',

            'region_ar.required' => 'اسم الشارع باللغة العربية مطلوب',
            'region_ar.string' => 'اسم الشارع باللغة العربية لابد ان يتكون من احرف',
            'region_en.string' => 'اسم الشارع باللغة الانجليزية لابد ان يتكون من احرف',
            'building_number.required' => 'رقم المبني مطلوب',
            'building_number.string' => 'ادخل صيغة صحيحة لرقم المبني',
            'building_number.building_number_length' => 'رقم المبني المرتبط بعنوان البائع يجب أن يتكون من اربع ارقام ',

            'plot_identification.required' => 'الرقم الفرعي مطلوب مطلوب',
            'plot_identification.string' => 'ادخل صيغة صحيحة للرقم الفرعي',

            'postal_code.required' => 'الرقم البريدي باللغة العربية مطلوب',
            'postal_code.string' => 'الرقم البريدي يجب ان يكون رقم',
            'postal_code.postal_code_length' => 'الرمز البريدي يجب أن يتكون من خمسه ارقام ',

            'gln.string' => trans('validation.gln_string'),
            'gln.gln_length' => trans('validation.gln_length'),

            'email.email' => trans('validation.email_email'),
            'phone.string' => trans('validation.phone_string'),

            // 'branch_num.required' => trans('validation.branch_num_required'),
            'branch_num.numeric' => trans('validation.branch_num_numeric'),

        ];
    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        //dd($this->all());

        // try {
            Branch::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'street_name_ar' => $this->street_name_ar,
                'street_name_en' => $this->street_name_en,
                'city_ar' => $this->city_ar,
                'city_en' => $this->city_en,
                'region_ar' => $this->region_ar,
                'region_en' => $this->region_en,
                'building_number' => $this->building_number,
                'plot_identification' => $this->plot_identification,
                'postal_code' => $this->postal_code,
                'gln' => $this->gln == "" ? null : $this->gln,
                'phone' => $this->phone,
                'email' => $this->email,
                'branch_num' => $this->branch_num,
                'is_active' => 1,
            ]);

            $this->reset(['name_ar','name_en','street_name_ar','street_name_en','gln',
            'phone','email','branch_num','is_active','city_en','city_ar','region_en','region_ar',
            'building_number','plot_identification','postal_code']);

            $this->dispatch('createModalToggle');

            // $this->dispatch('refreshData')->to(DisplayBranches::class);

            // $this->dispatch(
            // 'alert',
            //     text: trans('admin.branch_created_successfully'),
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done')
            // );
            Alert::success('تم إضافة فرع جديد بنجاح');
            return redirect('branches');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }

    }


    public function render()
    {
        return view('livewire.branches.add-branch');
    }
}
