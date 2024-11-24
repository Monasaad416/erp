<?php

namespace App\Livewire\AssetSuppliers;

use Exception;
use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\AccountType;
use App\Models\AssetSupplier;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Suppliers\DisplaySuppliers;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddSupplier extends Component
{
    public $name_ar,$name_en,$email,$phone,$address,$branch_id,$id,
    $tax_num,$balance_state,$start_balance=0,$current_balance=0,$supplier;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('suppliers')],
            'name_en' => ['nullable','string','max:255',Rule::unique('suppliers')],
            'email' =>   ['nullable','string','email','max:100',Rule::unique('suppliers')],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'tax_num' => 'nullable|tax_num_length',

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

            'branch_id.required' =>'الفرع مطلوب',
            'branch_id.exists' => 'الفرع الذي تم اختياره غير موجود بقاعدة البيانات',
            'tax_num.tax_num_length' => trans('validation.tax_num_length'),


        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        DB::beginTransaction();
        try {


        $currentChildAccountNum = 0;

        $suppliersParentAccount = Account::where('account_num', 224)->first();
        //dd($suppliersParentAccount);
        $latestAccountChild = Account::where('parent_id', $suppliersParentAccount->id)->latest()->first();
        if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num;
        } else {

            $currentChildAccountNum = $suppliersParentAccount->account_num . '0';
        }


    

            $assetSupplier = AssetSupplier::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'email' => $this->email == "" ? null: $this->email,
                'address' => $this->address,
                'phone' => $this->phone,
                'tax_num' => $this->tax_num == "" ? null: $this->tax_num,
                'account_num' => $currentChildAccountNum + 1,
                'branch_id' => $this->branch_id == "" ? null: $this->branch_id,
                'balance_state' =>'متزن',
                'start_balance' => 0,
                'current_balance' => 0,
            ]);

            //dd($assetSupplier);

            $account = Account::create([
                'name_ar' => $this->name_ar,
                'name_en' => $this->name_en,
                'start_balance' => $this->start_balance,
                'current_balance' => $assetSupplier->current_state == 'دائن' ? -$this->current_balance : $this->current_balance ,
                'account_num' => $assetSupplier->account_num,
                'account_type_id' => AccountType::where('name_ar','مورد')->first()->id,
                'parent_id' => $suppliersParentAccount->id,
                'branch_id' => Auth::user()->roles_name=='سوبر-ادمن' ? $this->branch_id : Auth::user()->branch,
                'accountable_id' =>$assetSupplier->id,
                'accountable_type' => 'App\Models\Supplier',
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'level' => $suppliersParentAccount->level  +1,
                'is_active' => 1 ,
                'is_parent' => 0 ,
            ]);


           // dd($account);


            $ledger = new Ledger();
            $ledger->account_id = $account->id;
            $ledger->account_num = $account->account_num;
            $ledger->name_ar = $assetSupplier->name_ar;
            $ledger->created_by = Auth::user()->id;
            $ledger->type = 'journal_entry';
            $ledger->date = Carbon::now();


            $this->reset(['name_en','name_ar','email','address','phone','current_balance','start_balance','branch_id','balance_state','tax_num' ]);

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
        $branches = Branch::select(
            'id',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name'
        )->where('is_active', 1)->get();
        return view('livewire.asset-suppliers.add-supplier', compact('branches'));
    }
}
