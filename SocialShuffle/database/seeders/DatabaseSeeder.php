<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use App\Models\Member;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'jdof',
            'email' => 'jdof@a.a',
            'email_verified_at' => now(),
            'password' => Hash::make('root'),
            'admin' => true,
            'remember_token' => Str::random(10),
        ]);
        User::factory(1)->create();
        Team::factory(10)->create();
        Member::factory(300)->create();        
    }
}
