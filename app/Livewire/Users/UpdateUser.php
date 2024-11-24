<?php

namespace App\Livewire\Users;

use Alert;
use App\Models\User;
use App\Models\Account;
use Livewire\Component;
use Illuminate\Validation\Rule;

class UpdateUser extends Component
{
    protected $listeners = ['editUser'];
        public $user,$name, $email, $password,$password_confirmation, $roles_name,$branch_id,$fingerprint_code,
    $date_of_birth,$address,$phone,$age,$has_driving_license=0,$has_medical_insurance=0,$id_num,$id_exp_date,
    $marital_status,$gender,$joining_date,$blood_type_id,$nationality_id,$passport_num,$passport_exp_date,
    $resignation_date,$working_status,$image,
    $vacations_balance,$work_status,$salary,$overtime_hour_price,$job_title;


    public function editUser($id)
    {
        $this->user = User::findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->roles_name = $this->user->roles_name;
        $this->branch_id = $this->user->branch_id;
        $this->fingerprint_code = $this->user->fingerprint_code;
        $this->date_of_birth = $this->user->date_of_birth;
        $this->address = $this->user->address;
        $this->phone = $this->user->phone;
        $this->age = $this->user->age;
        $this->has_driving_license = $this->user->has_driving_license;
        $this->has_medical_insurance = $this->user->has_medical_insurance;
        $this->id_num = $this->user->id_num;
        $this->id_exp_date = $this->user->id_exp_date;
        $this->marital_status = $this->user->marital_status;
        $this->gender = $this->user->gender;
        $this->joining_date = $this->user->joining_date;
        $this->blood_type_id = $this->user->blood_type_id;
        $this->nationality_id = $this->user->nationality_id;
        $this->passport_num = $this->user->passport_num;
        $this->passport_exp_date = $this->user->passport_exp_date;
        $this->resignation_date = $this->user->resignation_date;
        $this->working_status = $this->user->working_status;
        $this->image = $this->user->image;
        $this->vacations_balance = $this->user->vacations_balance;
        $this->salary = $this->user->salary;
        $this->overtime_hour_price = $this->user->overtime_hour_price;
        $this->job_title = $this->user->job_title;


        //return dd($this->is_active);

        $this->resetValidation();

        //dispatch browser events (js)
        //add event to toggle edit modal after save
        $this->dispatch('editModalToggle');

    }


    public function rules() {
        return [
            'name' => "nullable|string|max:100",
            'email' =>  ['nullable','email','max:100',Rule::unique('users')->ignore($this->user->id, 'id')],
            'roles_name' => "nullable|exists:roles,name",
            'branch_id' => "nullable|exists:branches,id",
            'gender' => "nullable|in:male,female",
            'joining_date' => "nullable|date",
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
            // 'image' => 'nullable|string|mimes:jpg,jpeg,png',
            'has_medical_insurance' => 'nullable|boolean',
            // 'medical_insurance_deduction' => 'nullable|numeric',
            // 'transfer_allowance' => 'nullable|numeric',
            // 'housing_allowance' => 'nullable|numeric',
            'vacations_balance' => 'nullable|numeric',
            'salary' => 'nullable|numeric',
            'overtime_hour_price' =>' nullable|numeric',
             'job_title' => 'nullable|string',

        ];
    }
    public function messages()
    {
        return [
            'name.string' => 'إسم الموظف يجب أن يتكون من أحرف',
            'name.max' => 'أقصي عدد احرف لإسم الموظف 100 حرف',

            'email.string' => 'البريد الإلكتروني  يجب أن يتكون من أحرف',
            'email.max' => 'أقصي عدد احرف للبريد الإلكتروني  100 حرف',
            'email.unique' => 'البريد الإلكتروني الذي تم إدخالة بالفعل مسجل في قاعدة البيانات',

            'roles_name.nullable' => 'مهمة الموظف مطلوبة ',
            'roles_name.exists' => 'مهمة الموظف التي تم اخيارها غير موجودة بقاعدة البيانات',

            'branch_id.requird'=> 'الفرع مطلوب',
            'branch_id.exists'=> 'الفرع الذي تم ادخالة غير مسجل بقاعدة البيانات',
            'gender.nullable' => 'النوع مطلوب',
            'gender.in' => 'النوع يجب أن يكون واحد من ذكر-انثي',
            'joining_date.nullable' => 'تاريخ الإلتحاق بالعمل  مطلوب',
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


    public function update()
    {

        $data = $this->validate($this->rules() ,$this->messages());
        $oldBranch = User::where('id',$this->user->id)->first()->branch_id;


        if( empty($this->resignation_date) ) {
                $this->user->resignation_date = null;
                $this->user->save();
        } else {
                $this->user->resignation_date = $this->resignation_date;
                $this->user->save();
        }

        if($this->branch_id != $oldBranch) { 
            $useuOldAccount = Account::where('account_num',$this->user->account_num)->delete();
            $useuOldAdvancePaymentAccount = Account::where('account_num',$this->user->advance_payment_account_num)->delete();

                //رقم حساب الراتب
            $currentChildAccountNum = 0;


            $usersParentAccount = Account::where('account_num',513)->first();
            dd($usersParentAccount);
            $usersParentAccountBranch = Account::where('parent_id', $usersParentAccount->id)->where('branch_id',$this->branch_id)->first();

            $latestAccountChild = Account::where('parent_id', $usersParentAccountBranch->id)->first();
            

            if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num ;
            } else {
                $currentChildAccountNum = $usersParentAccountBranch->account_num . '0';
            }


        


            //رقم حساب السلف
            $currentAdvancePayChildAccountNum = 0;

            $usersAdvancePayParentAccount = Account::where('account_num',1233)->first();//سلف العاملين
            $usersAdvancePayParentAccountBranch = Account::where('parent_id', $usersAdvancePayParentAccount->id)->where('branch_id',$this->branch_id)->first();
        
    

            $latestAdvancePayAccountChild = Account::where('parent_id', $usersAdvancePayParentAccountBranch->id)->first();
                //dd($latestAdvancePayAccountChild);
            
                //dd($latestAdvancePayAccountChild);
            if ($latestAdvancePayAccountChild) {
                $currentAdvancePayChildAccountNum = $latestAdvancePayAccountChild->account_num ;
                    //dd($latestAdvancePayAccountChild);
            } else {
                $currentAdvancePayChildAccountNum = $usersAdvancePayParentAccountBranch->account_num . '0';
            }


            $account = new  Account();
            $account->name_ar = 'ذمة الموظف  '.$this->user->name;
            $account->start_balance = 0;
            $account->current_balance = 0;
            $account->account_num = $this->user->account_num;
            $account->account_type_id = 8;
            $account->parent_id = $usersParentAccountBranch->id;
            $account->created_by = $this->user->id;
            $account->updated_by = $this->user->id;
            $account->is_active = 1 ;
            $account->level = $usersParentAccount->level + 1;
            $account->save();


            $advancePaymenAccount = new Account();
            $advancePaymenAccount->name_ar= 'سلف الموظف  '.$this->user->name;
            $advancePaymenAccount->start_balance= 0;
            $advancePaymenAccount->current_balance= 0;
            $advancePaymenAccount->account_num= 123311;
            $advancePaymenAccount->account_type_id= 8;
            $advancePaymenAccount->parent_id= $usersAdvancePayParentAccountBranch->id;
            $advancePaymenAccount->created_by= $this->user->id;
            $advancePaymenAccount->updated_by= $this->user->id;
            $advancePaymenAccount->is_active= 1 ;
            $advancePaymenAccount->level= $usersAdvancePayParentAccount->level + 1;
            $advancePaymenAccount->save();
        }

        //dd($currentAdvancePayChildAccountNum +1);

        $this->user->update($data);
        $this->user->assignRole($this->user->roles_name);

        $this->reset(['name','email','password','roles_name','branch_id' ,'password_confirmation','roles_name','fingerprint_code',
        'date_of_birth','address','phone','age','has_driving_license','has_medical_insurance','id_num','id_exp_date',
        'marital_status','gender','joining_date','blood_type_id','nationality_id','passport_num','passport_exp_date',
        'resignation_date','working_status','image','vacations_balance','work_status']);
        //dispatch browser events (js)
        //add event to toggle update modal after save
        $this->dispatch('editModalToggle');







        //refrsh data after adding update row
        $this->dispatch('refreshData')->to(DisplayUsers::class);

            Alert::success('تم تعديل بيانات الموظف بنجاح');
            return redirect()->route('users');
    }



    
    public function render()
    {
        return view('livewire.users.update-user');
    }
}
