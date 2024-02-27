<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            DB::table('reports')->insert([
                ['userId' => '3', 'title' => 'about coach', 'text' => 'coaches donnot come on the time', 'created_at' => '2023-12-25 11:54:01', 'updated_at' => '2023-12-25 11:54:01'],
                ['userId' => '2', 'title' => 'about machine', 'text' => 'The machines are not clean', 'created_at' => '2023-12-25 11:54:01', 'updated_at' => '2023-12-25 11:54:01'],
                ['userId' => '4', 'title' => 'about machine', 'text' => 'The air conditioners are broken', 'created_at' => '2023-12-25 11:54:01', 'updated_at' => '2023-12-25 11:54:01'],
                ['userId' => '5', 'title' => 'about cost', 'text' => 'the cost is high', 'created_at' => '2023-12-25 11:54:01', 'updated_at' => '2023-12-25 11:54:01'],
            ]);
        }
    }
}

