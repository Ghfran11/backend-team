<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all categories and users
        $categories = Category::all();
        $users = User::all();

        // If there are no categories or users, we can't seed the programs table
        if ($categories->isEmpty() || $users->isEmpty()) {
            return;
        }

        // Create 50 programs
        Program::factory()->count(50)->create()->each(function ($program) use ($categories, $users) {
            // Assign a random category and user to each program
            $program->categoryId = $categories->random()->id;
            $program->user_id = $users->random()->id;
            $program->save();
        });
    }
}
