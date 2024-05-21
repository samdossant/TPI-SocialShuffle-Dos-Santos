<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Team;
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
        Team::factory(5)->create();
        Member::factory(150)->create();

        
    }
}
