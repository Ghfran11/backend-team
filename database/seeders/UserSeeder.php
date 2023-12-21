<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  DB::table('users')->insert([
        ['name' => 'Admin','birthDate'=>'2023-11-13','password'=>'$2y$12$v7GBqNWcAan3omc2hoRp9u4epVIc5p1yR2N7uJ0.2wmKfJiadQdYW','phoneNumber'=>'1234567890','role'=>'admin'],
        ['name' => 'Player','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622240','role'=>'player'],

    ]);

}

    }

