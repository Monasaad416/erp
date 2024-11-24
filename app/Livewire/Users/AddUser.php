<?php

namespace App\Livewire\Users;

use Alert;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ledger;
use App\Models\Salary;
use App\Models\Account;
use Livewire\Component;
use App\Models\AccountType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Livewire\Users\DisplayUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AddUser extends Component
{
    public $name, $email, $password,$password_confirmation, $roles_name,$price,$branch_id,$fingerprint_code,
    $date_of_birth,$address,$phone,$age,$has_driving_license,$has_medical_insurance,$id_num,$id_exp_date,
    $marital_status,$gender,$joining_date,$blood_type_id,$nationality_id,$passport_num,$passport_exp_date,
    $resignation_date,$working_status,$image,$medical_insurance_deduction,$transfer_allowance,$housing_allowance,
    $vacations_balance,$work_status,$salary,$overtime_hour_price,$account_num,$job_title;

    public function rules() {
        return [
            'name' => "required|string|max:100",
            'email' =>  ['required','email','max:100',Rule::unique('users')],
            'password' => "required|string|min:5|max:25",
            'password_confirmation' => 'required|same:password',
            'roles_name' => "required|exists:roles,name",
            'branch_id' => "required|exists:branches,id",
            'gender' => "required|in:male,female",
            'joining_date' => "required|date",
            'fingerprint_code' =>"nullable|string",
            'blood_type_id' => "nullable|exists:blood_types,id",
            'nationality_id' => "nullable|exists:nationalities,id",
            'marital_status' => "nullable|in:single,married",
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'age' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'id_num' => 'nullable|string',
            'id_exp_date' => 'nullable|date',
            'passport_num' => 'nullable|string',
            'passport_exp_date' => 'nullable|date',
            'resignation_date' => 'nullable|date',
            'working_status' => 'nullable|in:working,not_working',
            'has_driving_license' => 'nullable|boolean',
            'image' => 'nullable|string|mimes:jpg,jpeg,png',
            'has_medical_insurance' => 'nullable|boolean',
            'medical_insurance_deduction' => 'nullable|numeric',
            'transfer_allowance' => 'nullable|numeric',
            'housing_allowance' => 'nullable|numeric',
            'vacations_balance' => 'nullable|numeric',
            'salary' => 'nullable|numeric',
            'overtime_hour_price' =>' nullable|numeric',
            'job_title' => 'nullable|string',

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'إسم الموظف مطلوب',
            'name.string' => 'إسم الموظف يجب أن يتكون من أحرف',
            'name.max' => 'أقصي عدد احرف لإسم الموظف 100 حرف',

            'email.required' => 'البريد الإلكتروني للموظف مطلوب',
            'email.string' => 'البريد الإلكتروني  يجب أن يتكون من أحرف',
            'email.max' => 'أقصي عدد احرف للبريد الإلكتروني  100 حرف',
            'email.unique' => 'البريد الإلكتروني الذي تم إدخالة بالفعل مسجل في قاعدة البيانات',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => ' كلمة المرور يجب أن يتكون من أحرف وأرقام',
            'password.min' => ' كلمة المرور يجب أن لا تقل عن 5 أحرف    ',
            'password.max' => ' كلمة المرور يجب أن لا تزيد عن 25 حرف    ',
            'password_confirmation.same' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين ',
            'password_confirmation.required' => ' تأكيد  كلمة المرور مطلوب',

            'roles_name.required' => 'مهمة الموظف مطلوبة ',
            'roles_name.exists' => 'مهمة الموظف التي تم اخيارها غير موجودة بقاعدة البيانات',

            'branch_id.requird'=> 'الفرع مطلوب',
            'branch_id.exists'=> 'الفرع الذي تم ادخالة غير مسجل بقاعدة البيانات',
            'gender.required' => 'النوع مطلوب',
            'gender.in' => 'النوع يجب أن يكون واحد من ذكر-انثي',
            'joining_date.required' => 'تاريخ الإلتحاق بالعمل  مطلوب',
            'joining_date.date' => 'صيغة تاريخ الإلتحاق بالعمل التي تم إدخالها غير صحيحة',
            'id_exp_date.date' => 'صيغة تاريخ إنتهاء الهوية التي تم إدخالها غير صحيحة',
            'passport_exp_date.date' => 'صيغة تاريخ إنتهاء جواز السفر التي تم إدخالها غير صحيحة',
             'fingerprint_code.string' => 'كود البصمة يجب أن يتكون من أحرف',
            'blood_type_id.in' => 'نوع فصيلة الدم الذي تم إخياره غير موجود بقاعدة البيانات',
            'nationality_id.in' => 'الجنسية التي  تم إختيارها غير موجود بقاعدة البيانات',
            'marital_status.in' => 'الحالة الاإجتماعية يجب أن تكون واحد من اعزب-متزوج',
            'medical_insurance_deduction.numeric' => 'استقطاعات التأمين الطبي يجب أن تكون رقم',
            'transfer_allowance.numeric' => 'بدل الإنتقالات يجب أن يكون رقم',
            'housing_allowance.numeric' =>  'بدل السكن يجب أن يكون رقم',
            'vacations_balance.numeric' =>  'رصيد الأجازات  يجب أن يكون رقم',
            'age.numeric' => 'فضلا ادخل صيغة صحيحة للعمر',
            'date_of_birth.date' => 'فضلا ادخل صيغة صحيحة لتاريخ الميلاد',
            'salary.numeric' =>  'الراتب  يجب أن يكون رقم',
            'overtime_hour_price.numeric' =>  'تكلفة ساعة الإضافي  يجب أن يكون رقم',
            'job_title.string' =>'المسمي الوظيفي يجب أن يتكون من أحرف',
        ];

    }

    public function getNextEmployeeCode()
    {
        $currentCode = User::where('branch_id',$this->branch_id)->max('account_num');
        if($currentCode) {
            return $currentCode + 1;
        }
        return 1;
    }


    public function create()
    {


        //الاجور والمرتبات
        $usersParentAccount = Account::where('account_num',513)->first();//اجور و مرتبات
        $usersParentAccountBranch = Account::where('parent_id', $usersParentAccount->id)->where('branch_id',2)->first();

        $latestAccountChild = Account::where('parent_id', $usersParentAccountBranch->id)->first();
        

        if ($latestAccountChild) {
            $currentChildAccountNum = $latestAccountChild->account_num;
        } else {
            $currentChildAccountNum = $usersParentAccountBranch->account_num . '0';
        }


            //السلف
        $usersAdvancePayParentAccount = Account::where('account_num',1233)->first();//سلف العاملين
        $usersAdvancePayParentAccountBranch = Account::where('parent_id', $usersAdvancePayParentAccount->id)->where('branch_id',2)->first();

        //dd($usersAdvancePayParentAccount);
        $latestAdvancePayAccountChild = Account::where('parent_id', $usersAdvancePayParentAccountBranch->id)->first();
        

        if ($latestAdvancePayAccountChild) {
            $currentAdvancePayChildAccountNum = $latestAdvancePayAccountChild->account_num;
        } else {
            $currentAdvancePayChildAccountNum = $usersAdvancePayParentAccountBranch->account_num . '0';
        }

            //العهد
        $usersCustodyParentAccount = Account::where('account_num',1232)->first();// عهد العاملين
        $usersCustodyParentAccountBranch = Account::where('parent_id', $usersCustodyParentAccount->id)->where('branch_id',2)->first();

        //dd($usersCustodyParentAccount);
        $latestCustodyAccountChild = Account::where('parent_id', $usersCustodyParentAccountBranch->id)->first();
        

        if ($latestCustodyAccountChild) {
            $currentCustodyChildAccountNum = $latestCustodyAccountChild->account_num;
        } else {
            $currentCustodyChildAccountNum = $usersCustodyParentAccountBranch->account_num . '0';
        }

        //الخصومات
        $usersDeductParentAccount = Account::where('account_num',operator: 47)->first();// خصومات العاملين
        $usersDeductParentAccountBranch = Account::where('parent_id', $usersDeductParentAccount->id)->where('branch_id',2)->first();

        //dd($usersDeductParentAccount);
        $latestDeductAccountChild = Account::where('parent_id', $usersDeductParentAccountBranch->id)->first();
        

        if ($latestDeductAccountChild) {
            $currentDeductChildAccountNum = $latestDeductAccountChild->account_num;
        } else {
            $currentDeductChildAccountNum = $usersDeductParentAccountBranch->account_num . '0';
        }
        //المكافئات
        $usersRewardParentAccount = Account::where('account_num',operator: 514)->first();// مكافئات العاملين
        $usersRewardParentAccountBranch = Account::where('parent_id', $usersRewardParentAccount->id)->where('branch_id',2)->first();

        //dd($usersRewardParentAccount);
        $latestRewardAccountChild = Account::where('parent_id', $usersRewardParentAccountBranch->id)->first();
        

        if ($latestRewardAccountChild) {
            $currentRewardChildAccountNum = $latestRewardAccountChild->account_num;
        } else {
            $currentRewardChildAccountNum = $usersRewardParentAccountBranch->account_num . '0';
        }

        //التأمينات
        $usersInsuranceParentAccount = Account::where('account_num',operator: 1238)->first();// تأمينات العاملين
        $usersInsuranceParentAccountBranch = Account::where('parent_id', $usersInsuranceParentAccount->id)->where('branch_id',2)->first();

        //dd($usersInsuranceParentAccount);
        $latestInsuranceAccountChild = Account::where('parent_id', $usersInsuranceParentAccountBranch->id)->first();
        

        if ($latestInsuranceAccountChild) {
            $currentInsuranceChildAccountNum = $latestInsuranceAccountChild->account_num;
        } else {
            $currentInsuranceChildAccountNum = $usersInsuranceParentAccountBranch->account_num . '0';
        }

        //الضرائب
        $usersTaxParentAccount = Account::where('account_num',operator: 1239)->first();// ضرائب العاملين
            $usersTaxParentAccountBranch = Account::where('parent_id', $usersTaxParentAccount->id)->where('branch_id',2)->first();

            //dd($usersTaxParentAccount);
            $latestTaxAccountChild = Account::where('parent_id', $usersTaxParentAccountBranch->id)->first();
            
    
            if ($latestTaxAccountChild) {
                $currentTaxChildAccountNum = $latestTaxAccountChild->account_num;
            } else {
                $currentTaxChildAccountNum = $usersTaxParentAccountBranch->account_num . '0';
            }


        //عمولة المبيعات
        $usersCommissionParentAccount = Account::where('account_num',operator: 521)->first();// عمولة مبيعات العاملين
        $usersCommissionParentAccountBranch = Account::where('parent_id', $usersCommissionParentAccount->id)->where('branch_id',2)->first();

        //dd($usersCommissionParentAccount);
        $latestCommissionAccountChild = Account::where('parent_id', $usersCommissionParentAccountBranch->id)->first();
        

        if ($latestCommissionAccountChild) {
            $currentCommissionChildAccountNum = $latestCommissionAccountChild->account_num;
        } else {
            $currentCommissionChildAccountNum = $usersCommissionParentAccountBranch->account_num . '0';
        }    


  



        $this->validate($this->rules() ,$this->messages());
        //return dd($this->password);

        //   $path = Storage::putFile("exams", $request->file('img'));

        // try{
            DB::begintransaction();
            $user = new User();
             $user->name  = $this->name;
             $user->roles_name  = $this->roles_name;
             $user->code  = $this->getNextEmployeeCode();
             $user->account_num  = $currentChildAccountNum + 1;
             $user->advance_payment_account_num  =  $currentAdvancePayChildAccountNum + 1;
             $user->gender  = $this->gender;
             $user->password  = Hash::make($this->password);
             $user->joining_date  = $this->joining_date;
             $user->branch_id = $this->branch_id;
             $user->fingerprint_code = $this->fingerprint_code;
             $user->blood_type_id  =  $this->blood_type_id;
             $user->marital_status = $this->marital_status;
             $user->email  = $this->email;
             $user->address  = $this->address;
             $user->phone =  $this->phone;
             $user->date_of_birth = $this->date_of_birth;
             $user->nationality_id = $this->nationality_id ;
             $user->has_driving_license =  $this->has_driving_license ;
             $user->id_num = $this->id_num ;
             $user->id_exp_date = $this->id_exp_date ;
             $user->passport_num = $this->passport_num ;
             $user->passport_exp_date = $this->passport_exp_date ;
             $user->age =  $this->age ;
             $user->resignation_date = empty($this->resignation_date) ? null : $this->resignation_date;
             $user->work_status = $this->work_status ;
             $user->image = $this->image;
             $user->vacations_balance = $this->vacations_balance ;
             $user->salary = $this->salary ;
             $user->overtime_hour_price = $this->overtime_hour_price ;
             $user->medical_insurance_deduction = $this->medical_insurance_deduction ;
             $user->has_medical_insurance = $this->has_medical_insurance ;
             $user->transfer_allowance = $this->transfer_allowance ;
             $user->housing_allowance = $this->housing_allowance ;
             $user->job_title = $this->job_title ;
             $user->save();

 
            $user->assignRole($user->roles_name);

    
            $account = new  Account();
            $account->name_ar = 'ذمة الموظف  '.$user->name;
            $account->start_balance = 0;
            $account->current_balance = 0;
            $account->account_num = $user->account_num;
            $account->account_type_id = 8;
            $account->nature = "مدين";
            $account->list = "دخل";
            $account->parent_id = $usersParentAccountBranch->id;
            $account->created_by = $user->id;
            $account->updated_by = $user->id;
            $account->is_active = 1 ;
            $account->level = $usersParentAccountBranch->level + 1;
            $account->branch_id = $user->branch_id;
            $account->is_parent = 0;
            $account->save();
            //dd($usersAdvancePayParentAccountBranch);

            $advancePaymenAccount = new Account();
            $advancePaymenAccount->name_ar = 'سلف الموظف  '.$user->name;
            $advancePaymenAccount->start_balance = 0;
            $advancePaymenAccount->current_balance = 0;
            $account->nature = "مدين";
            $account->list = "مركز-مالي";
            $advancePaymenAccount->account_num = $currentAdvancePayChildAccountNum + 1;
            $advancePaymenAccount->account_type_id = 8;
            $advancePaymenAccount->parent_id = $usersAdvancePayParentAccountBranch->id;
            $advancePaymenAccount->created_by = $user->id;
            $advancePaymenAccount->updated_by = $user->id;
            $advancePaymenAccount->is_active = 1 ;
            $advancePaymenAccount->level = $usersAdvancePayParentAccountBranch->level + 1;
            $advancePaymenAccount->branch_id = $user->branch_id;
            $advancePaymenAccount->is_parent = 0;
            $advancePaymenAccount->save() ;  

           $custodyAccount = new Account();
            $custodyAccount->name_ar = 'عهد الموظف  '.$user->name;
            $custodyAccount->start_balance = 0;
            $custodyAccount->current_balance = 0;
            $account->nature = "مدين";
            $account->list = "مركز-مالي";
            $custodyAccount->account_num = $currentCustodyChildAccountNum + 1;
            $custodyAccount->account_type_id = 8;
            $custodyAccount->parent_id = $usersCustodyParentAccountBranch->id;
            $custodyAccount->created_by = $user->id;
            $custodyAccount->updated_by = $user->id;
            $custodyAccount->is_active = 1 ;
            $custodyAccount->level = $usersCustodyParentAccountBranch->level + 1;
            $custodyAccount->branch_id = $user->branch_id;
            $custodyAccount->is_parent = 0;
            $custodyAccount->save() ;  

            $deductionAccount = new Account();
            $deductionAccount->name_ar = 'خصومات مستقطعة من الموظف  '.$user->name;
            $deductionAccount->start_balance = 0;
            $deductionAccount->current_balance = 0;
            $account->nature = "دائن";
            $account->list = "دخل";
            $deductionAccount->account_num = $currentDeductChildAccountNum + 1;
            $deductionAccount->account_type_id = 8;
            $deductionAccount->parent_id = $usersDeductParentAccountBranch->id;
            $deductionAccount->created_by = $user->id;
            $deductionAccount->updated_by = $user->id;
            $deductionAccount->is_active = 1 ;
            $deductionAccount->level = $usersDeductParentAccountBranch->level + 1;
            $deductionAccount->branch_id = $user->branch_id;
            $deductionAccount->is_parent = 0;
            $deductionAccount->save() ; 

           $rewardAccount = new Account();
            $rewardAccount->name_ar = ' مكافئات الموظف  '.$user->name;
            $rewardAccount->start_balance = 0;
            $rewardAccount->current_balance = 0;
            $account->nature = "مدين";
            $account->list = "دخل";
            $rewardAccount->account_num = $currentRewardChildAccountNum + 1;
            $rewardAccount->account_type_id = 8;
            $rewardAccount->parent_id = $usersRewardParentAccountBranch->id;
            $rewardAccount->created_by = $user->id;
            $rewardAccount->updated_by = $user->id;
            $rewardAccount->is_active = 1 ;
            $rewardAccount->level = $usersRewardParentAccountBranch->level + 1;
            $rewardAccount->branch_id = $user->branch_id;
            $rewardAccount->is_parent = 0;
            $rewardAccount->save() ;

            $insuranceAccount = new Account();
            $insuranceAccount->name_ar = ' تأمينات مستقطعة من الموظف  '.$user->name;
            $insuranceAccount->start_balance = 0;
            $insuranceAccount->current_balance = 0;
            $account->nature = "دائن";
            $account->list = "مركز-مالي";
            $insuranceAccount->account_num = $currentInsuranceChildAccountNum + 1;
            $insuranceAccount->account_type_id = 8;
            $insuranceAccount->parent_id = $usersInsuranceParentAccountBranch->id;
            $insuranceAccount->created_by = $user->id;
            $insuranceAccount->updated_by = $user->id;
            $insuranceAccount->is_active = 1 ;
            $insuranceAccount->level = $usersInsuranceParentAccountBranch->level + 1;
            $insuranceAccount->branch_id = $user->branch_id;
            $insuranceAccount->is_parent = 0;
            $insuranceAccount->save() ;

            $taxAccount = new Account();
            $taxAccount->name_ar = ' ضرائب مستقطعة من الموظف  '.$user->name;
            $taxAccount->start_balance = 0;
            $taxAccount->current_balance = 0;
            $account->nature = "دائن";
            $account->list = "مركز-مالي";
            $taxAccount->account_num = $currentTaxChildAccountNum + 1;
            $taxAccount->account_type_id = 8;
            $taxAccount->parent_id = $usersTaxParentAccountBranch->id;
            $taxAccount->created_by = $user->id;
            $taxAccount->updated_by = $user->id;
            $taxAccount->is_active = 1 ;
            $taxAccount->level = $usersTaxParentAccountBranch->level + 1;
            $taxAccount->branch_id = $user->branch_id;
            $taxAccount->is_parent = 0;
            $taxAccount->save() ;

            $commissionAccount = new Account();
            $commissionAccount->name_ar = ' عمولة المبيعات للموظف  '.$user->name;
            $commissionAccount->start_balance = 0;
            $commissionAccount->current_balance = 0;
            $account->nature = "مدين";
            $account->list = "دخل";
            $commissionAccount->account_num = $currentCommissionChildAccountNum + 1;
            $commissionAccount->account_type_id = 8;
            $commissionAccount->parent_id = $usersCommissionParentAccountBranch->id;
            $commissionAccount->created_by = $user->id;
            $commissionAccount->updated_by = $user->id;
            $commissionAccount->is_active = 1 ;
            $commissionAccount->level = $usersCommissionParentAccountBranch->level + 1;
            $commissionAccount->branch_id = $user->branch_id;
            $commissionAccount->is_parent = 0;
            $commissionAccount->save() ;



            

            
            $ledger1 = new Ledger();
            $ledger1->name_ar = 'ذمة الموظف  '.$user->name;
            $ledger1->account_id = $account->id;
            $ledger1->account_num = $account->account_num;
            $ledger1->created_by = Auth::user()->id;
            $ledger1->date = Carbon::now();
            $ledger1->type ="journal_entry";
            $ledger1->save();


 

            $ledger2 = new Ledger();
            $ledger2->name_ar = 'سلف الموظف  '.$user->name;
            $ledger2->account_id = $advancePaymenAccount->id;
            $ledger2->account_num = $advancePaymenAccount->account_num;
            $ledger2->created_by = Auth::user()->id;
            $ledger2->date = Carbon::now();
            $ledger2->type ="journal_entry";
            $ledger2->save();

            $ledger3 = new Ledger();
            $ledger3->name_ar = 'عهد الموظف  '.$user->name;
            $ledger3->account_id = $custodyAccount->id;
            $ledger3->account_num = $custodyAccount->account_num;
            $ledger3->created_by = Auth::user()->id;
            $ledger3->date = Carbon::now();
            $ledger3->type ="journal_entry";
            $ledger3->save();

            $ledger4 = new Ledger();
            $ledger4->name_ar = 'تأمينات مستقطعة من الموظف  '.$user->name;
            $ledger4->account_id = $insuranceAccount->id;
            $ledger4->account_num = $insuranceAccount->account_num;
            $ledger4->created_by = Auth::user()->id;
            $ledger4->date = Carbon::now();
            $ledger4->type ="journal_entry";
            $ledger4->save();
            
            $ledger5 = new Ledger();
            $ledger5->name_ar = 'خصومات مستقطعة من الموظف  '.$user->name;
            $ledger5->account_id = $deductionAccount->id;
            $ledger5->account_num = $deductionAccount->account_num;
            $ledger5->created_by = Auth::user()->id;
            $ledger5->date = Carbon::now();
            $ledger5->type ="journal_entry";
            $ledger5->save();

            $ledger6 = new Ledger();
            $ledger6->name_ar = 'ضرائب مستقطعة من الموظف  '.$user->name;
            $ledger6->account_id = $taxAccount->id;
            $ledger6->account_num = $taxAccount->account_num;
            $ledger6->created_by = Auth::user()->id;
            $ledger6->date = Carbon::now();
            $ledger6->type ="journal_entry";
            $ledger6->save();

            $ledger7 = new Ledger();
            $ledger7->name_ar = 'مكافئات الموظف  '.$user->name;
            $ledger7->account_id = $rewardAccount->id;
            $ledger7->account_num = $rewardAccount->account_num;
            $ledger7->created_by = Auth::user()->id;
            $ledger7->date = Carbon::now();
            $ledger7->type ="journal_entry";
            $ledger7->save();
            
            
            $ledger8 = new Ledger();
            $ledger8->name_ar = 'عمولة المبيعات للموظف  '.$user->name;
            $ledger8->account_id = $rewardAccount->id;
            $ledger8->account_num = $rewardAccount->account_num;
            $ledger8->created_by = Auth::user()->id;
            $ledger8->date = Carbon::now();
            $ledger8->type ="journal_entry";
            $ledger8->save();

            DB::commit();
            Alert::success('تم إضافة موظف جديد بنجاح');
            return redirect()->route('users');
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }



        $role = Role::where(['name' => $this->roles_name])->first();

        $user->assignRole([$role->id]);



        //$user->assignRole($this->roles_name);

        $this->reset(['name','email','password','roles_name','branch_id' ,'password_confirmation','roles_name','fingerprint_code',
        'date_of_birth','address','phone','age','has_driving_license','has_medical_insurance','id_num','id_exp_date',
        'marital_status','gender','joining_date','blood_type_id','nationality_id','passport_num','passport_exp_date',
        'resignation_date','working_status','image','medical_insurance_deduction','transfer_allowance','housing_allowance',
        'vacations_balance','work_status']);

        //dispatch browser events (js)
        //add event to toggle create modal after save
        $this->dispatch('createModalToggle');


        //refrsh data after adding new row
        $this->dispatch('refreshData')->to(DisplayUsers::class);

        $this->dispatch(
           'alert',
            text: trans('admin.user_created_successfully'),
            icon: 'success',
            confirmButtonText: trans('admin.done'),
        );



    }

    public function render()
    {
        return view('livewire.users.add-user');
    }
}
