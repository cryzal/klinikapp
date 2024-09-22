# klinik app Project Setup

## 1. Instalasi Dependencies
Untuk menginstal semua dependencies yang diperlukan oleh Laravel, jalankan perintah berikut:

```bash
composer install
```
## 2. Mengatur File .env
Buat file .env dengan menyalin dari .env.example. Setelah itu, sesuaikan pengaturan database dengan lingkungan lokal Anda. Kemudian, buka file `.env` dan ubah bagian berikut sesuai dengan konfigurasi database lokal Anda:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={{nama_database_anda}}
DB_USERNAME={{nama_username_anda}}
DB_PASSWORD={{password_anda}}
```

## 3. Generate Key Aplikasi
```bash
php artisan key:generate
```

## 4. Migrasi Database
Setelah mengatur konfigurasi database, jalankan migrasi untuk membuat tabel-tabel di database:
```bash
php artisan migrate
```

Jalankan seeder untuk mengisi database dengan data awal:
```bash
php artisan db:seed --class=UserSeeder
```

## 5. jalankan aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di http://localhost:8000 secara default.

Untuk halaman login, masuk ke http://localhost:8000/login

```bash
dokter
username : dokter@example.com
password : password

apoteker
username : apoteker@example.com
password : password
```


