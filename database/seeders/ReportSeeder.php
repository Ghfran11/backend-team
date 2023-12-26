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
        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],
        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],

        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],

        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],

        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],

        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],

        ['userId' => '2','title'=>'aaa','text'=>'welcome project manager','created_at'=> '2023-12-25 11:54:01','updated_at'=> '2023-12-25 11:54:01'],


    ]); }
}
