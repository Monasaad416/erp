<?php

namespace App\Livewire\Salaries;

use Alert;
use Carbon\Carbon;
use App\Models\Reward;
use App\Models\Salary;
use Livewire\Component;
use App\Models\Deduction;
use App\Events\salaryAdded;
use App\Models\MonthShifts;
use App\Models\FinancialYear;
use App\Models\AdvancePayment;
use App\Models\FinancialMonth;
use App\Models\CustomerInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use App\Models\AdvancePaymaentInstallment;

class AddSalary extends Component
{
    public $user,$branch_id,$user_id ,$salary ,$overtime_mins
     ,$total_overtime ,$receiving_type ,$medical_insurance_deduction ,
    $transfer_allowance  ,$total_commission_rate ,$financial_year_id ,$financial_month_id  ,$deductions ,
    $rewards ,$advance_payment_deduction ,$mainSalary,$received ,$from_date,$to_date,$deserved1,$required_days ,$actual_days_num,$actual_days,$required_hours ,$actual_hours,$housing_allowance
    ,$commissions,$advancePaymentInstallments,$total_delay=0,$delay,$actual_delay,$total_overtime_mins,$bank_id,$currentInstallments,$advancePayments;
    public function mount($user)
    {
        $this->user = $user;

            // $lastMonth = Carbon::now()->subMonth();
            // $this->from_date = $lastMonth->day(25)->format('d-m-Y');
            // $this->to_date = Carbon::now()->day(24);

        
     }
     

     public function getValues()
     {
        $fromDay = Carbon::parse($this->from_date)->day;
        $fromMonth = Carbon::parse($this->from_date)->month;

        $toDay = Carbon::parse($this->to_date)->day;
        $toMonth = Carbon::parse($this->to_date)->month;

            $currentFinancialYear = FinancialYear::where('year',Carbon::now()->format('Y'))->first();
            $currentFinancialMonth = FinancialMonth::where('month_id',Carbon::now()->format('m'))->first();
            $startMonth = $currentFinancialMonth->start_date;
            $endMonth =  $currentFinancialMonth->end_date;


            $days = MonthShifts::where('user_id', $this->user->id)->where('financial_year_id',$currentFinancialYear->id)
            ->whereBetween('date',[$this->from_date,$this->to_date]);
            $overtimeMins = $days->sum('overtime_mins');
            $this->actual_days_num = $days->count();
            $overtimePrices = number_format(($overtimeMins /60 ) * $this->user->overtime_hour_price,2);

            $this->financial_year_id = $currentFinancialYear->id;
            $this->financial_month_id = $currentFinancialMonth->id;
            // dd($this->financial_month_id);
            //deductions
            $this->deductions = Deduction::where('user_id', $this->user->id)->where('financial_year_id',$currentFinancialYear->id)
             ->whereBetween('created_at',[$this->from_date,$this->to_date])->sum('amount');
            //rewards


            $this->rewards = Reward::where('user_id', $this->user->id)->where('financial_year_id',$currentFinancialYear->id)
             ->whereBetween('created_at',[$this->from_date,$this->to_date])->sum('amount');
            //advance payment
            $this->advancePayments = AdvancePayment::where('user_id', $this->user->id)->where('financial_year_id',$currentFinancialYear->id)->
            where('is_paid',0)->where('return_type','from_salary')->get();
            $advancePaymentsIds = $this->advancePayments->pluck('id')->toArray();

            $installments = AdvancePaymaentInstallment::whereIn('advance_payment_id',$advancePaymentsIds)->where('is_paid',0)->get();
            $this->currentInstallments = AdvancePaymaentInstallment::whereIn('advance_payment_id',$advancePaymentsIds)->where('is_paid',0)
            ->where('financial_month_id',$currentFinancialMonth->id)->get();
            
            //dd($this->currentInstallments);

            $this->advancePaymentInstallments = 0;
            foreach($this->currentInstallments as $payment) {
                $this->advancePaymentInstallments += $payment->amount;
            }




            $commissionsInvoices = CustomerInvoice::whereBetween('created_at',[$startMonth,$endMonth])->get();
            $commissions = 0 ;
            foreach ( $commissionsInvoices as $invoice) {
                $items = CustomerInvoiceItem::where('customer_invoice_id',$invoice->id)->get();
                foreach($items as $item) {
                    $commissions += $item->total_commission_rate;
                }
            }


            $this->branch_id = $this->user->id;
            $this->mainSalary = $this->user->salary;
            $this->total_overtime = $overtimePrices;
            $this->total_commission_rate = $commissions;
            // $this->rewards = $this->rewards;
            // $this->deductions = $this->deductions;
            $this->medical_insurance_deduction = $this->user->medication_insurance_deduction ? $this->user->medication_insurance_deduction :0;
            $this->housing_allowance = $this->user->housing_allowance ? $this->user->housing_allowance : 0 ;
            $this->transfer_allowance = $this->user->transfer_allowance ?$this->user->transfer_allowance : 0;
            $this->advance_payment_deduction = $this->advancePaymentInstallments;
            // $this->required_days = $user->required_days;


            $this->actual_days = MonthShifts::where('user_id', $this->user->id)->where('financial_year_id',$currentFinancialYear->id)
            ->whereBetween('date',[$this->from_date,$this->to_date])->where('attended',1)->count();
            


            
            $delay =0;
            $overtime=0;
            $currentFinancialYear = FinancialYear::where('year',Carbon::now()->format('Y'))->first();
            $currentFinancialMonth = FinancialMonth::where('month_id',Carbon::now()->format('m'))->first();


            $this->actual_days = MonthShifts::where('user_id',$this->user->id)->
            whereBetween('date',[$this->from_date,$this->to_date])->where('attended',1)->get();
            //dd( $this->actual_days);
             foreach($this->actual_days as $actualDay) {
                $delay+= $actualDay->delay_mins;
                $overtime += $actualDay->overtime_mins;
            }
            
            $this->delay = $delay;
            $this->total_overtime_mins= $overtime;

     }

    public function rules() {
        return [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'actual_days_num' => 'required|numeric',
            'required_days' => 'required|numeric',



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

            'amount.required' => ' مبلغ المكافاءة مطلوب',
        ];

    }


     public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        // try{
           
            DB::beginTransaction();
            $userAttendAt = Carbon::parse($this->user->user_attend_at);
            $userLeaveAt = Carbon::parse($this->user->user_leave_at);

            $diff = $userAttendAt->diff($userLeaveAt);
            /// delay
            $mainsalary = $this->user->salary * ($this->actual_days_num/$this->required_days);

            $salaryDetails = Salary::where('financial_month_id',$this->financial_month_id)
            ->where('user_id',$this->user->id)->first();
            //dd($this->receiving_type);
            if(!$salaryDetails) {
                $salary = new Salary();
                $salary->branch_id =  $this->user->branch_id;
                $salary->user_id =$this->user->id;
                $salary->salary = $mainsalary;
                $salary->overtime_mins = $this->total_overtime_mins;
                $salary->total_overtime = ($this->total_overtime_mins/60) * $this->user->overtime_hour_price;
                $salary->delay_mins = $this->delay;//mins
                $salary->total_delay = $this->total_delay;//price
                $salary->medical_insurance_deduction = $this->user->medical_insurance_deduction;
                $salary->transfer_allowance = $this->user->transfer_allowance;
                $salary->housing_allowance = $this->user->housing_allowance;
                $salary->total_commission_rate =  $this->commissions;
                $salary->financial_year_id = $this->financial_year_id ;
                $salary->financial_month_id= $this->financial_month_id  ;
                $salary->deductions = $this->deductions;
                $salary->rewards = $this->rewards ;
                $salary->advance_payment_deduction = $this->advancePaymentInstallments;
                $salary->received = 0 ;
                $salary->deserved =1;
                $salary->required_days = $this->required_days;
                $salary->actual_days = $this->actual_days_num;
                $salary->receiving_type = $this->receiving_type;
                $salary->bank_id = $this->bank_id;
                $salary->from_date = $this->from_date;
                $salary->to_date = $this->to_date;
                $salary->save();

                foreach($this->currentInstallments as $payment ) {
                    $payment->is_paid = 1;
                    $payment->save();
                }


                foreach($this->advancePayments as $advancePayment) {
                    $noOfPaidInstallements = $advancePayment->installments()->where('is_paid', 1)->count();
                    if($noOfPaidInstallements == $advancePayment->no_of_installments) {
                        $advancePayment->is_paid = 01;
                        $advancePayment->save();
                    }

                    
                }

              
          
            } else {
  
                $salaryDetails->salary = $mainsalary;
                $salaryDetails->overtime_mins = $this->total_overtime_mins;
                $salaryDetails->total_overtime = ($this->total_overtime_mins/60) * $this->user->overtime_hour_price;
                $salaryDetails->delay_mins = $this->delay;//mins
                $salaryDetails->total_delay = $this->total_delay;//price
                $salaryDetails->medical_insurance_deduction = $this->user->medical_insurance_deduction;
                $salaryDetails->transfer_allowance = $this->user->transfer_allowance;
                $salaryDetails->housing_allowance = $this->user->housing_allowance;
                $salaryDetails->total_commission_rate =  $this->commissions;
                $salaryDetails->financial_year_id = $this->financial_year_id ;
                $salaryDetails->financial_month_id= $this->financial_month_id  ;
                $salaryDetails->deductions = $this->deductions;
                $salaryDetails->rewards = $this->rewards ;
                $salaryDetails->advance_payment_deduction = $this->advancePaymentInstallments;
                $salaryDetails->received = 0 ;
                $salaryDetails->deserved =1;
                $salaryDetails->required_days = $this->required_days;
                $salaryDetails->actual_days= $this->actual_days_num;
                $salaryDetails->receiving_type = $this->receiving_type;
                $salaryDetails->bank_id = $this->bank_id;
                $salaryDetails->from_date = $this->from_date;
                $salaryDetails->to_date = $this->to_date;
                $salaryDetails->save();
    
            }





            $bank_id = $this->bank_id;
            //dd($bank_id);
        
            event(new salaryAdded($this->user ,$salaryDetails ? $salaryDetails : $salary,$bank_id));
            DB::commit();
            Alert::success('تم إعتماد الراتب بنجاح');
            return redirect()->route('users');
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }







   }
    public function render()
    {
        return view('livewire.salaries.add-salary');
    }
}
