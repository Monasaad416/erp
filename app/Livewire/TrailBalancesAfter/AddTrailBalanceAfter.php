<?php

namespace App\Livewire\TrailBalancesAfter;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\TrailBalanceAfter;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddTrailBalanceAfter extends Component
{
        public $start_date,$end_date,$branch_id;

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
            'start_date.required' => 'تاريخ بداية إصدار ميزان المراجعة مطلوب',
            'start_date.date' => 'أدخل صيغة صحيحة لتاريخ بداية إصدار ميزان  ',
            'start_date.before' => 'تاريخ بداية ميزان المراجعة يجب أن يكون قبل تاريخ نهاية الميزان',

            'end_date.required' => 'تاريخ نهاية إصدار ميزان المراجعة مطلوب',
            'end_date.date' => 'أدخل صيغة صحيحة لتاريخ نهاية إصدار ميزان  ',
            'end_date.before' =>  'تاريخ نهاية ميزان المراجعة يجب أن يكون بعد تاريخ بداية  الميزان',

            'branch_id.required' => 'اختر الفرع المطلوب  إصدار ميزان المراجعة له',
            'branch_id.date' => 'الفرع الذي تم إختياره غير موجود بقاعدة البيانات ',

        ];

    }

    public function mount()
    {
        $currentYear = Carbon::now()->format('Y');
        $this->start_date = $currentYear.'-01-01';
        $this->end_date = $currentYear.'-12-31';
    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        // try {

        // return dd($this->all());
        // DB::beginTransaction();

        $purchasesParent = Account::where('account_num',1224)->where('name_ar','المخزون')->first();
        $salesParent = Account::where('account_num',41)->where('name_ar','ايرادات مبيعات')->first();
        $salesReturnParent = Account::where('account_num',42)->where('name_ar','مردودات ومسموحات مبيعات')->first();
        $waterParent = Account::where('account_num',5111)->where('name_ar',"استهلاك المياة")->first();
        $electricityParent = Account::where('account_num',5112)->where('name_ar',"استهلاك الكهرباء")->first();
        $phoneParent = Account::where('account_num',5113)->where('name_ar',"  استهلاك هاتف")->first();
        $rentParent = Account::where('account_num',5114)->where('name_ar', "ايجار")->first();
        $internetParent = Account::where('account_num',5115)->where('name_ar', "انترنت")->first();
        $stationryParent = Account::where('account_num',5116)->where('name_ar', "ادوات مكتبية")->first();
        $transportaionParent = Account::where('account_num',5117)->where('name_ar',  "انتقالات")->first();
        $printersParent = Account::where('account_num',5119)->where('name_ar',  "طباعة واحبار")->first();
        $salariesParent = Account::where('account_num',513)->first();

        $purchasesBranch =  Account::where('parent_id',$purchasesParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $salesBranch =  Account::where('parent_id',$salesParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $salesReturnsBranch =  Account::where('parent_id',$salesReturnParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $waterBranch =  Account::where('parent_id',$waterParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $electricityBranch =  Account::where('parent_id',$electricityParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $phoneBranch =  Account::where('parent_id',$phoneParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $rentBranch =  Account::where('parent_id',$rentParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $internetBranch =  Account::where('parent_id',$internetParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $stationryBranch =  Account::where('parent_id',$stationryParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $transportationBranch =  Account::where('parent_id',$transportaionParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $printerBranch =  Account::where('parent_id',$printersParent->id)->where('branch_id',$this->branch_id)->first()->id;
        $salariesBranch =  Account::where('parent_id',$salariesParent->id)->where('branch_id',$this->branch_id)->first()->id;


        $ids = compact(
            'purchasesBranch',
            'salesBranch',
            'salesReturnsBranch',
            'waterBranch',
            'electricityBranch',
            'phoneBranch',
            'rentBranch',
            'internetBranch',
            'stationryBranch',
            'transportationBranch',
            'printerBranch',
            'salariesBranch'
        );

    //dd($ids);


        $account = Account::whereNotIn('id',$ids)->where('branch_id',$this->branch_id)->get();
        dd($account);


        $purchasesBranchLedger = Ledger::where('account_id',$purchasesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->pluck('id')->toArray();
        $salesBranchLedger = Ledger::where('account_id',$salesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $salesReturnsBranchLedger = Ledger::where('account_id',$salesReturnsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $waterBranchLedger = Ledger::where('account_id',$waterBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $electricityBranchLedger = Ledger::where('account_id',$electricityBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $phoneBranchLedger = Ledger::where('account_id',$phoneBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $rentBranchLedger = Ledger::where('account_id',$rentBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $internetBranchLedger = Ledger::where('account_id',$internetBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $stationryBranchLedger = Ledger::where('account_id',$stationryBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $transportationBranchLedger = Ledger::where('account_id',$transportationBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $printerBranchLedger = Ledger::where('account_id',$printerBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();
        $salariesBranchLedger = Ledger::where('account_id',$salariesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get()->pluck('id')->toArray();


        $removedLedgersIds = array_merge(
            $purchasesBranchLedger,
            $salesBranchLedger,
            $salesReturnsBranchLedger,
            $waterBranchLedger,
            $electricityBranchLedger,
            $phoneBranchLedger,
            $rentBranchLedger,
            $internetBranchLedger,
            $stationryBranchLedger,
            $transportationBranchLedger,
            $printerBranchLedger,
            $salariesBranchLedger
        );









            $this->dispatch('createModalToggle');

            Alert::success('تم إضافة ميزان المراجعة بنجاح');
            return redirect()->route('trail_balance_after');
        // } catch (Exception $e) {
        //     return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        // }



    }


    public function render()
    {
        return view('livewire.trail-balances-before.add-trail-balance-before');
    }
}
