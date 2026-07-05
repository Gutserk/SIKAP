<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Models\Respondent;
use App\Models\Submission;
use App\Models\Answer;
use App\Models\SentimentResult;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $survey = Survey::where('status', 'aktif')->first();

        if (!$survey) {
            $survey = Survey::create([
                'admin_id'       => 1,
                'judul'          => 'Survei Kepuasan Masyarakat (Data Dummy)',
                'deskripsi'      => 'Ini adalah survei dummy untuk melihat detail analitik dan tabel responden.',
                'status'         => 'aktif',
                'tanggal_mulai'  => now()->subDays(14),
                'tanggal_selesai' => now()->addDays(16),
            ]);
        }

        $survey->questions()->delete();

        $q1 = Question::create([
            'survei_id'       => $survey->id,
            'teks_pertanyaan' => 'Bagaimana penilaian Anda secara keseluruhan terhadap pelayanan yang kami berikan?',
            'tipe_pertanyaan' => 'pilihan_ganda',
            'wajib_diisi'     => true,
            'urutan'          => 1,
        ]);
        $optionsQ1 = [
            'baik'    => Option::create(['pertanyaan_id' => $q1->id, 'teks_pilihan' => 'Sangat Baik', 'urutan' => 1]),
            'baik2'   => Option::create(['pertanyaan_id' => $q1->id, 'teks_pilihan' => 'Baik', 'urutan' => 2]),
            'cukup'   => Option::create(['pertanyaan_id' => $q1->id, 'teks_pilihan' => 'Cukup', 'urutan' => 3]),
            'kurang'  => Option::create(['pertanyaan_id' => $q1->id, 'teks_pilihan' => 'Kurang Baik', 'urutan' => 4]),
        ];

        $q2 = Question::create([
            'survei_id'       => $survey->id,
            'teks_pertanyaan' => 'Apakah petugas memberikan informasi dengan jelas dan mudah dipahami?',
            'tipe_pertanyaan' => 'pilihan_ganda',
            'wajib_diisi'     => true,
            'urutan'          => 2,
        ]);
        $optionsQ2 = [
            'jelas'   => Option::create(['pertanyaan_id' => $q2->id, 'teks_pilihan' => 'Sangat Jelas', 'urutan' => 1]),
            'jelas2'  => Option::create(['pertanyaan_id' => $q2->id, 'teks_pilihan' => 'Jelas', 'urutan' => 2]),
            'kurang'  => Option::create(['pertanyaan_id' => $q2->id, 'teks_pilihan' => 'Kurang Jelas', 'urutan' => 3]),
            'tidak'   => Option::create(['pertanyaan_id' => $q2->id, 'teks_pilihan' => 'Tidak Jelas', 'urutan' => 4]),
        ];

        $q3 = Question::create([
            'survei_id'       => $survey->id,
            'teks_pertanyaan' => 'Seberapa puas Anda dengan kecepatan waktu pelayanan kami?',
            'tipe_pertanyaan' => 'skala_linear',
            'wajib_diisi'     => true,
            'urutan'          => 3,
            'skala_min'       => 1,
            'skala_max'       => 5,
            'skala_min_label' => 'Sangat Tidak Puas',
            'skala_max_label' => 'Sangat Puas',
        ]);

        $q4 = Question::create([
            'survei_id'       => $survey->id,
            'teks_pertanyaan' => 'Seberapa besar kemungkinan Anda merekomendasikan layanan ini kepada orang lain?',
            'tipe_pertanyaan' => 'skala_linear',
            'wajib_diisi'     => true,
            'urutan'          => 4,
            'skala_min'       => 0,
            'skala_max'       => 10,
            'skala_min_label' => 'Tidak Mungkin',
            'skala_max_label' => 'Sangat Mungkin',
        ]);

        $q5 = Question::create([
            'survei_id'       => $survey->id,
            'teks_pertanyaan' => 'Apa saran atau masukan Anda untuk peningkatan layanan kami?',
            'tipe_pertanyaan' => 'esai',
            'wajib_diisi'     => false,
            'urutan'          => 5,
        ]);

        $profiles = [
            'positif' => [
                'weight'    => 60,
                'opsiQ1'    => ['baik', 'baik2'],
                'opsiQ2'    => ['jelas', 'jelas2'],
                'skalaQ3'   => [4, 5],
                'skalaQ4'   => [8, 9, 10],
                'esai'      => [
                    'Pelayanannya sangat cepat dan ramah, saya puas sekali dengan kunjungan hari ini.',
                    'Petugasnya informatif dan sigap membantu, prosesnya juga tidak berbelit-belit. Terima kasih!',
                    'Semua berjalan lancar, antrian tidak terlalu lama dan stafnya sopan. Pertahankan kualitas ini.',
                    'Sangat puas dengan pelayanan online maupun di kantor, semoga terus konsisten seperti ini.',
                    'Proses pengurusan dokumen cepat selesai, tidak ada kendala sama sekali. Mantap!',
                ],
            ],
            'netral' => [
                'weight'    => 25,
                'opsiQ1'    => ['cukup'],
                'opsiQ2'    => ['jelas2', 'kurang'],
                'skalaQ3'   => [3],
                'skalaQ4'   => [5, 6, 7],
                'esai'      => [
                    'Pelayanannya cukup baik, namun ruang tunggu bisa diperluas lagi agar lebih nyaman.',
                    'Secara umum sudah cukup, tapi informasi terkait persyaratan dokumen sebaiknya lebih jelas.',
                    'Tidak ada masalah berarti, hanya saja waktu tunggu agak lama di jam sibuk.',
                    'Lumayan, tapi sistem antrian online kadang masih sering error.',
                ],
            ],
            'negatif' => [
                'weight'    => 15,
                'opsiQ1'    => ['kurang'],
                'opsiQ2'    => ['kurang', 'tidak'],
                'skalaQ3'   => [1, 2],
                'skalaQ4'   => [0, 1, 2, 3],
                'esai'      => [
                    'Pelayanan sangat lambat, saya menunggu lebih dari dua jam tanpa kejelasan.',
                    'Petugas kurang ramah dan informasi yang diberikan membingungkan, mohon diperbaiki.',
                    'Sistem online sering down sehingga saya harus datang langsung dan mengantri lama sekali.',
                    'Sangat mengecewakan, dokumen saya diproses berkali-kali karena kesalahan input petugas.',
                ],
            ],
        ];

        $weightedProfiles = [];
        foreach ($profiles as $key => $profile) {
            for ($w = 0; $w < $profile['weight']; $w++) {
                $weightedProfiles[] = $key;
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $profileKey = $faker->randomElement($weightedProfiles);
            $profile = $profiles[$profileKey];

            $email = $faker->unique()->userName . '@gmail.com';

            $respondent = Respondent::firstOrCreate(
                ['email' => $email],
                [
                    'nama'          => $faker->name,
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'pendidikan'    => $faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']),
                    'usia'          => $faker->numberBetween(18, 60),
                    'dibuat_pada'   => now(),
                ]
            );

            $submission = Submission::create([
                'survei_id'    => $survey->id,
                'responden_id' => $respondent->id,
                'dikirim_pada' => $faker->dateTimeBetween($survey->tanggal_mulai, 'now'),
            ]);

            $opsiQ1Key = $faker->randomElement($profile['opsiQ1']);
            Answer::create([
                'pengisian_id'  => $submission->id,
                'pertanyaan_id' => $q1->id,
                'pilihan_id'    => $optionsQ1[$opsiQ1Key]->id,
                'teks_jawaban'  => null,
            ]);

            $opsiQ2Key = $faker->randomElement($profile['opsiQ2']);
            Answer::create([
                'pengisian_id'  => $submission->id,
                'pertanyaan_id' => $q2->id,
                'pilihan_id'    => $optionsQ2[$opsiQ2Key]->id,
                'teks_jawaban'  => null,
            ]);

            Answer::create([
                'pengisian_id'  => $submission->id,
                'pertanyaan_id' => $q3->id,
                'pilihan_id'    => null,
                'teks_jawaban'  => (string) $faker->randomElement($profile['skalaQ3']),
            ]);

            Answer::create([
                'pengisian_id'  => $submission->id,
                'pertanyaan_id' => $q4->id,
                'pilihan_id'    => null,
                'teks_jawaban'  => (string) $faker->randomElement($profile['skalaQ4']),
            ]);

            if (rand(1, 100) <= 70) {
                $essayAnswer = Answer::create([
                    'pengisian_id'  => $submission->id,
                    'pertanyaan_id' => $q5->id,
                    'pilihan_id'    => null,
                    'teks_jawaban'  => $faker->randomElement($profile['esai']),
                ]);

                SentimentResult::create([
                    'jawaban_id'      => $essayAnswer->id,
                    'sentimen'        => $profileKey,
                    'skor'            => round($faker->randomFloat(4, 0.80, 0.99), 4),
                    'dianalisis_pada' => $submission->dikirim_pada,
                ]);
            }
        }
    }
}
