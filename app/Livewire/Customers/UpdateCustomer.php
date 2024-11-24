<?php

namespace App\Livewire\Customers;

use Exception;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Validation\Rule;

class UpdateCustomer extends Component
{
    protected $listeners = ['updateCustomer'];
    public  $name_ar,$name_en,$email,$phone,$address,$id,$balance_state,$start_balance,$current_balance,$customer,$pos;

    public function updateCustomer($id)
    {
        $this->customer = Customer::findOrFail($id);

        $this->email = $this->customer->email;
        $this->name_en = $this->customer->name_en;
        $this->name_ar = $this->customer->name_ar;
        $this->phone = $this->customer->phone;
        $this->address = $this->customer->address;
        $this->balance_state = $this->customer->balance_state;
        $this->start_balance = $this->customer->start_balance;
        $this->current_balance = $this->customer->current_balance;
        $this->pos = $this->customer->pos;

        $this->resetValidation();

        $this->dispatch('editModalToggle');
    }

    public function rules() {
        return [
            'name_ar' => ['nullable','string','max:255',Rule::unique('Customers')->ignore($this->customer->id, 'id')],
            'name_en' => ['nullable','string','max:255',Rule::unique('Customers')->ignore($this->customer->id, 'id')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('Customers')->ignore($this->customer->id, 'id')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'start_balance' =>'nullable|numeric|min:0',
            'current_balance' =>'nullable|numeric|min:0',
            'balance_state'=>'nullable|in:1,2,3',
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

            'gln.gln_length' => trans('validation.gln_length'),
            'tax_num.tax_num_length' => trans('validation.tax_num_length'),

            'start_balance.numeric' => trans('validation.start_balance_numeric'),
            'start_balance.min' => trans('validation.start_balance_min'),

            'current_balance.numeric' => trans('validation.current_balance_numeric'),
            'current_balance.min' => trans('validation.current_balance_min'),

             'balance_state.in' =>  trans('validation.balance_state_in'),

            


        ];

    }

    public function update()
    {
            $data = $this->validate($this->rules() ,$this->messages());

        // try {

            $this->customer->update($data);

            $this->reset(['name_ar','name_en','email','phone','address','balance_state','start_balance','current_balance','pos']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayCustomers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.customer_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }



    public function render()
    {
        return view('livewire.customers.update-customer');
    }
}
