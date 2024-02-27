<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            ['title' => 'Article 1', 'content' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
            ['title' => 'Article 2', 'content' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
            ['title' => 'Article 3', 'content' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
            ['title' => 'Article 4', 'content' => 'Based on the provided code, it seems like you want to retrieve the base salary of a user based on a given date. The code checks if a date is provided in the query parameters, and if so, it retrieves the sum of the salaries for that user on that specific date.', 'created_at' => Carbon::now()],
        ]);
    }
}
