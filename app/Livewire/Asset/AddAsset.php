<?php

namespace App\Livewire\Asset;

use App\Events\NewAssetAddedEvent;
use Carbon\Carbon;
use App\Models\Asset;
use App\Models\Account;
use Livewire\Component;
use App\Models\AccountType;
use App\Models\Depreciation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Alert;

class AddAsset extends Component
{
    public $name_ar,$name_en,$life_span,$purchase_price,$scrap_price,$parent_account_id,$branch_id,
    $payment_type,$bank_id,$check_num, $purchase_date,$parent_parent_account_id,$supplier_id;

    public function rules() {
        return [
            'name_ar' => ['required','string','max:255',Rule::unique('assets')],
            'name_en' => ['nullable','string','max:255',Rule::unique('assets')],
            'life_span' =>   'required|numeric',
            'scrap_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'purchase_date' => 'required|date',
            'parent_parent_account_id' => 'required|exists:accounts,id',
            'branch_id' => [

                'required',
                Rule::exists('branches', 'id')->where(function ($query) {
                    return Auth::user()->role_name == "سوبر-ادمن";
                }),
            ],
            'bank_id' =>  'required_if:payment_type,by_check',
            // 'check_num' =>  'required_if:payment_type,by_check',
            'payment_type'=>'required',
            'supplier_id' => 'required|exists:suppliers,id',
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => trans('validation.name_ar_required'),
            'name_ar.string' => trans('validation.name_ar_string'),
            'name_ar.max' => trans('validation.name_ar_max'),
            'name_ar.unique' => trans('validation.name_ar_unique'),

            'name_en.string' => trans('validation.name_en_string'),
            'name_en.max' => trans('validation.name_en_max'),
            'name_en.unique' => trans('validation.name_en_unique'),

            'life_span.required' => 'العمر الإفتراضي للاصل الثابت مطلوب',
            'life_span.numeric' => 'العمر الإفتراضي للاصل الثابت يجب أن يكون رقم',

            'scrap_price.required' => '  قيمة الخردة مطلوب',
            'scrap_price.numeric' => '  قيمة الخردة يجب أن تكون رقم',

            'purchase_price.required' => 'سعر شراء الأصل الثابت مطلوب',
            'purchase_price.numeric' =>'سعر شراء الأصل الثابت يجب أن يكون رقم',

            'purchase_date.required' => 'تاريخ شراء الأصل الثابت مطلوب',
            'purchase_date.numeric' =>'أدخل صيغة صالحة لتاريخ شاء الاصل الثابت',

            'branch_id.required' =>  trans('validation.branch_id_required'),
            'branch_id.in' =>  trans('validation.branch_id_in'),

            'parent_parent_account_id.required' =>  'الحساب الاب التابع له الاصل الثابت في الشجرة المحاسبية مطلوب',
            'parent_parent_account_id.in' =>  'الحساب الاب الذي تم إدخاله غير موجود بقاعدة البيانات ',

            'bank_id.required_if' => 'اختر البنك المطلوب صرف الشيك منه',
            // 'check_num.required_if' => 'ادخل رقم الشيك',
            'payment_type.required'=> 'طريقة الدفع مطلوبة',

            'supplier_id.required' => 'إسم المورد مطلوب',
            'supplier_id.exists' => 'إسم المورد الذي تم إدخالة غير مسجل بقاعدة البيانات',
        ];

    }





    public function create()
    {
        $this->validate($this->rules() ,$this->messages());
        //dd("ff");
        DB::beginTransaction();
        // try {


        $parentParent = Account::where('id',$this->parent_parent_account_id)->first();
        $parent = Account::where('parent_id',$this->parent_parent_account_id)->where('branch_id',$this->branch_id)->first();
       // dd($parent->account_num);

        $currentChildAccountNum = 0;


        $latestAccountChild = Account::where('parent_id', $parent->id)->latest()->first();
        //dd($parent);
        if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num;
        } else {

            $currentChildAccountNum = $parent->account_num . '0';
        }
          //dd($currentChildAccountNum);

        //dd($currentChildAccountNum);



            $asset = new Asset();
            $asset->name_ar = $this->name_ar;
            $asset->name_en = $this->name_en;
            $asset->life_span = $this->life_span;
            $asset->scrap_price = $this->scrap_price;
            $asset->purchase_price = $this->purchase_price;
            $asset->purchase_date = $this->purchase_date;
            $asset->account_num = $currentChildAccountNum + 1;
            $asset->branch_id = $this->branch_id;
            $asset->current_price = $this->purchase_price;
            $asset->parent_account_id = $parent->id;
            $asset->payment_type = $this->payment_type;
            $asset->bank_id = $this->bank_id;
            $asset->check_num = $this->check_num;
            $asset->supplier_id = $this->supplier_id;
            $asset->created_by = Auth::user()->id;
            $asset->save();


            //حساب الاصل الثابت بالشجرة المحاسبية
            $account1 = new Account();
            $account1->name_ar = $this->name_ar;
            $account1->name_en = $this->name_en;
            $account1->start_balance = $asset->purchase_price;
            $account1->current_balance = $asset->purchase_price;
            $account1->account_num = $asset->account_num;
            $account1->account_type_id = 1;
            $account1->parent_id = $parent->id;
            $account1->created_by = Auth::user()->id;
            $account1->updated_by = Auth::user()->id;
            $account1->is_active = 1 ;
            $account1->branch_id = $this->branch_id;
            $account1->level = $parent->level +1 ;
            $account1->nature = $parent->nature;
            $account1->list = $parent->list;
            $account1->is_parent = 0;
            $account1->save();

            if($parentParent->account_num == 1111) {
                //المباني
                $depParentAccount = Account::where('account_num', 2144)->first();//مخصص الاهلاك
                $depAccount = Account::where('parent_id',$depParentAccount->id)->where('branch_id',$this->branch_id)->first();//مخصص اهلاك الفر

                $depExpensesParentAccount = Account::where('account_num',5122)->first();//مصروف الاهلاك
                $depExpensesAccount = Account::where('parent_id',$depExpensesParentAccount->id)->where('branch_id',$this->branch_id)->first();//مصروف اعلاك الفرع


            } elseif($parentParent->account_num == 1121){
                 //السيارات
                $depParentAccount = Account::where('account_num',2141)->first();//مخصص الاهلاك
                // $netAssetValue = Account::where('account_num', 112)->first();//الصافي
                $depAccount = Account::where('parent_id',$depParentAccount->id)->where('branch_id',$this->branch_id)->first();//مخصص اهلاك الفر

                $depExpensesParentAccount = Account::where('account_num',5124)->first();//مصروف الاهلاك
                $depExpensesAccount = Account::where('parent_id',$depExpensesParentAccount->id)->where('branch_id',$this->branch_id)->first();//مصروف اعلاك الفرع
            } elseif($parentParent->account_num == 1131){
                  //اجهزة الكمبيوتروغيرها
                $depParentAccount = Account::where('account_num',operator: 2142)->first();//مخصص الاهلاك
                // $netAssetValue = Account::where('account_num', 113)->first();//الصافي
                $depAccount = Account::where('parent_id',$depParentAccount->id)->where('branch_id',$this->branch_id)->first();//مخصص اهلاك الفر
                $depExpensesParentAccount = Account::where('account_num',5123)->first();//مصروف الاهلاك
                $depExpensesAccount = Account::where('parent_id',$depExpensesParentAccount->id)->where('branch_id',$this->branch_id)->first();//مصروف اعلاك الفرع
                
            } elseif($parentParent->account_num == 1141){
                  //الاثاث والمفروشات
                $depParentAccount = Account::where('account_num',2143)->first();//مخصص الاهلاك
                // $netAssetValue = Account::where('account_num', 114)->first();//الصافي
                $depAccount = Account::where('parent_id',$depParentAccount->id)->where('branch_id',$this->branch_id)->first();//مخصص اهلاك الفر
                $depExpensesParentAccount = Account::where('account_num',5124)->first();//مصروف الاهلاك
                $depExpensesAccount = Account::where('parent_id',$depExpensesParentAccount->id)->where('branch_id',$this->branch_id)->first();//مصروف اعلاك الفرع

            } elseif($parentParent->account_num == 1151){
                  //اجهزة الدفع الالكترونية
                $depParentAccount = Account::where('account_num',2145)->first();
                // $netAssetValue = Account::where('account_num', 115)->first();
                $depAccount = Account::where('parent_id',$depParentAccount->id)->where('branch_id',$this->branch_id)->first();//مخصص اهلاك الفر
                $depExpensesParentAccount = Account::where('account_num',5125)->first();//مصروف الاهلاك
                $depExpensesAccount = Account::where('parent_id',$depExpensesParentAccount->id)->where('branch_id',$this->branch_id)->first();//مصروف اعلاك الفرع


            }

            //حساب مخصص الاهلاك للاصل الثابت بالشجرة المحاسبية
            $account2 = new Account();
            $account2->name_ar = "مخصص اهلاك". " " .$this->name_ar;
            $account2->name_en = $this->name_en;
            $account2->start_balance = 0;
            $account2->current_balance = 0;
            $account2->account_num = $depAccount->account_num . $asset->id;
            $account2->account_type_id = 1;
            $account2->parent_id = $parent->id;
            $account2->created_by = Auth::user()->id;
            $account2->updated_by = Auth::user()->id;
            $account2->branch_id = $this->branch_id;
            $account2->is_active = 1 ;
            $account2->nature = $depAccount->nature;
            $account2->list = $depAccount->list;
            $account2->level = $depAccount ->level +1 ;
            $account1->is_parent = 0;
            $account2->save();

            //حساب مصروفات الاهلاك للاصل الثابت بالشجرة المحاسبية
            $account3 = new Account();
            $account3->name_ar = "مصروفات اهلاك". " " .$this->name_ar;
            $account3->name_en = $this->name_en;
            $account3->start_balance = 0;
            $account3->current_balance = 0;
            $account3->account_num = $depExpensesParentAccount->account_num . $asset->id;
            $account3->account_type_id = 1;
            $account3->parent_id = $parent->id;
            $account3->created_by = Auth::user()->id;
            $account3->updated_by = Auth::user()->id;
            $account3->branch_id = $this->branch_id;
            $account3->is_active = 1 ;
            $account3->nature = $depExpensesParentAccount->nature;
            $account3->list = $depExpensesParentAccount->list;
            $account3->level = $depExpensesParentAccount ->level +1 ;
            $account1->is_parent = 0;
            $account3->save();




            //بداية حسابات اهلاكات الاصل الثابت
            $depreciationAmount = ($asset->purchase_price - $asset->scrap_price) / $asset->life_span;

            $date = Carbon::parse($this->purchase_date);
            $year = $date->year;
            //dd($this->purchase_date);

            $startDate = Carbon::createFromDate($year, 1, 1);
            $endDate = Carbon::createFromDate($year, 12, 31);
            $numberOfDaysFromYearStart = $startDate->diffInDays($date) ;
            $remainingDaysToYearStart = $date->diffInDays($endDate) ;
           // dd($numberOfDaysFromYearStart,$remainingDaysToYearStart);
            $purchaseYear = Carbon::parse($this->purchase_date)->year;
            $depYear = '';
            // dd($numberOfDaysFromYearStart,$remainingDaysToYearStart);

        

            if($numberOfDaysFromYearStart == 0 ||$remainingDaysToYearStart == 0 ){
                for ($i = 1; $i <= $this->life_span ; $i++) {

                    $depreciationYear = Carbon::parse($this->purchase_date)->copy()->addYears($i);
                    $depreciationDate = $depreciationYear->setMonth(12)->setDay(31);

                    Depreciation::create([
                        'date' => $depreciationDate,
                        'asset_id' => $asset->id,
                        'amount' => $depreciationAmount,
                        // 'start_date'=>,
                        // 'end_date'
                    ]);
                }

            } else {
                for ($i = 1; $i <= $this->life_span + 1; $i++) {
                    // $depreciationYear = Carbon::parse($this->purchase_date)->copy()->addYears($i)->format('Y');
                    // $depreciationDate = Carbon::parse($this->purchase_date)->copy()->addYears($i);


                    $depreciationYear = Carbon::parse($this->purchase_date)->copy()->addYears($i);
                    $depreciationDate = $depreciationYear->setMonth(12)->setDay(31);

                    if ($i == 1) {
                        $dep = ($numberOfDaysFromYearStart / 365) * $depreciationAmount;
                        $depYear = $purchaseYear;
                    } elseif ($i == $this->life_span + 1) {
                        $dep = ($remainingDaysToYearStart / 365) * $depreciationAmount;
                        $depYear = $purchaseYear + ($this->life_span - 1);
                    } else {
                        $dep = $depreciationAmount;
                        $purchaseYear++;
                    }

                    Depreciation::create([
                        'date' => $depreciationDate,
                        'asset_id' => $asset->id,
                        'amount' => $dep,
                        // 'start_date'=>,
                        // 'end_date'
                    ]);

                }
            }
            //نهاية حسابات اهلاكات الاصل الثابت


            $this->reset(['name_en','name_ar','life_span','scrap_price','purchase_price','parent_account_id','branch_id']);

            $this->dispatch('createModalToggle');
            event(new NewAssetAddedEvent($asset,$account1,$account2,$account3,$this->supplier_id));
            DB::commit();
            Alert::success('تم حفظ الاصل الثابت واهلاكاته بنجاح');

             return redirect()->route('assets');


        // } catch (Exception $e) {
        //      DB::rollback();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }
    }
  public function render()
    {
        return view('livewire.asset.add-asset');
    }
}

