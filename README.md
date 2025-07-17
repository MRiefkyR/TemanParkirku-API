# 🚗 TemanParkirku-API

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![PHP](https://img.shields.io/badge/PHP-8.1-blue)
![License](https://img.shields.io/github/license/MRiefkyR/TemanParkirku-API)
![Build](https://img.shields.io/badge/build-passing-brightgreen)

TemanParkirku-API adalah backend RESTful API berbasis Laravel yang dikembangkan untuk mendukung sistem manajemen parkir digital, termasuk pencatatan data kendaraan, tarif, pembayaran parkir, serta integrasi pembayaran melalui Midtrans. API ini mendukung autentikasi menggunakan Laravel Sanctum dan dirancang untuk diintegrasikan dengan aplikasi mobile (Android).

---

## 📦 Fitur Utama

- ✅ Registrasi & login pengguna
- 🚙 Pencatatan parkir masuk & keluar
- ⏱️ Perhitungan tarif otomatis
- 💳 Integrasi pembayaran Midtrans (Snap API)
- 🧾 Riwayat transaksi & laporan pembayaran
- 📦 API berbasis RESTful untuk komunikasi dengan aplikasi Android
- 🔐 Autentikasi token dengan Sanctum
- 👮‍♂️ Role management: Penjaga & Pelanggan
- 🔍 Scan QR Code untuk entry data plat nomor

---

## 🧭 Struktur Proyek

```bash
TemanParkirku-API/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   ├── Models/
├── config/
├── database/
│   ├── migrations/
├── routes/
│   ├── api.php
├── .env
├── composer.json
└── README.md
```
---

## 🧰 Teknologi yang Digunakan

- PHP 8.1+
- Laravel 10.x
- MySQL
- Laravel Sanctum
- Midtrans Snap API
- Postman (untuk pengujian API)
- Firebase (opsional, untuk autentikasi Android)

---

## 🚀 Instalasi

1. **Clone repositori**
```bash
git clone https://github.com/MRiefkyR/TemanParkirku-API.git
cd TemanParkirku-API
```
2. Install Dependensi
```bash
composer install
```
3. Copy and edit file environment
```bash
cp .env.example .env
php artisan key:generate
```
4. Konfiguras.env sesuai dengan database dan kredensial Midtrans:
```bash
DB_DATABASE=temanparkir
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_SERVER_KEY=YOUR_SERVER_KEY
MIDTRANS_CLIENT_KEY=YOUR_CLIENT_KEY
MIDTRANS_IS_PRODUCTION=false
```
5. Migrasi Database
```bash
php artisan migrate
```
6. Jalankan Aplikasi
```bash
php artisan serve
```
