<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('exercises')->insert([
            ['name' => 'Exercise 1', 'description' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
            ['name' => 'Exercise 2', 'description' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
            ['name' => 'Exercise 3', 'description' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
            ['name' => 'Exercise 4', 'description' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
        ]);
    }
}
