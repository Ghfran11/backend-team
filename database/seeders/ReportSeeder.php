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
    { DB::table('reports')->insert([
        ['userId' => '2','title'=>'aaaaaaaaa','text'=>'welcome project manager'],
        ['userId' => '3','title'=>'sss','text'=>'welcome project manager'],

        ['userId' => '4','title'=>'aaa','text'=>'welcome project manager'],

        ['userId' => '4','title'=>'hhh','text'=>'welcome project manager'],

        ['userId' => '2','title'=>'jjjj','text'=>'welcome project manager'],

        ['userId' => '3','title'=>'iii','text'=>'welcome project manager'],

        ['userId' => '2','title'=>'rrr','text'=>'welcome project manager'],


    ]); }
}
