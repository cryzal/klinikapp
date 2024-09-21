<?php

// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Dokter',
            'email' => 'dokter@example.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        User::create([
            'name' => 'Apoteker',
            'email' => 'apoteker@example.com',
            'password' => Hash::make('password'),
            'role' => 'apoteker',
        ]);
    }
}
