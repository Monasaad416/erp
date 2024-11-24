<?php

namespace App\Livewire\Deductions;

use Alert;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Branch;
use Livewire\Component;
use App\Models\Deduction;
use App\Models\FinancialYear;
use App\Models\FinancialMonth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddDeduction extends Component
{
    public $branches=[],$selectedUsers,$months=[],$branch_id,$financial_month_id,$user_id,$account_num ,$amount,$notes;


    public function branchIdChanged()
    {
        $this->selectedUsers = User::where('branch_id',$this->branch_id)->get();

    }

    public function getAccountNum()
    {
        $this->account_num = User::where('id',$this->user_id)->first()->account_num;

    }

        public function rules() {
        return [
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'financial_month_id' => 'required|exists:financial_months,id',
            'amount' => 'required|numeric',
            'notes' =>'nullable|string',


        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'إسم الموظف مطلوب',
            'user_id.exists' => 'إسم الموظف الذي تم إدخاله غير موجود بقاعدة البيانات',
            'branch_id.required' => 'إسم الفرع مطلوب',
            'branch_id.exists' => 'إسم الفرع الذي تم إدخاله غير موجود بقاعدة البيانات',
            'financial_month_id.required' => 'إسم الشهر المالي مطلوب',
            'financial_month_id.exists' => 'إسم الشهر المالي الذي تم إدخاله غير موجود بقاعدة البيانات',

            'amount.required' => ' مبلغ الخصم مطلوب',
        ];

    }


    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        // try {

            $currentYear = Carbon::now()->format('Y');
            $currentMonth = Carbon::now()->format('m');
            $currentDay = Carbon::now();
            //dd($currentDay);
            $selectedMonth = FinancialMonth::where('id',$this->financial_month_id)->first();
            $currentFinancialYear = FinancialYear::where('year',$currentYear)->first();
            $user = User::where('id',$this->user_id)->first();
 
                if($user->joining_date < $currentDay && $currentDay . $user->resignation_date) {
                    if($selectedMonth->month_id >= $currentMonth) {
                        Deduction::create([
                            'user_id' => $this->user_id,
                             'branch_id' => $this->branch_id,
                             'financial_month_id' => $this->financial_month_id,
                             'financial_year_id' => $currentFinancialYear->id,
                             'amount' => $this->amount,
                             'notes' => $this->notes,
                            'account_num' => $this->account_num,
                        ]);
                                 
                        $this->reset(['user_id','branch_id','account_num','financial_month_id','amount','notes']);

                        $this->dispatch('createModalToggle');
                         Alert::success('تم  تطبيق الخصم بنجاح');
                         return redirect()->route('users.deductions');
                    } else{
                        Alert::error('عفوا لايمكن تطبيق الخصم علي مرتب تم إستلامه ');
                         return redirect()->route('users.deductions');
                    }

                }else {
                   Alert::error('عفوا لايمكن تطبيق الخصم -الموظف غير متواجد علي رأس العمل بهذه الفترة  '); 
                    return redirect()->route('users.deductions');
                }


        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.deductions.add-deduction');
    }
}
