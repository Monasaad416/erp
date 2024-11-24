<?php

namespace App\Livewire\ClosingEntries;

use Alert;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\ClosingEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AddEntry extends Component
{
    public $start_date,$end_date,$branch_id;

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
            'start_date.required' => 'تاريخ بداية إصدار قيد الاقفال مطلوب',
            'start_date.date' => 'أدخل صيغة صحيحة لتاريخ بداية إصدار قيد الاقفال  ',
            'start_date.before' => 'تاريخ بداية قيد الاقفال يجب أن يكون قبل تاريخ نهاية القيد',

            'end_date.required' => 'تاريخ نهاية إصدار قيد الاقفال مطلوب',
            'end_date.date' => 'أدخل صيغة صحيحة لتاريخ نهاية إصدار قيد الاقفال  ',
            'end_date.before' =>  'تاريخ نهاية قيد الاقفال يجب أن يكون بعد تاريخ بداية  القيد',

            'branch_id.required' => 'اختر الفرع المطلوب  إصدار قيد الاقفال له',
            'branch_id.date' => 'الفرع الذي تم إختياره غير موجود بقاعدة البيانات ',
        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        // try {
        DB::beginTransaction();

        $incomeSummaryParent = Account::where('account_num',311)->first();//حساب ملخص الدخل
        $incomeSummaryBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$incomeSummaryParent->id)->where('branch_id',$this->branch_id)->first();//حساب ملخص الدخل للفرع
        $incomeSummaryLedger = Ledger::where('account_id',$incomeSummaryBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();//الاستاذ العام لمخلص الدخل مدين - دائن

        //إغلاق المصروفات من ح ملخص الدخل الي ح  المصروف

        // بند  مصروف المخزون
        //من ح ملخص الدخل الي حساب المخزون
        $purchasesParent = Account::where('account_num',1224)->where('name_ar','المخزون')->first();
        $purchasesBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$purchasesParent->id)->where('branch_id',$this->branch_id)->first();
        $purchasesBranchLedger = Ledger::where('account_id',$purchasesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry1 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$purchasesBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry1) {
            $entry1->debit_amount = $purchasesBranchLedger->sum('debit_amount') - $purchasesBranchLedger->sum('credit_amount');
            $entry1->credit_amount = $purchasesBranchLedger->sum('debit_amount') - $purchasesBranchLedger->sum('credit_amount');
            $entry1->updated_by = Auth::user()->id;
            $entry1->save();

            $ledger11 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry1->id)->first();
            $ledger12 = Ledger::where('account_id',$purchasesBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry1->id)->first();

            // dd($ledger12);

            //الاستاذ العام لملخص الدخل المدين
            $ledger11->debit_amount = $entry1->debit_amount;
            $ledger11->updated_by = Auth::user()->id;
            $ledger11->save();

            //الاستاذ العام للمخزون دائن
            $ledger12->credit_amount = $entry1->debit_amount;
            $ledger12->updated_by = Auth::user()->id;
            $ledger12->save();

        } else {
            $entry = getNextClosingEntryNum();
            $entry1 = new ClosingEntry();
            $entry1->entry_num = $entry;
            $entry1->debit_account_num = $incomeSummaryBranch->account_num;
            $entry1->debit_account_id = $incomeSummaryBranch ->id;
            $entry1->credit_account_num = $purchasesBranch->account_num;
            $entry1->credit_account_id = $purchasesBranch->id;
            $entry1->debit_amount = $purchasesBranchLedger->sum('debit_amount') - $purchasesBranchLedger->sum('credit_amount');
            $entry1->credit_amount = $purchasesBranchLedger->sum('debit_amount') - $purchasesBranchLedger->sum('credit_amount');
            $entry1->branch_id = $this->branch_id;
            $entry1->entry_type_id = 5 ;
            $entry1->start_date = $this->start_date;
            $entry1->end_date = $this->end_date;
            $entry1->created_by = Auth::user()->id;
            $entry1->updated_by = Auth::user()->id;
            $entry1->description = "من ح  /  " .  $incomeSummaryBranch->name   ."الي ح  /   ". $purchasesBranch->name  ;
            $entry1->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger11 = new Ledger();
            $ledger11->debit_amount = $entry1->debit_amount;
            $ledger11->credit_amount = 0;
            $ledger11->account_id = $incomeSummaryBranch->id;
            $ledger11->account_num = $incomeSummaryBranch->account_num;
            $ledger11->name_ar= $incomeSummaryBranch->name;
            $ledger11->created_by = Auth::user()->id;
            $ledger11->closing_entry_id = $entry1->id;
            $ledger11->type = 'closing_entry';
            $ledger11->save();


            //الاستاذ العام للمخزون دائن
            $ledger12 = new Ledger();
            $ledger12->debit_amount = 0;
            $ledger12->credit_amount = $entry1->debit_amount;
            $ledger12->account_id = $purchasesBranch->id;
            $ledger12->account_num = $purchasesBranch->account_num;
            $ledger12->name_ar= $purchasesBranch->name;
            $ledger12->created_by = Auth::user()->id;
            $ledger12->closing_entry_id = $entry1->id;
            $ledger12->type = 'closing_entry';
            $ledger12->save();
        }




        // بند  مصروف مردودات المبيعات
        //من ح ملخص الدخل الي حساب مردودات المبيعات
        $salesReturnParent = Account::where('account_num',42)->where('name_ar','مردودات ومسموحات مبيعات')->first();
        $salesReturnsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$salesReturnParent->id)->where('branch_id',$this->branch_id)->first();
        $salesReturnsBranchLedger = Ledger::where('account_id',$salesReturnsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();



        $entry2 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$salesReturnsBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry2) {
            $entry2->debit_amount = $salesReturnsBranchLedger->sum('debit_amount') - $salesReturnsBranchLedger->sum('credit_amount');
            $entry2->credit_amount = $salesReturnsBranchLedger->sum('debit_amount') - $salesReturnsBranchLedger->sum('credit_amount');
            $entry2->updated_by = Auth::user()->id;
            $entry2->save();

            $ledger21 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry2->id)->first();
            $ledger22 = Ledger::where('account_id',$salesReturnsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry2->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger21->debit_amount = $entry2->debit_amount;
            $ledger21->updated_by = Auth::user()->id;
            $ledger21->save();

            //الاستاذ العام لمردودات المبيعات دائن
            $ledger22->credit_amount = $entry2->debit_amount;
            $ledger22->updated_by = Auth::user()->id;
            $ledger22->save();

        } else {
            $entry = getNextClosingEntryNum();
            $entry2 = new ClosingEntry();
            $entry2->entry_num = $entry;
            $entry2->debit_account_num = $incomeSummaryBranch->account_num;
            $entry2->debit_account_id = $incomeSummaryBranch ->id;
            $entry2->credit_account_num = $salesReturnsBranch->account_num;
            $entry2->credit_account_id = $salesReturnsBranch->id;
            $entry2->debit_amount = $salesReturnsBranchLedger->sum('debit_amount') - $salesReturnsBranchLedger->sum('credit_amount');
            $entry2->credit_amount = $salesReturnsBranchLedger->sum('debit_amount') - $salesReturnsBranchLedger->sum('credit_amount');
            $entry2->branch_id = $this->branch_id;
            $entry2->entry_type_id = 5 ;
            $entry2->start_date = $this->start_date;
            $entry2->end_date = $this->end_date;
            $entry2->created_by = Auth::user()->id;
            $entry2->updated_by = Auth::user()->id;
            $entry2->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $salesReturnsBranch->name  ;
            $entry2->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger21 = new Ledger();
            $ledger21->debit_amount = $entry2->debit_amount;
            $ledger21->credit_amount = 0;
            $ledger21->account_id = $incomeSummaryBranch->id;
            $ledger21->account_num = $incomeSummaryBranch->account_num;
            $ledger21->name_ar= $incomeSummaryBranch->name;
            $ledger21->created_by = Auth::user()->id;
            $ledger21->closing_entry_id = $entry2->id;
            $ledger21->type = 'closing_entry';
            $ledger21->save();

            //الاستاذ العام لمردودات المبيعات دائن
            $ledger22 = new Ledger();
            $ledger22->debit_amount = 0;
            $ledger22->credit_amount = $entry2->debit_amount;
            $ledger22->account_id = $salesReturnsBranch->id;
            $ledger22->account_num = $salesReturnsBranch->account_num;
            $ledger22->name_ar= $salesReturnsBranch->name;
            $ledger22->created_by = Auth::user()->id;
            $ledger22->closing_entry_id = $entry2->id;
            $ledger22->type = 'closing_entry';
            $ledger22->save();

        }

        // بند  مصروف استهلاك المياه للفرع
        //من ح ملخص الدخل الي حساب استهلاك المياه
        $waterParent = Account::where('account_num',5111)->where('name_ar',"استهلاك المياة")->first();
        $waterBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$waterParent->id)->where('branch_id',$this->branch_id)->first();
        $waterBranchLedger = Ledger::where('account_id',$waterBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        $entry3 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$waterBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();

        if($entry3) {
            $entry3->debit_amount = $waterBranchLedger->sum('debit_amount') - $waterBranchLedger->sum('credit_amount');
            $entry3->credit_amount = $waterBranchLedger->sum('debit_amount') - $waterBranchLedger->sum('credit_amount');
            $entry3->updated_by = Auth::user()->id;
            $entry3->save();


            $ledger31 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry3->id)->first();
            $ledger32 = Ledger::where('account_id',$waterBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry3->id)->first();


            //الاستاذ العام لملخص الدخل المدين
            $ledger31->debit_amount = $entry3->debit_amount;
            $ledger31->updated_by = Auth::user()->id;
            $ledger31->save();

            //الاستاذ العام لاستهلاك المياة دائن
            $ledger32->credit_amount = $entry3->debit_amount;
            $ledger32->updated_by = Auth::user()->id;
            $ledger32->save();

        } else {

            $entry = getNextClosingEntryNum();
            $entry3 = new ClosingEntry();
            $entry3->entry_num = $entry;
            $entry3->debit_account_num = $incomeSummaryBranch->account_num;
            $entry3->debit_account_id = $incomeSummaryBranch ->id;
            $entry3->credit_account_num = $waterBranch->account_num;
            $entry3->credit_account_id = $waterBranch->id;
            $entry3->debit_amount = $waterBranchLedger->sum('debit_amount') - $waterBranchLedger->sum('credit_amount');
            $entry3->credit_amount = $waterBranchLedger->sum('debit_amount') - $waterBranchLedger->sum('credit_amount');
            $entry3->branch_id = $this->branch_id;
            $entry3->entry_type_id = 5 ;
            $entry3->start_date = $this->start_date;
            $entry3->end_date = $this->end_date;
            $entry3->created_by = Auth::user()->id;
            $entry3->updated_by = Auth::user()->id;
            $entry3->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $waterBranch->name  ;
            $entry3->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger31 = new Ledger();
            $ledger31->debit_amount = $entry3->debit_amount;
            $ledger31->credit_amount = 0;
            $ledger31->account_id = $incomeSummaryBranch->id;
            $ledger31->account_num = $incomeSummaryBranch->account_num;
            $ledger31->name_ar= $incomeSummaryBranch->name;
            $ledger31->created_by = Auth::user()->id;
            $ledger31->closing_entry_id = $entry3->id;
            $ledger31->type = 'closing_entry';
            $ledger31->save();

            //الاستاذ العام لاستهلاك المياة دائن
            $ledger32 = new Ledger();
            $ledger32->debit_amount = 0;
            $ledger32->credit_amount = $entry3->debit_amount;
            $ledger32->account_id = $waterBranch->id;
            $ledger32->account_num = $waterBranch->account_num;
            $ledger32->name_ar= $waterBranch->name;
            $ledger32->created_by = Auth::user()->id;
            $ledger32->closing_entry_id = $entry3->id;
            $ledger32->type = 'closing_entry';
            $ledger32->save();

        }



        // بند  مصروف استهلاك الكهرباء للفرع
        //من ح ملخص الدخل الي حساب استهلاك الكهرباء
        $electricityParent = Account::where('account_num',5112)->where('name_ar',"استهلاك الكهرباء")->first();
        $electricityBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$electricityParent->id)->where('branch_id',$this->branch_id)->first();
        $electricityBranchLedger = Ledger::where('account_id',$electricityBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry4 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$electricityBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry4) {
            $entry4->debit_amount = $electricityBranchLedger->sum('debit_amount') - $electricityBranchLedger->sum('credit_amount');
            $entry4->credit_amount = $electricityBranchLedger->sum('debit_amount') - $electricityBranchLedger->sum('credit_amount');
            $entry4->updated_by = Auth::user()->id;
            $entry4->save();



            $ledger41 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry4->id)->first();
            $ledger42 = Ledger::where('account_id',$electricityBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry4->id)->first();


            //الاستاذ العام لملخص الدخل المدين
            $ledger41->debit_amount = $entry4->debit_amount;
            $ledger41->updated_by = Auth::user()->id;
            $ledger41->save();

            //الاستاذ العام لاستهلاك الكهرباء دائن
            $ledger42->credit_amount = $entry4->debit_amount;
            $ledger42->updated_by = Auth::user()->id;
            $ledger42->save();


        } else {
            $entry = getNextClosingEntryNum();
            $entry4 = new ClosingEntry();
            $entry4->entry_num = $entry;
            $entry4->debit_account_num = $incomeSummaryBranch->account_num;
            $entry4->debit_account_id = $incomeSummaryBranch ->id;
            $entry4->credit_account_num = $electricityBranch->account_num;
            $entry4->credit_account_id = $electricityBranch->id;
            $entry4->debit_amount = $electricityBranchLedger->sum('debit_amount') - $electricityBranchLedger->sum('credit_amount');
            $entry4->credit_amount = $electricityBranchLedger->sum('debit_amount') - $electricityBranchLedger->sum('credit_amount');
            $entry4->branch_id = $this->branch_id;
            $entry4->entry_type_id = 5 ;
            $entry4->start_date = $this->start_date;
            $entry4->end_date = $this->end_date;
            $entry4->created_by = Auth::user()->id;
            $entry4->updated_by = Auth::user()->id;
            $entry4->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $electricityBranch->name  ;
            $entry4->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger41 = new Ledger();
            $ledger41->debit_amount = $entry4->debit_amount;
            $ledger41->credit_amount = 0;
            $ledger41->account_id = $incomeSummaryBranch->id;
            $ledger41->account_num = $incomeSummaryBranch->account_num;
            $ledger41->name_ar= $incomeSummaryBranch->name;
            $ledger41->created_by = Auth::user()->id;
            $ledger41->closing_entry_id = $entry4->id;
            $ledger41->type = 'closing_entry';
            $ledger41->save();

            //الاستاذ العام لاستهلاك الكهرباء دائن
            $ledger42 = new Ledger();
            $ledger42->debit_amount = 0;
            $ledger42->credit_amount = $entry4->debit_amount;
            $ledger42->account_id = $electricityBranch->id;
            $ledger42->account_num = $electricityBranch->account_num;
            $ledger42->name_ar= $electricityBranch->name;
            $ledger42->created_by = Auth::user()->id;
            $ledger42->closing_entry_id = $entry4->id;
            $ledger42->type = 'closing_entry';
            $ledger42->save();

        }



        // بند  مصروف استهلاك الهواتف للفرع
        //من ح ملخص الدخل الي حساب استهلاك الهواتف
        $phoneParent = Account::where('account_num',5113)->where('name_ar',"  استهلاك هاتف")->first();
        $phoneBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$phoneParent->id)->where('branch_id',$this->branch_id)->first();
        $phoneBranchLedger = Ledger::where('account_id',$phoneBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry5 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$phoneBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry5) {
            $entry5->debit_amount = $phoneBranchLedger->sum('debit_amount') - $phoneBranchLedger->sum('credit_amount');
            $entry5->credit_amount = $phoneBranchLedger->sum('debit_amount') - $phoneBranchLedger->sum('credit_amount');
            $entry5->updated_by = Auth::user()->id;
            $entry5->save();


            $ledger51 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry5->id)->first();
            $ledger52 = Ledger::where('account_id',$phoneBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry5->id)->first();


            //الاستاذ العام لملخص الدخل المدين
            $ledger51->debit_amount = $entry5->debit_amount;
            $ledger51->updated_by = Auth::user()->id;
            $ledger51->save();

            //الاستاذ العام لاستهلاك الهواتف دائن
            $ledger52->credit_amount = $entry5->debit_amount;
            $ledger52->updated_by = Auth::user()->id;
            $ledger52->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry5 = new ClosingEntry();
            $entry5->entry_num = $entry;
            $entry5->debit_account_num = $incomeSummaryBranch->account_num;
            $entry5->debit_account_id = $incomeSummaryBranch ->id;
            $entry5->credit_account_num = $phoneBranch->account_num;
            $entry5->credit_account_id = $phoneBranch->id;
            $entry5->debit_amount = $phoneBranchLedger->sum('debit_amount') - $phoneBranchLedger->sum('credit_amount');
            $entry5->credit_amount = $phoneBranchLedger->sum('debit_amount') - $phoneBranchLedger->sum('credit_amount');
            $entry5->branch_id = $this->branch_id;
            $entry5->entry_type_id = 5 ;
            $entry5->start_date = $this->start_date;
            $entry5->end_date = $this->end_date;
            $entry5->created_by = Auth::user()->id;
            $entry5->updated_by = Auth::user()->id;
            $entry5->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $phoneBranch->name  ;
            $entry5->save();


            //الاستاذ العام لملخص الدخل المدين
            $ledger51 = new Ledger();
            $ledger51->debit_amount = $entry5->debit_amount;
            $ledger51->credit_amount = 0;
            $ledger51->account_id = $incomeSummaryBranch->id;
            $ledger51->account_num = $incomeSummaryBranch->account_num;
            $ledger51->name_ar= $incomeSummaryBranch->name;
            $ledger51->created_by = Auth::user()->id;
            $ledger51->closing_entry_id = $entry5->id;
            $ledger51->type = 'closing_entry';
            $ledger51->save();

            //الاستاذ العام لاستهلاك الهواتف دائن
            $ledger52 = new Ledger();
            $ledger52->debit_amount = 0;
            $ledger52->credit_amount = $entry5->debit_amount;
            $ledger52->account_id = $phoneBranch->id;
            $ledger52->account_num = $phoneBranch->account_num;
            $ledger52->name_ar= $phoneBranch->name;
            $ledger52->created_by = Auth::user()->id;
            $ledger52->closing_entry_id = $entry5->id;
            $ledger52->type = 'closing_entry';
            $ledger52->save();
        }




        // بند  مصروف الايجارات للفرع
        //من ح ملخص الدخل الي حساب الايجارات
        $rentParent = Account::where('account_num',5114)->where('name_ar', "ايجار")->first();
        $rentBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$rentParent->id)->where('branch_id',$this->branch_id)->first();
        $rentBranchLedger = Ledger::where('account_id',$rentBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry6 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$rentBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry6) {
            $entry6->debit_amount = $rentBranchLedger->sum('debit_amount') - $rentBranchLedger->sum('credit_amount');
            $entry6->credit_amount = $rentBranchLedger->sum('debit_amount') - $rentBranchLedger->sum('credit_amount');
            $entry6->updated_by = Auth::user()->id;
            $entry6->save();

            $ledger61 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry6->id)->first();
            $ledger62 = Ledger::where('account_id',$rentBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry6->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger61->debit_amount = $entry6->debit_amount;
            $ledger61->updated_by = Auth::user()->id;
            $ledger61->save();

            //الاستاذ العام للايجارات دائن
            $ledger62->credit_amount = $entry6->debit_amount;
            $ledger62->updated_by = Auth::user()->id;
            $ledger62->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry6 = new ClosingEntry();
            $entry6->entry_num = $entry;
            $entry6->debit_account_num = $incomeSummaryBranch->account_num;
            $entry6->debit_account_id = $incomeSummaryBranch ->id;
            $entry6->credit_account_num = $rentBranch->account_num;
            $entry6->credit_account_id = $rentBranch->id;
            $entry6->debit_amount = $rentBranchLedger->sum('debit_amount') - $rentBranchLedger->sum('credit_amount');
            $entry6->credit_amount = $rentBranchLedger->sum('debit_amount') - $rentBranchLedger->sum('credit_amount');
            $entry6->branch_id = $this->branch_id;
            $entry6->entry_type_id = 5 ;
            $entry6->start_date = $this->start_date;
            $entry6->end_date = $this->end_date;
            $entry6->created_by = Auth::user()->id;
            $entry6->updated_by = Auth::user()->id;
            $entry6->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $rentBranch->name  ;
            $entry6->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger61 = new Ledger();
            $ledger61->debit_amount = $entry6->debit_amount;
            $ledger61->credit_amount = 0;
            $ledger61->account_id = $incomeSummaryBranch->id;
            $ledger61->account_num = $incomeSummaryBranch->account_num;
            $ledger61->name_ar= $incomeSummaryBranch->name;
            $ledger61->created_by = Auth::user()->id;
            $ledger61->closing_entry_id = $entry6->id;
            $ledger61->type = 'closing_entry';
            $ledger61->save();

            //الاستاذ العام للايجارات  دائن
            $ledger62 = new Ledger();
            $ledger62->debit_amount = 0;
            $ledger62->credit_amount = $entry6->debit_amount;
            $ledger62->account_id = $rentBranch->id;
            $ledger62->account_num = $rentBranch->account_num;
            $ledger62->name_ar= $rentBranch->name;
            $ledger62->created_by = Auth::user()->id;
            $ledger62->closing_entry_id = $entry6->id;
            $ledger62->type = 'closing_entry';
            $ledger62->save();
        }


        // بند  مصروف الانترنت للفرع
        //من ح ملخص الدخل الي حساب الانترنت
        $internetParent = Account::where('account_num',5115)->where('name_ar', "انترنت")->first();
        $internetBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$internetParent->id)->where('branch_id',$this->branch_id)->first();
        $internetBranchLedger = Ledger::where('account_id',$internetBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry7 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$internetBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry7) {
            $entry7->debit_amount = $internetBranchLedger->sum('debit_amount') - $internetBranchLedger->sum('credit_amount');
            $entry7->credit_amount = $internetBranchLedger->sum('debit_amount') - $internetBranchLedger->sum('credit_amount');
            $entry7->updated_by = Auth::user()->id;
            $entry7->save();

            $ledger71 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry7->id)->first();
            $ledger72 = Ledger::where('account_id',$internetBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry7->id)->first();


            //الاستاذ العام لملخص الدخل المدين
            $ledger71->debit_amount = $entry7->debit_amount;
            $ledger71->updated_by = Auth::user()->id;
            $ledger71->save();

            //الاستاذ العام لاستهلاك الانترنت دائن
            $ledger72->credit_amount = $entry7->debit_amount;
            $ledger72->updated_by = Auth::user()->id;
            $ledger72->save();



        } else {
            $entry = getNextClosingEntryNum();
            $entry7 = new ClosingEntry();
            $entry7->entry_num = $entry;
            $entry7->debit_account_num = $incomeSummaryBranch->account_num;
            $entry7->debit_account_id = $incomeSummaryBranch ->id;
            $entry7->credit_account_num = $internetBranch->account_num;
            $entry7->credit_account_id = $internetBranch->id;
            $entry7->debit_amount = $internetBranchLedger->sum('debit_amount') - $internetBranchLedger->sum('credit_amount');
            $entry7->credit_amount = $internetBranchLedger->sum('debit_amount') - $internetBranchLedger->sum('credit_amount');
            $entry7->branch_id = $this->branch_id;
            $entry7->entry_type_id = 5 ;
            $entry7->start_date = $this->start_date;
            $entry7->end_date = $this->end_date;
            $entry7->created_by = Auth::user()->id;
            $entry7->updated_by = Auth::user()->id;
            $entry7->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $internetBranch->name  ;
            $entry7->save();


            //الاستاذ العام لملخص الدخل المدين
            $ledger71 = new Ledger();
            $ledger71->debit_amount = $entry7->debit_amount;
            $ledger71->credit_amount = 0;
            $ledger71->account_id = $incomeSummaryBranch->id;
            $ledger71->account_num = $incomeSummaryBranch->account_num;
            $ledger71->name_ar= $incomeSummaryBranch->name;
            $ledger71->created_by = Auth::user()->id;
            $ledger71->closing_entry_id = $entry7->id;
            $ledger71->type = 'closing_entry';
            $ledger71->save();

            //الاستاذ العام لاستهلااك الانترنت  دائن
            $ledger72 = new Ledger();
            $ledger72->debit_amount = 0;
            $ledger72->credit_amount = $entry7->debit_amount;
            $ledger72->account_id = $internetBranch->id;
            $ledger72->account_num = $internetBranch->account_num;
            $ledger72->name_ar= $internetBranch->name;
            $ledger72->created_by = Auth::user()->id;
            $ledger72->closing_entry_id = $entry7->id;
            $ledger72->type = 'closing_entry';
            $ledger72->save();
        }


        // بند  مصروف الادوات المكتبية للفرع
        //من ح ملخص الدخل الي حساب الادوات المكتبية
        $stationryParent = Account::where('account_num',5116)->where('name_ar', "ادوات مكتبية")->first();
        $stationryBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$stationryParent->id)->where('branch_id',$this->branch_id)->first();
        $stationryBranchLedger = Ledger::where('account_id',$stationryBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry8 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$stationryBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry8) {
            $entry8->debit_amount = $stationryBranchLedger->sum('debit_amount') - $stationryBranchLedger->sum('credit_amount');
            $entry8->credit_amount = $stationryBranchLedger->sum('debit_amount') - $stationryBranchLedger->sum('credit_amount');
            $entry8->updated_by = Auth::user()->id;
            $entry8->save();


            $ledger81 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry8->id)->first();
            $ledger82 = Ledger::where('account_id',$stationryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry8->id)->first();


            //الاستاذ العام لملخص الدخل المدين
            $ledger81->debit_amount = $entry8->debit_amount;
            $ledger81->updated_by = Auth::user()->id;
            $ledger81->save();

            //الاستاذ العام لاستهلاك الادوات المكتبية دائن
            $ledger82->credit_amount = $entry8->debit_amount;
            $ledger82->updated_by = Auth::user()->id;
            $ledger82->save();

        } else {
            $entry = getNextClosingEntryNum();
            $entry8 = new ClosingEntry();
            $entry8->entry_num = $entry;
            $entry8->debit_account_num = $incomeSummaryBranch->account_num;
            $entry8->debit_account_id = $incomeSummaryBranch ->id;
            $entry8->credit_account_num = $stationryBranch->account_num;
            $entry8->credit_account_id = $stationryBranch->id;
            $entry8->debit_amount = $stationryBranchLedger->sum('debit_amount') - $stationryBranchLedger->sum('credit_amount');
            $entry8->credit_amount = $stationryBranchLedger->sum('debit_amount') - $stationryBranchLedger->sum('credit_amount');
            $entry8->branch_id = $this->branch_id;
            $entry8->entry_type_id = 5 ;
            $entry8->start_date = $this->start_date;
            $entry8->end_date = $this->end_date;
            $entry8->created_by = Auth::user()->id;
            $entry8->updated_by = Auth::user()->id;
            $entry8->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $stationryBranch->name  ;
            $entry8->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger81 = new Ledger();
            $ledger81->debit_amount = $entry8->debit_amount;
            $ledger81->credit_amount = 0;
            $ledger81->account_id = $incomeSummaryBranch->id;
            $ledger81->account_num = $incomeSummaryBranch->account_num;
            $ledger81->name_ar= $incomeSummaryBranch->name;
            $ledger81->created_by = Auth::user()->id;
            $ledger81->closing_entry_id = $entry8->id;
            $ledger81->type = 'closing_entry';
            $ledger81->save();

            //الاستاذ العام لاستهلااك الادوات المكتبية  دائن
            $ledger82 = new Ledger();
            $ledger82->debit_amount = 0;
            $ledger82->credit_amount = $entry8->debit_amount;
            $ledger82->account_id = $stationryBranch->id;
            $ledger82->account_num = $stationryBranch->account_num;
            $ledger82->name_ar= $stationryBranch->name;
            $ledger82->created_by = Auth::user()->id;
            $ledger82->closing_entry_id = $entry8->id;
            $ledger82->type = 'closing_entry';
            $ledger82->save();
        }


        // بند  مصروف الانتقالات للفرع
        //من ح ملخص الدخل الي حساب الانتقالات
        $transportationParent = Account::where('account_num',5117)->where('name_ar',  "انتقالات")->first();
        $transportationBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$transportationParent->id)->where('branch_id',$this->branch_id)->first();
        $transportationBranchLedger = Ledger::where('account_id',$transportationBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry9 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$transportationBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry9) {
            $entry9->debit_amount = $transportationBranchLedger->sum('debit_amount') - $transportationBranchLedger->sum('credit_amount');
            $entry9->credit_amount = $transportationBranchLedger->sum('debit_amount') - $transportationBranchLedger->sum('credit_amount');
            $entry9->updated_by = Auth::user()->id;
            $entry9->save();

            $ledger91 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry9->id)->first();
            $ledger92 = Ledger::where('account_id',$transportationBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry9->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger91->debit_amount = $entry9->debit_amount;
            $ledger91->updated_by = Auth::user()->id;
            $ledger91->save();

            //الاستاذ العام لاستهلاك الانتقالات دائن
            $ledger92->credit_amount = $entry9->debit_amount;
            $ledger92->updated_by = Auth::user()->id;
            $ledger92->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry9 = new ClosingEntry();
            $entry9->entry_num = $entry;
            $entry9->debit_account_num = $incomeSummaryBranch->account_num;
            $entry9->debit_account_id = $incomeSummaryBranch ->id;
            $entry9->credit_account_num = $transportationBranch->account_num;
            $entry9->credit_account_id = $transportationBranch->id;
            $entry9->debit_amount = $transportationBranchLedger->sum('debit_amount') - $transportationBranchLedger->sum('credit_amount');
            $entry9->credit_amount = $transportationBranchLedger->sum('debit_amount') - $transportationBranchLedger->sum('credit_amount');
            $entry9->branch_id = $this->branch_id;
            $entry9->entry_type_id = 5 ;
            $entry9->start_date = $this->start_date;
            $entry9->end_date = $this->end_date;
            $entry9->created_by = Auth::user()->id;
            $entry9->updated_by = Auth::user()->id;
            $entry9->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $transportationBranch->name  ;
            $entry9->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger91 = new Ledger();
            $ledger91->debit_amount = $entry9->debit_amount;
            $ledger91->credit_amount = 0;
            $ledger91->account_id = $incomeSummaryBranch->id;
            $ledger91->account_num = $incomeSummaryBranch->account_num;
            $ledger91->name_ar= $incomeSummaryBranch->name;
            $ledger91->created_by = Auth::user()->id;
            $ledger91->closing_entry_id = $entry9->id;
            $ledger91->type = 'closing_entry';
            $ledger91->save();

            //الاستاذ العام لاستهلااك الانتقالات  دائن
            $ledger92 = new Ledger();
            $ledger92->debit_amount = 0;
            $ledger92->credit_amount = $entry9->debit_amount;
            $ledger92->account_id = $transportationBranch->id;
            $ledger92->account_num = $transportationBranch->account_num;
            $ledger92->name_ar= $transportationBranch->name;
            $ledger92->created_by = Auth::user()->id;
            $ledger92->closing_entry_id = $entry9->id;
            $ledger92->type = 'closing_entry';
            $ledger92->save();
        }

        // بند  مصروف الطباعة والاحبار للفرع
        //من ح ملخص الدخل الي حساب الطباعة والاحبار
        $printersParent = Account::where('account_num',5119)->where('name_ar',  "طباعة واحبار")->first();
        $printerBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$printersParent->id)->where('branch_id',$this->branch_id)->first();
        $printerBranchLedger = Ledger::where('account_id',$printerBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry10 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$printerBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry10) {
            $entry10->debit_amount = $printerBranchLedger->sum('debit_amount') - $printerBranchLedger->sum('credit_amount');
            $entry10->credit_amount = $printerBranchLedger->sum('debit_amount') - $printerBranchLedger->sum('credit_amount');
            $entry10->updated_by = Auth::user()->id;
            $entry10->save();

            $ledger101 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry10->id)->first();
            $ledger102 = Ledger::where('account_id',$printerBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry10->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger101->debit_amount = $entry10->debit_amount;
            $ledger101->updated_by = Auth::user()->id;
            $ledger101->save();

            //الاستاذ العام لاستهلاك الطباعة والاحبار دائن
            $ledger102->credit_amount = $entry10->debit_amount;
            $ledger102->updated_by = Auth::user()->id;
            $ledger102->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry10 = new ClosingEntry();
            $entry10->entry_num = $entry;
            $entry10->debit_account_num = $incomeSummaryBranch->account_num;
            $entry10->debit_account_id = $incomeSummaryBranch ->id;
            $entry10->credit_account_num = $printerBranch->account_num;
            $entry10->credit_account_id = $printerBranch->id;
            $entry10->debit_amount = $printerBranchLedger->sum('debit_amount') - $printerBranchLedger->sum('credit_amount');
            $entry10->credit_amount = $printerBranchLedger->sum('debit_amount') - $printerBranchLedger->sum('credit_amount');
            $entry10->branch_id = $this->branch_id;
            $entry10->entry_type_id = 5 ;
            $entry10->start_date = $this->start_date;
            $entry10->end_date = $this->end_date;
            $entry10->created_by = Auth::user()->id;
            $entry10->updated_by = Auth::user()->id;
            $entry10->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $printerBranch->name  ;
            $entry10->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger101 = new Ledger();
            $ledger101->debit_amount = $entry10->debit_amount;
            $ledger101->credit_amount = 0;
            $ledger101->account_id = $incomeSummaryBranch->id;
            $ledger101->account_num = $incomeSummaryBranch->account_num;
            $ledger101->name_ar= $incomeSummaryBranch->name;
            $ledger101->created_by = Auth::user()->id;
            $ledger101->closing_entry_id = $entry10->id;
            $ledger101->type = 'closing_entry';
            $ledger101->save();

            //الاستاذ العام لاستهلااك الطباعة والاحبار  دائن
            $ledger102 = new Ledger();
            $ledger102->debit_amount = 0;
            $ledger102->credit_amount = $entry10->debit_amount;
            $ledger102->account_id = $printerBranch->id;
            $ledger102->account_num = $printerBranch->account_num;
            $ledger102->name_ar= $printerBranch->name;
            $ledger102->created_by = Auth::user()->id;
            $ledger102->closing_entry_id = $entry10->id;
            $ledger102->type = 'closing_entry';
            $ledger102->save();
        }


        // بند  مصروف  الاجور والمرتبات للفرع
        //من ح ملخص الدخل الي حساب  الاجور والمرتبات
        $salariesParent = Account::where('account_num',513)->first();
        $salariesBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$salariesParent->id)->where('branch_id',$this->branch_id)->first();
        $salariesBranchLedger = Ledger::where('account_id',$salariesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry11 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$salariesBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry11) {
            $entry11->debit_amount = $salariesBranchLedger->sum('debit_amount') - $salariesBranchLedger->sum('credit_amount');
            $entry11->credit_amount = $salariesBranchLedger->sum('debit_amount') - $salariesBranchLedger->sum('credit_amount');
            $entry11->updated_by = Auth::user()->id;
            $entry11->save();

            $ledger111 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry11->id)->first();
            $ledger112 = Ledger::where('account_id',$salariesBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry11->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger111->debit_amount = $entry11->debit_amount;
            $ledger111->updated_by = Auth::user()->id;
            $ledger111->save();

            //الاستاذ العام اللرواتب والاجور دائن
            $ledger112->credit_amount = $entry11->debit_amount;
            $ledger112->updated_by = Auth::user()->id;
            $ledger112->save();


        } else {
            $entry = getNextClosingEntryNum();
            $entry11 = new ClosingEntry();
            $entry11->entry_num = $entry;
            $entry11->debit_account_num = $incomeSummaryBranch->account_num;
            $entry11->debit_account_id = $incomeSummaryBranch ->id;
            $entry11->credit_account_num = $salariesBranch->account_num;
            $entry11->credit_account_id = $salariesBranch->id;
            $entry11->debit_amount = $salariesBranchLedger->sum('debit_amount') - $salariesBranchLedger->sum('credit_amount');
            $entry11->credit_amount = $salariesBranchLedger->sum('debit_amount') - $salariesBranchLedger->sum('credit_amount');
            $entry11->branch_id = $this->branch_id;
            $entry11->entry_type_id = 5 ;
            $entry11->start_date = $this->start_date;
            $entry11->end_date = $this->end_date;
            $entry11->created_by = Auth::user()->id;
            $entry11->updated_by = Auth::user()->id;
            $entry11->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $salariesBranch->name  ;
            $entry11->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger111 = new Ledger();
            $ledger111->debit_amount = $entry11->debit_amount;
            $ledger111->credit_amount = 0;
            $ledger111->account_id = $incomeSummaryBranch->id;
            $ledger111->account_num = $incomeSummaryBranch->account_num;
            $ledger111->name_ar= $incomeSummaryBranch->name;
            $ledger111->created_by = Auth::user()->id;
            $ledger111->closing_entry_id = $entry11->id;
            $ledger111->type = 'closing_entry';
            $ledger111->save();

            //الاستاذ العام للرواتب والاجور  دائن
            $ledger112 = new Ledger();
            $ledger112->debit_amount = 0;
            $ledger112->credit_amount = $entry11->debit_amount;
            $ledger112->account_id = $salariesBranch->id;
            $ledger112->account_num = $salariesBranch->account_num;
            $ledger112->name_ar= $salariesBranch->name;
            $ledger112->created_by = Auth::user()->id;
            $ledger112->closing_entry_id = $entry11->id;
            $ledger112->type = 'closing_entry';
            $ledger112->save();
        }

        // بند مصروف اهلاكات المباني
        //من ح ملخص الدخل الي ح اهلاكات المباني
        $buildingsDepreciationsParent = Account::where('account_num',5121)->first();//اهلاكات المباني
        $buildingsDepreciationsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$buildingsDepreciationsParent->id)->where('branch_id',$this->branch_id)->first();
        $buildingsDepreciationsBranchLedger = Ledger::where('account_id',$buildingsDepreciationsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry12 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$buildingsDepreciationsBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry12) {
            $entry12->debit_amount = $buildingsDepreciationsBranchLedger->sum('debit_amount') - $buildingsDepreciationsBranchLedger->sum('credit_amount');
            $entry12->credit_amount = $buildingsDepreciationsBranchLedger->sum('debit_amount') - $buildingsDepreciationsBranchLedger->sum('credit_amount');
            $entry12->updated_by = Auth::user()->id;
            $entry12->save();


            $ledger121 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry12->id)->first();
            $ledger122 = Ledger::where('account_id',$buildingsDepreciationsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry12->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger121->debit_amount = $entry12->debit_amount;
            $ledger121->updated_by = Auth::user()->id;
            $ledger121->save();

            //الاستاذ العام لاهلاكات المباني دائن
            $ledger122->credit_amount = $entry12->debit_amount;
            $ledger122->updated_by = Auth::user()->id;
            $ledger122->save();

        } else {
            $entry = getNextClosingEntryNum();
            $entry12 = new ClosingEntry();
            $entry12->entry_num = $entry;
            $entry12->debit_account_num = $incomeSummaryBranch->account_num;
            $entry12->debit_account_id = $incomeSummaryBranch ->id;
            $entry12->credit_account_num = $buildingsDepreciationsBranch->account_num;
            $entry12->credit_account_id = $buildingsDepreciationsBranch->id;
            $entry12->debit_amount = $buildingsDepreciationsBranchLedger->sum('debit_amount') - $buildingsDepreciationsBranchLedger->sum('credit_amount');
            $entry12->credit_amount = $buildingsDepreciationsBranchLedger->sum('debit_amount') - $buildingsDepreciationsBranchLedger->sum('credit_amount');
            $entry12->branch_id = $this->branch_id;
            $entry12->entry_type_id = 5 ;
            $entry12->start_date = $this->start_date;
            $entry12->end_date = $this->end_date;
            $entry12->created_by = Auth::user()->id;
            $entry12->updated_by = Auth::user()->id;
            $entry12->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $buildingsDepreciationsBranch->name  ;
            $entry12->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger121 = new Ledger();
            $ledger121->debit_amount = $entry12->debit_amount;
            $ledger121->credit_amount = 0;
            $ledger121->account_id = $incomeSummaryBranch->id;
            $ledger121->account_num = $incomeSummaryBranch->account_num;
            $ledger121->name_ar= $incomeSummaryBranch->name;
            $ledger121->created_by = Auth::user()->id;
            $ledger121->closing_entry_id = $entry12->id;
            $ledger121->type = 'closing_entry';
            $ledger121->save();

            //الاستاذ العام لاهلاكات المباني دائن
            $ledger122 = new Ledger();
            $ledger122->debit_amount = 0;
            $ledger122->credit_amount = $entry12->debit_amount;
            $ledger122->account_id = $buildingsDepreciationsBranch->id;
            $ledger122->account_num = $buildingsDepreciationsBranch->account_num;
            $ledger122->name_ar= $buildingsDepreciationsBranch->name;
            $ledger122->created_by = Auth::user()->id;
            $ledger122->closing_entry_id = $entry12->id;
            $ledger122->type = 'closing_entry';
            $ledger122->save();
        }


        // بند  مصروف  اهلاكات السيارات للفرع
        //من ح ملخص الدخل الي حساب  اهلاكات السيارات
        $carsDepreciationsParent = Account::where('account_num',5122)->first();//اهلاكات السيارات
        $carsDepreciationsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$carsDepreciationsParent->id)->where('branch_id',$this->branch_id)->first();
        $carsDepreciationsBranchLedger = Ledger::where('account_id',$carsDepreciationsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        $entry13 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$carsDepreciationsBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry13) {
            $entry13->debit_amount = $carsDepreciationsBranchLedger->sum('debit_amount') - $carsDepreciationsBranchLedger->sum('credit_amount');
            $entry13->credit_amount = $carsDepreciationsBranchLedger->sum('debit_amount') - $carsDepreciationsBranchLedger->sum('credit_amount');
            $entry13->updated_by = Auth::user()->id;
            $entry13->save();

            $ledger131 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry13->id)->first();
            $ledger132 = Ledger::where('account_id',$carsDepreciationsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry13->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger131->debit_amount = $entry13->debit_amount;
            $ledger131->updated_by = Auth::user()->id;
            $ledger131->save();

            //الاستاذ العام لاهلاكات السيارات دائن
            $ledger132->credit_amount = $entry13->debit_amount;
            $ledger132->updated_by = Auth::user()->id;
            $ledger132->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry13 = new ClosingEntry();
            $entry13->entry_num = $entry;
            $entry13->debit_account_num = $incomeSummaryBranch->account_num;
            $entry13->debit_account_id = $incomeSummaryBranch ->id;
            $entry13->credit_account_num = $carsDepreciationsBranch->account_num;
            $entry13->credit_account_id = $carsDepreciationsBranch->id;
            $entry13->debit_amount = $carsDepreciationsBranchLedger->sum('debit_amount') - $carsDepreciationsBranchLedger->sum('credit_amount');
            $entry13->credit_amount = $carsDepreciationsBranchLedger->sum('debit_amount') - $carsDepreciationsBranchLedger->sum('credit_amount');
            $entry13->branch_id = $this->branch_id;
            $entry13->entry_type_id = 5 ;
            $entry13->start_date = $this->start_date;
            $entry13->end_date = $this->end_date;
            $entry13->created_by = Auth::user()->id;
            $entry13->updated_by = Auth::user()->id;
            $entry13->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $carsDepreciationsBranch->name  ;
            $entry13->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger131 = new Ledger();
            $ledger131->debit_amount = $entry13->debit_amount;
            $ledger131->credit_amount = 0;
            $ledger131->account_id = $incomeSummaryBranch->id;
            $ledger131->account_num = $incomeSummaryBranch->account_num;
            $ledger131->name_ar= $incomeSummaryBranch->name;
            $ledger131->created_by = Auth::user()->id;
            $ledger131->closing_entry_id = $entry13->id;
            $ledger131->type = 'closing_entry';
            $ledger131->save();

            //الاستاذ العام لاهلاكات السيارات دائن
            $ledger132 = new Ledger();
            $ledger132->debit_amount = 0;
            $ledger132->credit_amount = $entry13->debit_amount;
            $ledger132->account_id = $carsDepreciationsBranch->id;
            $ledger132->account_num = $carsDepreciationsBranch->account_num;
            $ledger132->name_ar= $carsDepreciationsBranch->name;
            $ledger132->created_by = Auth::user()->id;
            $ledger132->closing_entry_id = $entry13->id;
            $ledger132->type = 'closing_entry';
            $ledger132->save();

        }

        // بند  مصروف  اهلاكات اجهزة الكمبيوتر وغيرها للفرع
        //من ح ملخص الدخل الي حساب  اهلاكات اجهزة الكمبيوتر وغيرها
        $computersDepreciationsParent = Account::where('account_num',5123)->first();//اهلاكات اجهزة الكمبيوتر وغيرها
        $computersDepreciationsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$computersDepreciationsParent->id)->where('branch_id',$this->branch_id)->first();
        $computersDepreciationsBranchLedger = Ledger::where('account_id',$computersDepreciationsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        $entry14 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$computersDepreciationsBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry14) {
            $entry14->debit_amount = $computersDepreciationsBranchLedger->sum('debit_amount') - $computersDepreciationsBranchLedger->sum('credit_amount');
            $entry14->credit_amount = $computersDepreciationsBranchLedger->sum('debit_amount') - $computersDepreciationsBranchLedger->sum('credit_amount');
            $entry14->updated_by = Auth::user()->id;
            $entry14->save();

            $ledger141 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry14->id)->first();
            $ledger142 = Ledger::where('account_id',$computersDepreciationsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry14->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger141->debit_amount = $entry14->debit_amount;
            $ledger141->updated_by = Auth::user()->id;
            $ledger141->save();

            //الاستاذ العام لاهلاكات اجهزة الكمبيوتر دائن
            $ledger142->credit_amount = $entry14->debit_amount;
            $ledger142->updated_by = Auth::user()->id;
            $ledger142->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry14 = new ClosingEntry();
            $entry14->entry_num = $entry;
            $entry14->debit_account_num = $incomeSummaryBranch->account_num;
            $entry14->debit_account_id = $incomeSummaryBranch ->id;
            $entry14->credit_account_num = $computersDepreciationsBranch->account_num;
            $entry14->credit_account_id = $computersDepreciationsBranch->id;
            $entry14->debit_amount = $computersDepreciationsBranchLedger->sum('debit_amount') - $computersDepreciationsBranchLedger->sum('credit_amount');
            $entry14->credit_amount = $computersDepreciationsBranchLedger->sum('debit_amount') - $computersDepreciationsBranchLedger->sum('credit_amount');
            $entry14->branch_id = $this->branch_id;
            $entry14->entry_type_id = 5 ;
            $entry14->start_date = $this->start_date;
            $entry14->end_date = $this->end_date;
            $entry14->created_by = Auth::user()->id;
            $entry14->updated_by = Auth::user()->id;
            $entry14->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $computersDepreciationsBranch->name  ;
            $entry14->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger141 = new Ledger();
            $ledger141->debit_amount = $entry14->debit_amount;
            $ledger141->credit_amount = 0;
            $ledger141->account_id = $incomeSummaryBranch->id;
            $ledger141->account_num = $incomeSummaryBranch->account_num;
            $ledger141->name_ar= $incomeSummaryBranch->name;
            $ledger141->created_by = Auth::user()->id;
            $ledger141->closing_entry_id = $entry14->id;
            $ledger141->type = 'closing_entry';
            $ledger141->save();

            //الاستاذ العام لاهلاكات اجهزة الكمبيوتر دائن
            $ledger142 = new Ledger();
            $ledger142->debit_amount = 0;
            $ledger142->credit_amount = $entry14->debit_amount;
            $ledger142->account_id = $computersDepreciationsBranch->id;
            $ledger142->account_num = $computersDepreciationsBranch->account_num;
            $ledger142->name_ar= $computersDepreciationsBranch->name;
            $ledger142->created_by = Auth::user()->id;
            $ledger142->closing_entry_id = $entry14->id;
            $ledger142->type = 'closing_entry';
            $ledger142->save();
        }

         // بند  مصروف  اهلاكات الاثاث وغيرها للفرع
        //من ح ملخص الدخل الي حساب  اهلاكات الاثاث وغيرها
        $furnitureDepreciationsParent = Account::where('account_num',5124)->first();//اهلاكات الاثاثات
        $furnitureDepreciationsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$furnitureDepreciationsParent->id)->where('branch_id',$this->branch_id)->first();
        $furnitureDepreciationsBranchLedger = Ledger::where('account_id',$furnitureDepreciationsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        $entry15 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$furnitureDepreciationsBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry15) {
            $entry15->debit_amount = $furnitureDepreciationsBranchLedger->sum('debit_amount') - $furnitureDepreciationsBranchLedger->sum('credit_amount');
            $entry15->credit_amount = $furnitureDepreciationsBranchLedger->sum('debit_amount') - $furnitureDepreciationsBranchLedger->sum('credit_amount');
            $entry15->updated_by = Auth::user()->id;
            $entry15->save();

            $ledger151 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry15->id)->first();
            $ledger152 = Ledger::where('account_id',$furnitureDepreciationsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry15->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger151->debit_amount = $entry15->debit_amount;
            $ledger151->updated_by = Auth::user()->id;
            $ledger151->save();

            //الاستاذ العام لاهلاكات الاثاث دائن
            $ledger152->credit_amount = $entry15->debit_amount;
            $ledger152->updated_by = Auth::user()->id;
            $ledger152->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry15 = new ClosingEntry();
            $entry15->entry_num = $entry;
            $entry15->debit_account_num = $incomeSummaryBranch->account_num;
            $entry15->debit_account_id = $incomeSummaryBranch ->id;
            $entry15->credit_account_num = $furnitureDepreciationsBranch->account_num;
            $entry15->credit_account_id = $furnitureDepreciationsBranch->id;
            $entry15->debit_amount = $furnitureDepreciationsBranchLedger->sum('debit_amount') - $furnitureDepreciationsBranchLedger->sum('credit_amount');
            $entry15->credit_amount = $furnitureDepreciationsBranchLedger->sum('debit_amount') - $furnitureDepreciationsBranchLedger->sum('credit_amount');
            $entry15->branch_id = $this->branch_id;
            $entry15->entry_type_id = 5 ;
            $entry15->start_date = $this->start_date;
            $entry15->end_date = $this->end_date;
            $entry15->created_by = Auth::user()->id;
            $entry15->updated_by = Auth::user()->id;
            $entry15->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $furnitureDepreciationsBranch->name  ;
            $entry15->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger151 = new Ledger();
            $ledger151->debit_amount = $entry15->debit_amount;
            $ledger151->credit_amount = 0;
            $ledger151->account_id = $incomeSummaryBranch->id;
            $ledger151->account_num = $incomeSummaryBranch->account_num;
            $ledger151->name_ar= $incomeSummaryBranch->name;
            $ledger151->created_by = Auth::user()->id;
            $ledger151->closing_entry_id = $entry15->id;
            $ledger151->type = 'closing_entry';
            $ledger151->save();

            //الاستاذ العام لاهلاكات الاثاث دائن
            $ledger152 = new Ledger();
            $ledger152->debit_amount = 0;
            $ledger152->credit_amount = $entry15->debit_amount;
            $ledger152->account_id = $furnitureDepreciationsBranch->id;
            $ledger152->account_num = $furnitureDepreciationsBranch->account_num;
            $ledger152->name_ar= $furnitureDepreciationsBranch->name;
            $ledger152->created_by = Auth::user()->id;
            $ledger152->closing_entry_id = $entry15->id;
            $ledger152->type = 'closing_entry';
            $ledger152->save();
        }


        // بند  مصروف  اهلاكات اجهزة الدفع الالكتروني وغيرها للفرع
        //من ح ملخص الدخل الي حساب  اهلاكات اجهزة الدفع الالكتروني وغيرها
        $posDevicesDepreciationsParent = Account::where('account_num',5125)->first();//اهلاكات اجهزة الدفع الالكتروني
        $posDevicesDepreciationsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$posDevicesDepreciationsParent->id)->where('branch_id',$this->branch_id)->first();
        $posDevicesDepreciationsBranchLedger = Ledger::where('account_id',$posDevicesDepreciationsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        $entry16 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$posDevicesDepreciationsBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry16) {
            $entry16->debit_amount = $posDevicesDepreciationsBranchLedger->sum('debit_amount') - $posDevicesDepreciationsBranchLedger->sum('credit_amount');
            $entry16->credit_amount = $posDevicesDepreciationsBranchLedger->sum('debit_amount') - $posDevicesDepreciationsBranchLedger->sum('credit_amount');
            $entry16->updated_by = Auth::user()->id;
            $entry16->save();

            $ledger161 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry16->id)->first();
            $ledger162 = Ledger::where('account_id',$posDevicesDepreciationsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry16->id)->first();

            //الاستاذ العام لملخص الدخل المدين
            $ledger161->debit_amount = $entry16->debit_amount;
            $ledger161->updated_by = Auth::user()->id;
            $ledger161->save();

            //الاستاذ العام لاهلاكات اجهزة الدفع الالكتروني دائن
            $ledger162->credit_amount = $entry16->debit_amount;
            $ledger162->updated_by = Auth::user()->id;
            $ledger162->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry16 = new ClosingEntry();
            $entry16->entry_num = $entry;
            $entry16->debit_account_num = $incomeSummaryBranch->account_num;
            $entry16->debit_account_id = $incomeSummaryBranch ->id;
            $entry16->credit_account_num = $posDevicesDepreciationsBranch->account_num;
            $entry16->credit_account_id = $posDevicesDepreciationsBranch->id;
            $entry16->debit_amount = $posDevicesDepreciationsBranchLedger->sum('debit_amount') - $posDevicesDepreciationsBranchLedger->sum('credit_amount');
            $entry16->credit_amount = $posDevicesDepreciationsBranchLedger->sum('debit_amount') - $posDevicesDepreciationsBranchLedger->sum('credit_amount');
            $entry16->branch_id = $this->branch_id;
            $entry16->entry_type_id = 5 ;
            $entry16->start_date = $this->start_date;
            $entry16->end_date = $this->end_date;
            $entry16->created_by = Auth::user()->id;
            $entry16->updated_by = Auth::user()->id;
            $entry16->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $posDevicesDepreciationsBranch->name  ;
            $entry16->save();

            //الاستاذ العام لملخص الدخل المدين
            $ledger161 = new Ledger();
            $ledger161->debit_amount = $entry16->debit_amount;
            $ledger161->credit_amount = 0;
            $ledger161->account_id = $incomeSummaryBranch->id;
            $ledger161->account_num = $incomeSummaryBranch->account_num;
            $ledger161->name_ar= $incomeSummaryBranch->name;
            $ledger161->created_by = Auth::user()->id;
            $ledger161->closing_entry_id = $entry16->id;
            $ledger161->type = 'closing_entry';
            $ledger161->save();

            //الاستاذ العام لاهلاكات اجهزة الدفع الالكتروني دائن
            $ledger162 = new Ledger();
            $ledger162->debit_amount = 0;
            $ledger162->credit_amount = $entry16->debit_amount;
            $ledger162->account_id = $posDevicesDepreciationsBranch->id;
            $ledger162->account_num = $posDevicesDepreciationsBranch->account_num;
            $ledger162->name_ar= $posDevicesDepreciationsBranch->name;
            $ledger162->created_by = Auth::user()->id;
            $ledger162->closing_entry_id = $entry16->id;
            $ledger162->type = 'closing_entry';
            $ledger162->save();
        }

        //بند مصروفات تسوية الضرائب للفرع
        //من ح ملخص الدخل الي حساب تسوية الضرائب
        // $taxesParent = Account::where('account_num',2232)->first();
        // $taxesBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$taxesParent->id)->where('branch_id',$this->branch_id)->first();
        // $taxesBranchLedger = Ledger::where('account_id',$taxesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();


        // $entry17 = ClosingEntry::where('debit_account_id',$incomeSummaryBranch->id)->where('credit_account_id',$taxesBranch->id)
        // ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        // if($entry17) {
        //     $entry17->debit_amount = $taxesBranchLedger->sum('debit_amount') - $taxesBranchLedger->sum('credit_amount');
        //     $entry17->credit_amount = $taxesBranchLedger->sum('debit_amount') - $taxesBranchLedger->sum('credit_amount');
        //     $entry17->updated_by = Auth::user()->id;
        //     $entry17->save();

        //     $ledger171 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry17->id)->first();
        //     $ledger172 = Ledger::where('account_id',$taxesBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry17->id)->first();

        //     //الاستاذ العام لملخص الدخل المدين
        //     $ledger171->debit_amount = $entry17->debit_amount;
        //     $ledger171->updated_by = Auth::user()->id;
        //     $ledger171->save();

        //     //الاستاذ العام لتسوية الضرائب دائن
        //     $ledger172->credit_amount = $entry17->debit_amount;
        //     $ledger172->updated_by = Auth::user()->id;
        //     $ledger172->save();
        // } else {
        //     $entry = getNextClosingEntryNum();
        //     $entry17 = new ClosingEntry();
        //     $entry17->entry_num = $entry;
        //     $entry17->debit_account_num = $incomeSummaryBranch->account_num;
        //     $entry17->debit_account_id = $incomeSummaryBranch ->id;
        //     $entry17->credit_account_num = $taxesBranch->account_num;
        //     $entry17->credit_account_id = $taxesBranch->id;
        //     $entry17->debit_amount = $taxesBranchLedger->sum('debit_amount') - $taxesBranchLedger->sum('credit_amount');
        //     $entry17->credit_amount = $taxesBranchLedger->sum('debit_amount') - $taxesBranchLedger->sum('credit_amount');
        //     $entry17->branch_id = $this->branch_id;
        //     $entry17->entry_type_id = 5 ;
        //     $entry17->start_date = $this->start_date;
        //     $entry17->end_date = $this->end_date;
        //     $entry17->created_by = Auth::user()->id;
        //     $entry17->updated_by = Auth::user()->id;
        //     $entry17->description = "من ح  /  " .  $incomeSummaryBranch->name  ."الي ح  /   ". $taxesBranch->name  ;
        //     $entry17->save();

        //     //الاستاذ العام لملخص الدخل المدين
        //     $ledger171 = new Ledger();
        //     $ledger171->debit_amount = $entry17->debit_amount;
        //     $ledger171->credit_amount = 0;
        //     $ledger171->account_id = $incomeSummaryBranch->id;
        //     $ledger171->account_num = $incomeSummaryBranch->account_num;
        //     $ledger171->name_ar= $incomeSummaryBranch->name;
        //     $ledger171->created_by = Auth::user()->id;
        //     $ledger171->closing_entry_id = $entry17->id;
        //     $ledger171->type = 'closing_entry';
        //     $ledger171->save();

        //     //الاستاذ العام لتسوية الضريبة  دائن
        //     $ledger172 = new Ledger();
        //     $ledger172->debit_amount = 0;
        //     $ledger172->credit_amount = $entry17->debit_amount;
        //     $ledger172->account_id = $taxesBranch->id;
        //     $ledger172->account_num = $taxesBranch->account_num;
        //     $ledger172->name_ar= $taxesBranch->name;
        //     $ledger172->created_by = Auth::user()->id;
        //     $ledger172->closing_entry_id = $entry17->id;
        //     $ledger172->type = 'closing_entry';
        //     $ledger172->save();
        // }

        // قيود الاغلاق لضرائب المشتريات
        //من ح تسوية الضرائب الي ح ض المدخلات
        $taxAdjustingAccount = Account::where('Parent_account_num',2232)->where('branch_id',$this->id)->first();

        //dd($salesReturnParent);

      //إغلاق الايرادات من ح الايراد الي ح  ملخص الدخل
      //بند مبيعات الفرع
      //من ح المبيعات الي ح  ملخص الدخل
        $salesParent = Account::where('account_num',41)->where('name_ar','ايرادات مبيعات')->first();
        $salesBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$salesParent->id)->where('branch_id',$this->branch_id)->first();
        $salesBranchLedger = Ledger::where('account_id',$salesBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        $entry18 = ClosingEntry::where('debit_account_id',$salesBranch->id)->where('credit_account_id',$incomeSummaryBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry18) {
            $entry18->debit_amount = $salesBranchLedger->sum('debit_amount') - $salesBranchLedger->sum('credit_amount');
            $entry18->credit_amount = $salesBranchLedger->sum('debit_amount') - $salesBranchLedger->sum('credit_amount');
            $entry18->updated_by = Auth::user()->id;
            $entry18->save();

            $ledger181 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry18->id)->first();
            $ledger182 = Ledger::where('account_id',$salesBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry18->id)->first();

            //الاستاذ العام لملخص الدخل دائن
            $ledger181->credit_amount = $entry18->credit_amount;
            $ledger181->updated_by = Auth::user()->id;
            $ledger181->save();

            //الاستاذ العام للمبيعات مدين
            $ledger182->debit_amount = $entry18->debit_amount;
            $ledger182->updated_by = Auth::user()->id;
            $ledger182->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry18 = new ClosingEntry();
            $entry18->entry_num = $entry;
            $entry18->debit_account_num = $salesBranch->account_num;
            $entry18->debit_account_id = $salesBranch ->id;
            $entry18->credit_account_num = $incomeSummaryBranch->account_num;
            $entry18->credit_account_id = $incomeSummaryBranch->id;
            $entry18->debit_amount = $salesBranchLedger->sum('debit_amount') - $salesBranchLedger->sum('credit_amount');
            $entry18->credit_amount = $salesBranchLedger->sum('debit_amount') - $salesBranchLedger->sum('credit_amount');
            $entry18->branch_id = $this->branch_id;
            $entry18->entry_type_id = 5 ;
            $entry18->start_date = $this->start_date;
            $entry18->end_date = $this->end_date;
            $entry18->created_by = Auth::user()->id;
            $entry18->updated_by = Auth::user()->id;
            $entry18->description = "من ح  /  " .  $incomeSummaryBranch ->name  ."الي ح  /   ". $salesBranch->name  ;
            $entry18->save();

            //الاستاذ العام لملخص الدخل دائن
            $ledger181 = new Ledger();
            $ledger181->debit_amount = 0;
            $ledger181->credit_amount = $entry18->debit_amount;
            $ledger181->account_id = $incomeSummaryBranch->id;
            $ledger181->account_num = $incomeSummaryBranch->account_num;
            $ledger181->name_ar= $incomeSummaryBranch->name;
            $ledger181->created_by = Auth::user()->id;
            $ledger181->closing_entry_id = $entry18->id;
            $ledger181->type = 'closing_entry';
            $ledger181->save();

            //الاستاذ العام للمبيعات مدين
            $ledger182 = new Ledger();
            $ledger182->debit_amount = $entry18->debit_amount;
            $ledger182->credit_amount = 0;
            $ledger182->account_id = $salesBranch->id;
            $ledger182->account_num = $salesBranch->account_num;
            $ledger182->name_ar= $salesBranch->name;
            $ledger182->created_by = Auth::user()->id;
            $ledger182->closing_entry_id = $entry18->id;
            $ledger182->type = 'closing_entry';
            $ledger182->save();
        }


        //بند مبيعات الاصول الثابتة
        // من ح مبيعات الاصول الثابتة الي ح ملخص الدخل
        $salesAssetsParent = Account::where('account_num',44)->first();//ايردات بيع الاصول الثابتة
        $salesAssetsBranch =  Account::select('id','name_'.LaravelLocalization::getCurrentLocale().' as name','account_num')->where('parent_id',$salesAssetsParent->id)->where('branch_id',$this->branch_id)->first();
        $salesAssetsBranchLedger = Ledger::where('account_id',$salesAssetsBranch->id)->whereBetween('date',[$this->start_date,$this->end_date])->get();

        $entry19 = ClosingEntry::where('debit_account_id',$salesAssetsBranch->id)->where('credit_account_id',$incomeSummaryBranch->id)
        ->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        if($entry19) {
            $entry19->debit_amount = $salesAssetsBranchLedger->sum('debit_amount') - $salesAssetsBranchLedger->sum('credit_amount');
            $entry19->credit_amount = $salesAssetsBranchLedger->sum('debit_amount') - $salesAssetsBranchLedger->sum('credit_amount');
            $entry19->updated_by = Auth::user()->id;
            $entry19->save();


            $ledger191 = Ledger::where('account_id',$incomeSummaryBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry19->id)->first();
            $ledger192 = Ledger::where('account_id',$salesAssetsBranch->id)->where('type','closing_entry')->where('closing_entry_id',$entry19->id)->first();

            //الاستاذ العام لملخص الدخل دائن
            $ledger191->credit_amount = $entry19->credit_amount;
            $ledger191->updated_by = Auth::user()->id;
            $ledger191->save();

            //الاستاذ العام لمبيعات الاصول الثابتة مدين
            $ledger192->debit_amount = $entry19->debit_amount;
            $ledger192->updated_by = Auth::user()->id;
            $ledger192->save();
        } else {
            $entry = getNextClosingEntryNum();
            $entry19 = new ClosingEntry();
            $entry19->entry_num = $entry;
            $entry19->debit_account_num = $salesAssetsBranch->account_num;
            $entry19->debit_account_id = $salesAssetsBranch ->id;
            $entry19->credit_account_num = $incomeSummaryBranch->account_num;
            $entry19->credit_account_id = $incomeSummaryBranch->id;
            $entry19->debit_amount = $salesAssetsBranchLedger->sum('debit_amount') - $salesAssetsBranchLedger->sum('credit_amount');
            $entry19->credit_amount = $salesAssetsBranchLedger->sum('debit_amount') - $salesAssetsBranchLedger->sum('credit_amount');
            $entry19->branch_id = $this->branch_id;
            $entry19->entry_type_id = 5 ;
            $entry19->start_date = $this->start_date;
            $entry19->end_date = $this->end_date;
            $entry19->created_by = Auth::user()->id;
            $entry19->updated_by = Auth::user()->id;
            $entry19->description = "من ح  /  " .  $incomeSummaryBranch ->name  ."الي ح  /   ". $salesAssetsBranch->name  ;
            $entry19->save();

            //الاستاذ العام لملخص الدخل دائن
            $ledger191 = new Ledger();
            $ledger191->debit_amount = 0;
            $ledger191->credit_amount = $entry19->debit_amount;
            $ledger191->account_id = $incomeSummaryBranch->id;
            $ledger191->account_num = $incomeSummaryBranch->account_num;
            $ledger191->name_ar= $incomeSummaryBranch->name;
            $ledger191->created_by = Auth::user()->id;
            $ledger191->closing_entry_id = $entry19->id;
            $ledger191->type = 'closing_entry';
            $ledger191->save();

            //الاستاذ العام لمبيعات الاصول الثابتة مدين
            $ledger192 = new Ledger();
            $ledger192->debit_amount = $entry19->debit_amount;
            $ledger192->credit_amount = 0;
            $ledger192->account_id = $salesAssetsBranch->id;
            $ledger192->account_num = $salesAssetsBranch->account_num;
            $ledger192->name_ar= $salesAssetsBranch->name;
            $ledger192->created_by = Auth::user()->id;
            $ledger192->closing_entry_id = $entry19->id;
            $ledger192->type = 'closing_entry';
            $ledger192->save();
        }


        $this->reset(['start_date','end_date','branch_id']);



            //dispatch browser events (js)
            //add event to toggle create modal after save
            $this->dispatch('createModalToggle');

            DB::commit();
            Alert::success('تم إضافة قيد الاقفال للعام المالي بنجاح');
            return redirect()->route('closing_entry');
        // } catch (Exception $e) {
            DB::rollback();
        //     return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        // }



    }

    public function render()
    {
        return view('livewire.closing-entries.add-entry');
    }
}
