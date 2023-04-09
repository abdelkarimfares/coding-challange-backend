<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $groups = Group::factory()->count(5)->create();

         \App\Models\User::factory(50)
             ->hasAttached($groups)
             ->create();

         \App\Models\User::factory()->count(1)->create([
             'username' => 'admin',
             'email' => 'admin@gmail.com',
             'firstname' => fake()->firstName(),
             'lastname' => fake()->lastName(),
             'phone' => fake()->phoneNumber(),
             'age' => fake()->numberBetween(18, 100),
             'type' => fake()->randomElement(['admin']),
             'email_verified_at' => now(),
             'password' => Hash::make('admin'),
             'remember_token' => Str::random(10),
         ]);
    }
}
