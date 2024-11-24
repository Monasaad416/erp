<?php

namespace App\Livewire\Partners;

use Alert;
use App\Models\Account;
use App\Models\Partner;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddPartner extends Component
{
    public $name_ar,$name_en,$email,$phone,$address,$balance_state,$start_balance=0,$current_balance=0;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('partners')],
            'name_en' => ['nullable','string','max:255',Rule::unique('partners')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('partners')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
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

            'email.string' => trans('validation.email_string'),
            'email.email' => trans('validation.email_email'),
            'email.max' => trans('validation.email_max'),
            'email.unique' => trans('validation.email_unique'),

            'address.string' => trans('validation.address_string'),
            'phone.string' => trans('validation.phone_string'),

        ];

    }





    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        // try {


            DB::beginTransaction();

            $partner = new Partner();
            $partner->name_ar = $this->name_ar;
            $partner->name_en = $this->name_en;
            $partner->email = $this->email == "" ? null: $this->email;
            $partner->address = $this->address;
            $partner->phone = $this->phone;
            $partner->created_by = Auth::user()->id;
            $partner->save();



            DB::commit();

            $this->reset(['name_en','name_ar','email','address','phone']);

            $this->dispatch('createModalToggle');

            Alert::success('تم حفظ معلومات الشريك بنجاح');
            return redirect()->route('partners');

        // } catch (Exception $e) {
            //DB::rollBack();
        //   //return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.partners.add-partner');
    }
}
