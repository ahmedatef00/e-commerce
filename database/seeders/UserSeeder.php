<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Ahmed',
            'email' => 'ahmedatef62437@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
            'email_verified_at' => now(),
            ]);

        
    }
}
