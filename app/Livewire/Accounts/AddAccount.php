<?php

namespace App\Livewire\Accounts;

use Exception;
use Carbon\Carbon;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddAccount extends Component
{
    public $name_ar,$name_en,$notes,$is_active,
    $account_num,$start_balance,$current_balance,
    $branch_id,$parent_id,$account_type_id,
    $created_by,$updated_by,$is_parent = 0;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:100',Rule::unique('accounts')],
            'name_en' => ['nullable','string','max:100',Rule::unique('accounts')],
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


    public function create()
    {
        //return dd($this->all());
        $this->validate($this->rules() ,$this->messages());

        // try {

            if (empty($this->parent_id)) {
                $this->parent_id = null; // Set a default value, such as null
            }

            // if($this->parent_id != null) {
            //     $currentChildAccountNum='';
            //     $latestAccountChild = Account::where('parent_id',$this->parent_id)->latest()->first();
            //     if($latestAccountChild) {
            //         $currentChildAccountNum = $latestAccountChild->account_num;
            //     }
            //     else {
            //         $parentAccountNum = Account::where('id',$this->parent_id)->first();
            //         //dd($parentAccountNum);
            //         $currentChildAccountNum =  $parentAccountNum . 1;
            //     }
            // }

            if ($this->parent_id != null) {
                $currentChildAccountNum = '';
                $latestAccountChild = Account::where('parent_id', $this->parent_id)->latest()->first();
                if ($latestAccountChild) {
                    $currentChildAccountNum = $latestAccountChild->account_num;
                } else {
                    $parentAccountNum = Account::where('id', $this->parent_id)->first();
                    //dd($parentAccountNum);
                    $currentChildAccountNum = $parentAccountNum->account_num . '0';
                }
            }

            Account::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'start_balance' => $this->start_balance,
                'current_balance' => $this->current_balance,
                'account_num' => $this->parent_id == null ? $this->getNextParentAccountNum() : $currentChildAccountNum + 1,
                'account_type_id' => $this->account_type_id,
                // 'branch_id' => $this->branch_id,
                'parent_id' => $this->parent_id ?? null,
                'notes' => $this->notes,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'is_active' => 1 ,
                'is_parent' => $this->is_parent,
                'parent_account_num' => $this->parent_id ? Account::where('id',$this->parent_id)->first()->account_num : null,
                'level' => $this->parent_id ? Account::where('id',$this->parent_id)->first()->level +1 : 1,
            ]);

            $this->reset(['name_ar','name_en','account_num','account_type_id','parent_id','parent_id','start_balance','current_balance','is_parent']);

            $this->dispatch('createModalToggle');

            $this->dispatch('refreshData')->to(DisplayAccounts::class);

            $this->dispatch(
            'alert',
                text: trans('admin.account_created_successfully'),
                icon: 'success',
                confirmButtonText: trans('admin.done')
            );
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }

    }
    public function render()
    {
        return view('livewire.accounts.add-account');
    }
}
