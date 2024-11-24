<?php

namespace App\Livewire\AdvancePayments;

use Alert;
use Exception;
use App\Models\User;
use Livewire\Component;
use App\Models\FinancialYear;
use App\Models\AdvancePayment;
use App\Models\FinancialMonth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AdvancePaymaentInstallment;

class UpdateAdvancePayment extends Component
{
    public $selectedUsers,$advancePayment,$financial_year_id,$branches=[],$users=[],$no_of_installments,$return_type,$months=[],$branch_id,$financial_month_id,$user_id,$account_num ,$amount,$notes;
    protected $listeners = ['updateAdvancePayment'];
 

    public function updateAdvancePayment($id)
    {

        $this->advancePayment = AdvancePayment::findOrFail($id);
    

        $this->user_id = $this->advancePayment->user_id;
       // dd($this->advancePayment->user_id);
        $this->branch_id = $this->advancePayment->branch_id;
        $this->user_id = $this->advancePayment->user_id;
        $this->financial_month_id = $this->advancePayment->financial_month_id;
        $this->financial_year_id = $this->advancePayment->financial_year_id;
        $this->amount = $this->advancePayment->amount;
        $this->no_of_installments = $this->advancePayment->no_of_installments;
        $this->return_type = $this->advancePayment->return_type;
        $this->account_num = $this->advancePayment->account_num;
        $this->notes = $this->advancePayment->notes;
        $this->users = User::where('branch_id', $this->advancePayment->branch_id)->get();
        
        //dd( $this->financial_year_id);
         
        $this->resetValidation();
        $this->dispatch('editModalToggle');
    }
    public function branchIdChanged()
    {
        $this->selectedUsers = User::where('branch_id',$this->branch_id)->get();

    }

    public function rules() 
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',
            'financial_month_id' => 'nullable|exists:financial_months,id',
            'amount' => 'nullable|numeric',
            'notes' =>'nullable|string',
            'no_of_installments' => 'nullable|numeric|min:0',
            'return_type' => 'nullable|in:from_salary,treasury',
        ];
    }

    public function messages()
    {
        return [
            'user_id.nullable' => 'إسم الموظف مطلوب',
            'user_id.exixts' => 'إسم الموظف الذي تم إدخاله غير موجود بقاعدة البيانات',
            'branch_id.nullable' => 'إسم الفرع مطلوب',
            'branch_id.exixts' => 'إسم الفرع الذي تم إدخاله غير موجود بقاعدة البيانات',
            'financial_month_id.nullable' => 'إسم الشهر المالي مطلوب',
            'financial_month_id.exixts' => 'إسم الشهر المالي الذي تم إدخاله غير موجود بقاعدة البيانات',
            'amount.nullable' => ' مبلغ السلفة مطلوب',
            'no_of_installments.nullable' => ' عدد أقساط رد  السلفة مطلوب',
            'no_of_installments.numeric' => ' عدد أقساط رد  السلفة يجب أن يكون رقم',
            'no_of_installments.min' => ' عدد أقساط رد  السلفة يجب أن الا يقل عن 0 ',
            'return_type.nullable' => ' طريقة  رد  السلفة مطلوبة',
            'return_type.in' => 'طريقة رد السلفة التي تم إدخالها غير موجودة بقاعدة البيانات',
        ];
    }

  

    public function update()
    {
        $data = $this->validate($this->rules() ,$this->messages());


        // try {

                if($this->advancePayment->financial_month_id < Carbon::now()->format('m')){
                    $this->dispatch('editModalToggle');
                    Alert::error('عفوا لا يمكن تعديل سلفة تم تطبيقها علي راتب تم إستلامه');
                    return redirect()->route('users.advancePayments');
                } else {
                    DB::beginTransaction();
                    $this->advancePayment->update($data);

                    $installments = AdvancePaymaentInstallment::where('advance_payment_id',$this->advancePayment->id)->get();
                    foreach($installments as $installment) {
                        $installment->delete();
                    }
                    
                    $paymentYear= FinancialYear::where('id',$this->financial_year_id)->first()->year;
                    $paymentMonth= FinancialMonth::where('id',$this->financial_month_id)->first()->month_id;
                    $startMonth = Carbon::create($paymentYear, $paymentMonth, 1);
                    
                    for($i=1 ; $i <= $this->advancePayment->no_of_installments ; $i++) {
                            $nextMonth = $startMonth->addMonth();
                            $nextPaymentYear = $nextMonth->year; 
                            $nextPaymentMonth = $nextMonth->month;
                            $nextPaymentFinancialYear = FinancialYear::where('year',$nextPaymentYear)->first();
                            $nextPaymentFinancialMonth = FinancialMonth::where('month_id',$nextPaymentMonth)->first();


                            // if (!$nextPaymentFinancialYear) {
                            //     // Generate validation error if the next payment financial year does not exist
                            //     $validator = Validator::make([], []); // Empty validator to generate the error
                            //     $validator->errors()->add('financial_year_id', 'عفوا مطلوب تسجيل السنة المالية القادمة لاستكمال العملية');
                            //     return redirect()->back()->withErrors($validator->errors());
                            // }

                            $advancePaymentInstallment = new AdvancePaymaentInstallment();
                            $advancePaymentInstallment->advance_payment_id = $this->advancePayment->id;
                            $advancePaymentInstallment->financial_month_id = $nextPaymentFinancialMonth->id;
                            $advancePaymentInstallment->financial_year_id = $nextPaymentFinancialYear->id;
                            $advancePaymentInstallment->amount = $this->advancePayment->amount / $this->advancePayment->no_of_installments;
                            $advancePaymentInstallment->installment_num = $i;  
                            $advancePaymentInstallment->is_paid = 0;  
                            $advancePaymentInstallment->save();

        
                    }

                    DB::commit();
                    $this->reset(['user_id','financial_month_id','branch_id','amount','notes','no_of_installments','return_type']);
                    $this->dispatch('editModalToggle');
                    Alert::success('تم  تعديل السلفة بنجاح');
                    return redirect()->route('users.advance_payments');
                }

        // } catch (Exception $e) {
        //     DB::rollBack(); 
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
    public function render()
    {
        return view('livewire.advance-payments.update-advance-payment');
    }
}
