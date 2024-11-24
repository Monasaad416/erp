<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $accounts = [
                        [
                            "name_en"=>"Capital",
                            "name_ar"=>"رأس مال",
                            "is_active"=>"1",
                            "separate_screen" => 0,
                        ],
                        [
                            "name_en"=>"Treasury",
                            "name_ar"=>"خزينة",
                            "is_active"=>"1",
                            "separate_screen" => 1,
                        ],
                        [
                            "name_en"=>"Expenses",
                            "name_ar"=>"المصروفات",
                            "is_active"=>"1",
                            "separate_screen" => 0,
                        ],
                        [
                            "name_en"=>"General",
                            "name_ar"=>"عام",
                            "is_active"=>"1",
                            "separate_screen" => 0,
                        ],
                        [
                            "name_en"=>"Bank",
                            "name_ar"=>"بنكي ",
                            "is_active"=>"1",
                            "separate_screen" => 0,
                        ],
                        // [
                        //     "name_en"=>"Representative",
                        //     "name_ar"=>"مندوب",
                        //     "is_active"=>"1",
                        //     "separate_screen" => 1,
                        // ],
                        [
                            "name_en"=>"Client",
                            "name_ar"=>"عميل",
                            "is_active"=>"1",
                            "separate_screen" => 1,
                        ],
                        [
                            "name_en"=>"Supplier",
                            "name_ar"=>"مورد",
                            "is_active"=>"1",
                            "separate_screen" => 1,
                        ],
                        [
                            "name_en"=>"Employee",
                            "name_ar"=>"موظف",
                            "is_active"=>"1",
                            "separate_screen" => 1,
                        ],

                    ];
        foreach ($accounts as $account) {
            AccountType::create(
                [
                    'name_en' => $account['name_en'],
                    'name_ar' => $account['name_ar'],
                    'is_active' => $account['is_active'],
                    'separate_screen' => $account['separate_screen'],
                ],
            );
        }
    }
}
