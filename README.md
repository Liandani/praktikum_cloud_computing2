# TaskFlow – Aplikasi Manajemen Tugas Mahasiswa (Laravel & MySQL)

Aplikasi web full-stack modern berbasis **PHP Laravel** dan **MySQL** yang dirancang untuk mengelola daftar tugas kuliah secara responsif, mudah dipahami untuk praktikum, dan siap dihubungkan ke server lokal (XAMPP) maupun di-deploy ke **Microsoft Azure App Service**.

---

## Daftar Isi
1. [Fitur Utama](#fitur-utama)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Struktur Direktori Proyek](#struktur-direktori-proyek)
4. [Panduan Menjalankan di Lokal (XAMPP & MySQL)](#panduan-menjalankan-di-lokal-xampp--mysql)
   - [Langkah 1: Nyalakan Apache & MySQL di XAMPP](#langkah-1-nyalakan-apache--mysql-di-xampp)
   - [Langkah 2: Buat Database MySQL (phpMyAdmin)](#langkah-2-buat-database-mysql-phpmyadmin)
   - [Langkah 3: Periksa File `.env`](#langkah-3-periksa-file-env)
   - [Langkah 4: Jalankan Composer & Migrasi Data](#langkah-4-jalankan-composer--migrasi-data)
   - [Langkah 5: Jalankan Server Laravel](#langkah-5-jalankan-server-laravel)
5. [Pengujian Fitur CRUD & Health Check](#pengujian-fitur-crud--health-check)
6. [Panduan Deployment ke Azure App Service](#panduan-deployment-ke-azure-app-service)
7. [Troubleshooting Kendala Umum](#troubleshooting-kendala-umum)

---

## Fitur Utama

- **Create**: Formulir penambahan tugas baru dengan validasi judul tugas, mata kuliah, deskripsi, tanggal batas waktu (*deadline*), dan status awal.
- **Read**:
  - Dashboard statistik interaktif: Total Tugas, Sedang Dikerjakan, Belum Dikerjakan, Selesai, dan persentase progres penyelesaian.
  - Fitur pencarian fleksibel (*search bar*) berdasarkan judul tugas, mata kuliah, maupun deskripsi.
  - Penyaringan (*filter*) data berdasarkan status pengerjaan.
  - Pengurutan (*sorting*) berdasarkan deadline terdekat/terjauh, tanggal dibuat, dan abjad judul.
  - Pilihan tampilan ganda: **Tampilan Tabel (Table View)** dan **Tampilan Kartu (Card View)**.
- **Update**:
  - Formulir pengeditan lengkap untuk memperbarui seluruh data tugas.
  - *Quick Status Switcher*: Ubah status tugas secara langsung dari dropdown tabel/kartu tanpa harus membuka halaman edit.
- **Delete**:
  - Penghapusan tugas dilengkapi dengan **Modal Konfirmasi Interaktif** Bootstrap 5 untuk mencegah penghapusan data secara tidak sengaja.
- **Health Check Endpoint (`/health`)**:
  - Endpoint JSON untuk mengecek status aplikasi dan memverifikasi koneksi database MySQL aktif.

---

## Teknologi yang Digunakan

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend Framework** | PHP 8.2+ / Laravel 11 | Framework PHP modern berstandar industri |
| **Database** | MySQL (XAMPP / MariaDB / Azure MySQL) | Basis data relasional |
| **Frontend UI** | HTML5, CSS3, JavaScript | Struktur semantik & interaksi dinamis |
| **CSS Framework** | Bootstrap 5.3.3 & Bootstrap Icons | Desain responsif, mobile-friendly & profesional |
| **Palet Desain** | Deep Navy Blue (`#0f2b48`), Putih, Sky Blue (`#0284c7`) | Tampilan modern & minimalis |
| **Cloud Hosting** | Microsoft Azure App Service (PHP Linux) | PaaS Deployment Ready |

---

## Struktur Direktori Proyek

```text
CRUD CloudComputing/
├── app/
│   ├── Http/Controllers/
│   │   ├── Controller.php
│   │   └── TaskController.php       # Controller CRUD & Health Check
│   └── Models/
│       └── Task.php                 # Model Eloquent Tabel Tasks
├── bootstrap/
│   └── app.php                      # Bootstrap aplikasi Laravel
├── config/
│   ├── app.php                      # Konfigurasi aplikasi & timezone (Asia/Jakarta)
│   └── database.php                 # Konfigurasi koneksi MySQL & Azure SQL
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000000_create_tasks_table.php  # Skema tabel tasks
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   └── TaskSeeder.php           # Data awal contoh tugas kuliah mahasiswa
│   └── taskflow.sql                 # SQL dump siap import langsung di phpMyAdmin!
├── public/
│   ├── css/
│   │   └── style.css                # Styling kustom modern biru tua & aksen biru muda
│   ├── js/
│   │   └── main.js                  # Skrip interaksi (modal hapus, switcher view, alerts)
│   ├── .htaccess
│   └── index.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php        # Layout induk Blade (Navbar, Flash alerts, Footer)
│       ├── tasks/
│       │   ├── index.blade.php      # Halaman dashboard (tabel & kartu tugas, filter)
│       │   ├── create.blade.php     # Formulir Tambah Tugas
│       │   └── edit.blade.php       # Formulir Edit Tugas
│       └── errors/
│           ├── 404.blade.php        # Halaman Not Found
│           └── 500.blade.php        # Halaman Database / Server Error
├── routes/
│   ├── web.php                      # Definisi rute web CRUD & health check
│   ├── api.php
│   └── console.php
├── .env                             # File environment lokal MySQL
├── .env.example                     # Contoh template environment
├── .gitignore                       # File yang diabaikan git
├── artisan                          # Laravel CLI executable
├── composer.json                    # Konfigurasi dependensi Composer
└── README.md                        # Dokumentasi lengkap
```

---

## Panduan Menjalankan di Lokal (XAMPP & MySQL)

### Langkah 1: Nyalakan Apache & MySQL di XAMPP
1. Buka aplikasi **XAMPP Control Panel** di komputer Anda.
2. Klik tombol **Start** pada modul **Apache** dan **MySQL** hingga indikator berwarna hijau.

---

### Langkah 2: Buat Database MySQL (phpMyAdmin)
Anda memiliki dua cara mudah:

#### Cara A: Import File SQL Siap Pakai (Paling Mudah)
1. Buka browser dan buka **[http://localhost/phpmyadmin](http://localhost/phpmyadmin)**.
2. Klik tab **Import** di menu atas.
3. Klik **Choose File** -> pilih file `database/taskflow.sql` yang ada di dalam folder proyek ini.
4. Klik tombol **Import** di bagian bawah. Database `taskflow` dan tabel `tasks` beserta 5 data contoh mahasiswa akan otomatis terbuat!

*Atau*

#### Cara B: Buat Database Kosong
1. Buka **[http://localhost/phpmyadmin](http://localhost/phpmyadmin)**.
2. Klik menu **Databases** (Basis Data).
3. Buat database baru dengan nama `taskflow` dan pilih collation `utf8mb4_unicode_ci`, lalu klik **Create**.

---

### Langkah 3: Periksa File `.env`
File `.env` sudah dikonfigurasikan sesuai pengaturan default XAMPP:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taskflow
DB_USERNAME=root
DB_PASSWORD=
```
*(Secara default XAMPP username adalah `root` dan password kosong).*

---

### Langkah 4: Jalankan Composer & Migrasi Data

Buka terminal di folder proyek ini:
```bash
cd "/Users/lian/Documents/CRUD CloudComputing"
```

1. **Unduh Paket Vendor Laravel**:
   ```bash
   composer install
   ```
   *(Jika perintah `composer` belum ada di terminal macOS, Anda bisa memasangnya lewat Homebrew: `brew install composer`)*.

2. **Jalankan Migrasi & Data Seeder** *(Jika tidak menggunakan cara import phpMyAdmin)*:
   ```bash
   php artisan migrate --seed
   ```

---

### Langkah 5: Jalankan Server Laravel

Jalankan perintah berikut di terminal:
```bash
php artisan serve
```

Aplikasi Anda kini aktif! Buka browser dan akses:
- **Dashboard Tugas**: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**
- **Health Check Endpoint**: **[http://127.0.0.1:8000/health](http://127.0.0.1:8000/health)**

---

## Pengujian Fitur CRUD & Health Check

1. **Uji Health Check Endpoint**:
   - Kunjungi `http://127.0.0.1:8000/health`
   - Pastikan muncul JSON:
     ```json
     {
       "status": "healthy",
       "application": "TaskFlow – Laravel Edition",
       "framework": "Laravel 11.x",
       "database": {
         "status": "connected",
         "driver": "mysql"
       }
     }
     ```

2. **Uji Tambah Tugas (Create)**:
   - Klik tombol **Tambah Tugas Baru** di navbar atau dashboard.
   - Isi judul tugas: misal *"Tugas Cloud Computing: Deploy Laravel"*, mata kuliah: *"Cloud Computing"*, pilih tanggal batas waktu, dan status.
   - Klik **Tambahkan Tugas**. Pesan sukses akan muncul dan data tersimpan di tabel MySQL.

3. **Uji Tampilan & Pencarian (Read)**:
   - Ketikkan kata kunci di kolom pencarian (misal *"Cloud"* atau *"Jurnal"*).
   - Filter berdasarkan status (misal pilih *"Sedang Dikerjakan"*).
   - Klik tombol switcher tampilan untuk berpindah dari **Tabel** ke **Kartu (Card)**.

4. **Uji Ubah Status & Edit (Update)**:
   - Pada dropdown status di kolom tabel atau kartu tugas, ubah status menjadi *"Selesai"*.
   - Perhatikan persentase pada progress bar otomatis meningkat.
   - Klik tombol **Edit** (ikon pensil), ubah deskripsi tugas, lalu klik **Simpan Perubahan**.

5. **Uji Hapus Tugas (Delete)**:
   - Klik tombol **Hapus** (ikon tempat sampah).
   - Modal konfirmasi akan muncul dengan menampilkan judul tugas.
   - Klik tombol **Ya, Hapus Tugas**. Data akan dihapus secara permanen dari database MySQL.

---

## Panduan Deployment ke Azure App Service

1. **Buat Azure Database for MySQL atau Azure SQL**:
   - Di Azure Portal, buat **Azure Database for MySQL flexible server** (atau Azure SQL Database).
   - Pada menu **Networking**, izinkan akses: centang **"Allow public access from any Azure service within Azure to this server"**.
2. **Buat Web App di Azure**:
   - Runtime stack: **PHP 8.2** atau **PHP 8.3**.
   - Operating System: **Linux**.
3. **Konfigurasi Environment Variables di Azure App Service**:
   - Pada menu **Settings** -> **Environment variables**, tambahkan:
     - `APP_KEY`: Salin dari file `.env`.
     - `APP_ENV`: `production`
     - `APP_DEBUG`: `false`
     - `DB_CONNECTION`: `mysql`
     - `DB_HOST`: Host server database Azure Anda.
     - `DB_DATABASE`: `taskflow`
     - `DB_USERNAME`: Username admin database.
     - `DB_PASSWORD`: Password database.
4. **Deploy Kode**:
   - Hubungkan ke GitHub via **Deployment Center** menggunakan workflow yang telah disediakan di [.github/workflows/azure-deploy.yml](file:///Users/lian/Documents/CRUD%20CloudComputing/.github/workflows/azure-deploy.yml).

---

## Troubleshooting Kendala Umum

### 1. `SQLSTATE[HY000] [2002] Connection refused`
- **Penyebab**: MySQL di XAMPP belum menyala atau port berbeda.
- **Solusi**: Pastikan modul MySQL di XAMPP Control Panel sudah dalam kondisi *Running* (port 3306).

### 2. `SQLSTATE[42S02]: Base table or view not found: Table 'taskflow.tasks' doesn't exist`
- **Penyebab**: Database `taskflow` sudah dibuat tapi tabelnya belum di-import/di-migrate.
- **Solusi**: Import file `database/taskflow.sql` melalui phpMyAdmin, atau jalankan `php artisan migrate --seed` di terminal.

### 3. Composer belum terpasang di Mac
- Jalankan di terminal:
  ```bash
  brew install composer
  ```
# praktikum_cloud_computing2
