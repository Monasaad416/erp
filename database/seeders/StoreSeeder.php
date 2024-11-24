<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $stores = [
                        [
                            "branch_id" => 1,
                            "name_ar"=>"المخزن الرئيسي",
                            "name_en"=>"main store",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                            'is_parent' => 1,
                        ],
                        [
                            "branch_id" => 2,
                            "name_en"=>"branch1 store",
                            "name_ar"=>"مخزن فرع مشعل",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                            'is_parent' => 0,
                        ],
                        [
                            "branch_id" => 3,
                            "name_en"=>"branch2 store",
                            "name_ar"=>"مخزن فرع الوديعة البلدية",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                             'is_parent' => 0,
                        ],
                        [
                            "branch_id" => 4,
                            "name_en"=>"branch3 store ",
                            "name_ar"=>"مخزن فرع سعود الوديعة",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                             'is_parent' => 0,
                        ],
                        [
                            "branch_id" => 5,
                            "name_en"=>"branch4 store",
                            "name_ar"=>"مخزن فرع بن علا",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                             'is_parent' => 0,
                        ],
                        [
                            "branch_id" => 6,
                            "name_en"=>"branch5 store",
                            "name_ar"=>"مخزن فرع السوق",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                            'is_parent' => 0,
                        ],
                        [
                            "branch_id" => 7,
                            "name_en"=>"branch6 store",
                            "name_ar"=>"مخزن فرع 6",
                            "address_en"=>"address",
                            "address_ar"=>"address",
                            "is_active"=>"1",
                            'is_parent' => 0,
                        ],

                    ];
        foreach ($stores as $store) {
            Store::create(
                [
                    'branch_id' => $store['branch_id'],
                    'name_en' => $store['name_en'],
                    'name_ar' => $store['name_ar'],
                    'address_en' => $store['address_en'],
                    'address_ar' => $store['address_ar'],
                    'is_active' => $store['is_active'],
                    'is_parent' => $store['is_parent'],
                ],
            );
        }
    }
}
