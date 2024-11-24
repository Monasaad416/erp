<?php

namespace App\Livewire\Partners;

use Alert;
use App\Models\Partner;
use Livewire\Component;
use Illuminate\Validation\Rule;

class UpdatePartner extends Component
{
  protected $listeners = ['updatePartner'];
    public  $name_ar,$name_en,$email,$phone,$address,$id,$balance_state,$start_balance,$current_balance,$patrner,$pos;

    public function updatePartner($id)
    {
        $this->patrner = Partner::findOrFail($id);

        $this->email = $this->patrner->email;
        $this->name_en = $this->patrner->name_en;
        $this->name_ar = $this->patrner->name_ar;
        $this->phone = $this->patrner->phone;
        $this->address = $this->patrner->address;

        $this->resetValidation();

        $this->dispatch('editModalToggle');
    }

    public function rules() {
        return [
            'name_ar' => ['nullable','string','max:255',Rule::unique('partners')->ignore($this->patrner->id, 'id')],
            'name_en' => ['nullable','string','max:255',Rule::unique('partners')->ignore($this->patrner->id, 'id')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('partners')->ignore($this->patrner->id, 'id')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
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

            'email.string' => trans('validation.email_string'),
            'email.email' => trans('validation.email_email'),
            'email.max' => trans('validation.email_max'),
            'email.unique' => trans('validation.email_unique'),

            'address.string' => trans('validation.address_string'),
            'phone.string' => trans('validation.phone_string'),
        ];

    }

    public function update()
    {
            $data = $this->validate($this->rules() ,$this->messages());

        // try {

            $this->patrner->update($data);

            $this->reset(['name_ar','name_en','email','phone','address']);

            $this->dispatch('editModalToggle');


            $this->reset(['name_en','name_ar','email','address','phone']);

            $this->dispatch('editModalToggle');

            Alert::success('تم تعديل معلومات الشريك بنجاح');
            return redirect()->route('partners');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }

    public function render()
    {
        return view('livewire.partners.update-partner');
    }
}
