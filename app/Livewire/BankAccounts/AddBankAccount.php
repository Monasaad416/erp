<?php

namespace App\Livewire\BankAccounts;

use Alert;
use App\Models\Bank;
use Livewire\Component;
use App\Models\BankAccount;
use Illuminate\Validation\Rule;

class AddBankAccount extends Component
{
    public $bank_id,$id,$accountable_type,$user_id,$supplier_id,$bank_account_num;

    public function rules() {
        return [
            'accountable_type' => 'required',
            'user_id' => 'required_if:supplier_id,null', 
            'supplier_id' => 'required_if:user_id,null', 
            'bank_id' => 'required|exists:banks,id',
            'bank_account_num' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'accountable_type.required' => 'حدد الحساب يتبع لاي مستفيد',
            'account_num.exists' => ' رقم الحساب الذي تم إدخاله غير موجود بالشجرة بالمحاسبية ',
             'user_d.required_id' => 'اسم الموظف مطلوب  ',
            'supplier_id.required_id' => 'اسم المورد مطلوب  ',
            'bank_id.required' => 'إسم البنك مطلوب',
            'bank_id.exists' => 'إسم البنك الذي تم إدخاله غير مسجل بقاعدة البيانات',

            'bank_account_num.required' => 'رقم الحساب البنكي مطلوب',
            'bank_account_num.string' => 'ادخل صيغة صحيحة لرقم الحساب',
        ];

    }


    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        // try {


            $bankAccount = BankAccount::create([
                'accountable_type' => $this->accountable_type == "supplier" ? 'App\Models\Supplier' : 'App\Models\User', 
                'accountable_id' => $this->accountable_type == "supplier" ? $this->supplier_id : $this->user_id ,
                'bank_id' => $this->bank_id,
                'bank_account_num' => $this->bank_account_num,
            ]);




                Alert::success('تم إضافة حساب بنكي جديد بنجاح');
                return redirect()->route('banks.accounts');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }

    public function render()
    {
        return view('livewire.bank-accounts.add-bank-account');
    }
}
