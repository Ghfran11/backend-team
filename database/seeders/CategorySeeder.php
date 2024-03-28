<?php

namespace Database\Seeders;

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
            'type' => 'sport',
            'imageUrl' => '1.jpg'
        ]);
        DB::table('categories')->insert([
            'name' => 'Cardiovascular Training',
            'description' => 'Programs that focus on improving cardiovascular health.',
            'type' => 'food',
            'imageUrl' => '2.jpg'
        ]);
        DB::table('categories')->insert([
            'name' => 'Flexibility Training',
            'description' => 'Programs that focus on improving flexibility and range of motion.',
            'type' => 'sport',
            'imageUrl' => '3.png'
        ]);
    }
}

