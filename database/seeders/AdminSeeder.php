<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name'     => 'Admin',
                'email'    => 'admin@stokumkm.com',
                'password' => bcrypt('password'),
            ],
            [
                'name'     => 'Admin2',
                'email'    => 'admin2@stokumkm.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['email' => $admin['email']],
                [
                    'name'     => $admin['name'],
                    'password' => $admin['password'],
                ]
            );
        }
    }
}
