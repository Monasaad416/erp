<?php

namespace App\Livewire\Shifts;

use Carbon\Carbon;
use Livewire\Component;
use Carbon\CarbonPeriod;
use App\Models\MonthShifts;
use App\Models\FinancialYear;
use App\Models\FinancialMonth;
use Alert;

class AddCurrentYearShifts extends Component
{
    public $user,$rows=[],$branch_id,$i,$year,$shift_type_id,$shift_hours,$shift_start,$shift_end,$user_attend_at,$user_leave_at,$attended=0,
    $financial_year_id,$financial_month_id,$date;
    public function mount($user)
    {
        $currentYear = Carbon::now()->format('Y');
        $currentMonthNo = Carbon::now()->format('m');
        $currentFinancialYear = FinancialYear::where('year',$currentYear)->first();
        $currentFinancialMonth = FinancialMonth::where('month_id',$currentMonthNo)->first();
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $this->financial_year_id = $currentFinancialYear->id;
        $this->financial_month_id = $currentFinancialMonth->id;
        //dd($this->financial_year_id);

        $period = new CarbonPeriod($startDate, '1 day', $endDate);
        $numberOfDays = count($period);
            //dd($numberOfDays);
        $this->user = $user;
        $this->branch_id = $this->user->branch_id;
        $this->rows = MonthShifts::where('user_id',$this->user->id)->where('branch_id',$this->branch_id)
        ->where('financial_year_id',$currentFinancialYear->id)
        ->where('financial_month_id',$currentFinancialMonth->id)->get();
        if ($this->rows->isNotEmpty()) {
            $this->rows = $this->rows->toArray();
        } else {
            $this->rows = [];

                for ($day_num = 1; $day_num <= $numberOfDays; $day_num++) {
                    $date = Carbon::createFromDate($currentFinancialYear->year, $currentFinancialMonth->month_id, $day_num);
                    //dd($date);
                    $this->rows[] = [
                        'shift_hours' => null,
                        'shift_start' => null,
                        'shift_end' => null,
                        'user_attend_at' => null,
                        'user_leave_at' => null,
                        'attended' => null,
                        'day_num' => null,
                        'shift_type_id' => null,
                        'overtime_mins' => null,
                        'date' => null,
                    ];
               }
        }
    }


    public function rules()
    {


        foreach ($this->rows as $index => $row) {

            $rules['rows.' . $index . '.shift_type_id'] = 'required';
            $rules['rows.' . $index . '.shift_hours'] = 'required|numeric|min:0';
            $rules['rows.' . $index . '.shift_start'] = 'required|time';
            $rules['rows.' . $index . '.shift_end'] = 'required|time';
            $rules['rows.' . $index . '.user_attend_at'] = 'required|time';
            $rules['rows.' . $index . '.user_leave_at'] = 'required|time';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'payment_type.required' => trans('validation.payment_type_required'),
            'supplier_id.required' => trans('validation.supplier_id_required'),
            'supp_inv_date_time.required' => trans('validation.supp_inv_date_time_required'),
            'payment_type.in' => trans('validation.payment_type_in'),
            'status.required' => trans('validation.status_required'),
            'bank_id.required_if' => 'اختر البنك المطلوب صرف الشيك منه',
            'check_num.required_if' => 'ادخل رقم الشيك',
            'rows.*.product_code.required' => trans('validation.product_code_required'),
            'rows.*.product_code.string' => trans('validation.product_code_string'),
            'rows.*.product_code.max' => trans('validation.product_code_max'),
            'rows.*.product_code.exists' => trans('validation.product_code_exists'),
            'rows.*.purchase_price.required_if' => trans('validation.purchase_price_required_if'),
            'rows.*.wholesale_inc_vat.required_if' => trans('validation.wholesale_inc_vat_required_if'),
            'rows.*.wholesale_inc_vat.numeric' => trans('validation.wholesale_inc_vat_numeric'),
            'rows.*.purchase_price.min' => trans('validation.purchase_price_min'),
            'rows.*.purchase_price.gt' => 'سعر الشراء يجب أن يكون اكبر من 0',
            'rows.*.purchase_price.lt' => 'سعر الشراء يجب أن يكون اقل من سعر البيع',
            'rows.*.discount_percentage.numeric' => trans('validation.discount_percentage_numeric'),
            'rows.*.discount_value.numeric' => trans('validation.discount_value_numeric'),
            'rows.*.qty.required' => trans('validation.qty_required'),
            'rows.*.qty.numeric' => trans('validation.qty_numeric'),
        ];
    }


        public function update()
    {

        foreach($this->rows as $index => $row) {
           //dd($row);

            // $indexDigits = str_split(strval($index));

            // $extractedDigits = array_slice($indexDigits, 2);
            // $extractedDigitsString = implode('', $extractedDigits);
            // // dd($extractedDigitsString);
            $dayInfo = MonthShifts::where('user_id',$this->user->id)->where('branch_id',$this->branch_id)

        ->where('financial_year_id',$this->financial_year_id)
        ->where('financial_month_id',$this->financial_month_id)
        ->where('day_num', $index + 1)->first();

        $currentYear = Carbon::now()->format('Y');
        $currentMonthNo = Carbon::now()->format('m');
        $currentFinancialYear = FinancialYear::where('year',$currentYear)->first();
        $currentFinancialMonth = FinancialMonth::where('month_id',$currentMonthNo)->first();


                $expectedAttendTime = Carbon::parse($row['shift_start']);
                $actualAttendTime = Carbon::parse($row['user_attend_at']);


                $expectedLeaveTime = Carbon::parse($row['shift_end']);
                $actualLeaveTime = Carbon::parse($row['user_leave_at']);
               // dd($expectedAttendTime->diffInMinutes( $actualAttendTime));


                 //dd($overtime);

            //dd( Carbon::createFromDate($currentFinancialYear->year, $currentFinancialMonth->month_id, $index)->format('y m d'));
            if(!$dayInfo){

                    // if ($actualAttendTime > $expectedAttendTime) {
                    //     $delay = $actualAttendTime->diffInMinutes($expectedAttendTime);
                    //     // dd($delay);
                    // }

                    // if ($actualLeaveTime > $expectedLeaveTime) {
                    //     $overtime = $actualLeaveTime->diffInMinutes($expectedLeaveTime);

                    // }
                MonthShifts::create([
                    'user_id' => $this->user->id ,
                    'branch_id' => $this->branch_id,
                    'day_num' => $index+1,
                    'financial_year_id' => $this->financial_year_id,
                    'financial_month_id' => $this->financial_month_id,
                    'shift_type_id' => $row['shift_type_id'] ?? null,
                    'shift_start' => $row['shift_start']?? null,
                    'shift_end' =>  $row['shift_end']?? null,
                    'shift_hours' =>  $row['shift_hours']?? null,
                    'user_attend_at' => $row['user_attend_at']?? null,
                    'user_leave_at' =>$row['user_leave_at']?? null,
                    'attended' => $row['attended']?? null,
                    'date' => $row['date'],
                    'delay_mins' => $actualAttendTime > $expectedAttendTime ? $actualAttendTime->diffInMinutes($expectedAttendTime) : 0 ,
                    'overtime_mins' =>  $actualLeaveTime > $expectedLeaveTime ? max(0, $actualLeaveTime->diffInMinutes($expectedLeaveTime)) : 0 ,
                ]);
            } else {
                $dayInfo->shift_type_id = $row['shift_type_id'];
                $dayInfo->shift_start = $row['shift_start'];
                $dayInfo->shift_end =  $row['shift_end'];
                $dayInfo->shift_hours =  $row['shift_hours'];
                $dayInfo->user_attend_at = $row['user_attend_at'];
                $dayInfo->user_leave_at =$row['user_leave_at'];
                $dayInfo->attended = $row['attended'];
                $dayInfo->date = $row['date'];
                $dayInfo->delay_mins = $actualAttendTime > $expectedAttendTime ? $actualAttendTime->diffInMinutes($expectedAttendTime) : 0 ;
                $dayInfo->overtime_mins =  $actualLeaveTime > $expectedLeaveTime ? max(0, $actualLeaveTime->diffInMinutes($expectedLeaveTime)) : 0 ;
                $dayInfo->save();
                //dd($dayInfo);
            }

            }
            Alert::success('تم تعديل الورديات بنجاح');
            return redirect()->route('users');

    }



    public function render()
    {
        return view('livewire.shifts.add-current-year-shifts');
    }
}
