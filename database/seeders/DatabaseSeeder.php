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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => env('FIRST_NAME', '_x'),
            'email' => env('FRIST_EMAIL', 'meohere@gmail.com'),
            'password' => env('FIRST_PASS', 'Tuem@n1107'),
        ]);
    }
}
