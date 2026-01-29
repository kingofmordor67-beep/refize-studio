# Monster Adventure - Edisi CodeIgniter

Proyek ini telah dimigrasikan dari React/Node.js ke framework PHP kustom gaya CodeIgniter 4 untuk Laragon.

catatan: Proyek ini menggunakan backend PHP custom.

## Persyaratan Hosting

PENTING: Proyek ini TIDAK dapat berjalan di Firebase Hosting (paket gratis/statis) karena membutuhkan PHP untuk backend.

Anda membutuhkan server yang mendukung:
- PHP 7.4 atau lebih baru
- Database MySQL

Opsi hosting yang disarankan:
- Shared Hosting (cPanel)
- VPS (DigitalOcean, Linode)
- Heroku (dengan PHP buildpack)
- Railway / Render

## Instruksi Pengaturan

### 1. Pengaturan Database
1. Buka Laragon dan jalankan semua layanan (Apache, MySQL).
2. Buka HeidiSQL (atau klien SQL pilihan Anda).
3. Hubungkan ke server MySQL lokal Anda (default: user root, tanpa password).
4. Jalankan skrip pengaturan yang terletak di:
   database/setup.sql
   
   Ini akan membuat database refize_studio dan mengisinya dengan:
   - Pengguna (Admin & User Tes)
   - Berita (Contoh changelog)
   - Pelanggan

### 2. Konfigurasi
Salin file konfigurasi CMS:
cp cms/sanity-config.example.php cms/sanity-config.php

Edit cms/sanity-config.php dan masukkan kredensial Sanity CMS Anda (Project ID, Dataset, Token).

### 3. Akses Situs
Karena Anda menggunakan Laragon, situs seharusnya tersedia secara otomatis di:
http://refize-studio.test

(Jika auto-virtual hosts dinonaktifkan, buka http://localhost/refize-studio/)

---

## Kredensial Default

### Akun Admin
- Email: admin@refize.com
- Password: admin123

### Akun User
- Email: user@refize.com
- Password: admin123

---

## Struktur Proyek

- app/ - Logika aplikasi inti (MVC)
  - Controllers/ - Menangani permintaan (Home, Auth, News)
  - Models/ - Interaksi database
  - Views/ - Template HTML
- public/ - Aset statis (CSS, JS)
- cms/ - Integrasi Sanity CMS
- database/ - Skrip SQL

## Fitur

- Autentikasi: Login, Daftar, Lupa Password
- Cerita Evolusioner: Carousel karakter dengan efek tilt 3D
- Log Permainan: Sistem berita dengan buat/edit/hapus (Khusus Admin)
- Pelacakan Mata: Monster SVG Interaktif (Kucing Programmer)
- Desain Responsif: Tata letak ramah seluler dengan dukungan giroskop
