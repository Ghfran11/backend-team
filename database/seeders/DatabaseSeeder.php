<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(DaysSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(ExerciseSeeder::class);
       // $this->call(ImageSeeder::class);
        $this->call(ReportSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(TimeSeeder::class);
        $this->call(UserInfoSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(InfoSeeder::class);
       // $this->call(OrderSeeder::class);
    }
}
