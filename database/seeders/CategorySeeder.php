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
            'imageUrl' => 'Screenshot 2023-12-17 114105.png'
        ]);
        DB::table('categories')->insert([
            'name' => 'Cardiovascular Training',
            'description' => 'Programs that focus on improving cardiovascular health.',
            'type' => 'sport',
            'imageUrl' => 'Screenshot 2023-12-17 114105.png'
        ]);
        DB::table('categories')->insert([
            'name' => 'Flexibility Training',
            'description' => 'Programs that focus on improving flexibility and range of motion.',
            'type' => 'food',
            'imageUrl' => 'Screenshot 2023-12-17 114105.png'
        ]);
    }
}

