<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Dani', 'birthDate' => '2023-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '1234567890', 'role' => 'admin', 'finance' => 0, 'created_at' => Carbon::now()],

            ['name' => 'Ghfran', 'birthDate' => '2001-12-3', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622241', 'role' => 'coach', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Ali', 'birthDate' => '2001-7-2', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622242', 'role' => 'coach', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Raneem', 'birthDate' => '2000-1-14', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622243', 'role' => 'coach', 'finance' => 000000, 'created_at' => Carbon::now()],
            ['name' => 'Mazhar', 'birthDate' => '2001-3-22', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622244', 'role' => 'coach', 'finance' => 2000000, 'created_at' => Carbon::now()],
            ['name' => 'Thales', 'birthDate' => '1998-10-23', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622245', 'role' => 'coach', 'finance' => 2000000, 'created_at' => Carbon::now()],

            ['name' => 'Ismael', 'birthDate' => '1997-10-23', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622246', 'role' => 'player', 'finance' => 2000000, 'created_at' => Carbon::now()],
            ['name' => 'Elfat', 'birthDate' => '1999-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622247', 'role' => 'player', 'finance' => 10000, 'created_at' => Carbon::now()],
            ['name' => 'Hadi', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => ' ', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Hussam', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622249', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],

            ['name' => 'Ismael', 'birthDate' => '1997-10-23', 'password' => Hash::make('123456789'), 'phoneNumber' => ' 0935622250', 'role' => 'player', 'finance' => 2000000, 'created_at' => Carbon::now()],
            ['name' => 'Elfat', 'birthDate' => '1999-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622251', 'role' => 'player', 'finance' => 10000, 'created_at' => Carbon::now()],
            ['name' => 'Hadi', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622252', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Hussam', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622253', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],

            ['name' => 'Ismael', 'birthDate' => '1997-10-23', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622254', 'role' => 'player', 'finance' => 2000000, 'created_at' => Carbon::now()],
            ['name' => 'Elfat', 'birthDate' => '1999-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622255', 'role' => 'player', 'finance' => 10000, 'created_at' => Carbon::now()],
            ['name' => 'Hadi', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622256', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],

            ['name' => 'Hussam', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622257', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Ismael', 'birthDate' => '1997-10-23', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622258', 'role' => 'player', 'finance' => 2000000, 'created_at' => Carbon::now()],
            ['name' => 'Elfat', 'birthDate' => '1999-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622259', 'role' => 'player', 'finance' => 10000, 'created_at' => Carbon::now()],
            ['name' => 'Hadi', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622260', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],

            ['name' => 'Hussam', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622261', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Ismael', 'birthDate' => '1997-10-23', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622262', 'role' => 'player', 'finance' => 2000000, 'created_at' => Carbon::now()],
            ['name' => 'Elfat', 'birthDate' => '1999-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622263', 'role' => 'player', 'finance' => 10000, 'created_at' => Carbon::now()],
            ['name' => 'Hadi', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622264', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],
            ['name' => 'Hussam', 'birthDate' => '2001-11-13', 'password' => Hash::make('123456789'), 'phoneNumber' => '0935622265', 'role' => 'player', 'finance' => 1000000, 'created_at' => Carbon::now()],
        ]);
    }
}
