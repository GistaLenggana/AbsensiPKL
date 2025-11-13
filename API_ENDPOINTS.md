# 🔧 API Endpoints & Configuration - Sistem Absensi BPKAD

## 📋 Daftar Lengkap Routes

### Public Routes

| Method | URI       | Handler                     | Nama            | Akses  |
| ------ | --------- | --------------------------- | --------------- | ------ |
| GET    | /         | welcome                     | home            | Public |
| GET    | /login    | AuthController@showLogin    | login           | Guest  |
| POST   | /login    | AuthController@login        | login.submit    | Guest  |
| GET    | /register | AuthController@showRegister | register        | Guest  |
| POST   | /register | AuthController@register     | register.submit | Guest  |
| POST   | /logout   | AuthController@logout       | logout          | Auth   |

### User Routes (Perlu Login & Role User)

| Method | URI                   | Handler                            | Nama                | Akses |
| ------ | --------------------- | ---------------------------------- | ------------------- | ----- |
| GET    | /dashboard            | AttendanceController@userDashboard | user.dashboard      | User  |
| POST   | /attendance/check-in  | AttendanceController@checkIn       | attendance.checkIn  | User  |
| POST   | /attendance/check-out | AttendanceController@checkOut      | attendance.checkOut | User  |

### Admin Routes (Perlu Login & Role Admin)

| Method | URI                            | Handler                             | Nama              | Akses |
| ------ | ------------------------------ | ----------------------------------- | ----------------- | ----- |
| GET    | /admin/dashboard               | AttendanceController@adminDashboard | admin.dashboard   | Admin |
| GET    | /admin/attendance/filter-date  | AttendanceController@filterByDate   | admin.filterDate  | Admin |
| GET    | /admin/attendance/filter-month | AttendanceController@filterByMonth  | admin.filterMonth | Admin |
| GET    | /admin/user/{userId}/history   | AttendanceController@userHistory    | admin.userHistory | Admin |

---

## ⚙️ Konfigurasi Penting

### .env File

```env
APP_NAME=Absensi-BPKAD
APP_ENV=production
APP_KEY=base64:xxxxx
APP_DEBUG=false
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_bpkad
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Database Configuration (config/database.php)

```php
'default' => env('DB_CONNECTION', 'mysql'),

'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_DATABASE', 'absensi_bpkad'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
    ],
],
```

### Auth Configuration (config/auth.php)

```php
'defaults' => [
    'guard' => env('AUTH_GUARD', 'web'),
    'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

---

## ⏰ Konfigurasi Deadline Absensi

### Lokasi: `app/Http/Controllers/AttendanceController.php`

```php
const CHECK_IN_DEADLINE = '08:00:00';
```

**Cara mengubah deadline:**

1. Buka file `app/Http/Controllers/AttendanceController.php`
2. Cari baris: `const CHECK_IN_DEADLINE = '08:00:00';`
3. Ubah waktu sesuai kebutuhan, contoh:
    - Jam 09:00 → `'09:00:00'`
    - Jam 07:30 → `'07:30:00'`
4. Save file

---

## 🔒 Middleware Configuration

### Lokasi: `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
    ]);
})
```

### Cara menggunakan di routes:

```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Routes hanya bisa diakses oleh admin
});

Route::middleware(['auth', 'user'])->group(function () {
    // Routes hanya bisa diakses oleh user
});
```

---

## 📊 Model & Relasi

### Model: User

```php
namespace App\Models;

class User extends Authenticatable
{
    // Fillable columns
    protected $fillable = ['name', 'email', 'password', 'role'];

    // Relations
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Methods
    public function isAdmin(): bool
    public function isUser(): bool
}
```

### Model: Attendance

```php
namespace App\Models;

class Attendance extends Model
{
    // Fillable columns
    protected $fillable = [
        'user_id', 'date', 'check_in_time',
        'check_out_time', 'status', 'notes'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
    public static function isLate($checkInTime, $deadline = '08:00:00')
    public function getStatusBadgeColor()
}
```

---

## 🗄️ Database Schema

### Table: users

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Table: attendances

```sql
CREATE TABLE attendances (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    date DATE,
    check_in_time TIME NULL,
    check_out_time TIME NULL,
    status ENUM('present', 'late', 'absent') DEFAULT 'absent',
    notes LONGTEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_date (user_id, date)
);
```

---

## 📝 Validasi Rules

### AuthController - Login

```php
$credentials = $request->validate([
    'email' => 'required|email',
    'password' => 'required',
]);
```

### AuthController - Register

```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|string|min:6|confirmed',
]);
```

### AttendanceController - Filter Date

```php
$date = $request->validate([
    'date' => 'required|date',
])['date'];
```

### AttendanceController - Filter Month

```php
$validated = $request->validate([
    'month' => 'required|integer|between:1,12',
    'year' => 'required|integer|min:2000',
]);
```

---

## 🔑 Hak Akses (Authorization)

### User Role

-   ✅ Login/Register
-   ✅ Akses `/dashboard`
-   ✅ Check-in/Check-out
-   ✅ Lihat riwayat pribadi
-   ❌ Akses admin dashboard
-   ❌ Lihat data user lain

### Admin Role

-   ✅ Login
-   ✅ Akses `/admin/dashboard`
-   ✅ Filter absensi
-   ✅ Lihat riwayat semua user
-   ✅ View reports
-   ✅ Manage attendance data

---

## 🧹 Cleanup & Maintenance

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Database Operations

```bash
# Fresh database
php artisan migrate:fresh

# Fresh dengan seed
php artisan migrate:fresh --seed

# Rollback migrations
php artisan migrate:rollback
```

### Logs

```bash
# View logs
tail -f storage/logs/laravel.log

# Clear logs
php artisan logs:clear
```

---

## 📱 API Response Format

### Success Response

```json
{
    "success": true,
    "message": "Operation successful",
    "data": {}
}
```

### Error Response

```json
{
    "success": false,
    "message": "Error message",
    "errors": {}
}
```

---

## 🚀 Deployment Checklist

-   [ ] Update `.env` untuk production
-   [ ] Set `APP_DEBUG=false`
-   [ ] Set `APP_ENV=production`
-   [ ] Generate new APP_KEY
-   [ ] Setup database production
-   [ ] Run migrations
-   [ ] Optimize laravel
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan optimize
    ```
-   [ ] Setup SSL/HTTPS
-   [ ] Configure web server (nginx/apache)
-   [ ] Setup backup strategy
-   [ ] Monitor logs

---

## 📞 Troubleshooting Commands

```bash
# Check if routes registered
php artisan route:list

# Check laravel health
php artisan tinker

# Check database connection
php artisan db

# Generate docs
php artisan make:docs
```

---

**Last Updated**: 11 November 2025
**Version**: 1.0.0
