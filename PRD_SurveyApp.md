# Product Requirements Document (PRD)
# Aplikasi Survei Berbasis Web — Diskominfo Kota Batam

**Versi:** 1.0  
**Tanggal:** Mei 2026  
**Stack Teknologi:** Laravel 10 · MySQL 8.0.30 ·PHP 8.3.23 · Tailwind CSS 4 dan daisyui 5.5.20

---

## 1. Latar Belakang

Diskominfo Kota Batam saat ini menggunakan WordPress dengan plugin survei untuk mengumpulkan data dari pengguna layanan. Sistem ini memiliki keterbatasan signifikan: data tersebar di berbagai plugin dan basis data WordPress, tidak ada visualisasi hasil, dan admin harus mengolah data secara manual dari berbagai sumber.

Proyek ini bertujuan membangun **aplikasi survei berbasis web** yang terintegrasi, dengan pengelolaan data terpusat, visualisasi hasil otomatis, dan fitur analisis sentimen untuk jawaban esai.

---

## 2. Tujuan Produk

- Memusatkan seluruh data survei dalam satu platform terintegrasi
- Mempermudah admin dalam membuat, mendistribusikan, dan memantau survei
- Menyediakan visualisasi hasil survei (grafik & diagram) secara real-time
- Menganalisis jawaban esai secara otomatis menggunakan sentiment analysis
- Memungkinkan ekspor hasil survei ke format PDF dan Excel

---

## 3. Pengguna Sistem

| Peran | Deskripsi |
|---|---|
| **Admin** | Pegawai Diskominfo yang mengelola survei, melihat hasil, dan mengekspor data |
| **Responden** | Masyarakat umum atau pengguna layanan yang mengisi survei |

---

## 4. Kebutuhan Fungsional

| Kode | Kebutuhan Fungsional |
|---|---|
| FR-01 | Admin dapat melakukan login ke dalam sistem |
| FR-02 | Admin dapat melakukan logout dari sistem |
| FR-03 | Admin dapat mengelola survei (buat, edit, hapus, publikasi) |
| FR-04 | Admin dapat mengelola data admin |
| FR-05 | Admin dapat menampilkan hasil survei esai dalam sentimen analisis |
| FR-06 | Admin dapat menampilkan hasil survei dalam visual grafik atau diagram |
| FR-07 | Admin dapat mengekspor hasil survei dalam bentuk PDF dan Excel |
| FR-08 | Responden dapat mengakses halaman utama sistem survei |
| FR-09 | Responden dapat melihat daftar survei yang tersedia |
| FR-10 | Responden dapat mengisi dan mengirimkan survei |

---

## 5. Kebutuhan Non-Fungsional

| Kode | Kebutuhan Non-Fungsional |
|---|---|
| NFR-01 | Sistem berbasis web, dapat diakses melalui browser modern |
| NFR-02 | Tampilan responsive untuk desktop dan mobile |
| NFR-03 | Antarmuka user-friendly untuk admin dan responden |
| NFR-04 | Data terenkripsi dan akses terbatas hanya untuk pengguna berwenang |

---

## 6. Halaman-Halaman Sistem

### 6.1 Area Publik (Responden)

---

#### `[PUB-01]` Halaman Beranda / Landing Page

**Route:** `/`  
**Deskripsi:** Halaman pertama yang dilihat responden saat membuka aplikasi.

**Konten:**
- Logo dan nama instansi (Diskominfo Kota Batam)
- Deskripsi singkat tujuan survei
- Tombol CTA "Lihat Survei Tersedia"
- Informasi kontak / footer instansi

---

#### `[PUB-02]` Halaman Daftar Survei

**Route:** `/surveys`  
**Deskripsi:** Menampilkan semua survei yang sedang aktif/dipublikasikan.

**Konten:**
- Daftar kartu survei (judul, deskripsi singkat, deadline, jumlah pertanyaan)
- Badge status survei (Aktif / Ditutup)
- Tombol "Isi Survei" per item
- Filter/pencarian survei (opsional)

---

#### `[PUB-03]` Halaman Detail & Pengisian Survei

**Route:** `/surveys/{id}`  
**Deskripsi:** Halaman untuk mengisi survei. Berisi semua pertanyaan dalam satu form atau multi-step.

**Konten:**
- Judul dan deskripsi survei
- Pertanyaan pilihan ganda (radio button / checkbox)
- Pertanyaan esai (textarea)
- Progress bar (jika multi-step)
- Tombol "Kirim Jawaban"
- Halaman konfirmasi setelah submit

---

### 6.2 Area Admin (Authenticated)

---

#### `[ADM-01]` Halaman Login Admin

**Route:** `/admin/login`  
**Deskripsi:** Form autentikasi untuk admin.

**Konten:**
- Form email & password
- Tombol login
- Pesan error validasi

---

#### `[ADM-02]` Dashboard Admin

**Route:** `/admin/dashboard`  
**Deskripsi:** Halaman utama admin setelah login. Memberikan ringkasan data secara keseluruhan.

**Konten:**
- Statistik ringkas: total survei, total responden, survei aktif, survei selesai
- Grafik tren respons (line chart per minggu/bulan)
- Daftar survei terbaru beserta jumlah respons
- Shortcut navigasi ke fitur utama

---

#### `[ADM-03]` Halaman Daftar Survei (Admin)

**Route:** `/admin/surveys`  
**Deskripsi:** Manajemen seluruh survei yang ada di sistem.

**Konten:**
- Tabel survei (judul, status, tanggal dibuat, jumlah responden)
- Filter berdasarkan status (Draft / Aktif / Ditutup)
- Tombol "Buat Survei Baru"
- Aksi per baris: Edit, Lihat Hasil, Hapus, Toggle Publikasi

---

#### `[ADM-04]` Halaman Buat / Edit Survei

**Route:** `/admin/surveys/create` · `/admin/surveys/{id}/edit`  
**Deskripsi:** Form untuk membuat atau mengedit survei beserta pertanyaan-pertanyaannya.

**Konten:**
- Input judul dan deskripsi survei
- Pengaturan tanggal mulai dan berakhir
- Builder pertanyaan dinamis:
  - Tambah pertanyaan (pilihan ganda / esai)
  - Urutkan pertanyaan (drag & drop)
  - Hapus pertanyaan
- Toggle status publikasi (Draft / Publikasikan)
- Tombol Simpan & Preview

---

#### `[ADM-05]` Halaman Hasil Survei — Statistik & Visualisasi

**Route:** `/admin/surveys/{id}/results`  
**Deskripsi:** Menampilkan hasil survei dalam bentuk grafik dan diagram.

**Konten:**
- Ringkasan: total responden, rata-rata waktu pengisian
- **Per pertanyaan pilihan ganda:**
  - Bar chart / Pie chart distribusi jawaban
  - Persentase tiap opsi
- **Per pertanyaan esai:**
  - Panel Sentimen Analisis (Positif / Negatif / Netral)
  - Donut chart distribusi sentimen
  - Daftar jawaban dengan label sentimen
  - Word cloud (opsional)
- Tombol Ekspor (PDF & Excel)

---

#### `[ADM-06]` Halaman Manajemen Admin

**Route:** `/admin/admins`  
**Deskripsi:** Kelola akun admin yang dapat mengakses sistem.

**Konten:**
- Tabel daftar admin (nama, email, tanggal dibuat)
- Tombol "Tambah Admin"
- Aksi: Edit, Hapus

---

#### `[ADM-07]` Halaman Tambah / Edit Admin

**Route:** `/admin/admins/create` · `/admin/admins/{id}/edit`  
**Deskripsi:** Form untuk menambahkan atau mengubah data admin.

**Konten:**
- Input nama, email, password
- Tombol Simpan

---

## 7. Alur Sistem

### Alur Responden
```
Beranda (PUB-01)
  └─→ Daftar Survei (PUB-02)
        └─→ Pengisian Survei (PUB-03)
              └─→ Halaman Konfirmasi / Terima Kasih
```

### Alur Admin
```
Login (ADM-01)
  └─→ Dashboard (ADM-02)
        ├─→ Daftar Survei (ADM-03)
        │     ├─→ Buat/Edit Survei (ADM-04)
        │     └─→ Hasil Survei (ADM-05)
        └─→ Manajemen Admin (ADM-06)
              └─→ Tambah/Edit Admin (ADM-07)
```

---

## 8. Komponen Shared / Reusable

| Komponen | Deskripsi |
|---|---|
| **Navbar Publik** | Logo, link ke daftar survei |
| **Sidebar Admin** | Navigasi utama area admin |
| **Topbar Admin** | Informasi user login, tombol logout |
| **Kartu Survei** | Digunakan di PUB-02 dan ADM-03 |
| **Chart Components** | Bar, Pie, Donut chart (menggunakan Chart.js atau ApexCharts) |
| **Alert / Toast** | Notifikasi sukses/gagal aksi |
| **Modal Konfirmasi** | Digunakan saat hapus data |
| **Pagination** | Digunakan di tabel-tabel data |

---

## 9. Struktur Database (Ringkasan)

| Tabel | Kolom Utama |
|---|---|
| `admins` | id, name, email, password, timestamps |
| `surveys` | id, title, description, status, start_date, end_date, timestamps |
| `questions` | id, survey_id, question_text, type (multiple_choice/essay), order |
| `options` | id, question_id, option_text |
| `responses` | id, survey_id, respondent_token, submitted_at |
| `answers` | id, response_id, question_id, answer_text / option_id |
| `sentiment_results` | id, answer_id, sentiment (positive/negative/neutral), score |

---

## 10. Teknologi & Library

| Kategori | Teknologi |
|---|---|
| Backend Framework | Laravel 10.x (PHP 8.3) |
| Database | MySQL 8.0 |
| Frontend Styling | Tailwind CSS 4.x + DaisyUI |
| Chart / Visualisasi | Chart.js atau ApexCharts |
| Sentiment Analysis | Python microservice / API eksternal (IndoBERT / VADER) atau library PHP |
| Ekspor PDF | Laravel DomPDF (`barryvdh/laravel-dompdf`) |
| Ekspor Excel | Laravel Excel (`maatwebsite/excel`) |

---

## 11. Prioritas Pengembangan

| Fase | Fitur |
|---|---|
| **Fase 1 — Core** | Login admin, CRUD survei, pengisian survei oleh responden |
| **Fase 2 — Visualisasi** | Dashboard statistik, grafik hasil survei pilihan ganda |
| **Fase 3 — AI Feature** | Integrasi sentimen analisis untuk jawaban esai |
| **Fase 4 — Export & Polish** | Ekspor PDF/Excel, manajemen admin, UI responsif penuh |



