<?php

namespace App\Livewire\Customers;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\Customer;
use App\Models\AccountType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Customers\DisplayCustomers;

class AddCustomer extends Component
{
    public $name_ar,$name_en,$email,$phone,$address,$gln,$id,
    $tax_num,$balance_state,$start_balance=0,$current_balance=0,$customer;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('customers')],
            'name_en' => ['nullable','string','max:255',Rule::unique('customers')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('customers')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'gln' => ['nullable','gln_length',Rule::unique('customers')],
            'tax_num' => 'nullable|tax_num_length',
            // 'start_balance' =>'required|numeric|min:0',
            // 'current_balance' =>'required|numeric|min:0',
            // 'balance_state'=>'required|in:1,2,3',
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

            // 'start_balance.required' => trans('validation.start_balance_required'),
            // 'start_balance.numeric' => trans('validation.start_balance_numeric'),
            // 'start_balance.min' => trans('validation.start_balance_min'),

            // 'current_balance.required' => trans('validation.current_balance_required'),
            // 'current_balance.numeric' => trans('validation.current_balance_numeric'),
            // 'current_balance.min' => trans('validation.current_balance_min'),

            // 'balance_state.required' =>  trans('validation.balance_state_required'),
            // 'balance_state.in' =>  trans('validation.balance_state_in')
        ];

    }





    public function create()
    {
          $this->validate($this->rules() ,$this->messages());
          // DB::beginTransaction();
        // try {


        $currentChildAccountNum = 0;

        $customersParentAccount = Account::where('name_ar',"العملاء")->first();
        $latestAccountChild = Account::where('parent_id', $customersParentAccount->id)->latest()->first();
        if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num;
        } else {

            $currentChildAccountNum = $customersParentAccount->account_num . '0';
        }



            $customerssParentAccount = Account::where('name_ar',"العملاء")->first();

            $customer = Customer::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'email' => $this->email == "" ? null: $this->email,
                'address' => $this->address,
                'phone' => $this->phone,
                'account_num' => $currentChildAccountNum + 1,
                'balance_state' => 1,
                'start_balance' => 0,
                'current_balance' => 0,
                'code' => getNextCustomerCode(),
            ]);


            $account = Account::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'start_balance' => 0,
                'current_balance' => 0,
                'account_num' => $customer->account_num,
                'account_type_id' => 6,
                'parent_id' => $customerssParentAccount->id,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'level' => $customerssParentAccount->level +1,
                'is_active' => 1 ,
                'is_parent' => 0,
                'nature' => "مدين",
                'list' => "مركز-مالي",
                'branch_id' => $this->branch_id,
            ]);


            Ledger::create([
                'name_ar' => $customer->name_ar,
                'account_id' => $account->id,
                'account_num' => $account->account_num,
                'created_by' => Auth::user()->id,
                'date' => Carbon::now(),
            ]);


            $this->reset(['name_en','name_ar','email','address','phone','current_balance','start_balance','balance_state']);

            $this->dispatch('createModalToggle');

           Alert::success('تم إضافة عميل جديد بنجاح');
           return redirect()->route('customers');
            //DB::commit();
        // } catch (Exception $e) {
        //      DB::rollback();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.customers.add-customer');
    }
}
