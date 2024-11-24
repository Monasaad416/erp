<?php

namespace Database\Seeders;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ledger;
use App\Models\Account;
use App\Models\AccountType;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //1821 superadmin account
        // $faker = Faker::create();

        // $roles = [ 'ادمن', 'صيدلي'];

   

        // for ($i = 0; $i < 90; $i++) {
        //     $gender = $faker->randomElement(['male', 'female']);
        //     $user = User::create([
        //         'name' => $faker->name(),
        //         'code' => $faker->unique()->randomDigit(),
        //         'gender' => $gender,
        //         'email' => $faker->email(),
        //         'password' => Hash::make('12345678'),
        //         'phone' => $faker->phoneNumber,
        //         'address' => $faker->streetAddress,
        //         'branch_id' => $faker->numberBetween(2, 7),
        //         'joining_date' => $faker->dateTime(),
        //         'roles_name' => $faker->randomElement($roles),
        //     ]);

        //     $user->assignRole($user->roles_name);
        // }

   

        // try {

        DB::beginTransaction();
        
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
   
         
            $latestCustodyAccountChild = Account::where('parent_id', $usersCustodyParentAccountBranch->id)->first();

       // dd($usersCustodyParentAccountBranch);
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
           $usersInsuranceParentAccount = Account::where('account_num',operator: 2231)->first();// تأمينات العاملين
            $usersInsuranceParentAccountBranch = Account::where('parent_id', $usersInsuranceParentAccount->id)->where('branch_id',2)->first();
   
            //dd($usersInsuranceParentAccount);
            $latestInsuranceAccountChild = Account::where('parent_id', $usersInsuranceParentAccountBranch->id)->first();
            
    
            if ($latestInsuranceAccountChild) {
                $currentInsuranceChildAccountNum = $latestInsuranceAccountChild->account_num;
            } else {
                $currentInsuranceChildAccountNum = $usersInsuranceParentAccountBranch->account_num . '0';
            }

           //الضرائب
           $usersTaxParentAccount = Account::where('account_num',operator: 2232)->first();// ضرائب العاملين
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




            $user = User::create([
                'name' => 'superadmin',
                'code' => 1,
                'account_num' => 51311,
                'advance_payment_account_num' => 123311,
                'gender' => 'male',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('12345678'),
                'phone' => '987654345',
                'address' => 'streetAddress',
                'branch_id' => 2,
                'joining_date' => \Carbon\Carbon::createFromFormat('d-m-Y', '1-1-2020')->format('Y-m-d'),
                'roles_name' => 'سوبر-ادمن',
            ]);


            $role = Role::create(['name'=>'سوبر-ادمن']);
            //$role = Role::where('name','سوبر-ادمن')->first();

            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole($user->roles_name);



            $account = Account::create([
                'name_ar' => 'ذمة الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'account_num' => $user->account_num,
                'account_type_id' => 8,
                'nature' => "مدين",
                'list' => "دخل",
                'parent_id' => $usersParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersParentAccount->level + 1,
                'branch_id'=>2,
                'is_parent'=>0,
            ]);

            $advancePaymenAccount = Account::create([
                'name_ar' => 'سلف الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'nature' => "مدين",
                'list' => "مركز-مالي",
                'account_num' => 123311,
                'account_type_id' => 8,
                'parent_id' => $usersAdvancePayParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersAdvancePayParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);

            $custodyAccount = Account::create([
                'name_ar' => 'عهدة الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'nature' => "مدين",
                'list' => "مركز-مالي",
                'account_num' => 123221,
                'account_type_id' => 8,
                'parent_id' => $usersCustodyParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersCustodyParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);

            $deductionAccount = Account::create([
                'name_ar' => 'خصومات مستقطعة من الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'nature' => "دائن",
                'list' => "دخل",
                'account_num' => 4721,
                'account_type_id' => 8,
                'parent_id' => $usersDeductParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersDeductParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);

            
            $rewardAccount = Account::create([
                'name_ar' => 'مكافئات الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'nature' => "مدين",
                'list' => "دخل",
                'account_num' => 51421 ,
                'account_type_id' => 8,
                'parent_id' => $usersRewardParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersRewardParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);

            $insuranceAccount = Account::create([
                'name_ar' => 'تأمينات مستقطعة من الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'nature' => "دائن",
                'list' => "مركز-مالي",
                'account_num' => 22351 ,
                'account_type_id' => 8,
                'parent_id' => $usersInsuranceParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersInsuranceParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);

            $taxAccount = Account::create([
                'name_ar' => 'ضرائب مستقطعة من الموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                'nature' => "دائن",
                'list' => "مركز-مالي",
                'account_num' => 22361 ,
                'account_type_id' => 8,
                'parent_id' => $usersTaxParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersTaxParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);

                $commissionAccount = Account::create([
                'name_ar' => 'عمولة المبيعات للموظف  '.$user->name,
                'start_balance' => 0,
                'current_balance' => 0,
                 'nature' => "مدين",
                'list' => "دخل",
                'account_num' => 54221 ,
                'account_type_id' => 8,
                'parent_id' => $usersCommissionParentAccountBranch->id,
                // 'accountable_id' => $user->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_active' => 1 ,
                'level' => $usersCommissionParentAccount->level + 1,
                 'branch_id'=>2,
                 'is_parent'=>0,
            ]);


            $ledger1 = new Ledger();
            $ledger1->name_ar = 'ذمة الموظف  '.$user->name;
            $ledger1->account_id = $account->id;
            $ledger1->account_num = $account->account_num;
            $ledger1->created_by = 1;
            $ledger1->date = Carbon::now();
            $ledger1->type ="journal_entry";
            $ledger1->save();


 

            $ledger2 = new Ledger();
            $ledger2->name_ar = 'سلف الموظف  '.$user->name;
            $ledger2->account_id = $advancePaymenAccount->id;
            $ledger2->account_num = $advancePaymenAccount->account_num;
            $ledger2->created_by = 1;
            $ledger2->date = Carbon::now();
            $ledger2->type ="journal_entry";
            $ledger2->save();

            $ledger3 = new Ledger();
            $ledger3->name_ar = 'عهد الموظف  '.$user->name;
            $ledger3->account_id = $custodyAccount->id;
            $ledger3->account_num = $custodyAccount->account_num;
            $ledger3->created_by = 1;
            $ledger3->date = Carbon::now();
            $ledger3->type ="journal_entry";
            $ledger3->save();

            $ledger4 = new Ledger();
            $ledger4->name_ar = 'تأمينات مستقطعة من الموظف  '.$user->name;
            $ledger4->account_id = $insuranceAccount->id;
            $ledger4->account_num = $insuranceAccount->account_num;
            $ledger4->created_by = 1;
            $ledger4->date = Carbon::now();
            $ledger4->type ="journal_entry";
            $ledger4->save();
            
            $ledger5 = new Ledger();
            $ledger5->name_ar = 'خصومات مستقطعة من الموظف  '.$user->name;
            $ledger5->account_id = $deductionAccount->id;
            $ledger5->account_num = $deductionAccount->account_num;
            $ledger5->created_by = 1;
            $ledger5->date = Carbon::now();
            $ledger5->type ="journal_entry";
            $ledger5->save();

            $ledger6 = new Ledger();
            $ledger6->name_ar = 'ضرائب مستقطعة من الموظف  '.$user->name;
            $ledger6->account_id = $taxAccount->id;
            $ledger6->account_num = $taxAccount->account_num;
            $ledger6->created_by = 1;
            $ledger6->date = Carbon::now();
            $ledger6->type ="journal_entry";
            $ledger6->save();

            $ledger7 = new Ledger();
            $ledger7->name_ar = 'مكافئات الموظف  '.$user->name;
            $ledger7->account_id = $rewardAccount->id;
            $ledger7->account_num = $rewardAccount->account_num;
            $ledger7->created_by = 1;
            $ledger7->date = Carbon::now();
            $ledger7->type ="journal_entry";
            $ledger7->save();


            $ledger8 = new Ledger();
            $ledger8->name_ar = 'عمولة المبيعات للموظف  '.$user->name;
            $ledger8->account_id = $rewardAccount->id;
            $ledger8->account_num = $rewardAccount->account_num;
            $ledger8->created_by = 1;
            $ledger8->date = Carbon::now();
            $ledger8->type ="journal_entry";
            $ledger8->save();



            DB::commit();
        //     }  catch (Exception $e) {
        //    return redirect()->back()->withErrors(['error' => trans('admin.something_wrong')]);
        // }


       
        }
    }
