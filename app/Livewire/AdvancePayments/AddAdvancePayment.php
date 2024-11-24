<?php

namespace App\Livewire\AdvancePayments;

use Alert;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\FinancialYear;
use App\Models\AdvancePayment;
use App\Models\FinancialMonth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AdvancePaymaentInstallment;


class AddAdvancePayment extends Component
{
        public $branches=[],$selectedUsers,$months=[],$branch_id,$financial_month_id,$financial_year_id,$user_id,$account_num
        ,$amount,$notes,$no_of_installments,$return_type,$is_paid;


        public function mount()
        {
            $currentFinancialYear = FinancialYear::where('year',Carbon::now()->format('Y'))->first();
         
            $this->financial_year_id = $currentFinancialYear->id;

        }
    public function branchIdChanged()
    {
        $this->selectedUsers = User::where('branch_id',$this->branch_id)->get();

    }

    public function getAccountNum()
    {
        $this->account_num = User::where('id',$this->user_id)->first()->account_num;

    }

    public function rules() 
    {
        return [
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'financial_month_id' => 'required|exists:financial_months,id',
            'amount' => 'required|numeric',
            'notes' =>'nullable|string',
            'no_of_installments' => 'required|numeric|min:0',
            'return_type' => 'required|in:from_salary,treasury',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'إسم الموظف مطلوب',
            'user_id.exixts' => 'إسم الموظف الذي تم إدخاله غير موجود بقاعدة البيانات',
            'branch_id.required' => 'إسم الفرع مطلوب',
            'branch_id.exixts' => 'إسم الفرع الذي تم إدخاله غير موجود بقاعدة البيانات',
            'financial_month_id.required' => 'إسم الشهر المالي مطلوب',
            'financial_month_id.exixts' => 'إسم الشهر المالي الذي تم إدخاله غير موجود بقاعدة البيانات',
            'amount.required' => ' مبلغ السلفة مطلوب',
            'no_of_installments.required' => ' عدد أقساط رد  السلفة مطلوب',
            'no_of_installments.numeric' => ' عدد أقساط رد  السلفة يجب أن يكون رقم',
            'no_of_installments.min' => ' عدد أقساط رد  السلفة يجب أن الا يقل عن 0 ',
            'return_type.required' => ' طريقة  رد  السلفة مطلوبة',
            'return_type.in' => 'طريقة رد السلفة التي تم إدخالها غير موجودة بقاعدة البيانات',
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
            $user = User::where('id',$this->user_id)->first();

                if($user->joining_date < $currentDay && $currentDay . $user->resignation_date) {
                    if($selectedMonth->month_id >= $currentMonth) {
                        DB::beginTransaction();
                        $advancePayment = new AdvancePayment();
                        $advancePayment->user_id = $this->user_id;
                        $advancePayment->branch_id = $this->branch_id;
                        $advancePayment->financial_month_id = $this->financial_month_id;
                        $advancePayment->financial_year_id = $this->financial_year_id;
                        $advancePayment->amount = $this->amount;
                        $advancePayment->notes = $this->notes;
                        $advancePayment->account_num = $this->account_num;
                        $advancePayment->no_of_installments = $this->no_of_installments;
                        $advancePayment->return_type = $this->return_type;
                        $advancePayment->is_paid = 0 ;
                        $advancePayment->save();

                        $paymentYear= FinancialYear::where('id',$this->financial_year_id)->first()->year;
                        $paymentMonth= FinancialMonth::where('id',$this->financial_month_id)->first()->month_id;
                        $startMonth = Carbon::create($paymentYear, $paymentMonth);
                        
    
                        for($i=1 ; $i <= $advancePayment->no_of_installments ; $i++) {
                            $nextMonth = $startMonth->addMonth();
                            $nextPaymentYear = $nextMonth->year; 

                            $nextPaymentFinancialYear = FinancialYear::where('year',$nextPaymentYear)->first();
                            $nextPaymentMonth = FinancialMonth::where('month_id',$nextMonth->month)->where('financial_year_id',$nextPaymentFinancialYear->id)->first();;
                            
                      
                            dd($nextPaymentMonth->id);


                            // if (!$nextPaymentFinancialYear) {
                            //     // Generate validation error if the next payment financial year does not exist
                            //     $validator = Validator::make([], []); // Empty validator to generate the error
                            //     $validator->errors()->add('financial_year_id', 'عفوا مطلوب تسجيل السنة المالية القادمة لاستكمال العملية');
                            //     return redirect()->back()->withErrors($validator->errors());
                            // }

                            $advancePaymentInstallment = new AdvancePaymaentInstallment();
                            $advancePaymentInstallment->advance_payment_id = $advancePayment->id;
                            $advancePaymentInstallment->financial_month_id = $nextPaymentMonth->id;
                            $advancePaymentInstallment->financial_year_id = $nextPaymentFinancialYear->id;
                            $advancePaymentInstallment->amount = $advancePayment->amount / $advancePayment->no_of_installments;
                            $advancePaymentInstallment->installment_num = $i;  
                            $advancePaymentInstallment->is_paid = 0;  
                            $advancePaymentInstallment->save();
 
                            

        
                        }

                        $this->reset(['user_id','branch_id','account_num','financial_month_id','amount','notes','no_of_installments','return_type']);

                        $this->dispatch('createModalToggle');

                        DB::commit();
                         Alert::success('تم  تطبيق السلفة بنجاح');
                         return redirect()->route('users.advance_payments');
                    } else{
                        Alert::error('عفوا لايمكن تطبيق السلفة علي مرتب تم إستلامه ');
                         return redirect()->route('users.advance_payments');
                    }

                }else {
                   Alert::error('عفوا لايمكن تطبيق السلفة -الموظف غير متواجد علي رأس العمل بهذه الفترة  ');
                    return redirect()->route('users.advance_payments');
                }


        // } catch (Exception $e) {
            // DB::rollback
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.advance-payments.add-advance-payment');
    }
}
