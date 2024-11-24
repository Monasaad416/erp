<?php

namespace App\Livewire\Accounts;

use Exception;
use App\Models\Bank;
use App\Models\Account;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Treasury;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Accounts\DisplayAccounts;
use App\Models\User;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UpdateAccount extends Component
{
    protected $listeners = ['updateAccount'];

    public $name_ar,$name_en,$notes,$is_active,
    $account_num,$start_balance,$current_balance,
    $branch_id,$parent_id,$account_type_id,
    $created_by,$updated_by,$account,$is_parent = 0,$parent_account_num;



    public function updateAccount($id)
    {
        $this->account = Account::findOrFail($id);

        $this->name_en = $this->account->name_en;
        $this->name_ar = $this->account->name_ar;
        $this->notes = $this->account->notes;
        $this->account_num = $this->account->account_num;
        $this->start_balance = $this->account->start_balance;
        $this->current_balance = $this->account->current_balance;
        $this->branch_id = $this->account->branch_id;
        $this->parent_id = $this->account->parent_id;
        $this->account_type_id = $this->account->account_type_id;
        $this->name_en = $this->account->name_en;
        $this->name_ar = $this->account->name_ar;
        $this->is_active = $this->account->is_active;
        $this->is_parent = $this->account->is_parent;
        $this->parent_account_num = $this->account->parent_account_num;

        //  'parent_account_num' => $this->parent_id ? Account::where('id',$this->parent_id)->account_num : null,

        $this->resetValidation();

        $this->dispatch('editModalToggle');

    }

    public function rules() {
        return [
            'name_ar' => ['required','string','max:100',Rule::unique('accounts')->ignore($this->account->id, 'id')],
            'name_en' => ['nullable','string','max:100',Rule::unique('accounts')->ignore($this->account->id, 'id')],
            'notes' =>'nullable|string',
            // 'account_num' =>'required|numeric|min:0',
            'start_balance' =>'required|numeric|min:0',
            'current_balance' =>'required|numeric|min:0',
            'account_type_id' => 'required|exists:account_types,id',
            // 'branch_id'=> 'required|exists:branches,id',
            'parent_id'=> 'nullable|exists:accounts,id',
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

            // 'account_num.required' => trans('validation.account_num_required'),
            // 'account_num.numeric' => trans('validation.account_num_numeric'),
            // 'account_num.min' => trans('validation.account_num_min'),

            'start_balance.required' => trans('validation.start_balance_required'),
            'start_balance.numeric' => trans('validation.start_balance_numeric'),
            'start_balance.min' => trans('validation.start_balance_min'),

            'current_balance.required' => trans('validation.current_balance_required'),
            'current_balance.numeric' => trans('validation.current_balance_numeric'),
            'current_balance.min' => trans('validation.current_balance_min'),

            'account_type_id.required' => trans('validation.account_type_id_required'),
            'account_type_id.exists' => trans('validation.account_type_id_exists'),

            // 'branch_id.required' => trans('validation.branch_id_required'),
            // 'branch_id.exists' => trans('validation.branch_id_exists'),

            'parent_id.exists' => trans('validation.parent_account_id_exists'),

        ];
    }

    public static function getNextParentAccountNum()
    {
        $latestAccountParent = Account::where('parent_id',null)->latest()->first();
        if($latestAccountParent) {
            $currentParentAccountNum = $latestAccountParent->account_num;
            return $currentParentAccountNum + 1;
        } else {
            return '1';
        }
    }
    public function update()
    {

        $data = $this->validate($this->rules() ,$this->messages());

        try {

            // $this->account->delete();


            // if ($this->parent_id != null) {
            //     $currentChildAccountNum = '';
            //     $latestAccountChild = Account::where('parent_id', $this->parent_id)->latest()->first();
            //     if ($latestAccountChild) {
            //         $currentChildAccountNum = $latestAccountChild->account_num;
            //     } else {
            //         $parentAccountNum = Account::where('id', $this->parent_id)->first();
            //         //dd($parentAccountNum);
            //         $currentChildAccountNum = $parentAccountNum->account_num . '0';
            //     }
            // }

            // Account::create([
            //     'name_ar' => $this->name_ar,
            //     'name_en' => $this->name_en,
            //     'start_balance' => $this->start_balance,
            //     'current_balance' => $this->current_balance,
            //     'account_num' => $this->parent_id == null ? $this->getNextParentAccountNum() : $currentChildAccountNum + 1,
            //     'account_type_id' => $this->account_type_id,
            //     // 'branch_id' => $this->branch_id,
            //     'parent_id' => $this->parent_id ?? null,
            //     'notes' => $this->notes,
            //     'created_by' => Auth::user()->id,
            //     'updated_by' => Auth::user()->id,
            //     'is_active' => 1 ,
            //     'is_parent' => $this->is_parent,
            //     'parent_account_num' => $this->parent_id ? Account::where('id',$this->parent_id)->first()->account_num : null,
            // ]);


            $this->account->update($data);

            //2 خزينة
            //5 بنك
            //6 عميل
            //7 مورد
            //8 موظف
            if($this->account->account_type_id == 2 ){
                $treasury = Treasury::where('account_num',$this->account->account_num)->first();
                $treasury->current_balance = $this->account->current_balance;
                $treasury->save();
            }
            if ($this->account->account_type_id == 5) {
                $bank = Bank::where('account_num', $this->account->account_num)->first();
                $bank->current_balance = $this->account->current_balance;
                $bank->save();
            }
            if ($this->account->account_type_id == 6) {
                $customer = Customer::where('account_num', $this->account->account_num)->first();
                $customer->current_balance = $this->account->current_balance;
                $customer->save();
            }
            if ($this->account->account_type_id == 7) {
                $supplier = Supplier::where('account_num', $this->account->account_num)->first();
                $supplier->current_balance = $this->account->current_balance;
                $supplier->save();
            }
            if ($this->account->account_type_id == 8) {
                $user = User::where('account_num', $this->account->account_num)->first();
                $user->current_balance = $this->account->current_balance;
                $user->save();
            }

            $this->reset(['name_en','name_ar','notes','start_balance','current_balance','account_type_id','branch_id','parent_id','account_num','is_parent']);

            $this->dispatch('editModalToggle');

            $this->dispatch('refreshData')->to(DisplayAccounts::class);

            $this->dispatch(
            'alert',
                text: trans('admin.account_updated_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')

            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        }
    }

    public function render()
    {
        return view('livewire.accounts.update-account');
    }
}
