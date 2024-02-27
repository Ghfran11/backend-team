<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ratings')->insert([
            ['coachId' => '2', 'playerId' => '6', 'rate' => '5'],
            ['coachId' => '2', 'playerId' => '7', 'rate' => '5'],
            ['coachId' => '2', 'playerId' => '1', 'rate' => '3'],
            ['coachId' => '3', 'playerId' => '6', 'rate' => '3'],
            ['coachId' => '4', 'playerId' => '6', 'rate' => '1'],
            ['coachId' => '2', 'playerId' => '8', 'rate' => '3'],
            ['coachId' => '4', 'playerId' => '8', 'rate' => '3'],
            ['coachId' => '3', 'playerId' => '8', 'rate' => '2'],
        ]);
    }
}
