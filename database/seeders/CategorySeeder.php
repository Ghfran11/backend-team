<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'name' => 'Strength Training',
            'description' => 'Programs that focus on building and maintaining muscle mass.',
            'type'=>'sport'
        ]);

        DB::table('categories')->insert([
            'name' => 'Cardiovascular Training',
            'description' => 'Programs that focus on improving cardiovascular health.',
            'type'=>'sport'
        ]);

        DB::table('categories')->insert([
            'name' => 'Flexibility Training',
            'description' => 'Programs that focus on improving flexibility and range of motion.',
            'type'=>'food'
        ]);


 }
}

