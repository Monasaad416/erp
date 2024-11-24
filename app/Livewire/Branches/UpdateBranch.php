<?php

namespace App\Livewire\Branches;
use Exception;
use App\Models\Branch;
use Livewire\Component;

use Illuminate\Validation\Rule;
use App\Livewire\Branches\DisplayBranches;
use Alert;

class UpdateBranch extends Component
{
    public $branch,$branch_num,$street_name_ar,$street_name_en,$name_ar,$name_en,$gln,$email,$phone
    ,$city_ar,$city_en,$region_ar,$region_en,$building_number,$plot_identification,$postal_code,$is_active,$id;

    protected $listeners = ['updateBranch'];

    public function updateBranch($id)
    {

        $this->branch = Branch::findOrFail($id);
        $this->name_en = $this->branch->name_en;
        $this->name_ar = $this->branch->name_ar;
        $this->street_name_en = $this->branch->street_name_en;
        $this->street_name_ar = $this->branch->street_name_ar;
        $this->city_en = $this->branch->city_en;
        $this->city_ar = $this->branch->city_ar;
        $this->region_en = $this->branch->region_en;
        $this->region_ar = $this->branch->region_ar;
        $this->branch_num = $this->branch->branch_num;
        $this->gln = $this->branch->gln;
        $this->email = $this->branch->email;
        $this->phone = $this->branch->phone;
        $this->is_active = $this->branch->is_active;
        $this->building_number = $this->branch->building_number;
        $this->plot_identification = $this->branch->plot_identification;
        $this->postal_code = $this->branch->postal_code;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }
    public function rules() {
        return [
            'name_ar' => ['nullable','string','max:100',Rule::unique('branches')->ignore($this->branch->id, 'id')],
            'name_en' => ['nullable','string','max:100',Rule::unique('branches')->ignore($this->branch->id, 'id')],
            'street_name_ar' => 'nullable|string',
            'street_name_en' => 'nullable|string',
            'gln' => ['nullable','string','gln_length',Rule::unique('branches')->ignore($this->branch->id, 'id')],
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'branch_num' => 'nullable|numeric',
            'city_ar' => 'nullable|string',
            'city_en' => 'nullable|string',
            'region_ar' => 'nullable|string',
            'region_en' => 'nullable|string',
            'plot_identification' => 'nullable|string',
            'postal_code' => 'nullable|string|postal_code_length',
            'building_number' => 'nullable|string|building_number_length',

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

            'street_name_ar.nullable' => 'اسم الشارع باللغة العربية مطلوب',
            'street_name_ar.string' => 'اسم الشارع باللغة العربية لابد ان يتكون من احرف',
            'street_name_en.string' => 'اسم الشارع باللغة الانجليزية لابد ان يتكون من احرف',

            'city_ar.nullable' => 'اسم الشارع باللغة العربية مطلوب',
            'city_ar.string' => 'اسم الشارع باللغة العربية لابد ان يتكون من احرف',
            'city_en.string' => 'اسم الشارع باللغة الانجليزية لابد ان يتكون من احرف',

            'region_ar.nullable' => 'اسم الشارع باللغة العربية مطلوب',
            'region_ar.string' => 'اسم الشارع باللغة العربية لابد ان يتكون من احرف',
            'region_en.string' => 'اسم الشارع باللغة الانجليزية لابد ان يتكون من احرف',
            'building_number.nullable' => 'رقم المبني مطلوب',
            'building_number.string' => 'ادخل صيغة صحيحة لرقم المبني',
            'building_number.building_number_length' => 'رقم المبني المرتبط بعنوان البائع يجب أن يتكون من اربع ارقام ',

            'plot_identification.nullable' => 'الرقم الفرعي مطلوب مطلوب',
            'plot_identification.string' => 'ادخل صيغة صحيحة للرقم الفرعي',

            'postal_code.nullable' => 'الرقم البريدي باللغة العربية مطلوب',
            'postal_code.string' => 'الرقم البريدي يجب ان يكون رقم',
            'postal_code.postal_code_length' => 'الرمز البريدي يجب أن يتكون من خمسه ارقام ',

            'gln.string' => trans('validation.gln_string'),
            'gln.gln_length' => trans('validation.gln_length'),

            'email.email' => trans('validation.email_email'),
            'phone.string' => trans('validation.phone_string'),

            // 'branch_num.nullable' => trans('validation.branch_num_nullable'),
            'branch_num.numeric' => trans('validation.branch_num_numeric'),

        ];
    }

        public function update()
        {
            $data = $this->validate($this->rules() ,$this->messages());
            try {


                $this->branch->update($data);

                $this->reset(['name_en','name_ar','street_name_ar','street_name_en','branch_num','email','phone','gln','is_active']);

                $this->dispatch('editModalToggle');

                // $this->dispatch('refreshData')->to(DisplayBranches::class);

                // $this->dispatch(
                // 'alert',
                //     text: trans('admin.branch_updated_successfully'),
                //     icon: 'success',
                //     confirmButtonText: trans('admin.done')

                // );
                    Alert::success('تم تعديل بيانات الفرع بنجاح');
                    return redirect('branches');
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
            }
        }


    public function render()
    {
        return view('livewire.branches.update-branch');
    }
}
