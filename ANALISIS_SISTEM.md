# Analisis Mendalam: Project SIKAP — Survey Management System

> **Catatan Keyakinan:** Semua temuan di bawah ini diverifikasi langsung dari source code, migrations, controller, view, dan dokumen PRD. Tingkat keyakinan dicantumkan pada setiap bagian.

---

## 1. Ringkasan Teknologi

| Layer | Teknologi | Versi | Keyakinan |
|---|---|---|---|
| **Backend Framework** | Laravel | ^10.10 | High |
| **Bahasa Pemrograman** | PHP | ^8.1 (aktual: 8.3.23) | High |
| **Database** | MySQL | 8.0.30 | High |
| **Frontend CSS** | Tailwind CSS | ^4.1.17 | High |
| **UI Component Library** | DaisyUI | ^5.5.20 | High |
| **Build Tool** | Vite | ^5.0.0 | High |
| **JS Interactivity** | Alpine.js | 3.x (CDN) | High |
| **Chart Library** | Chart.js | 4.4.0 (CDN) | High |
| **HTTP Client (JS)** | Axios | ^1.6.4 | High |
| **PDF Export** | barryvdh/laravel-dompdf | ^3.1 | High |
| **Excel Export** | maatwebsite/excel | ^3.1 | High |
| **API Auth** | Laravel Sanctum | ^3.3 | High |
| **HTTP Client (PHP)** | Guzzle | ^7.2 | High |
| **Font** | Plus Jakarta Sans | — (Google Fonts CDN) | High |
| **Web Server** | Tidak terdeteksi (lokal: artisan serve / Sail) | — | Medium |
| **Cloud Provider** | AWS S3 (dikonfigurasi, belum diisi) | — | Medium |
| **Real-time** | Pusher (dikonfigurasi, belum diisi) | — | Medium |
| **Cache** | File-based | — | High |
| **Queue** | Sync (tidak async) | — | High |
| **Session** | File-based | — | High |
| **Dev Environment** | Laravel Sail (Docker) tersedia | — | High |

---

## 2. Daftar Halaman & Sitemap

### Halaman Publik (Responden)

```
/                          → Landing Page (Beranda)
/survei                    → Daftar Survei Aktif
/survei/{id}               → Formulir Pengisian Survei
/terima-kasih              → Halaman Konfirmasi Setelah Submit
```

### Halaman Admin (Terautentikasi)

```
/login                                              → Form Login Admin
/admin/dasbor                                       → Dashboard & Analytics
/admin/kelola-survei                                → Manajemen Survei (List)
/admin/survei/create                                → Buat Survei Baru
/admin/survei/{id}                                  → Detail Survei + Tab Analitik + Tab Responden
/admin/survei/{id}/edit                             → Edit Survei
/admin/survei/{id}/responden/{submissionId}         → Detail Jawaban Responden
/admin/survei/{id}/export-excel                     → Download Hasil (.xlsx)
/admin/survei/{id}/export-pdf                       → Download Laporan (.pdf)
/admin/manajemen-admin                              → Manajemen Akun Admin
/logout (POST)                                      → Proses Logout
```

### API Routes

```
GET /api/user              → (auth:sanctum) Kembalikan data user terautentikasi
```

---

## 3. Daftar Fitur per Halaman

### Beranda Publik (`/`)
- Hero section dengan tagline dan 2 CTA button
- 4 kartu fitur: Transparan, Cepat & Mudah, Aman & Anonim, Berdampak Nyata
- Section "Cara Mengisi" (3 langkah)
- Section tentang platform
- 6 kartu survei aktif terbaru

### Daftar Survei (`/survei`)
- Grid 3 kolom kartu survei (responsive 1→3 kolom)
- Badge status "Aktif"
- Info: jumlah pertanyaan, tanggal berakhir
- Tombol "Mulai Survei"
- Empty state jika tidak ada survei aktif

### Formulir Pengisian Survei (`/survei/{id}`)
- Header survei: judul, deskripsi, jumlah pertanyaan, notifikasi anonimitas
- Form identitas responden: nama, jenis kelamin, usia, pendidikan, email (semua wajib)
- Pertanyaan dinamis:
  - Pilihan ganda → radio button berlabel huruf (A, B, C…)
  - Esai → textarea
- Validasi server-side dengan pesan error per field
- Submit dan redirect ke halaman terima kasih

### Halaman Terima Kasih (`/terima-kasih`)
- Ikon centang sukses besar
- Pesan konfirmasi
- 2 CTA: Isi Survei Lain / Kembali ke Beranda
- Guard: wajib ada session `success`, jika tidak redirect ke beranda

### Login Admin (`/login`)
- Form email + password
- Layout 2 kolom: form + ilustrasi
- Validasi domain wajib `@batam.go.id`
- Alert error jika kredensial salah
- Redirect ke dashboard jika sudah login

### Dashboard Admin (`/admin/dasbor`)
- 4 kartu statistik: Total Survei, Total Responden, Survei Aktif, Survei Ditutup
- Indikator pertumbuhan: survei baru bulan ini vs. bulan lalu
- Indikator responden minggu ini
- Grafik tren 7 hari terakhir (Chart.js line chart dengan gradient)
- Tabel 5 survei terbaru: status, jumlah responden, tanggal

### Manajemen Survei (`/admin/kelola-survei`)
- Grid kartu survei dengan badge status berwarna (Aktif/Draft/Ditutup)
- Search bar + filter status (Semua / Aktif / Draft / Ditutup)
- Dropdown menu per kartu: Edit, Hapus
- Modal konfirmasi hapus
- Pagination (12 item/halaman)
- Tombol "Buat Survei Baru"

### Buat/Edit Survei (`/admin/survei/create` & `/edit`)
- Form info survei: judul, deskripsi, status (draft/active/closed), tanggal mulai/akhir
- Survey builder dinamis (JavaScript vanilla):
  - Tambah/hapus pertanyaan
  - Toggle tipe: esai / pilihan ganda
  - Toggle wajib/opsional per pertanyaan
  - Tambah/hapus opsi jawaban dengan label huruf otomatis (A, B, C…)
- Validasi server-side dengan error messages

### Detail Survei (`/admin/survei/{id}`)
- Header: judul, deskripsi, badge status, rentang tanggal
- Kartu statistik: jumlah pertanyaan, jumlah responden
- **3 Tab (Alpine.js):**
  1. **Pertanyaan** — daftar pertanyaan beserta opsi jawaban
  2. **Analitik** — chart pie/bar/doughnut untuk pilihan ganda; analisis sentimen (beta) untuk esai
  3. **Responden** — tabel responden dengan demografi, waktu submit, link detail
- Tombol Export Excel & Export PDF
- Tombol Edit & Hapus survei
- Pagination responden (15/halaman)

### Detail Jawaban Responden (`/admin/survei/{id}/responden/{submissionId}`)
- Kartu profil: nama, avatar inisial, email, gender, usia, pendidikan, waktu submit
- Daftar jawaban per pertanyaan:
  - Pilihan ganda: opsi terpilih di-highlight
  - Esai: teks jawaban ditampilkan penuh

### Manajemen Admin (`/admin/manajemen-admin`)
- Tabel admin: Nama Lengkap, Email, Role, Tanggal Bergabung, Aksi
- Search + sort (Terbaru / Terlama / Nama A-Z)
- Modal Tambah Admin: nama, email (@batam.go.id), password
- Modal Edit Admin: nama, email, password (opsional)
- Modal konfirmasi hapus (tidak bisa hapus akun sendiri)
- Badge "Anda" pada akun yang sedang login
- Pagination (10/halaman)

---

## 4. Estimasi Arsitektur Sistem

```
┌──────────────────────────────────────────────────────────────────┐
│                         Browser Client                            │
│   Tailwind CSS + DaisyUI  │  Alpine.js  │  Chart.js  │  Axios    │
└────────────────────────────┬─────────────────────────────────────┘
                             │ HTTP (Server-Rendered Blade Views)
                             ▼
┌──────────────────────────────────────────────────────────────────┐
│                      Laravel Application                          │
│                                                                    │
│  ┌──────────────┐  ┌─────────────────┐  ┌────────────────────┐  │
│  │  Routes      │→ │   Middleware     │→ │   Controllers       │  │
│  │  web.php     │  │   auth:admin     │  │   Auth             │  │
│  │  api.php     │  │   RedirectIfAuth │  │   Public           │  │
│  └──────────────┘  └─────────────────┘  │   Dashboard        │  │
│                                          │   Survey           │  │
│                                          │   SurveyExport     │  │
│                                          │   AdminManager     │  │
│                                          └────────┬───────────┘  │
│                                                   │               │
│  ┌────────────────────────────────────────────────▼────────────┐ │
│  │                    Eloquent Models (ORM)                      │ │
│  │  Admin · Survey · Question · Option · Respondent ·           │ │
│  │  Submission · Answer · SentimentResult                        │ │
│  └────────────────────────────────────────────────────────────┘  │
│                                                                    │
│  ┌────────────────┐  ┌──────────────────┐  ┌─────────────────┐  │
│  │  Blade Views   │  │  DomPDF          │  │  Maatwebsite    │  │
│  │  (Templates)   │  │  (PDF Export)    │  │  Excel Export   │  │
│  └────────────────┘  └──────────────────┘  └─────────────────┘  │
└──────────────────────────────┬───────────────────────────────────┘
                               │ PDO / Eloquent ORM
                               ▼
┌──────────────────────────────────────────────────────────────────┐
│                      MySQL 8.0.30 Database                        │
│  admins · surveys · questions · options · respondents             │
│  submissions · answers · sentiment_results                        │
│  + users · password_reset_tokens · failed_jobs · PAT (default)   │
└──────────────────────────────────────────────────────────────────┘
```

**Pola Arsitektur:** MVC Monolith dengan Blade server-side rendering. Tidak ada SPA atau REST API utama — interaktivitas ringan ditangani Alpine.js di sisi klien.

**Keyakinan:** High

---

## 5. Analisis API

| Endpoint | Method | Auth | Fungsi | Keyakinan |
|---|---|---|---|---|
| `GET /api/user` | GET | Sanctum Token | Kembalikan data user terautentikasi | High |
| *(tidak ada endpoint lain)* | — | — | Semua operasi via web routes (form POST) | High |

**Catatan:** Laravel Sanctum terinstall namun hanya endpoint default di `api.php` yang aktif. Semua operasi CRUD menggunakan form POST tradisional (multipart/form-data), bukan JSON API. Sanctum kemungkinan disiapkan untuk pengembangan masa depan (mobile app / headless frontend).

---

## 6. Estimasi Struktur Database

### Diagram Relasi Entitas (ERD)

```
ADMINS (1) ──────────────────────────────── (N) SURVEYS
  id PK                                          id PK
  full_name VARCHAR(100)                         admin_id FK → admins.id [RESTRICT]
  email VARCHAR(150) UNIQUE                      title VARCHAR(200)
  password VARCHAR(255)                          description TEXT NULL
  last_login_at TIMESTAMP NULL                   status ENUM(draft,active,closed)
  created_at, updated_at                         start_date DATE NULL
                                                 end_date DATE NULL
                                                 created_at, updated_at

SURVEYS (1) ─────────────────────────── (N) QUESTIONS
                                               id PK
                                               survey_id FK → surveys.id [CASCADE]
                                               question_text TEXT
                                               question_type ENUM(multiple_choice,essay)
                                               order TINYINT UNSIGNED
                                               is_required BOOLEAN

QUESTIONS (1) ─────────────────────── (N) OPTIONS
                                             id PK
                                             question_id FK → questions.id [CASCADE]
                                             option_text VARCHAR(255)
                                             order TINYINT UNSIGNED

RESPONDENTS (1) ─────────────────── (N) SUBMISSIONS
  id PK                                       id PK
  name VARCHAR(100)                           respondent_id FK → respondents.id [RESTRICT]
  gender ENUM(M,F)                            survey_id FK → surveys.id [CASCADE]
  email VARCHAR(150)                          submitted_at TIMESTAMP
  education ENUM(SD,SMP,SMA,D3,S1,S2,S3)     UNIQUE(respondent_id, survey_id)
  age TINYINT UNSIGNED
  created_at TIMESTAMP

SURVEYS ─────────────────────────────────── ↑ (juga FK di SUBMISSIONS)

SUBMISSIONS (1) ──────────────── (N) ANSWERS
                                       id PK
                                       submission_id FK → submissions.id [CASCADE]
                                       question_id FK → questions.id [CASCADE]
                                       option_id FK → options.id [SET NULL]  ← nullable
                                       answer_text TEXT NULL

ANSWERS (1) ──────────────── (1) SENTIMENT_RESULTS
                                     id PK
                                     answer_id FK → answers.id [CASCADE]
                                     sentiment ENUM(positive,negative,neutral)
                                     score DECIMAL(5,4)
                                     analyzed_at TIMESTAMP
```

### Tabel Utama (Dikonfirmasi dari Migration Files)

| Tabel | Kolom Kunci | Timestamps | Catatan |
|---|---|---|---|
| `admins` | id, full_name, email, password, last_login_at | ✅ | Email unik, domain @batam.go.id |
| `surveys` | id, admin_id, title, description, status, start_date, end_date | ✅ | FK ke admins (RESTRICT) |
| `questions` | id, survey_id, question_text, question_type, order, is_required | ❌ | FK ke surveys (CASCADE) |
| `options` | id, question_id, option_text, order | ❌ | FK ke questions (CASCADE) |
| `respondents` | id, name, gender, email, education, age, created_at | Hanya `created_at` | No `updated_at` |
| `submissions` | id, respondent_id, survey_id, submitted_at | ❌ | Unique constraint composite |
| `answers` | id, submission_id, question_id, option_id, answer_text | ❌ | option_id nullable (SET NULL) |
| `sentiment_results` | id, answer_id, sentiment, score, analyzed_at | ❌ | DECIMAL(5,4) untuk skor |

### Tabel Default Laravel (Tidak Dipakai Secara Aktif)

| Tabel | Fungsi |
|---|---|
| `users` | Model default Laravel — tidak digunakan (admin pakai tabel `admins`) |
| `password_reset_tokens` | Fitur reset password |
| `failed_jobs` | Antrian job yang gagal |
| `personal_access_tokens` | Token Sanctum |

---

## 7. Estimasi Migration Laravel

12 file migration dalam urutan eksekusi:

```
2014_10_12_000000_create_users_table.php
2014_10_12_100000_create_password_reset_tokens_table.php
2019_08_19_000000_create_failed_jobs_table.php
2019_12_14_000001_create_personal_access_tokens_table.php
2026_06_04_041418_create_admins_table.php
2026_06_06_075418_create_respondents_table.php
2026_06_06_075419_create_surveys_table.php
2026_06_06_075420_create_questions_table.php
2026_06_06_075421_create_options_table.php
2026_06_06_075423_create_submissions_table.php
2026_06_06_075424_create_answers_table.php
2026_06_06_075426_create_sentiment_results_table.php
```

### Pola Delete Constraint

| Constraint | Berlaku Pada | Efek |
|---|---|---|
| `CASCADE` | questions, options, answers, sentiment_results | Ikut terhapus saat parent dihapus |
| `RESTRICT` | admins→surveys, respondents→submissions | Tidak bisa dihapus jika masih punya relasi |
| `SET NULL` | option_id pada answers | Jawaban tetap ada, referensi opsi menjadi NULL |

**Keyakinan:** High — semua file migration dibaca langsung.

---

## 8. Analisis Role Pengguna & Hak Akses

### Role Admin

| Atribut | Detail |
|---|---|
| Autentikasi | Custom guard `admin` (tabel `admins`, bukan `users`) |
| Email | Wajib domain `@batam.go.id` |
| Middleware | `auth:admin` di semua route `/admin/*` |
| Session | File-based, lifetime 120 menit |

**Hak Akses Admin:**
- CRUD penuh untuk survei (buat, lihat, edit, hapus)
- Lihat analitik dan hasil survei per pertanyaan
- Export data ke Excel (.xlsx) dan PDF (.pdf)
- Kelola akun admin lain (tambah, edit, hapus)
- Tidak dapat menghapus akun sendiri (proteksi di controller)

### Role Responden (Publik)

| Atribut | Detail |
|---|---|
| Autentikasi | Tidak ada — anonim tanpa akun |
| Identitas | Diisi saat submit survei (nama, gender, usia, pendidikan, email) |
| Pembatasan | Unique constraint `(respondent_id, survey_id)` di tabel `submissions` |

**Hak Akses Responden:**
- Lihat beranda dan daftar survei aktif
- Mengisi dan submit survei yang sedang aktif
- Tidak bisa melihat hasil, analitik, atau data responden lain

### Perbandingan Hak Akses

| Kemampuan | Admin | Responden |
|---|---|---|
| Login dengan akun | ✅ | ❌ |
| Buat / Edit / Hapus Survei | ✅ | ❌ |
| Lihat analitik & hasil | ✅ | ❌ |
| Export Excel / PDF | ✅ | ❌ |
| Kelola akun admin lain | ✅ | ❌ |
| Mengisi survei | ❌ | ✅ |
| Melihat daftar survei aktif | ✅ (panel admin) | ✅ (halaman publik) |

**Keyakinan:** High

---

## 9. Diagram Hubungan Antar Komponen Sistem

```
┌────────────────────────────────────────────────────────────────────────┐
│                              BROWSER                                    │
│                                                                          │
│  ┌─────────────────────┐         ┌──────────────────────────────────┐  │
│  │   PUBLIC AREA        │         │   ADMIN AREA                      │  │
│  │   (Tanpa Auth)       │         │   (auth:admin guard)              │  │
│  │                      │         │                                    │  │
│  │   Beranda            │         │   Sidebar ◄── sidebar.blade.php   │  │
│  │   Daftar Survei      │         │   Navbar  ◄── navbar.blade.php    │  │
│  │   Form Survei        │         │                                    │  │
│  │   Terima Kasih       │         │   Dashboard     (Chart.js)        │  │
│  │                      │         │   Survey CRUD   (Alpine.js + JS)  │  │
│  │   public-navbar ◄────┤         │   Analytics     (Chart.js)        │  │
│  │   public-footer ◄────┤         │   Admin Manager                   │  │
│  └──────────┬───────────┘         └──────────────────┬────────────────┘  │
│             │                                         │                    │
│             └─────────────────┬───────────────────────┘                   │
│                               │  HTTP Request / Form POST / GET            │
└───────────────────────────────┼────────────────────────────────────────────┘
                                │
                                ▼
┌────────────────────────────────────────────────────────────────────────┐
│                        LARAVEL ROUTING LAYER                            │
│      web.php  ──►  Middleware Stack  ──►  Controller                    │
│      (auth:admin / RedirectIfAuthenticated / CSRF / TrimStrings)        │
└──────────────────────────┬─────────────────────────────────────────────┘
                           │
         ┌─────────────────┼──────────────────────┐
         ▼                 ▼                        ▼
  PublicController    AuthController          Admin Controllers
  ├── home()          ├── showLoginForm()     ├── DashboardController
  ├── surveys()       ├── login()             ├── SurveyController
  ├── show()          └── logout()            ├── SurveyExportController
  ├── submit()                                └── AdminManagerController
  └── thanks()
         │                                          │
         └───────────────────┬──────────────────────┘
                             │  Eloquent ORM
                             ▼
┌────────────────────────────────────────────────────────────────────────┐
│                          MODEL LAYER                                    │
│                                                                          │
│   Admin ──► Survey ──► Question ──► Option                             │
│                   └──► Submission ──► Answer ──► SentimentResult       │
│   Respondent ──────────────↑                                            │
└──────────────────────────┬─────────────────────────────────────────────┘
                           │
                           ▼
┌────────────────────────────────────────────────────────────────────────┐
│                       MySQL 8.0.30 DATABASE                             │
│   admins · surveys · questions · options                                │
│   respondents · submissions · answers · sentiment_results               │
└──────────────────────────┬──────────────────┬──────────────────────────┘
                           │                  │
                           ▼                  ▼
                    DomPDF              Maatwebsite Excel
                    (laporan_survei     (hasil_survei
                     {id}.pdf)           {id}.xlsx)
```

---

## 10. Kesimpulan & Rekomendasi Pengembangan

### Kesimpulan

Project **SIKAP** adalah aplikasi survei berbasis web yang dibangun dengan stack modern (Laravel 10, PHP 8.3, MySQL 8, Tailwind CSS 4, DaisyUI 5). Dirancang khusus untuk **Diskominfo Kota Batam** sebagai pengganti sistem survei berbasis WordPress lama. Arsitekturnya adalah **MVC Monolith server-rendered** yang solid dengan pemisahan peran yang jelas antara admin dan publik.

Seluruh fitur inti (CRUD survei, pengisian survei publik, manajemen admin, export data) sudah terstruktur dengan baik di level routing, controller, model, dan migrations. Fitur **analisis sentimen** sudah memiliki tabel database (`sentiment_results`) namun logika analisis AI-nya belum diimplementasikan — masih dalam rencana PRD Phase 3.

### Rekomendasi Pengembangan

| # | Rekomendasi | Prioritas | Catatan |
|---|---|---|---|
| 1 | **Implementasi Analisis Sentimen** | 🔴 High | Tabel `sentiment_results` sudah ada. Integrasikan API NLP (IndoBERT / OpenAI / Gemini) di `SurveyController@show` |
| 2 | **Rate Limiting Submit Survei** | 🔴 High | Tidak ada proteksi spam. Tambahkan `throttle` middleware di `POST /survei/{id}/submit` |
| 3 | **Validasi Email Domain Admin** | 🟡 Medium | Validasi `@batam.go.id` ada di controller — perkuat dengan Laravel `Rule` class agar reusable |
| 4 | **Queue untuk Export** | 🟡 Medium | Export besar bisa timeout. Pindahkan ke background job (ubah `QUEUE_CONNECTION=sync` ke `database`/`redis`) |
| 5 | **Verifikasi Email Responden** | 🟡 Medium | Email responden tidak diverifikasi. Pertimbangkan OTP untuk mencegah data palsu |
| 6 | **Hapus Tabel `users` Default** | 🟢 Low | Tabel `users` tidak digunakan (admin pakai `admins`). Bisa dirapikan untuk mengurangi kebingungan |
| 7 | **Redis untuk Cache & Session** | 🟢 Low | Ganti file-based ke Redis untuk performa lebih baik saat traffic tinggi |
| 8 | **Pagination via AJAX** | 🟢 Low | Pagination saat ini full-page reload. Bisa diimprovisasi dengan Livewire atau fetch API |
| 9 | **Soft Delete untuk Survey** | 🟢 Low | Saat ini hard delete. Tambahkan `SoftDeletes` trait agar data dapat dipulihkan |
| 10 | **Test Coverage** | 🟢 Low | PHPUnit terinstall tapi belum ada test kustom. Tambahkan Feature Tests untuk alur kritis (submit survei, login admin) |
