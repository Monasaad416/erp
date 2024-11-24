<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Reward;
use App\Models\Deduction;
use App\Models\FinancialYear;
use App\Models\FinancialMonth;
use Illuminate\Console\Command;

class AddSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-salary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Salaries monthly for employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $currentFinancialYear = FinancialYear::where('year',$currentYear)->first();
        $currentFinancialMonth = FinancialMonth::where('month_id',$currentMonth)->first();
        foreach(User::where('work_status','working')->get() as $user)
        {
            $deductions = Deduction::where('user_id',$user->id)
            ->where('financial_year_id',$currentFinancialYear->id)
            ->where('financial_month_id',$currentFinancialMonth->id)
            ->sum('amount');
            $rewards = Reward::where('user_id',$user->id)
            ->where('financial_year_id',$currentFinancialYear->id)
            ->where('financial_month_id',$currentFinancialMonth->id)
            ->sum('amount');

        }
    }
}
