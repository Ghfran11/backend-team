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
    { DB::table('images')->insert([
        ['userId' => '1','exerciseId'=>null,'image'=>'460838971.jpg'],
        ['userId' => '1','exerciseId'=>null,'image'=>'765871961.jpg'],

        ['userId' => '2','exerciseId'=>null,'image'=>'919412255.jpg'],
        ['userId' => '2','exerciseId'=>null,'image'=>'626584726.jpg'],

        ['userId' => '3','exerciseId'=>null,'image'=>'1202299738.jpg'],
        ['userId' => '3','exerciseId'=>null,'image'=>'1311461512.jpg'],

        ['userId' => '4','exerciseId'=>null,'image'=>'1744293202.jpg'],
        ['userId' => '4','exerciseId'=>null,'image'=>'540998245.jpg'],

        ['userId' => '5','exerciseId'=>null,'image'=>'301136981.jpg'],
        ['userId' => '5','exerciseId'=>null,'image'=>'1903471181.jpg'],

        ['userId' => '8','exerciseId'=>null,'image'=>'1202299738.jpg'],
        ['userId' => '8','exerciseId'=>null,'image'=>'1311461512.jpg'],

        ['userId' => '9','exerciseId'=>null,'image'=>'1744293202.jpg'],
        ['userId' => '9','exerciseId'=>null,'image'=>'540998245.jpg'],

        ['userId' => '10','exerciseId'=>null,'image'=>'301136981.jpg'],
        ['userId' => '10','exerciseId'=>null,'image'=>'1903471181.jpg'],



<<<<<<< HEAD
        ['userId' => '2','exerciseId'=>null,'image'=>'462778385.jpg'],
        ['userId' => '3','exerciseId'=>null,'image'=>'462778385.jpg'],
        ['userId' => '4','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '5','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '8','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '6','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '7','exerciseId'=>null,'image'=>'238432623.jpg'],
=======
>>>>>>> 130365ca0f1ad581dcf857b37bc22e3acf611559




    ]);

    }
}
