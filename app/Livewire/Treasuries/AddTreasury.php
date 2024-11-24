<?php

namespace App\Livewire\Treasuries;

use Exception;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\Treasury;
use App\Models\AccountType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Treasuries\DisplayTreasuries;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddTreasury extends Component
{
    public $treasuries,$name_ar,$name_en,$is_parent,$branch_id,$parent_id,$id,$is_active;

    public function rules() {
        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('treasuries')
            ],
            'name_en' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('treasuries')
            ],
            'branch_id' => 'required_if:is_parent,null',
            'is_parent' => 'required_if:branch_id,null',

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

            'branch_id.required_if' => 'الفرع مطلوب في حالة الخزينة الفرعية',
            'branch_id.exists' => 'الفرع الذي تم ادخالة غير مسجل بقاعدة البيانات',

            'is_parent.required_if' => 'الخزينة يجب ان تكون رئيسية في حالة عدم وجود فرع',
        ];

    }


    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        // try {


            $currentChildAccountNum = 0;

            $treasuryParentAccount = Account::where('name_ar',"نقدية بالصندوق")->latest()->first();
            $latestAccountChild = Account::where('parent_id', $treasuryParentAccount->id)->pluck('account_num','id')->toArray();
            $maxTreasuryNum = max($latestAccountChild);
            // if ($latestAccountChild) {
            //         $currentChildAccountNum = $latestAccountChild->account_num;
            // } else {

            //     $currentChildAccountNum = $treasuryParentAccount->account_num . '0';
            // }

            $nextTreasuryNum = $maxTreasuryNum + 1;

            $treasury = Treasury::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'branch_id' => $this->branch_id,
                'is_parent' => $this->is_parent,
                'is_active' => 1,
                'start_balance' =>0,
                'current_balance' => 0,
                'account_num' => $nextTreasuryNum,
            ]);

            $account = Account::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'start_balance' => 0,
                'current_balance' => 0,
                'account_num' => $treasury->account_num,
                'account_type_id' => 2,
                'parent_id' => $treasuryParentAccount->id,
                'accountable_id' =>$treasury->id,
                'accountable_type' => 'App\Models\Treasury',
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'is_active' => 1 ,
            ]);

            Ledger::create([
                'account_id' => $account->id,
                'account_num' => $account->account_num,
                'created_by' => Auth::user()->id,
                'name_ar' => $account->name_ar,
                'type' =>' journal_entry',
                'date' => Carbon::now(),
            ]);

            $this->reset(['name_ar','name_en','branch_id','is_parent','is_active' ]);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayTreasuries::class);

            $this->dispatch(
            'alert',
                text: 'تم إضافة خزينة جديدة بنجاح',
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.treasuries.add-treasury');
    }
}
