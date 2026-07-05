<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->updateOrInsert(
            ['email' => 'ardanasmirza@batam.go.id'],
            [
                'nama_lengkap' => 'Mirza Ardanas',
                'kata_sandi'   => Hash::make('password'),
                'updated_at'   => now(),
            ]
        );
    }
}