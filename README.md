# Sistem Absensi Siswa - Darul Ilmi

Sistem Absensi Siswa adalah platform absensi modern berbasis web yang dibangun menggunakan Laravel. Proyek ini memfasilitasi pencatatan kehadiran siswa dengan fitur pemindaian QR code dan notifikasi otomatis.

## 🚀 Cara Menjalankan Proyek (Setup Guide)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal (komputer/laptop) Anda setelah melakukan clone dari repository.

### 📋 Prasyarat Sistem
Pastikan komputer Anda sudah terinstal:
- **PHP** (minimal versi 8.1 atau terbaru)
- **Composer** (untuk manajemen dependensi PHP)
- **Node.js & NPM** (untuk manajemen aset frontend)
- **Database Server** (MySQL/MariaDB, bisa menggunakan XAMPP, Laragon, dll)
- **Git**

---

### 🛠️ Langkah-langkah Instalasi

**1. Clone Repository**
Buka terminal/command prompt, lalu jalankan perintah berikut:
```bash
git clone https://github.com/devoralofficial-tech/absensi-siswa-Darul-Ilmi.git
cd absensi-siswa-Darul-Ilmi
```

**2. Install Dependensi PHP (Composer)**
Jalankan perintah ini untuk mengunduh semua paket backend yang dibutuhkan Laravel:
```bash
composer install
```

**3. Install Dependensi Frontend (NPM)**
Jalankan perintah ini untuk mengunduh paket frontend dan mengompilasi aset (CSS/JS):
```bash
npm install
npm run build
```
*(Catatan: Anda juga bisa menggunakan `npm run dev` jika ingin menjalankan vite server untuk development)*

**4. Konfigurasi Environment (File `.env`)**
Salin file konfigurasi contoh (`.env.example`) menjadi file utama (`.env`):
- **Windows (CMD/PowerShell):**
  ```cmd
  copy .env.example .env
  ```
- **Linux/Mac/Git Bash:**
  ```bash
  cp .env.example .env
  ```

**5. Generate Application Key**
Buat kunci unik untuk keamanan aplikasi Anda:
```bash
php artisan key:generate
```

**6. Konfigurasi Database**
- Buka aplikasi database Anda (misal: phpMyAdmin, DBeaver, dll) dan buat database baru (misalnya: `absensi_siswa`).
- Buka file `.env` di text editor (VS Code) dan sesuaikan bagian koneksi database:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=absensi_siswa   # Nama database yang baru Anda buat
  DB_USERNAME=root            # Username database Anda (default xampp/laragon biasanya 'root')
  DB_PASSWORD=                # Password database (kosongkan jika tidak ada password)
  ```

**7. Jalankan Migrasi dan Seeder (Database)**
Untuk membuat tabel di database beserta data awal (jika ada):
```bash
php artisan migrate --seed
```

**8. Hubungkan Storage (Storage Link)**
Agar file upload (seperti foto profil, bukti absen) bisa diakses secara publik:
```bash
php artisan storage:link
```

**9. Jalankan Server Lokal**
Mulai server bawaan Laravel:
```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui browser di alamat:
**[http://localhost:8000](http://localhost:8000)** atau **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

### 💡 Catatan Tambahan (Troubleshooting)
- Jika mengalami error terkait cache atau view, jalankan perintah: `php artisan optimize:clear`.
- Pastikan versi PHP yang Anda gunakan kompatibel dengan versi Laravel pada proyek ini.
- Jika ada anggota tim yang mengubah struktur tabel (migration) atau dependensi `composer.json` / `package.json`, pastikan untuk menjalankan `git pull`, lalu `composer install` / `npm install`, dan `php artisan migrate` kembali agar tetap up-to-date.
