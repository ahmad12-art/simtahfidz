# SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an

Aplikasi manajemen hafalan Al-Qur'an berbasis Laravel 12 untuk membantu guru tahfidz mengelola target hafalan, setoran, murajaah, penilaian, dan laporan santri secara digital.

Dokumen analisis & desain lengkap (use case, ERD, wireframe, roadmap) tersedia terpisah pada `SIMTAHFIDZ_Dokumen_Perencanaan.md`.

## Teknologi

- Laravel 12, PHP 8.3+
- MySQL
- Bootstrap 5 + Bootstrap Icons (custom layout bergaya AdminLTE, dimuat via CDN)
- Chart.js untuk grafik dashboard
- barryvdh/laravel-dompdf untuk export PDF
- maatwebsite/excel untuk export Excel
- simplesoftwareio/simple-qrcode untuk QR Code santri (opsional, kolom `qr_code` sudah disiapkan)

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate

# Sesuaikan kredensial database MySQL pada file .env, lalu:
php artisan migrate
php artisan db:seed
php artisan db:seed --class=Database\\Seeders\\DemoDataSeeder   # opsional: data contoh untuk demo

php artisan storage:link
php artisan serve
```

## Akun Default (setelah `db:seed`)

| Role  | Username | Password |
|-------|----------|----------|
| Admin | `admin`  | `password` |
| Guru  | `guru1`  | `password` |

**Wajib ganti password default sebelum digunakan di lingkungan produksi.**

## Struktur Penting

- `app/Services/PenilaianService.php` — satu-satunya sumber kebenaran untuk rumus bobot nilai (Kelancaran 40%, Tajwid 30%, Makhraj 20%, Adab 10%).
- `app/Services/ProgressTargetService.php` — menghitung ulang persentase & status Target Hafalan setiap ada Setoran baru/diubah/dihapus.
- `app/Traits/HasSearchFilterSort.php` — scope Eloquent reusable untuk pencarian, filter, dan sorting di semua halaman index.
- `app/Policies/*` — otorisasi granular agar Guru hanya mengelola data santri binaannya sendiri, sementara Admin memiliki akses penuh.
- `routes/web.php` — satu resource route untuk modul yang dipakai bersama Admin & Guru (Target/Setoran/Murajaah/Penilaian), dibatasi lebih lanjut lewat Policy, bukan route terpisah.

## Backup Database

Command `php artisan backup:database` (dipanggil dari menu Pengaturan) menjalankan `mysqldump` dan menyimpan hasilnya ke `storage/app/backups/`. Pastikan binary `mysqldump` tersedia di PATH server produksi.

## Pengembangan Lanjutan

Lihat bagian **Roadmap Pengembangan** pada dokumen perencanaan untuk fase v2: portal login santri, notifikasi WhatsApp Gateway, dan API mobile berbasis Laravel Sanctum.
