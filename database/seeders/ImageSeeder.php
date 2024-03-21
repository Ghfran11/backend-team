<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            ['userId' => '1', 'exerciseId' => 1, 'image' => 'img1.jpg'],


            ['userId' => '2', 'exerciseId' => 1, 'image' => 'img3.png'],

            ['userId' => '3', 'exerciseId' => 3, 'image' => 'img5.png'],


            ['userId' => '4', 'exerciseId' => 3, 'image' => 'img7.png'],


            ['userId' => '5', 'exerciseId' => 1, 'image' => 'img2.jpg'],


            ['userId' => '8', 'exerciseId' => 1, 'image' => 'img4.png'],


            ['userId' => '9', 'exerciseId' => 3, 'image' => 'img6.jpg'],
            ['userId' => '9', 'exerciseId' => 4, 'image' => 'img7.jpg'],

            ['userId' => '10', 'exerciseId' => 3, 'image' => 'img7.jpg'],
        
        ]);

    }
}
