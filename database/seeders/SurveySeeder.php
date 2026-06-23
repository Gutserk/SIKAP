<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Admin;
use Carbon\Carbon;

class SurveySeeder extends Seeder
{
    public function run()
    {
        $admin = Admin::where('email', 'ardanasmirza@batam.go.id')->first() ?? Admin::first();
        $adminId = $admin ? $admin->id : 1;

        $surveys = [
            [
                'judul'          => 'Survei Kepuasan Pelayanan Diskominfo Kota Batam 2026',
                'deskripsi'      => 'Survei rutin untuk mengukur tingkat kepuasan masyarakat terhadap layanan publik yang diselenggarakan oleh Dinas Komunikasi dan Informatika Kota Batam.',
                'status'         => 'aktif',
                'tanggal_mulai'  => Carbon::now()->subDays(14)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(16)->toDateString(),
            ],
            [
                'judul'          => 'Survei Kesiapan Smart City Kota Batam',
                'deskripsi'      => 'Mengukur pemahaman dan kesiapan masyarakat Kota Batam dalam menyambut integrasi layanan publik berbasis kota cerdas (Smart City).',
                'status'         => 'draf',
                'tanggal_mulai'  => Carbon::now()->addDays(10)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(40)->toDateString(),
            ],
            [
                'judul'          => 'Evaluasi Layanan Pengaduan SP4N LAPOR! Kota Batam',
                'deskripsi'      => 'Evaluasi kecepatan dan kualitas tindak lanjut dinas terkait terhadap aduan infrastruktur maupun pelayanan masyarakat yang dikirimkan melalui platform SP4N LAPOR.',
                'status'         => 'ditutup',
                'tanggal_mulai'  => Carbon::now()->subMonths(2)->toDateString(),
                'tanggal_selesai' => Carbon::now()->subMonth()->toDateString(),
            ],
        ];

        foreach ($surveys as $survey) {
            Survey::create([
                'admin_id'       => $adminId,
                'judul'          => $survey['judul'],
                'deskripsi'      => $survey['deskripsi'],
                'status'         => $survey['status'],
                'tanggal_mulai'  => $survey['tanggal_mulai'],
                'tanggal_selesai' => $survey['tanggal_selesai'],
            ]);
        }
    }
}
