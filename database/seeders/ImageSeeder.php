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

<<<<<<< HEAD
        ['userId' => '2','exerciseId'=>null,'image'=>'694402835.jpg'],
        ['userId' => '3','exerciseId'=>null,'image'=>'694402835.jpg'],
        ['userId' => '4','exerciseId'=>null,'image'=>'694402835.jpg'],
        ['userId' => '5','exerciseId'=>null,'image'=>'694402835.jpg'],
        ['userId' => '3','exerciseId'=>null,'image'=>'694402835.jpg'],
=======
        ['userId' => '2','exerciseId'=>null,'image'=>'462778385.jpg'],
        ['userId' => '3','exerciseId'=>null,'image'=>'462778385.jpg'],
        ['userId' => '4','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '5','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '8','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '6','exerciseId'=>null,'image'=>'238432623.jpg'],
        ['userId' => '7','exerciseId'=>null,'image'=>'238432623.jpg'],


>>>>>>> 549af65618835444f8eaf028b92af7db557c9f7a


    ]);

    }
}
