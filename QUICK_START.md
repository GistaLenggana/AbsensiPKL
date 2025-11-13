# 🚀 Quick Start - Sistem Absensi BPKAD

## Langkah-Langkah Cepat Setup

### 1️⃣ Instalasi

```bash
composer install
npm install
```

### 2️⃣ Setup Database

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

### 3️⃣ Jalankan Server

```bash
php artisan serve
```

**Buka browser**: http://localhost:8000

---

## ✅ Login Credentials

### Admin

```
Email: admin@bpkad.local
Password: admin123
```

### User (Karyawan)

```
Email: karyawan1@bpkad.local
Password: password123
```

---

## 🎯 Test Features

### Sebagai User/Karyawan:

1. Login dengan karyawan1@bpkad.local
2. Klik "Check In" → Sistem akan mendeteksi waktu otomatis
3. Lihat status absensi (HADIR/TERLAMBAT)
4. Lihat statistik bulan berjalan

### Sebagai Admin:

1. Login dengan admin@bpkad.local
2. Lihat dashboard dengan statistik real-time
3. Filter absensi per tanggal atau bulan
4. Klik "Lihat Detail" untuk melihat riwayat karyawan

---

## 📝 Catatan Penting

⏰ **Absensi hanya bisa dilakukan hingga pukul 08:00**

-   Sebelum jam 08:00 → Status HADIR
-   Setelah jam 08:00 → Status TERLAMBAT

---

## 🔧 Jika Ada Masalah

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Re-migrate database
php artisan migrate:fresh --seed

# Check routes
php artisan route:list
```

---

Selesai! Sistem siap digunakan! 🎉
