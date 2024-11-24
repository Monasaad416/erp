<?php

namespace App\Livewire\Suppliers;

use Exception;
use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Validation\Rule;

class UpdateSupplier extends Component
{
    protected $listeners = ['updateSupplier'];
    public  $name_ar,$name_en,$email,$phone,$address,$gln,$id,$tax_num,$balance_state,$start_balance,$current_balance,$supplier;

    public function updateSupplier($id)
    {
        $this->supplier = Supplier::findOrFail($id);

        $this->email = $this->supplier->email;
        $this->name_en = $this->supplier->name_en;
        $this->name_ar = $this->supplier->name_ar;
        $this->phone = $this->supplier->phone;
        $this->address = $this->supplier->address;
        $this->gln = $this->supplier->gln;
         $this->tax_num = $this->supplier->tax_num;
         $this->balance_state = $this->supplier->balance_state;
         $this->start_balance = $this->supplier->start_balance;
         $this->current_balance = $this->supplier->current_balance;



        $this->resetValidation();

        $this->dispatch('editModalToggle');
    }

    public function rules() {
        return [
            'name_ar' => ['nullable','string','max:255',Rule::unique('suppliers')->ignore($this->supplier->id, 'id')],
            'name_en' => ['nullable','string','max:255',Rule::unique('suppliers')->ignore($this->supplier->id, 'id')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('suppliers')->ignore($this->supplier->id, 'id')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'gln' => ['nullable','gln_length',Rule::unique('suppliers')->ignore($this->supplier->id, 'id')],
            'tax_num' => 'nullable|tax_num_length',
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

        try {

            $this->supplier->update($data);

            $this->reset(['name_ar','name_en','email','phone','address','gln','tax_num','balance_state','start_balance','current_balance']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplaySuppliers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.supplier_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }



    public function render()
    {
        return view('livewire.suppliers.update-supplier');
    }
}
