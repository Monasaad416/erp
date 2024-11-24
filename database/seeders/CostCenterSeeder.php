<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CostCenter;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $centers = [
                        [
                            "code" => 1,
                            "name_ar"=>"مركز تكلفة الفرع الرئيسي",
                            "name_en"=>"Main cost center",
                            "parent_id"=>null,
                            "is_parent"=> 1,
                        ],
                        [
                            "code" => 2,
                            "name_ar"=>"مركز تكلفة فرع1",
                            "name_en"=>"Branch1 cost center",
                            "parent_id"=>1,
                            "is_parent"=>0,
                        ],
                        [
                            "code" => 3,
                            "name_ar"=>"مركز تكلفة فرع2",
                            "name_en"=>"Branch2 cost center",
                            "parent_id"=>1,
                            "is_parent"=>0,
                        ],
                        [
                            "code" => 4,
                            "name_ar"=>"مركز تكلفة فرع3",
                            "name_en"=>"Branch3 cost center",
                            "parent_id"=>1,
                            "is_parent"=>0,
                        ],
                        [
                            "code" => 5,
                            "name_ar"=>"مركز تكلفة فرع4",
                            "name_en"=>"Branch4 cost center",
                            "parent_id"=>1,
                            "is_parent"=>0,
                        ],
                        [
                            "code" => 6,
                            "name_ar"=>"مركز تكلفة فرع5",
                            "name_en"=>"Branch5 cost center",
                            "parent_id"=>1,
                            "is_parent"=>0,
                        ],
                        [
                            "code" => 7,
                            "name_ar"=>"مركز تكلفة فرع6",
                            "name_en"=>"Branch6 cost center",
                            "parent_id"=>1,
                            "is_parent"=>0,
                        ],

                    ];
        foreach ($centers as $center) {
            CostCenter::create(
                [
                    'code' => $center['code'],
                    'name_en' => $center['name_en'],
                    'name_ar' => $center['name_ar'],
                    'is_parent' => $center['is_parent'],
                    'parent_id' => $center['parent_id'],
                ],
            );
        }
    }
}
