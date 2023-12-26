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
        ['name' => 'Admin','birthDate'=>'2023-11-13','password'=>'$2y$12$v7GBqNWcAan3omc2hoRp9u4epVIc5p1yR2N7uJ0.2wmKfJiadQdYW','phoneNumber'=>'1234567890','role'=>'admin','finance'=>0],
        ['name' => 'coach1','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622241','role'=>'coach','finance'=>1000000],
        ['name' => 'coach2','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622242','role'=>'coach','finance'=>1000000],
        ['name' => 'coach3','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622243','role'=>'coach','finance'=>000000],
        ['name' => 'coach4','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622244','role'=>'coach','finance'=>2000000],
        ['name' => 'coach5','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622245','role'=>'coach','finance'=>2000000],

        ['name' => 'player1','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622246','role'=>'player','finance'=>10000],
        ['name' => 'player2','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622247','role'=>'player','finance'=>1000000],
        ['name' => 'player3','birthDate'=>'2023-11-13','password'=>'$2y$12$tdFP5g.VOR5s1wsz8qqC1OG5bgyooFY1CXiiU037fCXfHMChuBi9W','phoneNumber'=>'0935622248','role'=>'player','finance'=>1000000],
    ]);

}

    }

