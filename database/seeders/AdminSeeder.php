<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'nama_lengkap' => 'Mirza Ardanas',
                'email'        => 'ardanasmirza@batam.go.id',
                'kata_sandi'   => 'password',
            ],
        ];

        foreach ($admins as $admin) {
            \App\Models\Admin::create([
                'nama_lengkap' => $admin['nama_lengkap'],
                'email'        => $admin['email'],
                'kata_sandi'   => \Illuminate\Support\Facades\Hash::make($admin['kata_sandi']),
            ]);
        }
    }
}
