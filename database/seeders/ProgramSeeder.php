<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpseclib3\Crypt\Random;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['general', 'private'];
        $userIds = DB::table('users')->pluck('id')->toArray(); // get all user ids
        $categoryIds = DB::table('categories')->pluck('id')->toArray(); // get all category ids

        for ($i = 0; $i < 10; $i++) {
            DB::table('programs')->insert([
                'categoryId' => $categoryIds[array_rand($categoryIds)],
                'name' => 'Program ' . random_int(1, 100),
                'file' => Str::random(10),
                'imageUrl' => '1.jpg', // replace with your image URL
                'user_id' => $userIds[array_rand($userIds)],
                'type' => $types[array_rand($types)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 2; $i++) {
            DB::table('programs')->insert([
                'categoryId' => $categoryIds[array_rand($categoryIds)],
                'name' => 'Program ' . random_int(1, 100),
                'file' => Str::random(10),
                'imageUrl' => '1.jpg', // replace with your image URL
                'user_id' => $userIds[array_rand($userIds)],
                'type' => 'recommended',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


    }
}
