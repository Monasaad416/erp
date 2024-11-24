<?php

namespace Database\Seeders;

use App\Models\ShiftType;
use App\Models\AccountType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShiftTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $shifts = [
                        [
                            "start"=>"09:00:00",
                            "end"=>"21:00:00",
                            "is_active"=>"1",
                            "total_hours" => 12,
                            "type"=>4,
                            "created_by"=>1,
                        ],
                        [
                            "start"=>"21:00:00",
                            "end"=>"09:00:00",
                            "is_active"=>"1",
                            "type" => 5,
                            "total_hours" =>12,
                            "created_by" => 1
                        ],
                        [
                            "start"=>"08:00:00",
                            "end"=>"04:00:00",
                            "is_active"=>"0",
                            "total_hours" => 8,
                            "type" => 1,
                            "created_by"=>1,
                        ],
                        [
                            "start"=> "04:00:00",
                            "end"=> "12:00:00",
                            "is_active"=>"0",
                            "total_hours" => 8,
                            "type"=>2,
                            "created_by"=>1,
                        ],
                        [
                            "start"=> "12:00:00",
                            "end"=> "08:00:00",
                            "is_active"=>"0",
                            "total_hours" => 8,
                            "type"=>3,
                            "created_by"=>1,
                        ],
    

                    ];
        foreach ($shifts as $account) {
            ShiftType::create(
                [
                    'start' => $account['start'],
                    'end' => $account['end'],
                    'is_active' => $account['is_active'],
                    'total_hours' => $account['total_hours'],
                    'created_by' => $account['created_by'],
                    'type' => $account['type'],
                ],
            );
        }
    }
}
