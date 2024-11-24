<?php

namespace App\Console\Commands;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use App\Models\FinancialYear;
use App\Models\FinancialMonth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NewFinancialYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-financial-year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new financial year';

    /**
     * Execute the console command.
     */
    public function handle()
    {


                $year = Carbon::now()->format('Y');
                $superAdminId = User::where('roles_name', 'سوبر-ادمن')->latest()->first()->id;
                $currentYear = FinancialYear::where('year',$year)->first();
                //dd($currentYear);
                if(!$currentYear) {

              
                    $financialYear = FinancialYear::create([
                        'year' => $year,
                        // 'year_desc' => $this->year_desc,
                        'start_date' => Carbon::now()->startOfYear(),
                        'end_date' => Carbon::now()->endOfYear(),
                        'is_opened' => 1,
                        'created_by' => $superAdminId,
                    ]);

                    $startDate = new DateTime($financialYear->start_date);
                    $endDate = new DateTime($financialYear->end_date);
                    $interval = new DateInterval('P1M');
                    $periods = new DatePeriod($startDate,$interval,$endDate);
                    foreach($periods as $period){
                        //return dd($period->format('t'));
                        $monthStartDate = date('Y-m-01', strtotime($period->format('Y-m-d')));
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
                            'created_by' => $superAdminId,
                            'updated_by' => $superAdminId,
                        ]);

                    }


                }


    }
}
