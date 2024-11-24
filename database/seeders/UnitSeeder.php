<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $units = [
                        [
                            "name_ar"=>"كيلوجرام"
                        ],
                        [
                            "name_ar"=>"جرام"
                        ],
                        [
                            "name_ar"=>"نانوجرام"
                        ],
                        [
                            "name_ar"=>"لتر"
                        ],
                        [
                            "name_ar"=>"ملليلتر"
                        ],
                        [
                            "name_ar"=>"كبسول"
                        ],

                    ];
        foreach ($units as $unit) {
            Unit::create(
                [
                    'name_ar' => $unit['name_ar'],
                ],
            );
        }
    }
}
