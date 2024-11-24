<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Treasury;

class TreasurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $treasuries = [
                       [
                            "branch_id" => 1,
                            "name_en"=>"main treasury",
                            "name_ar"=>"الخزينة الرئيسية ",
                            "is_active"=>"1",
                            'is_parent' => 1,
                            "account_num" => 12111,
                               'current_balance' => 0,
                        ],
                        [
                            "branch_id" => 2,
                            "name_en"=>"branch1 treasury",
                            "name_ar"=>"خزينة فرع مشعل",
                            "is_active"=>"1",
                            'is_parent' => 0,
                             "account_num" => 12112,
                                'current_balance' => 0,
                        ],
                        [
                            "branch_id" => 3,
                            "name_en"=>"branch2 treasury",
                            "name_ar"=>"خزينة فرع الوديعة البلدية",
                            "is_active"=>"1",
                             'is_parent' => 0,
                              "account_num" => 12113,
                                 'current_balance' => 0,
                        ],
                        [
                            "branch_id" => 4,
                            "name_en"=>"branch3 treasury ",
                            "name_ar"=>"خزينة فرع سعود الوديعة",
                            "is_active"=>"1",
                             'is_parent' => 0,
                              "account_num" => 12114,
                                 'current_balance' => 0,
                        ],
                        [
                            "branch_id" => 5,
                            "name_en"=>"branch4 treasury",
                            "name_ar"=>"خزينة فرع بن علا",
                            "is_active"=>"1",
                             'is_parent' => 0,
                              "account_num" => 12115,
                                 'current_balance' => 0,
                        ],
                        [
                            "branch_id" => 6,
                            "name_en"=>"branch5 treasury",
                            "name_ar"=>"خزينة فرع السوق",
                            "is_active"=>"1",
                            'is_parent' => 0,
                             "account_num" => 12116,
                                'current_balance' => 0,
                        ],
                        [
                            "branch_id" => 7,
                            "name_en"=>"branch6 treasury",
                            "name_ar"=>"خزينة فرع 6",
                            "is_active"=>"1",
                            'is_parent' => 0,
                             "account_num" => 12117,
                                'current_balance' => 0,
                        ],

                    ];
        foreach ($treasuries as $treasury) {
            Treasury::create(
                [
                    'branch_id' => $treasury['branch_id'],
                    'name_en' => $treasury['name_en'],
                    'name_ar' => $treasury['name_ar'],
                    'is_active' => $treasury['is_active'],
                    'is_parent' => $treasury['is_parent'],
                    'account_num' => $treasury['account_num'],
                    'current_balance' => $treasury['current_balance'],
                ],
            );
        }
    }
}
