<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('times')->insert([
            ['userId' => '3', 'dayId' => '1', 'startTime' => '2023-01-27', 'endTime' => null, 'isCoach' => '0'],
            ['userId' => '5', 'dayId' => '4', 'startTime' => '2023-01-27', 'endTime' => null, 'isCoach' => '0'],
        ]);
    }
}
