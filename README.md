# SIMONITORING BBM

Sistem Informasi Monitoring Distribusi dan Ketersediaan Stok BBM Berbasis Web — studi kasus PT Pertamina.

Dibangun dengan **Laravel 10**, Blade + **Tailwind CSS** (via CDN, tanpa proses build), **Alpine.js** untuk interaktivitas ringan, dan **Chart.js** untuk visualisasi data dashboard.

---

## 1. Isi Paket Ini

Folder/berkas yang disertakan dalam arsip ini **hanya berisi kode aplikasi**, bukan skeleton Laravel lengkap:

```
app/         → Models, Controllers, Middleware (logika aplikasi)
database/    → Migrations & Seeders (struktur dan data dummy)
resources/   → Views Blade (seluruh tampilan UI)
routes/      → web.php (definisi route)
.env.example → Contoh konfigurasi environment
```

Berkas-berkas inti Laravel lainnya (`vendor/`, `bootstrap/`, `public/`, `config/`, `composer.json`, dll.) **tidak disertakan** karena berkas tersebut dihasilkan otomatis oleh Composer saat instalasi Laravel, dan ukurannya besar / tidak spesifik untuk aplikasi ini. Ikuti langkah instalasi di bawah untuk menggabungkan kode ini ke dalam skeleton Laravel yang baru.

---

## 2. Kebutuhan Sistem

- PHP ≥ 8.1 beserta ekstensi umum (mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath)
- Composer 2.x
- Ekstensi PHP **pdo_sqlite** (jika memakai SQLite — direkomendasikan) atau **pdo_mysql** (jika memakai MySQL)

---

## 3. Langkah Instalasi

### Langkah 1 — Buat skeleton Laravel baru

```bash
composer create-project laravel/laravel:^10.10 simonitoring-bbm
cd simonitoring-bbm
```

### Langkah 2 — Salin kode aplikasi dari arsip ini

Ekstrak arsip `simonitoring-bbm-source.zip`, lalu **timpa (overwrite)** folder berikut ke dalam folder proyek Laravel yang baru dibuat pada Langkah 1:

```
app/        → timpa ke simonitoring-bbm/app/
database/   → timpa ke simonitoring-bbm/database/
resources/  → timpa ke simonitoring-bbm/resources/
routes/     → timpa ke simonitoring-bbm/routes/
```

> Konfirmasi "replace/overwrite" jika diminta oleh file manager / terminal Anda.

### Langkah 3 — Daftarkan middleware `role`

Buka `app/Http/Kernel.php` pada proyek Laravel Anda. Ada dua cara:

**Cara termudah:** timpa seluruh isi `app/Http/Kernel.php` dengan isi `app/Http/Kernel.php` yang ada di arsip ini (sudah lengkap dan sudah termasuk pendaftaran middleware `role`).

**Atau cara manual:** tambahkan baris berikut ke dalam array `$middlewareAliases` yang sudah ada di `Kernel.php` bawaan Laravel Anda:

```php
'role' => \App\Http\Middleware\CheckRole::class,
```

Tanpa langkah ini, seluruh route yang memakai `->middleware('role:admin')` pada `routes/web.php` akan menghasilkan error.

### Langkah 4 — Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Lalu, **pilih salah satu**:

**Opsi A — SQLite (paling mudah, direkomendasikan):**
```bash
touch database/database.sqlite
```
Pastikan `.env` Anda berisi `DB_CONNECTION=sqlite` (sudah default pada `.env.example` yang disertakan).

**Opsi B — MySQL/MariaDB:**
Buat database baru bernama `simonitoring_bbm`, lalu sesuaikan `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di `.env` (lihat komentar di dalam `.env.example`).

### Langkah 5 — Migrasi & seed data dummy

```bash
php artisan migrate --seed
```

Perintah ini akan membuat seluruh tabel (depots, spbus, users, jenis_bbms, stok_depots, stok_spbus, distribusis) dan mengisinya dengan data contoh: 4 terminal BBM, 8 SPBU, 6 jenis BBM, 4 akun pengguna demo, data stok awal, dan riwayat distribusi 15 hari terakhir.

### Langkah 6 — Jalankan server

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000` di browser.

---

## 4. Akun Demo

Seluruh akun di bawah menggunakan password yang sama: **`password123`**

| Email | Peran | Akses |
|---|---|---|
| admin@pertamina.test | Admin | Akses penuh ke seluruh modul |
| operator.depot@pertamina.test | Operator Terminal (Depot) | Kelola stok depot & proses distribusi |
| operator.spbu@pertamina.test | Operator SPBU | Lihat & kelola stok SPBU |
| pimpinan@pertamina.test | Pimpinan | Akses lihat dashboard & laporan |

---

## 5. Struktur Modul Aplikasi

- **Dashboard** — ringkasan KPI, grafik tren distribusi 7 hari, grafik status, perbandingan stok depot vs SPBU per jenis BBM, dan peringatan stok menipis.
- **Data Master** (khusus Admin) — Terminal BBM (Depot), SPBU, Jenis BBM, Pengguna.
- **Stok Terminal (Depot)** — kelola volume tangki per jenis BBM di setiap terminal, divisualisasikan dengan gauge melingkar.
- **Stok SPBU** — pantau stok SPBU; volume bertambah otomatis saat distribusi diterima (tidak diisi manual).
- **Distribusi BBM** — alur kerja permintaan→proses→kirim→terima, dengan stok depot otomatis berkurang saat status "Dikirim" dan stok SPBU otomatis bertambah saat status "Diterima".
- **Laporan** — rekap distribusi berdasarkan rentang tanggal, terminal, SPBU, jenis BBM, dan status.

---

## 6. Catatan Teknis

- Tailwind CSS, Alpine.js, dan Chart.js dimuat melalui CDN — **tidak diperlukan `npm install` atau proses build** apa pun.
- Hak akses (role-based access) diterapkan di level route melalui middleware `role`, dengan 4 peran: `admin`, `operator_depot`, `operator_spbu`, `pimpinan`.
- Kode distribusi dibuat otomatis dengan format `DIST-YYYYMMDD-XXXX`.
- Validasi penting: jumlah pengiriman tidak boleh melebihi stok depot yang tersedia; transisi status distribusi mengikuti urutan baku (menunggu → diproses → dikirim → diterima, atau dibatalkan pada tahap menunggu/diproses).
