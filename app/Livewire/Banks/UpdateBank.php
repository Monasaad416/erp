<?php

namespace App\Livewire\Banks;

use Exception;
use App\Models\Bank;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Alert;

class UpdateBank extends Component
{
    protected $listeners = ['updateBank'];
    public $name_ar,$name_en,$description_en,$description_ar,$id, $bank,$is_active,$parent_id;

    public function updateBank($id)
    {
        $this->bank = Bank::findOrFail($id);

        $this->name_en = $this->bank->name_en;
        $this->name_ar = $this->bank->name_ar;

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }
    public function rules() {
        return [
            'name_ar' => ['nullable','string','max:255',Rule::unique('banks')],
            'name_en' => ['nullable','string','max:255',Rule::unique('banks')],

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
        ];

    }
    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());

        try {

            $this->bank->update($data);

            $this->reset(['name_en','name_ar',]);

            $this->dispatch('editModalToggle');

            Alert::success(trans('admin.bank_updated_successfully'));
            return redirect('banks');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.banks.update-bank');
    }
}
