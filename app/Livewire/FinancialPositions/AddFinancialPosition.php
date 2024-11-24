<?php

namespace App\Livewire\FinancialPositions;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\Ledger;
use App\Models\Account;
use Livewire\Component;
use App\Models\FinancialPosition;
use Illuminate\Support\Facades\DB;
use Alert;

class AddFinancialPosition extends Component
{
        public $start_date,$end_date,$branch_id,$carsBranch1,$carsBranch2,$carsBranch3,$carsBranch4,$carsBranch5,$carsBranch6,$carsBranch7,
        $buildingsBranch1,$buildingsBranch2,$buildingsBranch3,$buildingsBranch4,$buildingsBranch5,$buildingsBranch6,$buildingsBranch7,
        $computersBranch1,$computersBranch2,$computersBranch3,$computersBranch4,$computersBranch5,$computersBranch6,$computersBranch7,
        $furnitureBranch1,$furnitureBranch2,$furnitureBranch3,$furnitureBranch4,$furnitureBranch5,$furnitureBranch6,$furnitureBranch7,
        $posDevicesBranch1,$posDevicesBranch2,$posDevicesBranch3,$posDevicesBranch4,$posDevicesBranch5,$posDevicesBranch6,$posDevicesBranch7;

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
            'start_date.required' => 'تاريخ بداية إصدار قائمة المركز المالي مطلوب',
            'start_date.date' => 'أدخل صيغة صحيحة لتاريخ بداية إصدار قائمة المركز المالي  ',
            'start_date.before' => 'تاريخ بداية قائمة المركز المالي يجب أن يكون قبل تاريخ نهاية القائمة',

            'end_date.required' => 'تاريخ نهاية إصدار قائمة المركز المالي مطلوب',
            'end_date.date' => 'أدخل صيغة صحيحة لتاريخ نهاية إصدار قائمة المركز المالي  ',
            'end_date.before' =>  'تاريخ نهاية قائمة المركز المالي يجب أن يكون بعد تاريخ بداية  القائمة',

            'branch_id.required' => 'اختر الفرع المطلوب  إصدار قائمة المركز المالي له',
            'branch_id.date' => 'الفرع الذي تم إختياره غير موجود بقاعدة البيانات ',

        ];

    }

    public function create()
    {
        $this->validate($this->rules() ,$this->messages());

        // try {
        DB::beginTransaction();

        //level 2 in accounting tree
        // $fixedAssetsParent = Account::where('account_num',11)->first();//'الاصول الغير متداولة'
        // $currentAssetsParent = Account::where('account_num',12)->first();//'الاصول المتداولة'


        // $shortTermLiabilitiesParent  = Account::where('account_num',21)->first();// خصوم قصيرة الاجل;
        // $longTermLiabilitiesParent = Account::where('account_num',22)->first();// خصوم طويلة الاجل

        // $capitalsParent = Account::where('account_num',31)->first();// رأس المال
        // $partnersCurrentAccountsParent = Account::where('account_num',32)->first();//جاري الشركاء والمساهمين
        // $netProfitOrLossParent = Account::where('account_num',33)->first();//صافي الارباح او الخسائر من قائمة الدخل

        // $fixedAssetsNetValueAccountsNums = Account::where('parent_id',$fixedAssetsParent->id)->pluck('account_num','id');//صافي الاصول الثابتة
        // //level 3 in accounting tree
        // $fixedAssetsAccounts = Account::whereIn('account_num',[1111,1121,1131,1141,1151])->get();// مباني-سيارات-كمبيوتر-اثاث-دفع الكتروني  
        // $fixedAssetsAccountNums = Account::whereIn('account_num',[1111,1121,1131,1141,1151])->pluck('account_num','id');// الاصول 
        // $fixedAssetsAccountsNetValue = Account::whereIn('account_num',[1111,1121,1131,1141,1151])->get();// مباني-سيارات-كمبيوتر-اثاث-دفع الكتروني  

     
        //مباني المركز الرئيسي
        // $this->buildingsBranch1 = Account::where('parent_account_num',11111)->get();
      
        // foreach($this->buildingsBranch1 as $bulding){
        //     $buildingsBranch1Ledger = Ledger::where('account_num',$bulding->account_num)->where('start_date',$this->start_date)->where('end_date',$this->end_date)->get();
        //     $legdgerBalance = $buildingsBranch1Ledger->sum('debt') - $buildingsBranch1Ledger->sum('credit');
       

        //     $buildingsBranch1FinancialPosition = FinancialPosition::where('account_num',$this->buildingsBranch1->id)->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        //     if($buildingsBranch1FinancialPosition) {
        //         $buildingsBranch1FinancialPosition->balance = $this->buildingsBranch1->sum('debit_amount') - $this->buildingsBranch1->sum('credit_amount');
        //         $buildingsBranch1FinancialPosition->save();
        //     } else {
        //         $buildingsBranch1FinancialPosition = new FinancialPosition();
        //         $buildingsBranch1FinancialPosition->account_id = $this->buildingsBranch1->id;
        //         $buildingsBranch1FinancialPosition->account_num = $this->buildingsBranch1->account_num;
        //         $buildingsBranch1FinancialPosition->balance = $legdgerBalance;
        //         $buildingsBranch1FinancialPosition->start_date = $this->start_date;
        //         $buildingsBranch1FinancialPosition->end_date = $this->end_date;
        //         $buildingsBranch1FinancialPosition->name_ar = $this->buildingsBranch1->name_ar;
        //         $buildingsBranch1FinancialPosition->branch_id = $this->branch_id;
        //         $buildingsBranch1FinancialPosition->save();
        //     }
        // }    

        // // مباني فرع مشعل
        // $this->buildingsBranch2 = Account::where('parent_account_num',11112)->get();
        //   dd($this->buildingsBranch2B);
        // foreach($this->buildingsBranch2 as $bulding){
        //     $buildingsBranch2Ledger = Ledger::where('account_num',$bulding->account_num)->where('start_date',$this->start_date)->where('end_date',$this->end_date)->get();
        //     $legdgerBalance = $buildingsBranch2Ledger->sum('debt') - $buildingsBranch2Ledger->sum('credit');
       

        //     $buildingsBranch2FinancialPosition = FinancialPosition::where('account_num',$this->buildingsBranch2->id)->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();
        //     if($buildingsBranch2FinancialPosition) {
        //         $buildingsBranch2FinancialPosition->balance = $this->buildingsBranch2->sum('debit_amount') - $this->buildingsBranch2->sum('credit_amount');
        //         $buildingsBranch2FinancialPosition->save();
        //     } else {
        //         $buildingsBranch2FinancialPosition = new FinancialPosition();
        //         $buildingsBranch2FinancialPosition->account_id = $this->buildingsBranch2->id;
        //         $buildingsBranch2FinancialPosition->account_num = $this->buildingsBranch2->account_num;
        //         $buildingsBranch2FinancialPosition->balance = $legdgerBalance;
        //         $buildingsBranch2FinancialPosition->start_date = $this->start_date;
        //         $buildingsBranch2FinancialPosition->end_date = $this->end_date;
        //         $buildingsBranch2FinancialPosition->name_ar = $this->buildingsBranch2->name_ar;
        //         $buildingsBranch2FinancialPosition->branch_id = $this->branch_id;
        //         $buildingsBranch2FinancialPosition->save();
        //     }
        // }  
        // // مباني فرع الوديعة البلدية
        // $this->buildingsBranch3 = Account::where('parent_account_num',11113)->get();
        // //مباني فرع سعود الوديعة
        // $this->buildingsBranch4 = Account::where('parent_account_num',11114)->get();
        // //مباني فرع بن علا
        // $this->buildingsBranch5 = Account::where('parent_account_num',11115)->get();
        // //مباني فرع السوق
        // $this->buildingsBranch6 = Account::where('parent_account_num',11116)->get();
        // //مباني فرع 6
        // $this->buildingsBranch7 = Account::where('parent_account_num',11117)->get();

        // //سيارات المركز الرئيسي
        // $this->carsBranch1 = Account::where('parent_account_num',11211)->get();
        // // $carsBranch1FinancialPosition = FinancialPosition::where('account_id',$this->carsBranch1->id)->where('start_date',$this->start_date)->where('end_date',$this->end_date)->first();

        
        // // سيارات فرع مشعل
        // $this->carsBranch2 = Account::where('parent_account_num',11212)->get();
        // // سيارات فرع الوديعة البلدية
        // $this->carsBranch3 = Account::where('parent_account_num',11213)->get();
        // //سيارات فرع سعود الوديعة
        // $this->carsBranch4 = Account::where('parent_account_num',11214)->get();
        // //سيارات فرع بن علا
        // $this->carsBranch5 = Account::where('parent_account_num',11215)->get();
        // //سيارات فرع السوق
        // $this->carsBranch6 = Account::where('parent_account_num',11216)->get();
        // //سيارات فرع 6
        // $this->carsBranch7 = Account::where('parent_account_num',11217)->get();

        // $this->computersBranch1 = Account::where('parent_account_num',11311)->get();//اجهزة كمبيوتر المركز الرئيسي
        // $this->computersBranch2 = Account::where('parent_account_num',11312)->get();// اجهزة كمبيوتر فرع مشعل
        // $this->computersBranch3 = Account::where('parent_account_num',11313)->get();// اجهزة كمبيوتر فرع الوديعة البلدية
        // $this->computersBranch4 = Account::where('parent_account_num',11314)->get();//اجهزة كمبيوتر فرع سعود الوديعة
        // $this->computersBranch5 = Account::where('parent_account_num',11315)->get();//اجهزة كمبيوتر فرع بن علا
        // $this->computersBranch6 = Account::where('parent_account_num',11316)->get();//اجهزة كمبيوتر فرع السوق
        // $this->computersBranch7 = Account::where('parent_account_num',11317)->get();//اجهزة كمبيوتر فرع 6

        // $this->furnitureBranch1 = Account::where('parent_account_num',11411)->get();//اثاث المركز الرئيسي
        // $this->furnitureBranch2 = Account::where('parent_account_num',11412)->get();// اثاث فرع مشعل
        // $this->furnitureBranch3 = Account::where('parent_account_num',11413)->get();// اثاث فرع الوديعة البلدية
        // $this->furnitureBranch4 = Account::where('parent_account_num',11414)->get();//اثاث فرع سعود الوديعة
        // $this->furnitureBranch5 = Account::where('parent_account_num',11415)->get();//اثاث فرع بن علا
        // $this->furnitureBranch6 = Account::where('parent_account_num',11416)->get();//اثاث فرع السوق
        // $this->furnitureBranch7 = Account::where('parent_account_num',11417)->get();//اثاث فرع 6

        // $this->posDevicesBranch1 = Account::where('parent_account_num',11511)->get();//اجهزة الدفع الالكترونية المركز الرئيسي
        // $this->posDevicesBranch2 = Account::where('parent_account_num',11512)->get();// اجهزة الدفع الالكترونية فرع مشعل
        // $this->posDevicesBranch3 = Account::where('parent_account_num',11513)->get();// اجهزة الدفع الالكترونية فرع الوديعة البلدية
        // $this->posDevicesBranch4 = Account::where('parent_account_num',11514)->get();//اجهزة الدفع الالكترونية فرع سعود الوديعة
        // $this->posDevicesBranch5 = Account::where('parent_account_num',11515)->get();//اجهزة الدفع الالكترونية فرع بن علا
        // $this->posDevicesBranch6 = Account::where('parent_account_num',11516)->get();//اجهزة الدفع الالكترونية فرع السوق
        // $this->posDevicesBranch7 = Account::where('parent_account_num',11517)->get();//اجهزة الدفع الالكترونية فرع 6



        
        

// $fixedAssetsBranchCollection = $fixedAssetsAccounts->map(function($fixedAssetsAccount) {
//     // Get all branches for the fixed asset account
//     $generalAccountsGroupByBranch = Account::where('parent_id', $fixedAssetsAccount->id)->get();

//     // Map through each branch to get its associated assets
//     $branchAssets = $generalAccountsGroupByBranch->map(function($assetsInBranch) {
//         // Get all assets for the current branch
//         return [
//             'branch' => $assetsInBranch,
//             'assets' => Account::where('parent_id', $assetsInBranch->id)->get() // Get assets under this branch
//         ];
//     });

//     return [
//         'fixedAssetAccount' => $fixedAssetsAccount,
//         'branches' => $branchAssets
//     ];
// });

// Now $fixedAssetsBranchCollection contains the desired structure



 
   $assetsParentsAccountsNums = Account::whereIn('parent_account_num',[11111,1121,1131,1141])->pluck('account_num')->unique()->values()->toArray();
   $assetsAccounts = Account::whereIn('parent_account_num', $assetsParentsAccountsNums)->get();
   dd($assetsAccounts);


  

            DB::commit();
            Alert::success('تم إضافة قائمة المركز المالي للعام المالي بنجاح');
            return redirect()->route('financial_positions');
        // } catch (Exception $e) {
            DB::rollback();
        //     return redirect()->back()->withErrors(['error' => 'عفوا حدث خطاء']);
        // }



    }
    public function render()
    {
        return view('livewire.financial-positions.add-financial-position');
    }
}
