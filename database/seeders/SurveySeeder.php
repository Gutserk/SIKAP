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
                'judul'          => 'Survei Kepuasan Website Layanan Perizinan Online Kota Batam',
                'deskripsi'      => 'Mengukur kepuasan masyarakat terhadap kemudahan, kecepatan, dan transparansi proses perizinan online.',
                'status'         => 'aktif',
                'tanggal_mulai'  => Carbon::now()->subDays(5)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(25)->toDateString(),
            ],
            [
                'judul'          => 'Survei Kesiapan Smart City Kota Batam',
                'deskripsi'      => 'Mengukur pemahaman dan kesiapan masyarakat Kota Batam dalam menyambut integrasi layanan publik berbasis kota cerdas (Smart City).',
                'status'         => 'draf',
                'tanggal_mulai'  => Carbon::now()->addDays(10)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(40)->toDateString(),
            ],
            [
                'judul'          => 'Evaluasi Layanan Web A Kota Batam',
                'deskripsi'      => 'Evaluasi kecepatan dan kualitas tindak lanjut dinas terkait terhadap aduan infrastruktur maupun pelayanan masyarakat yang dikirimkan melalui platform SP4N LAPOR.',
                'status'         => 'ditutup',
                'tanggal_mulai'  => Carbon::now()->subMonths(2)->toDateString(),
                'tanggal_selesai' => Carbon::now()->subMonth()->toDateString(),
            ],
        ];

        foreach ($surveys as $data) {
            $survey = Survey::create([
                'admin_id'       => $adminId,
                'judul'          => $data['judul'],
                'deskripsi'      => $data['deskripsi'],
                'status'         => $data['status'],
                'tanggal_mulai'  => $data['tanggal_mulai'],
                'tanggal_selesai' => $data['tanggal_selesai'],
            ]);

            if ($data['status'] === 'aktif') {
                $this->createSampleQuestions($survey);
            }
        }
    }

    private function createSampleQuestions(Survey $survey): void
    {
        $pilihanGanda = $survey->questions()->create([
            'teks_pertanyaan' => 'Bagaimana penilaian Anda terhadap kecepatan pelayanan yang diberikan?',
            'tipe_pertanyaan' => 'pilihan_ganda',
            'urutan'          => 1,
            'wajib_diisi'     => true,
        ]);

        foreach (['Sangat Baik', 'Baik', 'Cukup', 'Kurang Baik'] as $index => $opsi) {
            $pilihanGanda->options()->create([
                'teks_pilihan' => $opsi,
                'urutan'       => $index + 1,
            ]);
        }

        $survey->questions()->create([
            'teks_pertanyaan' => 'Berikan saran atau masukan Anda untuk peningkatan layanan kami.',
            'tipe_pertanyaan' => 'esai',
            'urutan'          => 2,
            'wajib_diisi'     => false,
        ]);

        $survey->questions()->create([
            'teks_pertanyaan' => 'Seberapa besar kemungkinan Anda merekomendasikan layanan ini kepada orang lain?',
            'tipe_pertanyaan' => 'skala_linear',
            'urutan'          => 3,
            'wajib_diisi'     => true,
            'skala_min'       => 1,
            'skala_max'       => 5,
            'skala_min_label' => 'Tidak Mungkin',
            'skala_max_label' => 'Sangat Mungkin',
        ]);
    }
}
