<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
            'full_name' => 'Administrator',
            'email' => 'admin@batam.go.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        for ($i = 1; $i <= 11; $i++) {
            \App\Models\Admin::create([
                'full_name' => "Admin Test $i",
                'email' => "admin$i@batam.go.id",
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            ]);
        }
    }
}
