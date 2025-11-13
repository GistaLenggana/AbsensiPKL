# ✅ Checklist Setup & Testing - Sistem Absensi BPKAD

## 📋 Pre-Setup Checklist

-   [ ] PHP 8.1+ terinstal
-   [ ] Composer terinstal
-   [ ] Node.js & npm terinstal
-   [ ] Database MySQL/SQLite siap
-   [ ] Port 8000 tersedia untuk Laravel server

## 🔧 Setup Checklist

-   [ ] Clone atau download project
-   [ ] Jalankan `composer install`
-   [ ] Jalankan `npm install`
-   [ ] Copy `.env.example` ke `.env`
-   [ ] Jalankan `php artisan key:generate`
-   [ ] Setup database di `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
-   [ ] Jalankan `php artisan migrate`
-   [ ] Jalankan `php artisan db:seed`
-   [ ] Jalankan `npm run build` (atau `npm run dev` untuk development)
-   [ ] Jalankan `php artisan serve`

## 🧪 Testing Checklist - USER FEATURES

### Test Login

-   [ ] Buka http://localhost:8000/login
-   [ ] Masukkan email: `karyawan1@bpkad.local`
-   [ ] Masukkan password: `password123`
-   [ ] Klik tombol "Login"
-   [ ] Berhasil redirect ke dashboard user

### Test Register

-   [ ] Buka http://localhost:8000/register
-   [ ] Isi form dengan data valid:
    -   [ ] Nama: "Nama Baru"
    -   [ ] Email: "baru@email.com"
    -   [ ] Password: "password123"
    -   [ ] Konfirmasi Password: "password123"
-   [ ] Klik tombol "Daftar"
-   [ ] Berhasil register dan redirect ke dashboard

### Test Check-In

-   [ ] Login sebagai user
-   [ ] Di dashboard, klik tombol "Check In"
-   [ ] Lihat notifikasi sukses dengan waktu masuk
-   [ ] Status berubah menjadi HADIR atau TERLAMBAT (sesuai jam)
-   [ ] Tombol Check-In hilang dan muncul tombol Check-Out

### Test Check-Out

-   [ ] Setelah Check-In, klik tombol "Check-Out"
-   [ ] Lihat notifikasi sukses dengan waktu keluar
-   [ ] Riwayat absensi terupdate dengan jam keluar

### Test Statistics

-   [ ] Di dashboard user, lihat card "Statistik Bulan Ini"
-   [ ] Verifikasi data statistik:
    -   [ ] Total Hadir
    -   [ ] Total Terlambat
    -   [ ] Total Absen

### Test Attendance History

-   [ ] Di dashboard user, scroll ke bawah
-   [ ] Lihat tabel "Riwayat Absensi Bulan Ini"
-   [ ] Verifikasi data absensi tercatat dengan benar
-   [ ] Lihat tanggal, jam masuk, jam keluar, status

### Test Logout

-   [ ] Klik menu "Logout" di navbar
-   [ ] Berhasil logout dan redirect ke home

## 🧪 Testing Checklist - ADMIN FEATURES

### Test Admin Login

-   [ ] Buka http://localhost:8000/login
-   [ ] Masukkan email: `admin@bpkad.local`
-   [ ] Masukkan password: `admin123`
-   [ ] Klik tombol "Login"
-   [ ] Berhasil redirect ke admin dashboard

### Test Admin Dashboard Statistics

-   [ ] Di admin dashboard, verifikasi card statistik:
    -   [ ] Total Karyawan (harus > 0)
    -   [ ] Absensi Hari Ini
    -   [ ] Terlambat Hari Ini

### Test Filter by Date

-   [ ] Masukkan tanggal di input "Filter by Date"
-   [ ] Klik tombol "Cari Tanggal"
-   [ ] Lihat laporan absensi untuk tanggal tersebut
-   [ ] Verifikasi tabel menampilkan data dengan benar

### Test Filter by Month

-   [ ] Pilih bulan dari dropdown
-   [ ] Pilih tahun dari dropdown
-   [ ] Klik tombol "Cari Bulan"
-   [ ] Lihat laporan absensi untuk bulan tersebut
-   [ ] Verifikasi pagination bekerja (50 per halaman)

### Test Attendance Table

-   [ ] Di admin dashboard, lihat tabel "Data Absensi"
-   [ ] Verifikasi kolom:
    -   [ ] Nama Karyawan
    -   [ ] Tanggal
    -   [ ] Jam Masuk
    -   [ ] Jam Keluar
    -   [ ] Status (warna berbeda untuk HADIR/TERLAMBAT/ABSEN)

### Test View Detail

-   [ ] Klik link "Lihat Detail" pada salah satu baris
-   [ ] Redirect ke halaman user history
-   [ ] Verifikasi data lengkap riwayat karyawan

### Test User History Page

-   [ ] Lihat statistik karyawan:
    -   [ ] Total Hadir
    -   [ ] Total Terlambat
    -   [ ] Total Absen
-   [ ] Lihat tabel riwayat lengkap
-   [ ] Verifikasi pagination

## ⏰ Testing Checklist - DEADLINE FEATURE

### Test Before Deadline (Sebelum 08:00)

-   [ ] Ubah waktu sistem ke jam 07:30
-   [ ] Login sebagai user
-   [ ] Klik Check-In
-   [ ] Verifikasi status = HADIR
-   [ ] Verifikasi notifikasi: "Absensi tercatat sebagai HADIR"

### Test After Deadline (Setelah 08:00)

-   [ ] Ubah waktu sistem ke jam 08:30
-   [ ] Login sebagai user
-   [ ] Klik Check-In
-   [ ] Verifikasi status = TERLAMBAT
-   [ ] Verifikasi notifikasi: "Absensi tercatat sebagai TERLAMBAT"

### Test Multiple Check-In Prevention

-   [ ] Coba Check-In lagi pada hari yang sama
-   [ ] Verifikasi error: "Anda sudah absen hari ini!"

## 🔐 Testing Checklist - SECURITY

### Test User Cannot Access Admin

-   [ ] Login sebagai user
-   [ ] Coba akses http://localhost:8000/admin/dashboard
-   [ ] Verifikasi redirect atau error (akses ditolak)

### Test Admin Can Access Admin

-   [ ] Login sebagai admin
-   [ ] Akses http://localhost:8000/admin/dashboard
-   [ ] Verifikasi berhasil akses

### Test Session Expiry

-   [ ] Login kemudian logout
-   [ ] Coba akses dashboard tanpa login
-   [ ] Verifikasi redirect ke login page

### Test CSRF Protection

-   [ ] Buka dev tools
-   [ ] Verifikasi form memiliki @csrf token
-   [ ] Verifikasi token dalam form

## 🎨 Testing Checklist - UI/UX

### Test Responsive Design

-   [ ] Test di desktop (ukuran layar besar)
-   [ ] Test di tablet (medium screen)
-   [ ] Test di mobile (small screen)
-   [ ] Verifikasi layout responsif

### Test Navigation

-   [ ] Test semua link/button berfungsi
-   [ ] Test navbar muncul dengan benar
-   [ ] Test hamburger menu (jika ada)

### Test Form Validation

-   [ ] Submit form kosong → error validasi
-   [ ] Submit email invalid → error validasi
-   [ ] Submit password < 6 karakter → error validasi
-   [ ] Verifikasi pesan error ditampilkan

### Test Error Messages

-   [ ] Verifikasi notifikasi error ditampilkan
-   [ ] Verifikasi notifikasi success ditampilkan
-   [ ] Verifikasi warna sesuai (hijau = success, merah = error)

## 📊 Testing Checklist - DATA INTEGRITY

### Test Database Constraints

-   [ ] Email tidak bisa duplikat (test register dengan email yang sama)
-   [ ] User + Date attendance unique (test absen 2x hari sama)
-   [ ] Foreign key bekerja (delete user, check attendance)

### Test Data Persistence

-   [ ] Logout kemudian login
-   [ ] Data absensi masih ada
-   [ ] Riwayat tidak hilang

### Test Pagination

-   [ ] Buat banyak data absensi (> 50)
-   [ ] Di admin dashboard, verifikasi pagination
-   [ ] Test navigasi ke halaman berikutnya

## 🚀 Final Checklist

-   [ ] Semua feature berfungsi dengan benar
-   [ ] Tidak ada error di browser console
-   [ ] Tidak ada error di Laravel logs
-   [ ] UI menarik dan user-friendly
-   [ ] Dokumentasi lengkap tersedia
-   [ ] Ready untuk production

## 📝 Catatan Testing

Tulis catatan di bawah jika ada isu:

```
Issue 1:
- Deskripsi:
- Tanggal:
- Status: FIXED / PENDING

Issue 2:
- Deskripsi:
- Tanggal:
- Status: FIXED / PENDING
```

---

## ✅ Approval Sign-Off

-   [ ] Developer: ********\_******** Tanggal: **\_\_\_**
-   [ ] QA/Tester: ********\_******** Tanggal: **\_\_\_**
-   [ ] Admin: ********\_******** Tanggal: **\_\_\_**

---

**Catatan**: Pastikan semua checklist di atas tercentang sebelum sistem go-live!
