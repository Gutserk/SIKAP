<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Admin;
use Carbon\Carbon;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::first();
        $adminId = $admin ? $admin->id : 1;

        $surveys = [
            [
                'title' => 'Indeks Kepuasan Masyarakat (IKM) Diskominfo 2026',
                'description' => 'Survei rutin tahunan untuk mengukur tingkat kepuasan masyarakat terhadap seluruh layanan publik yang diselenggarakan oleh Dinas Komunikasi dan Informatika Kota Batam.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(5)->toDateString(),
                'end_date' => Carbon::now()->addDays(25)->toDateString(),
            ],
            [
                'title' => 'Evaluasi Layanan Call Center 112 Kota Batam',
                'description' => 'Bagaimana tanggapan dan kecepatan respon tim Call Center 112 saat Anda dalam keadaan darurat? Suara Anda membantu kami menyelamatkan lebih banyak nyawa.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(10)->toDateString(),
                'end_date' => Carbon::now()->addDays(20)->toDateString(),
            ],
            [
                'title' => 'Survei Kebutuhan Pelatihan Literasi Digital ASN',
                'description' => 'Survei ini bertujuan untuk menjaring aspirasi dan kebutuhan materi pelatihan digital bagi Aparatur Sipil Negara di lingkungan Pemkot Batam guna mendukung SPBE.',
                'status' => 'closed',
                'start_date' => Carbon::now()->subMonths(2)->toDateString(),
                'end_date' => Carbon::now()->subMonths(1)->toDateString(),
            ],
            [
                'title' => 'Kepuasan Pelayanan Informasi Publik (PPID)',
                'description' => 'Kuisioner evaluasi pelayanan permohonan informasi publik melalui portal PPID Kota Batam. Apakah informasi yang Anda butuhkan mudah didapatkan?',
                'status' => 'draft',
                'start_date' => Carbon::now()->addDays(5)->toDateString(),
                'end_date' => Carbon::now()->addDays(35)->toDateString(),
            ],
            [
                'title' => 'Evaluasi Jaringan Internet Pemkot Batam',
                'description' => 'Survei khusus internal pegawai mengenai kestabilan dan kecepatan akses internet di masing-masing Organisasi Perangkat Daerah (OPD).',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(2)->toDateString(),
                'end_date' => Carbon::now()->addDays(14)->toDateString(),
            ],
            [
                'title' => 'Survei Pemanfaatan Aplikasi e-Kinerja',
                'description' => 'Menilai sejauh mana efektivitas penggunaan aplikasi e-Kinerja dalam pencatatan beban kerja dan pelaporan harian pegawai negeri sipil.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(1)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
            ],
            [
                'title' => 'Indeks Keamanan Informasi (KAMI) OPD',
                'description' => 'Penilaian tingkat kesadaran dan kepatuhan pegawai terhadap pedoman keamanan informasi dan perlindungan data pribadi di lingkungan instansi.',
                'status' => 'closed',
                'start_date' => Carbon::now()->subMonths(3)->toDateString(),
                'end_date' => Carbon::now()->subMonths(2)->subDays(10)->toDateString(),
            ],
            [
                'title' => 'Kepuasan Layanan Pembuatan Email @batam.go.id',
                'description' => 'Evaluasi proses pengajuan, pembuatan, hingga kendala teknis dalam penggunaan email resmi kedinasan bagi para pegawai.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(7)->toDateString(),
                'end_date' => Carbon::now()->addDays(15)->toDateString(),
            ],
            [
                'title' => 'Survei Kesiapan Smart City Kota Batam',
                'description' => 'Mengukur pemahaman dan kesiapan masyarakat Kota Batam dalam menyambut integrasi layanan publik berbasis kota cerdas (Smart City).',
                'status' => 'draft',
                'start_date' => Carbon::now()->addDays(10)->toDateString(),
                'end_date' => Carbon::now()->addDays(40)->toDateString(),
            ],
            [
                'title' => 'Evaluasi Layanan Pengaduan SP4N LAPOR!',
                'description' => 'Beri nilai kecepatan tindak lanjut dinas terkait terhadap aduan infrastruktur maupun pelayanan masyarakat yang Anda kirimkan melalui platform SP4N LAPOR.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(15)->toDateString(),
                'end_date' => Carbon::now()->addDays(15)->toDateString(),
            ],
            [
                'title' => 'Survei Portal Resmi Pemkot Batam',
                'description' => 'Apakah tampilan dan tata letak situs web batam.go.id saat ini sudah ramah pengguna? Berikan masukan desain untuk versi selanjutnya.',
                'status' => 'closed',
                'start_date' => Carbon::now()->subMonths(5)->toDateString(),
                'end_date' => Carbon::now()->subMonths(4)->toDateString(),
            ],
            [
                'title' => 'Kepuasan Masyarakat terhadap Aplikasi BSW',
                'description' => 'Ulasan mengenai kemudahan akses layanan perizinan dan non-perizinan melalui aplikasi Batam Single Window (BSW) versi Mobile.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(3)->toDateString(),
                'end_date' => Carbon::now()->addDays(28)->toDateString(),
            ],
            [
                'title' => 'Evaluasi Layanan Kependudukan (Disdukcapil)',
                'description' => 'Bagaimana pengalaman Anda saat mengurus e-KTP, Kartu Keluarga, dan perizinan kependudukan lainnya di Kota Batam? Berikan masukan Anda.',
                'status' => 'active',
                'start_date' => Carbon::now()->subDays(1)->toDateString(),
                'end_date' => Carbon::now()->addDays(30)->toDateString(),
            ],
        ];

        foreach ($surveys as $survey) {
            Survey::create([
                'admin_id' => $adminId,
                'title' => $survey['title'],
                'description' => $survey['description'],
                'status' => $survey['status'],
                'start_date' => $survey['start_date'],
                'end_date' => $survey['end_date'],
            ]);
        }
    }
}
