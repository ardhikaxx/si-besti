# SI-BESTI
Sistem Bimbingan & Evaluasi Siklus Tidur Ibu  
(SI-BESTI — Sistem Bimbingan & Evaluasi untuk Siklus Tidur Ibu)

[![Status](https://img.shields.io/badge/status-beta-yellow.svg)](https://github.com/ardhikaxx/si-besti)
[![Laravel](https://img.shields.io/badge/laravel-%5E8.0-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/php-8.0%2B-brightgreen.svg)](https://www.php.net/)
[![Blade](https://img.shields.io/badge/blade-66%25-ff69b4.svg)]()  
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)]()

---

Sebuah aplikasi web untuk membantu ibu memantau, mengevaluasi, dan memperbaiki pola tidur melalui catatan harian, evaluasi berkala, dan rekomendasi praktis. Dirancang sederhana dan ramah untuk pengguna maupun tenaga kesehatan.

---

## Teknologi & Komposisi Bahasa
- Framework: Laravel (Blade templates)
- Bahasa backend: PHP
- Bahasa frontend: HTML / CSS / JS di Blade views
- Database: MySQL
- Tooling: Composer

Komposisi bahasa repo:
- Blade: 66.3%  
- PHP: 33.4%  
- Other: 0.3%

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