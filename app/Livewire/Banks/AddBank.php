<?php

namespace App\Livewire\Banks;

use Alert;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\Treasury;
use App\Models\AccountType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Treasuries\DisplayTreasuries;

class AddBank extends Component
{    public $banks,$name_ar,$name_en,$account_num,$branch_id,$parent_id,$id,$is_active;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('banks')],
            'name_en' => ['nullable','string','max:255',Rule::unique('banks')],

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
        ];

    }


    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        // try {


            $currentChildAccountNum = 0;

            $bankParentAccount = Account::where('name_ar',"نقدية بنوك بالعملة المحلية")->latest()->first();
            //dd($bankParentAccount);
            $latestAccountChild = Account::where('parent_id', $bankParentAccount->id)->pluck('account_num','id')->toArray();
            $maxBankNum = $latestAccountChild ? max($latestAccountChild) : 121210;
        //dd($maxBankNum);
            // if ($latestAccountChild) {
            //         $currentChildAccountNum = $latestAccountChild->account_num;
            // } else {

            //     $currentChildAccountNum = $bankParentAccount->account_num . '0';
            // }

            $nextBankNum = $maxBankNum + 1;

            $bank = Bank::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'account_num' => $nextBankNum,
                'is_active' => 1,
                'start_balance' => 0,
                'current_balance' => 0,
            ]);
            //dd($bank);

            $account = Account::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'start_balance' => 0,
                'current_balance' => 0,
                'account_num' => $bank->account_num,
                'account_type_id' => 5,
                'parent_id' => $bankParentAccount->id,
                'is_parent' => 0 ,
                'accountable_id' =>$bank->id,
                'accountable_type' => 'App\Models\Bank',
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'is_active' => 1 ,
                'level' =>$bankParentAccount->level +1,
                'nature' => 'مدين',
                'list' => 'مركز-مالي',
            ]);

            Ledger::create([
                'name_ar' => $bank->name_ar,
                'account_id' => $account->id,
                'account_num' => $account->account_num,
                'created_by' => Auth::user()->id,
                'date' => Carbon::now(),
                'type' => 'journal_entry',
            ]);

            $this->reset(['name_ar','name_en','account_num','is_active']);

            $this->dispatch('createModalToggle');

            // $this->dispatch('refreshData')->to(DisplayTreasuries::class);


            // $this->dispatch(
            // 'alert',
            //     text: 'تم إضافة بنك جديد بنجاح',
            //     icon: 'success',
            //     confirmButtonText: trans('admin.done')
            // );

                Alert::success('تم إضافة بنك جديد بنجاح');
                return redirect()->route('banks');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }

    public function render()
    {
        return view('livewire.banks.add-bank');
    }
}
