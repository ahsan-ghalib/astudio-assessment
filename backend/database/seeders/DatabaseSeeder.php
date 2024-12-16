<?php

namespace Database\Seeders;

use App\Models\EntityAttribute;
use App\Models\Project;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            $this->call([
                UserSeeder::class,
                EntityAttributeSeeder::class,
                ProjectSeeder::class,
                TimeSheetSeeder::class,
            ]);
        }
    }
}
