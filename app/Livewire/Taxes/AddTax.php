<?php

namespace App\Livewire\Taxes;

use Alert;
use Carbon\Carbon;
use App\Models\Taxes;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\JournalEntry;
use App\Models\AdjustedTaxes;
use Illuminate\Support\Facades\DB;
use App\Events\TaxesAdjustmentEvent;

class AddTax extends Component
{
        public $start_date,$end_date,$quarter ,$branch_id;

    public function rules() {
        return [
            // 'start_date' => 'required|date|before:end_date',
            // 'end_date' => 'required|date|after:start_date',
            'branch_id' => 'required|exists:branches,id',
            'quarter' => 'required|in:1,2,3,4',
        ];

    }

    public function messages()
    {
        return [
            'branch_id.required' => 'اختر الفرع المطلوب  إصدار ميزان مبلغ الضرائب له',
            'branch_id.date' => 'الفرع الذي تم إختياره غير موجود بقاعدة البيانات ',
            'quarter.required' => 'إختر الربع المالي المطلوب حساب الضرائب فيه',
        ];

    }

    public function quarterChanged() {
        // dd(Carbon::now()->month);
        $currentYear = Carbon::now()->format('Y');
        if($this->quarter == 1) {
            $this->start_date = $currentYear.'-01-01';
            $this->end_date = $currentYear.'-03-31';
        }

        if($this->quarter == 2) {
            $this->start_date = $currentYear.'-04-01' ;
            $this->end_date = $currentYear.'-06-30' ;
        }

        if($this->quarter == 3) {
            $this->start_date =   $currentYear.'-07-01';
            $this->end_date =   $currentYear.'-09-30';
        }

        if($this->quarter == 4) {
            $this->start_date =   $currentYear.'-10-01';
            $this->end_date =   $currentYear.'-12-31';
        }
    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        // try {

        // return dd($this->all());
       DB::beginTransaction();

        $taxesInParent = Account::where('account_num',1236)->where('name_ar',"ضريبة القيمة المضافة على المدخلات")->first();
        $taxesOutParent = Account::where('account_num',2231)->where('name_ar',"ضريبة القيمة المضافة على المخرجات")->first();

        $adjustTaxesParent = Account::where('account_num',2232)->where('name_ar',"تسوية ضريبة القيمة المضافة")->first();
        //dd($adjustTaxesParent);

        $taxesInBranch =  Account::where('parent_id',$taxesInParent->id)->where('branch_id',$this->branch_id)->first();
        $taxesOutBranch =  Account::where('parent_id',$taxesOutParent->id)->where('branch_id',$this->branch_id)->first();

        $adjustTaxesBranch =  Account::where('parent_id',$adjustTaxesParent->id)->where('branch_id',$this->branch_id)->first();

        //dd($taxesInBranch);


        //حساب وتسوية ضرائب الربع سنوية
        $taxesInBranchLedge = Ledger::where('account_id',$taxesInBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();
        $taxesOutBranchLedger = Ledger::where('account_id',$taxesOutBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        // $taxesInBranchLedgerSec = Ledger::where('account_id',$taxesInBranch->id)->whereBetween('date',[$this->start_date_sec,$this->end_date_sec])->get();
        // $taxesOutBranchLedgerSec = Ledger::where('account_id',$taxesOutBranch->id)->whereBetween('date',[$this->start_date_sec,$this->end_date_sec])->get();

        // $taxesInBranchLedgerThird = Ledger::where('account_id',$taxesInBranch->id)->whereBetween('date',[$this->start_date_third,$this->end_date_third])->get();
        // $taxesOutBranchLedgerThird = Ledger::where('account_id',$taxesOutBranch->id)->whereBetween('date',[$this->start_date_third,$this->end_date_third])->get();

        // $taxesInBranchLedgerForth = Ledger::where('account_id',$taxesInBranch->id)->whereBetween('date',[$this->start_date_forth,$this->end_date_forth])->get();
        // $taxesOutBranchLedgerForth = Ledger::where('account_id',$taxesOutBranch->id)->whereBetween('date',[$this->start_date_forth,$this->end_date_forth])->get();

        $taxesIn = $taxesInBranchLedge->sum('debit_amount') - $taxesInBranchLedge->sum('credit_amount');
        $taxesOut = $taxesOutBranchLedger->sum('credit_amount') - $taxesOutBranchLedger->sum('debit_amount');



            $taxes = Taxes::where('start_date',$this->start_date)->where('end_date',$this->end_date)->whereYear('created_at',Carbon::now()->year)->first();
            $adjustedTaxesWithZatca = AdjustedTaxes::where('start_date',$this->start_date)->where('end_date',$this->end_date)->whereYear('created_at',Carbon::now()->year)->first();


            if ($taxes != null){
                $taxes->in_amount = $taxesIn;
                $taxes->out_amount = $taxesOut;
                $taxes->difference = $taxesOut-$taxesIn;
                $taxes->start_date = $this->start_date;
                $taxes->end_date = $this->end_date;
                $taxes->branch_id = $this->branch_id;
                $taxes->save();

                // تسوية الضرائب مع الهيأة
                if($adjustedTaxesWithZatca->is_adjusted == 0 ) {
                    $adjustedTaxesWithZatca->start_date = $this->start_date;
                    $adjustedTaxesWithZatca->end_date = $this->end_date;
                    $adjustedTaxesWithZatca->amount = $taxes->in_amount - $taxes->out_amount;
                } else {
                    return $this->dispatch(
                        'alert',
                        text: 'عفوأ لا يمكن تغيير قيمة الضرائب بعد تسويتها مع هيأة الزكاة والضريبة والجمارك في الربع المحدد',
                        icon: 'error',
                        confirmButtonText: trans('admin.done')
                    );
                }
            } else {

                $newTaxes = new Taxes();
                $newTaxes->in_amount = $taxesIn;
                $newTaxes->out_amount = $taxesOut;
                $newTaxes->difference = $taxesOut-$taxesIn;
                $newTaxes->start_date = $this->start_date;
                $newTaxes->end_date = $this->end_date;
                $newTaxes->branch_id = $this->branch_id;
                $newTaxes->save();

                $newTaxesWithZatca = new AdjustedTaxes();
                $newTaxesWithZatca->amount = $newTaxes->difference;
                $newTaxesWithZatca->start_date = $this->start_date;
                $newTaxesWithZatca->end_date = $this->end_date;
                $newTaxesWithZatca->is_adjusted = false;
                $newTaxesWithZatca->branch_id = $this->branch_id;
                $newTaxesWithZatca->save();
                //dd($taxesIn,$taxesOut,$this->start_date,$this->end_date);
            }



        // $taxesInSec = $taxesInBranchLedgerSec->sum('debit_amount') - $taxesInBranchLedgerSec->sum('credit_amount');
        // $taxesOutSec = $taxesOutBranchLedgerSec->sum('debit_amount') - $taxesOutBranchLedgerSec->sum('credit_amount');


        // if($this->start_date_sec != null && $this->end_date_sec != null) {
        //     $taxesSec = Taxes::where('start_date',$this->start_date_sec)->where('end_date',$this->end_date_sec)->whereYear('date',Carbon::now()->year)->first();
        //     $adjustedTaxesWithZatcaSec = AdjustedTaxes::where('start_date',$this->start_date_sec)->where('end_date',$this->end_date_sec)->whereYear('date',Carbon::now()->year)->first();

        //     if ($taxesSec){
        //         $taxesSec->in_amount = $taxesInSec;
        //         $taxesSec->out_amount = $taxesOutSec;
        //         $taxesSec->difference = $taxesInSec-$taxesOutSec;
        //         $taxesSec->start_date = $this->start_date_sec;
        //         $taxesSec->end_date = $this->end_date_sec;
        //         $taxesSec->branch_id = $this->branch_id;
        //         $taxesSec->save();

        //         // تسوية الضرائب مع الهيأة
        //         if($adjustedTaxesWithZatcaSec->is_adjusted == 0 ) {
        //             $adjustedTaxesWithZatcaSec->start_date = $this->start_date_sec;
        //             $adjustedTaxesWithZatcaSec->end_date = $this->end_date_sec;
        //             $adjustedTaxesWithZatcaSec->amount = $taxesSec->in_amount - $taxesSec->out_amount;
        //         } else {
        //             $this->dispatch(
        //                 'alert',
        //                 text: 'عفوأ لا يمكن تغيير قيمة الضرائب بعد تسويتها مع هيأة الزكاة والضريبة والجمارك في الربع المحدد',
        //                 icon: 'error',
        //                 confirmButtonText: trans('admin.done')
        //             );
        //         }
        //     } else {
        //         $newTaxesSec = new Taxes();
        //         $newTaxesSec->in_amount = $taxesInSec;
        //         $newTaxesSec->out_amount = $taxesOutSec;
        //         $newTaxesSec->difference = $taxesInSec-$taxesOutSec;
        //         $newTaxesSec->start_date = $this->start_date_sec;
        //         $newTaxesSec->end_date = $this->end_date_sec;
        //         $newTaxesSec->branch_id = $this->branch_id;
        //         $newTaxesSec->save();

        //         $newTaxesWithZatca = new AdjustedTaxes();
        //         $newTaxesWithZatca->amount = $newTaxesSec->in_amount - $newTaxesSec->out_amount;
        //         $newTaxesWithZatca->start_date = $this->start_date_sec;
        //         $newTaxesWithZatca->end_date = $this->end_date_sec;
        //         $newTaxesWithZatca->is_adjusted = false;
        //         $newTaxesWithZatca->branch_id = $this->branch_id;
        //         $newTaxesWithZatca->save();

        //     }
        //     // event(new TaxesAdjustmentEvent($taxesSec));
        // }

        // $taxesInThird = $taxesInBranchLedgerThird->sum('debit_amount') - $taxesInBranchLedgerThird->sum('credit_amount');
        // $taxesOutThird = $taxesOutBranchLedgerThird->sum('debit_amount') - $taxesOutBranchLedgerThird->sum('credit_amount');


        // if($this->start_date_third != null && $this->end_date_third != null) {
        //     $taxesThird = Taxes::where('start_date',$this->start_date_third)->where('end_date',$this->end_date_third)->whereYear('date',Carbon::now()->year)->first();
        //     $adjustedTaxesWithZatcaThird = AdjustedTaxes::where('start_date',$this->start_date_third)->where('end_date',$this->end_date_third)->whereYear('date',Carbon::now()->year)->first();

        //     if ($taxesThird){
        //         $taxesThird->in_amount = $taxesInThird;
        //         $taxesThird->out_amount = $taxesOutThird;
        //         $taxesThird->difference = $taxesInThird-$taxesOutThird;
        //         $taxesThird->start_date = $this->start_date_third;
        //         $taxesThird->end_date = $this->end_date_third;
        //         $taxesThird->branch_id = $this->branch_id;
        //         $taxesThird->save();

        //         // تسوية الضرائب مع الهيأة
        //         if($adjustedTaxesWithZatcaThird->is_adjusted == 0 ) {
        //             $adjustedTaxesWithZatcaThird->start_date = $this->start_date_third;
        //             $adjustedTaxesWithZatcaThird->end_date = $this->end_date_third;
        //             $adjustedTaxesWithZatcaThird->amount = $taxesThird->in_amount - $taxesThird->out_amount;
        //         } else {
        //             $this->dispatch(
        //                 'alert',
        //                 text: 'عفوأ لا يمكن تغيير قيمة الضرائب بعد تسويتها مع هيأة الزكاة والضريبة والجمارك في الربع المحدد',
        //                 icon: 'error',
        //                 confirmButtonText: trans('admin.done')
        //             );
        //         }
        //     } else {
        //         $newTaxesThird = new Taxes();
        //         $newTaxesThird->in_amount = $taxesInThird;
        //         $newTaxesThird->out_amount = $taxesOutThird;
        //         $newTaxesThird->difference = $taxesInThird-$taxesOutThird;
        //         $newTaxesThird->start_date = $this->start_date_third;
        //         $newTaxesThird->end_date = $this->end_date_third;
        //         $newTaxesThird->branch_id = $this->branch_id;
        //         $newTaxesThird->save();

        //         $newTaxesWithZatca = new AdjustedTaxes();
        //         $newTaxesWithZatca->amount = $newTaxesThird->in_amount - $newTaxesThird->out_amount;
        //         $newTaxesWithZatca->start_date = $this->start_date_third;
        //         $newTaxesWithZatca->end_date = $this->end_date_third;
        //         $newTaxesWithZatca->is_adjusted = false;
        //         $newTaxesWithZatca->branch_id = $this->branch_id;
        //         $newTaxesWithZatca->save();

        //     }

        //     // event(new TaxesAdjustmentEvent($taxesThird));
        // }



        // $taxesInForth = $taxesInBranchLedgerForth->sum('debit_amount') - $taxesInBranchLedgerForth->sum('credit_amount');
        // $taxesOutForth = $taxesOutBranchLedgerForth->sum('debit_amount') - $taxesOutBranchLedgerForth->sum('credit_amount');



        // if($this->start_date_forth != null && $this->end_date_forth != null) {
        //     $taxesForth = Taxes::where('start_date',$this->start_date_forth)->where('end_date',$this->end_date_forth)->whereYear('date',Carbon::now()->year)->first();
        //     $adjustedTaxesWithZatcaForth = AdjustedTaxes::where('start_date',$this->start_date_forth)->where('end_date',$this->end_date_forth)->whereYear('date',Carbon::now()->year)->first();

        //     if ($taxesForth){
        //         $taxesForth->in_amount = $taxesInForth;
        //         $taxesForth->out_amount = $taxesOutForth;
        //         $taxesForth->difference = $taxesInForth-$taxesOutForth;
        //         $taxesForth->start_date = $this->start_date_forth;
        //         $taxesForth->end_date = $this->end_date_forth;
        //         $taxesForth->branch_id = $this->branch_id;
        //         $taxesForth->save();

        //         // تسوية الضرائب مع الهيأة
        //         if($adjustedTaxesWithZatcaForth->is_adjusted == 0 ) {
        //             $adjustedTaxesWithZatcaForth->start_date = $this->start_date_forth;
        //             $adjustedTaxesWithZatcaForth->end_date = $this->end_date_forth;
        //             $adjustedTaxesWithZatcaForth->amount = $taxesForth->in_amount - $taxesForth->out_amount;
        //         } else {
        //             $this->dispatch(
        //                 'alert',
        //                 text: 'عفوأ لا يمكن تغيير قيمة الضرائب بعد تسويتها مع هيأة الزكاة والضريبة والجمارك في الربع المحدد',
        //                 icon: 'error',
        //                 confirmButtonText: trans('admin.done')
        //             );
        //         }
        //     } else {
        //         $newTaxesForth = new Taxes();
        //         $newTaxesForth->in_amount = $taxesInForth;
        //         $newTaxesForth->out_amount = $taxesOutForth;
        //         $newTaxesForth->difference = $taxesInForth-$taxesOutForth;
        //         $newTaxesForth->start_date = $this->start_date_forth;
        //         $newTaxesForth->end_date = $this->end_date_forth;
        //         $newTaxesForth->branch_id = $this->branch_id;
        //         $newTaxesForth->save();

        //         $newTaxesWithZatca = new AdjustedTaxes();
        //         $newTaxesWithZatca->amount = $newTaxesForth->in_amount - $newTaxesForth->out_amount;
        //         $newTaxesWithZatca->start_date = $this->start_date_forth;
        //         $newTaxesWithZatca->end_date = $this->end_date_forth;
        //         $newTaxesWithZatca->is_adjusted = false;
        //         $newTaxesWithZatca->branch_id = $this->branch_id;
        //         $newTaxesWithZatca->save();

        //     }

        //     // event(new TaxesAdjustmentEvent($taxesForth));
        // }







        DB::commit();





            $this->dispatch('createModalFirstToggle');
            // $this->dispatch('createModalSecToggle');
            // $this->dispatch('createModalThirdToggle');
            // $this->dispatch('createModalForthToggle');

            Alert::success('تم إضافة الضرائب بنجاح');
            return redirect()->route('taxes');
        // } catch (Exception $e) {
            //DB::rollback();
        //     return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        // }



    }
    public function render()
    {
        return view('livewire.taxes.add-tax');
    }
}
