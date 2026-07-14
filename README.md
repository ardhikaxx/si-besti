# SI-BESTI
Sistem Bimbingan & Evaluasi Siklus Tidur Ibu
(SI-BESTI — Sistem Bimbingan & Evaluasi untuk Siklus Tidur Ibu)

[![Status](https://img.shields.io/badge/status-beta-yellow.svg)](https://github.com/ardhikaxx/si-besti)
[![Laravel](https://img.shields.io/badge/laravel-%5E8.0-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/php-8.0%2B-brightgreen.svg)](https://www.php.net/)
[![Blade](https://img.shields.io/badge/blade-66%25-ff69b4.svg)]()
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)]()

---

Aplikasi web untuk membantu ibu memantau, mengevaluasi, dan memperbaiki pola tidur melalui catatan harian, evaluasi berkala, serta rekomendasi praktis. Dirancang sederhana dan ramah untuk pengguna maupun tenaga kesehatan.

---

## Fitur Utama
### Pengguna (Ibu)
- Autentikasi pengguna (login & registrasi).
- Dashboard ringkas untuk melihat ringkasan data.
- Pencatatan sleep tracking (tambah, ubah, hapus, dan detail).
- Statistik sleep tracking.
- Quality Test (pengisian tes, konfirmasi, dan hasil histori).
- Murottal untuk relaksasi.
- Profil pengguna (update data diri).

### Admin
- Autentikasi admin.
- Manajemen data ibu (lihat, detail, ubah status, hapus).
- Statistik data ibu.
- Monitoring sleep tracking pengguna & detail tidur.
- Profil admin & update password.

---

## Teknologi & Komposisi Bahasa
- Framework: Laravel (Blade templates)
- Bahasa backend: PHP
- Bahasa frontend: HTML / CSS / JS di Blade views
- Database: MySQL
- Tooling: Composer, Vite

Komposisi bahasa repo:
- Blade: 66.3%
- PHP: 33.4%
- Other: 0.3%

---

## Struktur Direktori (Ringkas)
- `app/` — controller, model, middleware.
- `routes/` — definisi routing aplikasi.
- `resources/views/` — tampilan Blade untuk pengguna & admin.
- `database/` — migrasi & seeder.
- `public/` — aset publik.

---

## Instalasi Cepat
Prasyarat: PHP 8+, Composer, MySQL, Node.js (opsional)

1. Clone repo
```bash
git clone https://github.com/ardhikaxx/si-besti.git
cd si-besti
```

2. Install dependensi PHP
```bash
composer install
```

3. Environment
```bash
cp .env.example .env
php artisan key:generate
# edit .env untuk DB_*, APP_URL, dsb.
```

4. Migrasi & seed (jika ada)
```bash
php artisan migrate
php artisan db:seed
```

5. (Opsional) Build assets
```bash
npm install
npm run dev   # atau npm run build
```

6. Jalankan server
```bash
php artisan serve
# Buka http://127.0.0.1:8000
```

---

## Akun Default (Jika Dikonfigurasi)
Jika project menyediakan seeder akun admin/pengguna, sertakan kredensialnya di sini. Jika tidak ada, silakan buat melalui halaman registrasi.

---


## Donasi

Jika project ini bermanfaat, Anda dapat mendukung pengembangan selanjutnya melalui donasi:

<div align="center">

![QRIS](public/assets/qris.png)

**Scan QRIS di atas untuk berdonasi**

Setiap donasi akan digunakan untuk:
- Pengembangan fitur baru
- Perbaikan bug & maintenance
- Infrastruktur server

</div>

## Lisensi
Proyek ini menggunakan lisensi MIT.