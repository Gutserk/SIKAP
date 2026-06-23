# SIKAP — Sistem Informasi Kuesioner dan Analisis Pendapat

Aplikasi survei berbasis web yang dikembangkan untuk **Dinas Komunikasi dan Informatika (Diskominfo) Kota Batam**. Sistem ini memungkinkan pengelolaan survei secara terpusat, visualisasi hasil secara real-time, dan analisis sentimen otomatis untuk jawaban esai menggunakan model BERT berbahasa Indonesia.

---

## Fitur Utama

**Admin (Petugas)**
- Login & logout dengan autentikasi berbasis sesi
- Kelola survei: buat, edit, hapus, dan publikasi
- Lihat hasil survei dengan visualisasi grafik dan diagram
- Analisis sentimen otomatis (Positif / Netral / Negatif) untuk jawaban esai
- Ekspor hasil survei ke format **PDF** dan **Excel**
- Manajemen akun admin

**Responden (Publik)**
- Lihat daftar survei yang tersedia tanpa perlu login
- Isi dan kirimkan survei secara online

---

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 10 / PHP 8.3 |
| Database | MySQL 8.0 |
| Frontend | Tailwind CSS 4 + DaisyUI 5 |
| Sentiment API | Python 3 + Flask + HuggingFace Transformers |
| Model NLP | `mdhugol/indonesia-bert-sentiment-classification` |
| Ekspor | DomPDF (PDF) + Maatwebsite Excel |

---

## Arsitektur Sistem

```
┌─────────────────────────────┐        ┌──────────────────────────┐
│      Laravel App            │  HTTP  │   Python Sentiment API   │
│  (PHP + MySQL + Blade)      │──────▶|   (Flask + BERT Model)    │
│  http://localhost           |        │  http://127.0.0.1:5000   │
└─────────────────────────────┘        └──────────────────────────┘
```

Kedua service berjalan secara terpisah. Laravel memanggil Flask API secara internal setiap kali ada jawaban esai yang perlu dianalisis.

---

## Prasyarat

Pastikan sudah terinstall:

- PHP >= 8.1 + ekstensi: `pdo_mysql`, `mbstring`, `xml`, `zip`
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) >= 18 + npm
- MySQL >= 8.0
- Python >= 3.10 + pip

---

## Instalasi

### 1. Clone repositori

```bash
git clone <url-repositori>
cd sikap
```

### 2. Install dependensi PHP

```bash
composer install
```

### 3. Install dependensi Node.js

```bash
npm install
```

### 4. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan file `.env` dengan konfigurasi lokal Anda:

```env
DB_DATABASE=sikap
DB_USERNAME=root
DB_PASSWORD=your_password

SENTIMENT_API_URL=http://127.0.0.1:5000/predict
```

### 5. Migrasi dan seeding database

```bash
php artisan migrate --seed
```

### 6. Build aset frontend

```bash
npm run build
```

### 7. Jalankan server Laravel

```bash
php artisan serve
```

Aplikasi dapat diakses di `http://localhost:8000`.

---

## Menjalankan Sentiment Service

Sentiment API harus berjalan agar analisis sentimen jawaban esai dapat berfungsi.

```bash
cd sikap-sentiment

# Buat virtual environment (hanya pertama kali)
python -m venv venv

# Aktifkan virtual environment
# Windows:
venv\Scripts\activate
# Linux/macOS:
source venv/bin/activate

# Install dependensi
pip install -r requirements.txt

# Jalankan Flask API
python app.py
```

API akan berjalan di `http://127.0.0.1:5000`. Model BERT akan diunduh otomatis dari HuggingFace pada saat pertama kali dijalankan (~500 MB).

---

## Akun Default

Setelah menjalankan seeder, gunakan kredensial berikut untuk login sebagai admin:

| Field | Nilai |
|---|---|
| Email | `ardanasmirza@batam.go.id` |
| Password | `password` |

> **Penting:** Ganti password default setelah pertama kali login di lingkungan produksi.

---

## Struktur Direktori

```
sikap/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller area admin (dashboard, survei, ekspor, manajemen admin)
│   │   ├── AuthController.php
│   │   └── PublicController.php   # Controller area publik (responden)
│   ├── Models/             # Eloquent models (Survey, Question, Answer, dll)
│   └── Exports/            # Kelas ekspor Excel
├── database/
│   ├── migrations/         # Skema database
│   └── seeders/            # Data awal (admin, survei contoh)
├── resources/views/
│   ├── admin/              # Tampilan area admin
│   ├── public/             # Tampilan area publik
│   └── auth/               # Halaman login
├── routes/
│   └── web.php             # Definisi semua route
└── sikap-sentiment/        # Microservice analisis sentimen (Python/Flask)
```

---

## Lisensi

Proyek ini dikembangkan untuk keperluan internal **Diskominfo Kota Batam**.
