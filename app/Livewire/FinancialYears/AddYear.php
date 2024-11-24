<?php

namespace App\Livewire\FinancialYears;

use DateTime;
use Exception;
use DatePeriod;
use DateInterval;
use Livewire\Component;
use App\Models\FinancialYear;
use App\Models\FinancialMonth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Alert;

class AddYear extends Component
{

    public $year, $start_date, $end_date,$is_opened;

    public function rules() {
        return [
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            // 'year_desc' => "required|int",
            'start_date' => "required|date",
            'end_date' => "required|date",
            // 'is_opened' => "required|in:0,1",
        ];
    }

    public function messages()
    {
        return [
            'year.required' => 'السنة المالية مطلوبة',
            'year.unique' => 'السنة المالية المدخلة بالفعل موجوده',


            'start_date.required' => 'تاريخ بداية السنة المالية مطلوب',
            'start_date.date' => 'تاريخ بداية السنة المالية يجب أن يكون تاريخ',

            'end_date.required' => 'تاريخ نهاية السنة المالية مطلوب',
            'end_date.date' => 'تاريخ نهاية السنة المالية يجب أن يكون تاريخ',

            // 'is_opened.required' => 'حالة السنة المالية مطلوبة',
        ];

    }

    public function create () {
            // try{
            //     //return dd($this->all());

             DB::beginTransaction();

                $financialYear = FinancialYear::create([
                    'year' => $this->year,
                    // 'year_desc' => $this->year_desc,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'is_opened' => 1,
                    'created_by' => Auth::user()->id,
                ]);
                if($financialYear) {
                    $startDate = new DateTime($this->start_date);
                    $endDate = new DateTime($this->end_date);
                    $interval = new DateInterval('P1M');
                    $periods = new DatePeriod($startDate,$interval,$endDate);
                    foreach($periods as $period){
                        //return dd($period->format('t'));
                        $monthStartDate = date('Y-m-01', strtotime($period->format('Y-m-d')));
                        $monthEndtDate = date('Y-m-t', strtotime($period->format('Y-m-d')));
                        //return dd($monthEndtDate);


                        $month = FinancialMonth::create([
                            'financial_year_id' => $financialYear->id,
                            'month_id' => $period->format('m'),
                            'month_name' => $period->format('F'),
                            'no_of_days' => $period->format('t'),
                            'year' =>  $financialYear->year,
                            'start_date' => $monthStartDate,
                            'end_date' => $monthEndtDate,
                            'signature_start_date' => $monthStartDate,
                            'signature_end_date' => $monthEndtDate,
                            'is_opened' => 1 ,
                            'created_by' => Auth::user()->id,
                            'updated_by' => Auth::user()->id,
                            'year_desc' => Auth::user()->year_desc,
                            'branch_code' => Auth::user()->branch_code,
                        ]);

                        //return dd($month);
                    }
                }

                DB::commit();
                $this->reset(['year','start_date', 'end_date','is_opened']);



                //dispatch browser events (js)
                //add event to toggle create modal after save
                $this->dispatch('createModalToggle');

                //refrsh data after adding new row

                Alert::success('تم إضافة سنة مالية جديدة بنجاح');
                return redirect()->route('financial_years');
        // } catch (Exception $e) {
        //      DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        // }
    }

    public function render()
    {

        return view('livewire.financial-years.add-year');
    }
}
