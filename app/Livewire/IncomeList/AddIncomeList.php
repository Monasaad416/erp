<?php

namespace App\Livewire\IncomeList;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\IncomeList;
use App\Models\CustomerReturn;
use App\Models\SupplierReturn;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInvoiceItem;
use App\Models\IncomeListNetProfit;
use App\Models\SupplierInvoiceItem;
use App\Events\FinancialYearExpensesEvent;
use App\Events\FinancialYearRevenuesEvent;
use App\Events\FinancialYearClosingEntryEvent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddIncomeList extends Component
{
    public $start_date,$end_date,$branch_id;

    // public function updatingBranchId()
    // {
    //     $this->resetPage();
    // }
    public function updatingFromDate()
    {
        $this->resetPage();
    }

    public function updatingToDate()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $currentYear = Carbon::now()->format('Y');
        $this->start_date = $currentYear.'-01-01';
        $this->end_date = $currentYear.'-12-31';
    }

    public function rules() {
        return [
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'branch_id' => 'required|exists:branches,id',
        ];

    }

    public function messages()
    {
        return [
            'start_date.required' => 'تاريخ بداية إصدار قائمة الدخل مطلوب',
            'start_date.date' => 'أدخل صيغة صحيحة لتاريخ بداية إصدار قائمة الدخل  ',
            'start_date.before' => 'تاريخ بداية قائمة الدخل يجب أن يكون قبل تاريخ نهاية القائمة',

            'end_date.required' => 'تاريخ نهاية إصدار قائمة الدخل مطلوب',
            'end_date.date' => 'أدخل صيغة صحيحة لتاريخ نهاية إصدار قائمة الدخل  ',
            'end_date.before' =>  'تاريخ نهاية قائمة الدخل يجب أن يكون بعد تاريخ بداية  القائمة',

            'branch_id.required' => 'اختر الفرع المطلوب  إصدار قائمة الدخل له',
            'branch_id.date' => 'الفرع الذي تم إختياره غير موجود بقاعدة البيانات ',

        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

       
        DB::beginTransaction();
    try {
        $expensesAccounts = Account::where('account_num','like','5'.'%')->where('is_parent',0)
        ->where('branch_id',$this->branch_id)->get();

        $revenuesAccounts = Account::where('account_num', 'like', '4' . '%')->where('is_parent', 0)
            ->where('branch_id', $this->branch_id)->get();

        foreach($expensesAccounts as $exp) {
            $expLedgers = Ledger::where('account_num',$exp->account_num)->whereBetween('created_at',[$this->start_date,$this->end_date])->get();
            $oldIncomeList1 = IncomeList::where('account_num',$exp->account_num)->where('start_date', $this->start_date)->where('end_date', $this->end_date)->first();
            if($oldIncomeList1) {
                    $oldIncomeList1->balance = $expLedgers->sum('debit_amount') - $expLedgers->sum('credit_amount');
                    $oldIncomeList1->save();
            } else {
                $incomeList1 =  new IncomeList();
                $incomeList1->account_id = $exp->id;
                $incomeList1->account_num = $exp->account_num;
                $incomeList1->balance = $expLedgers->sum('debit_amount') - $expLedgers->sum('credit_amount');
                $incomeList1->start_date = $this->start_date;
                $incomeList1->end_date = $this->end_date;
                $incomeList1->name_ar = $exp->name_ar;
                $incomeList1->branch_id = $this->branch_id;
                $incomeList1->type= 'مصروف';
                $incomeList1->save();
            }    
        }
    
        foreach ($revenuesAccounts as $revenue) {
            $revenueLedger = Ledger::where('account_num', $revenue->account_num)->whereBetween('created_at', [$this->start_date, $this->end_date])->get();
            //dd($revenueLedger);
            $oldIncomeList2 = IncomeList::where('account_num',$revenue->account_num)->where('start_date', $this->start_date)->where('end_date', $this->end_date)->first();
            //($oldIncomeList2);
            if($oldIncomeList2) {
                    $oldIncomeList2->balance = $revenueLedger->sum('credit_amount') - $revenueLedger->sum('debit_amount');
                    $oldIncomeList2->save();
            } else {
                $incomeList2 = new IncomeList();
                $incomeList2->account_id = $revenue->id;
                $incomeList2->account_num = $revenue->account_num;
                $incomeList2->balance = $revenueLedger->sum('credit_amount') - $revenueLedger->sum('debit_amount');
                $incomeList2->start_date = $this->start_date;
                $incomeList2->end_date = $this->end_date;
                $incomeList2->name_ar = $revenue->name_ar;
                $incomeList2->branch_id = $this->branch_id;
                $incomeList2->type = 'ايراد';
                $incomeList2->save();
            }    
        }


        // event(new FinancialYearClosingEntryEvent($salesBranchIncome,$salesAssetsBranchIncome,$purchasesBranchIncome , $salesReturnsBranchIncome , $waterBranchIncome , $electricityBranchIncome , $oldIncomeList1, $rentBranchIncome, $internetBranchIncome, $stationryBranchIncome, $transportationBranchIncome, $printersBranchIncome,
        // $salariesBranchIncome , $buildingsBranchDepIncome , $carsBranchDepIncome , $computersBranchDepIncome , $furnitureBranchDepIncome , $POSDevicesDepBranchIncome , $taxBranchIncome));




            $this->reset(['start_date','end_date','branch_id']);



            //dispatch browser events (js)
            //add event to toggle create modal after save
            $this->dispatch('createModalToggle');

            DB::commit();
            Alert::success('تم إضافة قائمة الدخل للعام المالي بنجاح');
            return redirect()->route('income_list');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        }



    }
    public function render()
    {

         return view('livewire.income-list.add-income-list');
        }

}
