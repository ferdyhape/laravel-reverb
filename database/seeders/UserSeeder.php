<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 20; $i++) {
            // user 0 is admin
            // user 1-5 are manager
            // user 6-19 are employee

            $role = $i == 0 ? 'admin' : ($i >= 1 && $i <= 5 ? 'manager' : 'employee');
            User::factory()->create([
                'email' => "user$i@gmail.com",
                'role' => $role,
            ]);
        }
    }
}
