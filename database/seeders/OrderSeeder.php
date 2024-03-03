<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;
use Carbon\Carbon;
use Faker\Factory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->count() == 0) {
            $this->command->info('There are no users to assign orders to, so no orders will be created.');
            return;
        }
        $types = ['join', 'program'];
        $statuses = ['waiting', 'accepted'];
        $currentYear = Carbon::now()->year;
        foreach ($users as $user) {
            $randomDate = Carbon::create($currentYear, rand(1, 12), rand(1, 28));
            DB::table('orders')->insert([
                'coachId' => 6,
                'playerId' => $user->id, // You may want to change this to another user's id
                'type' => $types[array_rand($types)],
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $randomDate->format('Y-m-d'),
                'updated_at' => now(),
            ]);
        }
    }
}
