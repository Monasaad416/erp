<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Account;
use App\Models\Bankknaextends;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $banks = [
                       [
                            "name_ar"=>"البنك الاهلي السعودي",
                            "is_active"=>"1",
                            "account_num" => 121211,
                            'current_balance' => 0,

                        ],
                        [
                            "name_ar"=>"مصرف الراجحي ",
                            "is_active"=>"1",
                             "account_num" => 121212,
                             'current_balance' => 0,
                        ],
                        [
                            "name_ar"=>"بنك الجزيرة",
                            "is_active"=>"1",
                            "account_num" => 121213,
                            'current_balance' => 0,
                        ],
                        [
                            "name_ar"=>"بنك البلاد",
                            "is_active"=>"1",
                            "account_num" => 121214,
                            'current_balance' => 0,
                        ],

                    ];
        foreach ($banks as $bank) {
            $newBank = Bank::create(
                [
                    'name_ar' => $bank['name_ar'],
                    'is_active' => $bank['is_active'],
                    'account_num' => $bank['account_num'],
                     'current_balance' => $bank['current_balance'],
                ],
            );

            $bankParentAccount = Account::where('account_num',12121)->first();


            $latestAccountChild = Account::where('parent_id', $bankParentAccount->id)->first();


            if ($latestAccountChild) {
                $currentChildAccountNum = $latestAccountChild->account_num;
            } else {
                $currentChildAccountNum = $bankParentAccount->account_num . '0';
            }


            $bankAccount = Account::create([
                'name_ar' => $newBank->name_ar,
                'start_balance' => 0,
                'current_balance' => 0,
                'account_num' => $newBank->account_num,
                'account_type_id' => 5,
                'parent_id' => $bankParentAccount->id,
                // 'accountable_id' => $newBank->id,
                // 'accountable_type' => 'App\Models\User',
                'created_by' => $newBank->id,
                'updated_by' => $newBank->id,
                'is_active' => 1 ,
                'level' => $bankParentAccount->level + 1,
                'branch_id'=>null,
                'nature' => 'مدين',
                'list' => 'مركز-مالي',
            ]);

        }
    }
}
