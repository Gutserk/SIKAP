## 9. Struktur Database
 
Sistem menggunakan **8 tabel** dengan konvensi penamaan bahasa Inggris mengikuti standar Laravel. Urutan tabel di bawah sekaligus mencerminkan urutan pembuatan migration (dari yang tidak memiliki FK hingga yang paling banyak dependensinya).
 
### 9.1 Tabel `admins`
Menyimpan data akun admin yang memiliki akses penuh ke sistem.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `full_name` | VARCHAR(100) | Nama lengkap admin |
| `email` | VARCHAR(150) | **UNIQUE** — digunakan untuk login |
| `password` | VARCHAR(255) | Di-hash otomatis oleh Laravel (Bcrypt) |
| `last_login_at` | TIMESTAMP NULL | Waktu terakhir login — NULL jika belum pernah login |
| `created_at` | TIMESTAMP | Diisi otomatis oleh Laravel |
| `updated_at` | TIMESTAMP | Diisi otomatis oleh Laravel |
 
---
 
### 9.2 Tabel `respondents`
Menyimpan data diri responden yang mengisi survei. Responden tidak perlu login — data diri diisi langsung saat hendak mengisi survei dan digunakan untuk analisis demografis.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `name` | VARCHAR(100) | Nama lengkap responden |
| `gender` | ENUM('M','F') | Jenis kelamin — M = Laki-laki, F = Perempuan |
| `email` | VARCHAR(150) | Alamat email responden — tidak unique secara global |
| `education` | ENUM('SD','SMP','SMA','D3','S1','S2','S3') | Tingkat pendidikan terakhir |
| `age` | TINYINT UNSIGNED | Usia responden dalam tahun |
| `created_at` | TIMESTAMP | Diisi otomatis oleh Laravel |
 
> **Catatan:** Kolom `email` tidak dibuat unique secara global karena satu orang boleh mengisi survei yang berbeda. Pencegahan duplikasi pengisian survei yang sama ditangani di tabel `submissions`.
 
---
 
### 9.3 Tabel `surveys`
Menyimpan seluruh data survei yang dibuat dan dikelola oleh admin, termasuk status publikasi dan rentang waktu aktif.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `admin_id` | BIGINT UNSIGNED | **FK** → `admins.id` — admin yang membuat survei |
| `title` | VARCHAR(200) | Judul survei |
| `description` | TEXT NULL | Deskripsi singkat tujuan survei |
| `status` | ENUM('draft','active','closed') | Status publikasi — default `draft` |
| `start_date` | DATE NULL | Tanggal survei mulai aktif — NULL jika tidak ada batas mulai |
| `end_date` | DATE NULL | Tanggal survei ditutup otomatis — NULL jika tidak ada deadline |
| `created_at` | TIMESTAMP | Diisi otomatis oleh Laravel |
| `updated_at` | TIMESTAMP | Diisi otomatis oleh Laravel |
 
> **Catatan:** Jumlah responden tidak disimpan sebagai kolom di sini karena rawan tidak sinkron — gunakan `withCount('submissions')` di Eloquent untuk menghitungnya secara dinamis.
 
---
 
### 9.4 Tabel `questions`
Menyimpan semua pertanyaan dalam sebuah survei. Setiap pertanyaan memiliki tipe dan urutan tampil yang dapat diatur oleh admin melalui fitur drag & drop.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `survey_id` | BIGINT UNSIGNED | **FK** → `surveys.id` |
| `question_text` | TEXT | Isi teks pertanyaan |
| `question_type` | ENUM('multiple_choice','essay') | Tipe pertanyaan |
| `order` | TINYINT UNSIGNED | Urutan tampil — diperbarui saat admin drag & drop |
| `is_required` | TINYINT(1) | Pertanyaan wajib diisi — 1 = wajib, 0 = opsional |
 
---
 
### 9.5 Tabel `options`
Menyimpan pilihan jawaban untuk pertanyaan bertipe `multiple_choice`. Tidak digunakan untuk pertanyaan esai.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `question_id` | BIGINT UNSIGNED | **FK** → `questions.id` |
| `option_text` | VARCHAR(255) | Teks pilihan jawaban, contoh: "Sangat Puas", "Puas" |
| `order` | TINYINT UNSIGNED | Urutan tampil pilihan (A, B, C, D) |
 
---
 
### 9.6 Tabel `submissions`
Menyimpan satu sesi pengisian survei oleh responden. Tabel ini menghubungkan `respondents` dengan `surveys` dan sekaligus menjadi mekanisme utama pencegahan duplikasi pengisian.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `respondent_id` | BIGINT UNSIGNED | **FK** → `respondents.id` |
| `survey_id` | BIGINT UNSIGNED | **FK** → `surveys.id` |
| `submitted_at` | TIMESTAMP | Waktu responden menekan tombol kirim |
 
> **Catatan:** Terdapat `UNIQUE(respondent_id, survey_id)` — satu responden hanya bisa mengisi survei yang sama sebanyak satu kali. Pelanggaran constraint ini akan ditolak langsung oleh MySQL di level database.
 
---
 
### 9.7 Tabel `answers`
Menyimpan jawaban responden untuk setiap pertanyaan dalam satu sesi pengisian. Untuk pertanyaan esai, kolom `answer_text` diisi dan `option_id` bernilai NULL. Untuk pilihan ganda, `option_id` diisi dan `answer_text` bernilai NULL.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `submission_id` | BIGINT UNSIGNED | **FK** → `submissions.id` — menghubungkan ke sesi pengisian |
| `question_id` | BIGINT UNSIGNED | **FK** → `questions.id` — pertanyaan yang dijawab |
| `option_id` | BIGINT UNSIGNED NULL | **FK** → `options.id` — diisi jika pilihan ganda, NULL jika esai |
| `answer_text` | TEXT NULL | Isi jawaban esai — NULL jika pilihan ganda |
 
---
 
### 9.8 Tabel `sentiment_results`
Menyimpan hasil analisis sentimen dari jawaban esai. Analisis dilakukan secara asinkron (background job) setelah responden submit agar tidak menghambat proses pengisian. Tabel ini dipisah dari `answers` karena hanya relevan untuk jawaban esai dan memudahkan re-analisis jika model AI diperbarui.
 
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED AI | Primary key |
| `answer_id` | BIGINT UNSIGNED | **FK** → `answers.id` — hanya untuk jawaban esai |
| `sentiment` | ENUM('positive','negative','neutral') | Hasil klasifikasi sentimen dari model AI |
| `score` | DECIMAL(5,4) | Nilai keyakinan model (confidence) antara 0.0000 – 1.0000 |
| `analyzed_at` | TIMESTAMP | Waktu analisis sentimen dilakukan |
 
---
 
### 9.9 Ringkasan Relasi
 
| Dari | Ke | On Delete |
|---|---|---|
| `surveys.admin_id` | `admins.id` | RESTRICT |
| `questions.survey_id` | `surveys.id` | CASCADE |
| `options.question_id` | `questions.id` | CASCADE |
| `submissions.respondent_id` | `respondents.id` | RESTRICT |
| `submissions.survey_id` | `surveys.id` | CASCADE |
| `answers.submission_id` | `submissions.id` | CASCADE |
| `answers.question_id` | `questions.id` | CASCADE |
| `answers.option_id` | `options.id` | SET NULL |
| `sentiment_results.answer_id` | `answers.id` | CASCADE |
 
---