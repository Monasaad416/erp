<?php

namespace App\Livewire\AccountsTypes;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\AccountType;

class UpdateAccountType extends Component
{
    protected $listeners = ['updateAccountType'];
    public $name_ar,$name_en,$notes,$is_active,
    $account_num,$start_balance,$current_balance,
    $branch_id,$parent_id,$account_type_id,
    $created_by,$updated_by,$is_parent,$accountType;

    public function updateAccountType($id)
    {
        $this->accountType = AccountType::findOrFail($id);

        $this->name_en = $this->accountType->name_en;
        $this->name_ar = $this->accountType->name_ar;
        $this->is_active = $this->accountType->is_active;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

    public function rules() {
        return [
            'name_ar' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('account_types')->ignore($this->accountType->id, 'id')
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('account_types')->ignore($this->accountType->id, 'id')
            ]
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

        ];

    }

    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {

            $this->accountType->update($data);

            $this->reset(['name_en','name_ar']);

            $this->dispatch('editModalToggle');
            
            $this->dispatch('refreshData')->to(DisplayAccountsTypes::class);

            $this->dispatch(
            'alert',
                text: trans('admin.account_type_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.accounts-types.update-account-type');
    }
}
