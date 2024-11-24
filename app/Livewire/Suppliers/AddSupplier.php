<?php

namespace App\Livewire\Suppliers;

use Exception;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\AccountType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Suppliers\DisplaySuppliers;

class AddSupplier extends Component
{
    public $name_ar,$name_en,$email,$phone,$address,$gln,$id,
    $tax_num,$balance_state,$start_balance=0,$current_balance=0,$supplier;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('suppliers')],
            'name_en' => ['nullable','string','max:255',Rule::unique('suppliers')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('suppliers')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'gln' => ['nullable','gln_length',Rule::unique('suppliers')],
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

            'gln.gln_length' => trans('validation.gln_length'),
            'tax_num.tax_num_length' => trans('validation.tax_num_length'),

            // 'start_balance.required' => trans('validation.start_balance_required'),
            // 'start_balance.numeric' => trans('validation.start_balance_numeric'),
            // 'start_balance.min' => trans('validation.start_balance_min'),

            // 'current_balance.required' => trans('validation.current_balance_required'),
            // 'current_balance.numeric' => trans('validation.current_balance_numeric'),
            // 'current_balance.min' => trans('validation.current_balance_min'),

            // 'balance_state.required' =>  trans('validation.balance_state_required'),
            // 'balance_state.in' =>  trans('validation.balance_state_in'),


        ];

    }

    public function create()
    {
          $this->validate($this->rules() ,$this->messages());
        DB::beginTransaction();
        try {


        $currentChildAccountNum = 0;

        $suppliersParentAccount = Account::where('name_ar',"دائنون")->first();
        $latestAccountChild = Account::where('parent_id', $suppliersParentAccount->id)->latest()->first();
        if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num;
        } else {

            $currentChildAccountNum = $suppliersParentAccount->account_num . '0';
        }


            $suppliersParentAccount = Account::where('name_ar',"دائنون")->first();

            $supplier = Supplier::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'email' => $this->email == "" ? null: $this->email,
                'address' => $this->address,
                'phone' => $this->phone,
                'tax_num' => $this->tax_num == "" ? null: $this->tax_num,
                'account_num' => $currentChildAccountNum + 1,
                'gln' => $this->gln == "" ? null: $this->gln,
                'balance_state' =>'متزن',
                'start_balance' => 0,
                'current_balance' => 0,
            ]);


            $account = new Account();
            $account->name_ar = $supplier->name_ar;
            $account->start_balance = 0;
            $account->current_balance = 0;
            $account->account_num = $supplier->account_num;
            $account->account_type_id = 7;
            $account->parent_id = $suppliersParentAccount->id;
            $account->nature = "دائن";
            $account->list = "مركز-مالي";
            $account->created_by = $supplier->id;
            $account->updated_by = $supplier->id;
            $account->is_active = 1;
            $account->level = $suppliersParentAccount->level + 1;
            $account->branch_id = $supplier->branch_id;
            $account->is_parent = 0;
            $account->save();

            Ledger::create([
                'name_ar' => $supplier->name_ar,
                'account_id' => $account->id,
                'account_num' => $account->account_num,
                'created_by' => Auth::user()->id,
                'date' => Carbon::now(),
            ]);


            $this->reset(['name_en','name_ar','email','address','phone','current_balance','start_balance','gln','balance_state','tax_num' ]);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplaySuppliers::class);

            $this->dispatch(
            'alert',
                text: trans('admin.supplier_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );

           DB::commit();
        } catch (Exception $e) {
             DB::rollback();
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }
    public function render()
    {
        return view('livewire.suppliers.add-supplier');
    }
}
