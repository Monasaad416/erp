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
use App\Livewire\FinancialYears\DisplayYears;
use Alert;

class UpdateYear extends Component
{
    protected $listeners = ['editYear'];
    public $year_id,$year,$financialYear, $start_date, $end_date,$is_opened;


    public function editYear($id)
    {
        $this->financialYear = FinancialYear::findOrFail($id);
        $this->year = $this->financialYear->year;
        $this->year_id = $id;
        //dd($this->year);


        $this->start_date = $this->financialYear->start_date;
        $this->end_date = $this->financialYear->end_date;
        $this->is_opened = $this->financialYear->is_opened;

        //return dd($this->is_active);

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('editModalToggle');

    }


    public function rules() {
        return [
            'year' => 'digits:4|integer|min:1900|max:'.(date('Y')+1),
            'start_date' => "date",
            'end_date' => "date",
            'is_opened' => "in:0,1",
        ];
    }

    public function messages()
    {
        return [
            // 'year.unique' => 'السنة المالية المدخلة بالفعل موجوده',

            'year_desc.string' => 'وصف السنة المالية يجب أن يكون أحرف   ',
            'year_desc.max' => 'أقصي عدد أحرف للوصف هو 255'  ,

            'start_date.date' => 'تاريخ بداية السنة المالية يجب أن يكون تاريخ',

            'end_date.date' => 'تاريخ نهاية السنة المالية يجب أن يكون تاريخ',

            'is_opened.required' => 'حالة السنة المالية مطلوبة',
        ];

    }

    public function update()
    {
        try{

            $data = $this->validate($this->rules() ,$this->messages());


            //$this->year->update(array_merge($data, ['updated_by' => Auth::user()->id]));


            $financialYear = FinancialYear::findOrFail($this->year_id);
           // dd($financialYear);


            if($this->start_date != $financialYear->start_date || $this->end_date != $financialYear->end_date) {
                //return dd($this->year_id);
                $financilMonths = FinancialMonth::where('financial_year_id',23)->get();
                //return dd($financilMonths);
                foreach($financilMonths as $month) {
                    $month->delete();
                }


                //insert new months

                $startDate = new DateTime($this->start_date);

                $endDate = new DateTime($this->end_date);
                $interval = new DateInterval('P1M');
                $periods = new DatePeriod($startDate,$interval,$endDate);
                //return dd($periods);
                foreach($periods as $period){
                    //return dd($period->format('t'));
                    $monthStartDate = date('Y-m-01', strtotime($period->format('Y-m-d')));
                    //return dd($monthStartDate);
                    $monthEndtDate = date('Y-m-t', strtotime($period->format('Y-m-d')));
                    //return dd($monthEndtDate);

                    FinancialMonth::create([
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
                        'branch_code' => Auth::user()->branch_code,
                    ]);
                }
            } else {
                $financialYear->update([
                    'year' => $this->year,
                    'is_opened' => $this->is_opened == "on" ? 1 : 0,
                    'updated_by' => Auth::user()->id,
                    'company_code' => Auth::user()->company_code,
                ]);
            }

            $this->reset(['year','start_date','end_date','is_opened']);
            //dispatch browser events (js)
            //add event to toggle update modal after save
            $this->dispatch('editModalToggle');

            //refrsh data after adding update row
            // $this->dispatch('refreshData')->to(DisplayYears::class);

            Alert::success('تم تعديل بيانات السنة المالية بنجاح');
            return redirect()->route('financial_years');
        } catch (Exception $e) {
             DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        }

    }
    public function render()
    {
        return view('livewire.financial-years.update-year');
    }
}
