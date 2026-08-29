<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-13-red" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-8.3%2B-777bb4" alt="PHP Version">
<img src="https://img.shields.io/badge/Filament-5.7-fdae4b" alt="Filament Version">
<img src="https://img.shields.io/badge/License-MIT-blue" alt="License">
</p>

# Travel Agent Booking Platform

Aplikasi web pemesanan paket wisata (tour package booking) berbasis Laravel. Pengunjung dapat menjelajahi destinasi, membaca artikel blog, melihat galeri, memesan paket tur, dan melakukan pembayaran online. Admin mengelola seluruh operasional lewat panel admin Filament.

## Fitur Utama

**Untuk pengunjung / customer:**
- Katalog paket tur & destinasi wisata
- Blog & galeri
- Registrasi dan login (termasuk **Login dengan Google** via Laravel Socialite)
- Proses booking paket tur dengan estimasi harga otomatis
- Pembayaran online terintegrasi **Midtrans Snap** (kartu kredit, e-wallet, VA, dll.)
- Dashboard akun customer: riwayat booking, invoice, ulasan (review), dan pengaturan profil

**Untuk admin (panel Filament):**
- Manajemen paket tur, jadwal keberangkatan (availability), destinasi, hotel, kendaraan
- Manajemen booking, invoice, dan pembayaran
- Manajemen blog, galeri, promosi, dan inquiry/kontak
- Role & permission (via Spatie Laravel Permission) — termasuk role `super_admin` dengan akses penuh

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 13 |
| Admin Panel | Filament 5 |
| Autentikasi | Laravel Breeze + Laravel Socialite (Google OAuth) |
| Payment Gateway | Midtrans (Snap) |
| Roles & Permissions | Spatie Laravel Permission |
| Frontend | Blade, Tailwind CSS 4, Alpine.js, Vite |
| Database | MySQL |

## Instalasi (Development)

```bash
# 1. Clone project
git clone <repo-url>
cd <nama-folder-project>

# 2. Install dependency PHP & JS
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi .env (lihat bagian "Environment Variables" di bawah)

# 5. Migrasi & seed database
php artisan migrate --seed

# 6. Jalankan server development (server + queue + vite sekaligus)
composer run dev
```

Aplikasi bisa diakses di `http://localhost:8000` (atau port sesuai `php artisan serve`).

## Environment Variables Penting

Selain konfigurasi standar Laravel (`DB_*`, `MAIL_*`, dsb), pastikan variabel berikut terisi:

```dotenv
# Google OAuth (untuk fitur "Login dengan Google")
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=https://domain-kamu.com/auth/google/callback

# Midtrans (payment gateway)
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

> ⚠️ **Server key & client key Midtrans berbeda antara mode Sandbox dan Production** — ambil dari dashboard yang sesuai (`dashboard.sandbox.midtrans.com` untuk development, `dashboard.midtrans.com` untuk production) dan jangan dicampur.

## Setup Webhook Pembayaran Midtrans

Agar status pembayaran otomatis ter-update (booking jadi lunas, invoice tercatat), Midtrans perlu mengirim notifikasi server-to-server ke aplikasi ini. Ini **wajib** dikonfigurasi, baik saat development (pakai tunnel) maupun production:

1. Login ke dashboard Midtrans (Sandbox atau Production sesuai environment).
2. Buka **Settings → Configuration → Payment Notification URL**.
3. Isi dengan:
   ```
   https://domain-kamu.com/midtrans/notification
   ```
4. Route ini (`/midtrans/notification`) sudah dikecualikan dari CSRF protection di `bootstrap/app.php` karena dipanggil langsung oleh server Midtrans, bukan browser pengguna.
5. Untuk development lokal, expose server kamu terlebih dahulu menggunakan tunnel (ngrok, Cloudflare Tunnel, dll.) agar server Midtrans bisa menjangkau endpoint tersebut.

## Deploy ke Production (di belakang reverse proxy / tunnel)

Jika aplikasi diakses lewat reverse proxy atau tunnel (Cloudflare Tunnel, Nginx proxy, dll.) yang meneruskan koneksi HTTPS sebagai HTTP secara internal, pastikan `trustProxies` sudah dikonfigurasi di `bootstrap/app.php` — jika tidak, Laravel akan salah mendeteksi skema URL (menghasilkan link `http://` di halaman `https://`) dan memicu error *mixed content* di browser.

Set juga:
```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-kamu.com
```

## Akses Panel Admin

Panel admin Filament dapat diakses di `/admin` (sesuaikan dengan path yang dikonfigurasi). Buat user dengan role `super_admin` melalui seeder atau tinker untuk mendapatkan akses penuh ke semua fitur admin.

## License

Project ini dibangun di atas framework [Laravel](https://laravel.com), yang merupakan open-source software berlisensi [MIT license](https://opensource.org/licenses/MIT).