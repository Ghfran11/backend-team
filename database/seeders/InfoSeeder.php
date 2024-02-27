<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('infos')->insert([
                'finance' => mt_rand(1000, 10000) / 100, // random finance data between 10.00 and 100.00
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
