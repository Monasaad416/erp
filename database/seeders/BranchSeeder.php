<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $branches = [
                        [
                            "branch_num" => 1,
                            "name_en"=>"Main Branch",
                            "name_ar"=>"المركز الرئيسي",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "main-branch@gmail.com",
                            "cost_center_id" => 1,
                        ],
                        [
                            "branch_num" => 2,
                            "name_en"=>"branch1",
                            "name_ar"=>"فرع مشعل",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "branch1@gmail.com",
                            "cost_center_id" => 2,
                        ],
                        [
                            "branch_num" => 3,
                            "name_en"=>"branch2",
                            "name_ar"=>"فرع الوديعة البلدية",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "branch2@gmail.com",
                            "cost_center_id" => 3,
                        ],
                        [
                            "branch_num" => 4,
                            "name_en"=>"branch3",
                            "name_ar"=>"فرع سعود الوديعة",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "branch3@gmail.com",
                            "cost_center_id" => 4,
                        ],
                        [
                            "branch_num" => 5,
                            "name_en"=>"branch4",
                            "name_ar"=>"فرع بن علا",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "branch4@gmail.com",
                            "cost_center_id" =>5,
                        ],
                        [
                            "branch_num" => 6,
                            "name_en"=>"branch5",
                            "name_ar"=>"فرع السوق",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "branch5@gmail.com",
                            "cost_center_id" => 6,
                        ],
                        [
                            "branch_num" => 7,
                            "name_en"=>"branch6",
                            "name_ar"=>"فرع 6",
                            "street_name_en"=>"street_name",
                            "street_name_ar"=>"street_name",
                            'city_ar' => "المدينة",
                            'region_ar' => "المنطقة",
                            'sub_number' => "1111",
                            "building_number" => "1111",
                            "postal_code" => "111111",
                            "is_active"=>"1",
                            "email" => "branch6@gmail.com",
                            "cost_center_id" => 7,
                        ],


                    ];
        foreach ($branches as $branch) {
            Branch::create(
                [
                    'branch_num' => $branch['branch_num'],
                    'name_en' => $branch['name_en'],
                    'name_ar' => $branch['name_ar'],
                    'street_name_ar' => $branch['street_name_ar'],
                    'street_name_en' => $branch['street_name_en'],
                    'city_ar' => $branch['city_ar'],
                    'region_ar' => $branch['region_ar'],
                     'sub_number' => $branch['sub_number'],
                    'building_number' => $branch['building_number'],
                    'postal_code' => $branch['postal_code'],
                    'is_active' => $branch['is_active'],
                    'email' => $branch['email'],
                    'cost_center_id' => $branch['cost_center_id'],
                ],
            );
        }
    }
}
