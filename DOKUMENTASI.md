# 📋 Sistem Absensi BPKAD - Dokumentasi Lengkap

## 🎯 Fitur Utama

### 1. **Autentikasi User (Login & Register)**

-   User dapat mendaftar akun baru
-   Login dengan email dan password
-   Password dienkripsi dengan aman

### 2. **Sistem Absensi dengan Batasan Waktu**

-   ⏰ **Deadline Check-in: 08:00 pagi**
-   Absensi sebelum jam 08:00 → Status: **HADIR**
-   Absensi setelah jam 08:00 → Status: **TERLAMBAT**
-   Fitur Check-in dan Check-out
-   Riwayat absensi bulanan

### 3. **Admin Dashboard**

-   Melihat semua data absensi karyawan
-   Filter absensi berdasarkan tanggal
-   Filter absensi berdasarkan bulan/tahun
-   Lihat detail riwayat absensi per karyawan
-   Statistik real-time (total hadir, terlambat, absen)

### 4. **Role-Based Access Control**

-   **Admin**: Akses dashboard admin dan laporan
-   **User**: Akses dashboard pribadi untuk absensi

---

## 🚀 Cara Setup

### 1. **Instalasi Dependencies**

```bash
composer install
npm install
```

### 2. **Setup Database**

```bash
# Copy file .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Jalankan migration
php artisan migrate

# Seed database (buat admin default)
php artisan db:seed
```

### 3. **Build Assets** (jika menggunakan Vite)

```bash
npm run build
# atau untuk development:
npm run dev
```

### 4. **Jalankan Server**

```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

---

## 👤 Akun Default

Setelah menjalankan `php artisan db:seed`, berikut adalah akun default:

### Admin Account

-   **Email**: `admin@bpkad.local`
-   **Password**: `admin123`
-   **Role**: Admin

### Contoh User Account

-   **Email**: `karyawan1@bpkad.local`
-   **Password**: `password123`
-   **Role**: User

---

## 🔑 Struktur Database

### Tabel: `users`

```
- id (Primary Key)
- name (string) - Nama lengkap
- email (string, unique) - Email
- password (string) - Password terenkripsi
- role (enum: 'user', 'admin') - Peran
- timestamps
```

### Tabel: `attendances`

```
- id (Primary Key)
- user_id (Foreign Key) - Referensi ke users
- date (date) - Tanggal absensi
- check_in_time (time, nullable) - Jam masuk
- check_out_time (time, nullable) - Jam keluar
- status (enum: 'present', 'late', 'absent') - Status
- notes (text, nullable) - Catatan tambahan
- unique constraint: user_id + date (satu absensi per hari)
- timestamps
```

---

## 📱 Menu Navigasi

### Halaman Home (/)

-   Tampilan utama dengan informasi sistem
-   Button Login dan Register (jika belum login)
-   Button Dashboard (jika sudah login)

### User Dashboard (/dashboard)

-   **Status Absensi Hari Ini**

    -   Tombol Check-in (jika belum absen)
    -   Tombol Check-out (jika sudah check-in)
    -   Tampilan jam masuk/keluar

-   **Statistik Bulan Ini**

    -   Total Hadir
    -   Total Terlambat
    -   Total Absen

-   **Riwayat Absensi Bulanan**
    -   Tabel dengan detail lengkap
    -   Tanggal, jam masuk, jam keluar, status

### Admin Dashboard (/admin/dashboard)

-   **Statistik Real-time**

    -   Total Karyawan
    -   Absensi Hari Ini
    -   Terlambat Hari Ini

-   **Filter & Laporan**

    -   Filter berdasarkan tanggal
    -   Filter berdasarkan bulan/tahun

-   **Tabel Absensi**
    -   Daftar lengkap semua absensi
    -   Pagination (50 per halaman)
    -   Link ke detail riwayat per karyawan

---

## 🔄 User Flow

### Untuk Karyawan (User):

1. Register akun baru atau login
2. Masuk ke dashboard pribadi
3. Klik "Check In" di pagi hari
4. Sistem akan otomatis menentukan status:
    - Sebelum jam 08:00 → HADIR
    - Setelah jam 08:00 → TERLAMBAT
5. Klik "Check Out" saat pulang (opsional)
6. Lihat riwayat absensi bulanan

### Untuk Admin:

1. Login dengan akun admin
2. Masuk ke Dashboard Admin
3. Lihat statistik real-time
4. Filter absensi:
    - Berdasarkan tanggal → Lihat laporan harian
    - Berdasarkan bulan → Lihat laporan bulanan
5. Klik "Lihat Detail" untuk melihat riwayat lengkap karyawan

---

## 🛠️ Struktur File Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php (Login/Register)
│   │   └── AttendanceController.php (Absensi & Admin)
│   └── Middleware/
│       ├── AdminMiddleware.php (Validasi Admin)
│       └── UserMiddleware.php (Validasi User)
│
├── Models/
│   ├── User.php
│   └── Attendance.php
│
database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   └── 2025_11_11_000000_create_attendances_table.php
│
├── seeders/
│   └── DatabaseSeeder.php
│
resources/
└── views/
    ├── welcome.blade.php (Home)
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── user/
    │   └── dashboard.blade.php
    └── admin/
        ├── dashboard.blade.php
        ├── attendance-report.blade.php
        └── user-history.blade.php

routes/
└── web.php (Semua routes)
```

---

## 📝 Rute (Routes)

### Public Routes

-   `GET /` - Home page
-   `GET /login` - Halaman login
-   `POST /login` - Submit login
-   `GET /register` - Halaman register
-   `POST /register` - Submit register

### User Routes (perlu login & role user)

-   `GET /dashboard` - Dashboard user
-   `POST /attendance/check-in` - Check in absensi
-   `POST /attendance/check-out` - Check out absensi

### Admin Routes (perlu login & role admin)

-   `GET /admin/dashboard` - Admin dashboard
-   `GET /admin/attendance/filter-date` - Filter by date
-   `GET /admin/attendance/filter-month` - Filter by month
-   `GET /admin/user/{userId}/history` - Lihat riwayat user

---

## ⏰ Konfigurasi Deadline

Deadline check-in saat ini diatur di `app/Http/Controllers/AttendanceController.php`:

```php
const CHECK_IN_DEADLINE = '08:00:00';
```

Untuk mengubah jam deadline:

1. Buka file `app/Http/Controllers/AttendanceController.php`
2. Ubah nilai `CHECK_IN_DEADLINE`
3. Contoh untuk jam 09:00 → `'09:00:00'`

---

## 🐛 Troubleshooting

### 1. Database Error

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Re-run migration
php artisan migrate:fresh --seed
```

### 2. 404 Not Found

-   Pastikan route sudah didaftarkan di `routes/web.php`
-   Jalankan `php artisan route:list` untuk melihat semua route

### 3. Authentication Error

-   Pastikan middleware sudah terdaftar di `bootstrap/app.php`
-   Cek `.env` file konfigurasi database

### 4. Asset/CSS tidak muncul

```bash
npm run build
# atau
npm run dev
```

---

## 🔐 Keamanan

✅ Password dienkripsi menggunakan bcrypt
✅ CSRF protection pada semua form
✅ Role-based access control
✅ Session management
✅ Unique constraint pada user+date attendance

---

## 📊 Contoh Laporan

Sistem dapat menghasilkan laporan:

1. **Laporan Harian** - Absensi pada tanggal tertentu
2. **Laporan Bulanan** - Absensi selama satu bulan
3. **Laporan Per Karyawan** - Riwayat lengkap seorang karyawan

Setiap laporan menampilkan:

-   Total Hadir
-   Total Terlambat
-   Total Absen
-   Jam Masuk/Keluar detail

---

## 📞 Support

Untuk pertanyaan atau bantuan, silakan hubungi administrator sistem.

---

**Last Updated**: 11 November 2025
**Version**: 1.0.0
