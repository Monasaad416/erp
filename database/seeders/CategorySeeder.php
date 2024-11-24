<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $categories = [
                        [
                            "name_ar"=>"تصنيفات1",
                            "parent_id"=>null,
                            "is_active"=>"1",
                        ],
                        [
                            "name_ar"=>"تصنيفات2",
                            "parent_id"=>"1",
                            "is_active"=>"1",
                        ],
                        [
                            "name_ar"=>"تصنيفات3",
                            "parent_id"=>null,
                            "is_active"=>"1",
                        ],
                        [
                            "name_ar"=>"تصنيفات4",
                            "parent_id"=>"2",
                            "is_active"=>"1",
                        ],
                        [
                            "name_ar"=>"تصنيفات5",
                            "parent_id"=>null,
                            "is_active"=>"1",
                        ],
                        [
                            "name_ar"=>"تصنيفات6",
                            "parent_id"=>"3",
                            "is_active"=>"1",
                        ],


                    ];
        foreach ($categories as $cat) {
            Category::create(
                [

                    'name_ar' => $cat['name_ar'],
                    'parent_id' => $cat['parent_id'],
                    'is_active' => $cat['is_active'],
                ],
            );
        }
    }
}
