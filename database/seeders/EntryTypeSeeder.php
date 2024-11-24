<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EntryType;
use App\Models\JournalEntry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $entries = [
                        [
                            "name_ar"=>"قيد بسيط",
                        ],
                        [
                            "name_ar"=>"قيد مركب",
                        ],
                        [
                            "name_ar"=>"قيد افتتاحي",
                        ],
                        [
                            "name_ar"=>"قيد تحويل",
                        ],
                        [
                            "name_ar"=>"قيد اقفال",
                        ],
                        [
                            "name_ar"=>"قيد ادخال",
                        ],
                        [
                            "name_ar"=>"قيد تصحيح",
                        ],
                        [
                            "name_ar"=>"قيد محاسبة حكومية ",
                        ],


                    ];
        foreach ($entries as $entry) {
            EntryType::create(
                [
                    'name_ar' => $entry['name_ar'],
                ],
            );
        }
    }
}
