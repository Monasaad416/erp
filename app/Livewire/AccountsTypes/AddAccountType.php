<?php

namespace App\Livewire\AccountsTypes;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\AccountType;

class AddAccountType extends Component
{
    public $name_ar,$name_en,$is_active,$id;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:100',Rule::unique('account_types')],
            'name_en' => ['nullable','string','max:100',Rule::unique('account_types')],

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

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        try {
            AccountType::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'is_active' => 1,
            ]);

            $this->reset(['name_ar','name_en']);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayAccountsTypes::class);

            $this->dispatch(
            'alert',
                text: trans('admin.account_type_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }

    }
    public function render()
    {
        return view('livewire.accounts-types.add-account-type');
    }
}
