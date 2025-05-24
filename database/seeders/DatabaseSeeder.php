<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Remove all previous data from DB
        DB::table('job_listing')->truncate();
        DB::table('users')->truncate();

        $this->call(RandomUserSeeder::class);
        $this->call(TestUserSeeder::class);
        $this->call(JobSeeder::class);
    }
}
