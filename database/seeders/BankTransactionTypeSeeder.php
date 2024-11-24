<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankTransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankTransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $transactions = [
                        [
                            "name_en"=>"Send mony from branch treasury to main treasury",
                            "name_ar"=>" تحويل مبيعات الشبكة نهاية الوردية        ",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,

                        ],
                        [
                            "name_en"=>"Disbursing an amount to a financial account",
                            "name_ar"=>"صرف مبلغ لحساب مالي",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,

                        ],
                        [
                            "name_en"=>"collectionunt from  financial account",
                            "name_ar"=>"تحصيل مبلغ من حساب مالي",
                            "is_active"=> 1,
                            "screen_name"=>"collection",
                            "is_internal_trans"=> 0,

                        ],
                        [
                            "name_en"=>"collectionrevenue,",
                            "name_ar"=>"تحصيل  إيراد مبيعات  ",
                            "is_active"=> 1,
                            "screen_name"=>"collection",
                            "is_internal_trans"=> 0,
                        ],
                        [
                            "name_en"=>"Disbursing Sales return",
                            "name_ar"=>"صرف نظير مرتجع مبيعات",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,
                        ],
                       [
                            "name_en"=>"Disbursing an advance on an employee's salary",
                            "name_ar"=>"صرف سلفة علي راتب موظف",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 1,
                        ],
                        [
                            "name_en"=>"Disbursement for purchases from a supplier",
                            "name_ar"=>"صرف  نظير مشتريات من مورد",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,
                        ],

                        [
                            "name_en"=>"collections for purchases made to a supplier",
                            "name_ar"=>" تحصيل نظير مرتجع مشتريات الي مورد ",
                            "is_active"=> 1,
                            "screen_name"=>"collection",
                            "is_internal_trans"=> 0,
                        ],
                        [
                            "name_en"=>"Capital increase revenues",
                            "name_ar"=>"إيرادات زيادة رأس المال  ",
                            "is_active"=>"10",
                            "screen_name"=>"collection",
                            "is_internal_trans"=> 0,
                        ],
                        [
                            "name_en"=>"Purchase expenses",
                            "name_ar"=>"مصاريف شراء",
                            "is_active"=>1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,
                        ],
                        [
                            "name_en"=>"Bank deposit expenses",
                            "name_ar"=>"مصاريف للإيداع البنكي",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,
                        ],
                        [
                            "name_en"=>"Return of an advance on an employee's salary",
                            "name_ar"=>"رد سلفة علي راتب موظف",
                            "is_active"=> 1,
                            "screen_name"=>"collection",
                            "is_internal_trans"=> 1,
                        ],
                        [
                            "name_en"=>"collectionee discounts",
                            "name_ar"=>"تحصيل خصومات موظفين",
                            "is_active"=> 1,
                            "screen_name"=>"collection",
                            "is_internal_trans"=> 1,
                        ],
                        [
                            "name_en"=>"Paying an employee's salary",
                            "name_ar"=>"صرف مرتب موظف",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 1,
                        ],

                        [
                            "name_en"=>"Disbursement to return capital",
                            "name_ar"=>"صرف  لرد رأس المال  ",
                            "is_active"=> 1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,
                        ],

                        [
                            "name_en"=>"Purchase expenses",
                            "name_ar"=>"مصاريف مقابل خدمات",
                            "is_active"=>1,
                            "screen_name"=>"exchange",
                            "is_internal_trans"=> 0,
                        ],
                        
                

                    ];
        foreach ($transactions as $trans) {
            BankTransactionType::create(
                [
                    'name_en' => $trans['name_en'],
                    'name_ar' => $trans['name_ar'],
                    'is_active' => $trans['is_active'],
                    'screen_name' => $trans['screen_name'],
                    'is_internal_trans' => $trans['is_internal_trans'],
                ],
            );
        }
    }
}
