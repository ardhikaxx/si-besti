# 😴 Website SI-BESTI - Sistem Bimbing & Evaluasi Siklus Tidur Ibu

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind](https://img.shields.io/badge/Tailwind-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-Proprietary-red?style=for-the-badge)](./LICENSE)
[![Author](https://img.shields.io/badge/Author-Yanuar%20Ardhika%20Rahmadhani%20Ubaidillah-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ardhikaxx)

Aplikasi **SI-BESTI (Sistem Bimbingan & Evaluasi Siklus Tidur Ibu)** adalah media edukasi & skrining kualitas tidur ibu hamil dan menyusui. Dilengkapi materi bimbingan, kuesioner kualitas tidur, skor otomatis, riwayat evaluasi, dan pemantauan oleh tenaga kesehatan.

---

## ✨ Fitur Utama

### 1. 🔑 Autentikasi & Profil Ibu
- Registrasi/login ibu dengan data kehamilan/menyusui.

### 2. 📖 Bimbingan Tidur
- Materi edukasi higiene tidur, posisi tidur aman, dan manajemen kelelahan.

### 3. 📝 Evaluasi Kualitas Tidur
- Kuesioner terstruktur dengan skoring otomatis & kategori kualitas tidur.

### 4. 📈 Riwayat & Grafik
- Riwayat evaluasi dengan tren skor untuk pemantauan mandiri.

### 5. 🩺 Pemantauan Nakes
- Dashboard tenaga kesehatan untuk memantau ibu risiko dan tindak lanjut.

---

## 👥 Hak Akses Pengguna (Role-Based Access Control)

| Role | Akses & Wewenang |
| :--- | :--- |
| **Ibu** | Akses materi, isi evaluasi, lihat riwayat & rekomendasi. |
| **Tenaga Kesehatan/Admin** | Kelola materi, pantau hasil evaluasi, kelola pengguna. |

> Otorisasi ditegakkan di backend (middleware/Policy) — bukan sekadar menyembunyikan menu.

---

## 🛠️ Tech Stack & Dependensi

* **Backend**: Laravel 12.x (PHP 8.2+)
* **Database**: MySQL 8.0+
* **Frontend**: Blade, {css}, SweetAlert2, vanilla JS/Chart.js
* **Testing**: PHPUnit / Pest
* **Code Style**: Laravel Pint (PSR-12)

---

## ⚙️ Panduan Instalasi & Menjalankan Aplikasi

### 1. Kloning Repositori
```bash
git clone https://github.com/ardhikaxx/si-besti
cd si-besti
```

### 2. Install Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan koneksi database MySQL di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=si_besti
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeding
```bash
php artisan migrate --seed
```
Development (database boleh dikosongkan):
```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan Server Lokal
```bash
php artisan serve
```
Buka: `http://127.0.0.1:8000`

---

## 📚 Dokumentasi Sistem

* [⚖️ **LICENSE**](./LICENSE) — Lisensi resmi **Proprietary Software License (All Rights Reserved)**.
* [🛡️ **SECURITY.md**](./SECURITY.md) — Kebijakan keamanan & pelaporan celah (*Responsible Disclosure*).
* [🤝 **CONTRIBUTING.md**](./CONTRIBUTING.md) — Pedoman kontribusi kode & standar.
* [📜 **CODE_OF_CONDUCT.md**](./CODE_OF_CONDUCT.md) — Pedoman perilaku komunitas pengembang.
* [💬 **SUPPORT.md**](./SUPPORT.md) — Kanal bantuan teknis & komunikasi resmi pengembang.
* [📋 **CHANGELOG.md**](./CHANGELOG.md) — Riwayat rilis fitur terstruktur (*Keep a Changelog* & SemVer).
* [📚 **CITATION.md**](./CITATION.md) — Format sitasi karya untuk keperluan akademik.

---

## 💖 Dukungan & Donasi

Jika proyek **Website SI-BESTI - Sistem Bimbing & Evaluasi Siklus Tidur Ibu** ini bermanfaat bagi Anda dan telah menghemat banyak jam kerja Anda, Anda dapat menunjukkan apresiasi dengan memberikan traktiran kopi (donasi) melalui pemindaian kode QRIS di bawah ini:

<p align="center">
  <img src="./qris.png" alt="QRIS Donasi" width="300"/>
</p>

> Donasi sepenuhnya bersifat sukarela dan tidak mengikat. Aplikasi tetap dapat digunakan secara utuh tanpa donasi.

---

## ⚠️ Ketentuan Penggunaan

Proyek ini dilindungi lisensi **Proprietary Software License (All Rights Reserved)**. Anda **dilarang** menyalin, memodifikasi, mendistribusikan ulang, atau menjual kode ini tanpa izin tertulis dari pemilik hak cipta. Lihat [LICENSE](./LICENSE) untuk detail lengkap.

---

## 👨‍💻 Pengembang & Hak Cipta

Dirancang dan dikembangkan dengan penuh dedikasi oleh:
**[Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx)](https://github.com/ardhikaxx)**
*Lead Software Architect & Maintainer*

> **Copyright (c) 2024 - 2026 Yanuar Ardhika Rahmadhani Ubaidillah (@ardhikaxx). All Rights Reserved.**
