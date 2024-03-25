<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch all users
        $users = User::all();

        // If there are no users, we can't seed the user_infos table
        if ($users->isEmpty()) {
            return;
        }

        // Create a user_info for each user
        foreach ($users as $user) {
            UserInfo::create([
                'gender' => $this->randomGender(),
                'birthDate' => $this->randomBirthDate(),
                'age' => $this->randomAge(),
                'weight' => $this->randomWeight(),
                'waist_measurement' => $this->randomWaistMeasurement(),
                'neck' => $this->randomNeck(),
                'height' => $this->randomHeight(),
                'BFP' => $this->randomBFP(),
                'userId' => $user->id,
            ]);
        }
    }

    private function randomGender()
    {
        $genders = ['male', 'female'];
        return $genders[array_rand($genders)];
    }

    private function randomBirthDate()
    {
        return now()->subYears(rand(20, 60));
    }

    private function randomAge()
    {
        return rand(20, 60);
    }

    private function randomWeight()
    {
        return rand(50, 100);
    }

    private function randomWaistMeasurement()
    {
        return rand(60, 100);
    }

    private function randomNeck()
    {
        return rand(30, 50);
    }

    private function randomHeight()
    {
        return rand(150, 200);
    }

    private function randomBFP()
    {
        return rand(10, 30);
    }
}
