<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'admin',
            'email' => 'rentahobby@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'address1' => Str::random(20),
            'address2' => Str::random(10),
            'phone_number' => rand(1234567890, 9999999999),
            'postcode' => Str::random(10),
            'role_id' => 1,
            'country_id' => 231,
            'state_id' => 3924,
            'city_id' => 42798,
            'status' => 'Active'
        ];

        User::create($data);
        
        $count = (int) $this->command->ask('Number of users to be created?', 10);
        User::factory()->count($count)->create();
        $this->command->info($count . ' users have been created');
    }
}
