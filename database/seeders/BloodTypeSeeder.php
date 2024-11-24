<?php

namespace Database\Seeders;

use App\Models\BloodType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bloodTypes = ['O+','O-','A+','A-','B+','B-','AB+','AB-'];
        foreach ($bloodTypes as $type) {
            BloodType::create(
                [
                    'name' => $type,
                ],
            );
        }
     
    }
}
