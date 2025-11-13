# 💡 TIPS & TRICKS - Sistem Absensi BPKAD

## 🚀 Development Tips

### 1. Debugging dengan Tinker

```bash
# Masuk ke tinker
php artisan tinker

# Check user dengan admin role
User::where('role', 'admin')->first()

# Check attendance hari ini
Attendance::whereDate('date', today())->count()

# Create test data
User::factory()->create(['email' => 'test@email.com'])
```

### 2. Database Query Testing

```bash
# Masuk ke tinker
php artisan tinker

# Test complex query
Attendance::with('user')
    ->whereMonth('date', 11)
    ->whereYear('date', 2025)
    ->get()

# Count by status
Attendance::where('status', 'late')->count()
```

### 3. View Debugging

```blade
<!-- Debug di blade template -->
@dd($variable)  <!-- Dump & die -->

<!-- Atau -->
<pre>{{ print_r($data, true) }}</pre>

<!-- Check koleksi -->
@foreach ($attendances as $a)
    {{ $a->user->name }} - {{ $a->status }}
@endforeach
```

---

## 🔧 Configuration Tips

### 1. Mengubah Deadline Absensi

**File**: `app/Http/Controllers/AttendanceController.php`

```php
// Find this line:
const CHECK_IN_DEADLINE = '08:00:00';

// Change to:
const CHECK_IN_DEADLINE = '09:00:00';  // Jam 9 pagi
```

**Atau gunakan config**:

```php
// Di file .env
ATTENDANCE_CHECK_IN_DEADLINE=08:00:00

// Di controller
const CHECK_IN_DEADLINE = env('ATTENDANCE_CHECK_IN_DEADLINE', '08:00:00');
```

### 2. Mengubah Jumlah Item per Halaman

**File**: `config/absensi.php`

```php
'reports' => [
    'items_per_page' => 50,  // Ubah ini
],
```

### 3. Mengubah Format Tanggal

**File**: `config/absensi.php`

```php
'reports' => [
    'date_format' => 'd/m/Y',      // Format di laporan
    'time_format' => 'H:i:s',      // Format jam
],
```

---

## 📱 Mobile & Responsive Tips

### 1. Test Responsive Design

```bash
# Di browser dev tools
- Ctrl + Shift + M (Firefox)
- F12 → Toggle device toolbar (Chrome)
```

### 2. CSS Classes yang Berguna (Tailwind)

```html
<!-- Hidden pada mobile, visible pada desktop -->
<div class="hidden md:block">Desktop only</div>

<!-- Grid responsive -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <!-- Auto responsive -->
</div>

<!-- Padding responsive -->
<div class="p-4 md:p-8 lg:p-12">
    <!-- Padding auto adjust -->
</div>
```

---

## 🔐 Security Tips

### 1. Secure .env File

```bash
# Pastikan .env tidak di-commit
echo ".env" >> .gitignore

# Set permission
chmod 400 .env
```

### 2. Protect Sensitive Routes

```php
// Di routes/web.php
Route::middleware(['auth', 'admin'])->group(function () {
    // Hanya admin yang bisa akses
    Route::get('/admin/dashboard', ...);
});
```

### 3. Password Hashing

```php
// Saat membuat user
User::create([
    'password' => Hash::make('password123'),  // ✅ Correct
    // 'password' => 'password123',           // ❌ Wrong!
]);
```

---

## 🚀 Performance Tips

### 1. Query Optimization - Eager Loading

**❌ WRONG** (N+1 problem)

```php
$attendances = Attendance::all();
foreach ($attendances as $att) {
    echo $att->user->name;  // Query berulang!
}
```

**✅ CORRECT** (Eager loading)

```php
$attendances = Attendance::with('user')->get();
foreach ($attendances as $att) {
    echo $att->user->name;  // Single query
}
```

### 2. Pagination

```php
// ❌ Wrong
$attendances = Attendance::all();
return view('list', ['attendances' => $attendances]);

// ✅ Correct
$attendances = Attendance::paginate(50);
return view('list', ['attendances' => $attendances]);
```

### 3. Cache Database Queries

```php
// Cache hasil query 1 jam
$users = Cache::remember('all_users', 3600, function () {
    return User::all();
});
```

### 4. Database Indexing

```php
// Migration
public function up()
{
    Schema::table('attendances', function (Blueprint $table) {
        $table->index('user_id');
        $table->index('date');
    });
}
```

---

## 🧪 Testing Tips

### 1. Test Login

```bash
# Buka browser
http://localhost:8000/login

# Enter credentials
Email: admin@bpkad.local
Password: admin123

# Verify redirect ke dashboard
```

### 2. Test Check-in

```bash
# Login sebagai user
http://localhost:8000

# Klik Check-in
# Verify timestamp dicatat

# Check database
php artisan tinker
Attendance::latest()->first()
```

### 3. Test Filter

```bash
# Admin dashboard
http://localhost:8000/admin/dashboard

# Filter by date
- Pilih tanggal
- Klik "Cari Tanggal"
- Verify hasil sesuai

# Filter by month
- Pilih bulan & tahun
- Klik "Cari Bulan"
- Verify hasil sesuai
```

---

## 🐛 Debugging Tips

### 1. Enable Debug Mode

```env
# .env
APP_DEBUG=true  # Development only!
```

### 2. Log Query

```php
// Enable query logging di controller
\Illuminate\Support\Facades\DB::listen(function($query) {
    echo $query->sql;
});
```

### 3. Dump Data

```php
// Dump dengan pretty print
dd($data);
dump($data);

// Dump di blade
@dump($variable)
```

### 4. Check Email Sent

```php
// Test email tanpa sending
Mail::dumpHeaders();
Mail::dumpMessage();
```

---

## 🗄️ Database Tips

### 1. Backup Database

```bash
# MySQL backup
mysqldump -u root -p absensi_bpkad > backup.sql

# Restore
mysql -u root -p absensi_bpkad < backup.sql
```

### 2. Database Migration

```bash
# Create migration
php artisan make:migration add_new_column_to_users

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback
php artisan migrate:refresh
php artisan migrate:fresh
```

### 3. Seed Data

```bash
# Run seeder
php artisan db:seed

# Seed specific class
php artisan db:seed --class=UserSeeder
```

---

## 🎨 Frontend Tips

### 1. Use Tailwind CSS

```html
<!-- Instead of -->
<div style="background: blue; color: white; padding: 10px;">Hello</div>

<!-- Use -->
<div class="bg-blue-500 text-white p-2.5">Hello</div>
```

### 2. Responsive Tables

```blade
<!-- Mobile: Stack, Desktop: Table -->
<div class="overflow-x-auto">
    <table class="w-full border">
        <tr class="block md:table-row">
            <td class="block md:table-cell">{{ $data }}</td>
        </tr>
    </table>
</div>
```

### 3. Color Coding

```blade
<!-- Status badges -->
@if ($attendance->status === 'present')
    <span class="bg-green-500 text-white px-2 py-1 rounded">Hadir</span>
@elseif ($attendance->status === 'late')
    <span class="bg-yellow-500 text-white px-2 py-1 rounded">Terlambat</span>
@else
    <span class="bg-red-500 text-white px-2 py-1 rounded">Absen</span>
@endif
```

---

## 💾 File Management Tips

### 1. Storage Files

```php
// Save file ke storage
$path = $request->file('document')->store('uploads');

// Retrieve file
Storage::get($path);

// Delete file
Storage::delete($path);
```

### 2. File Permissions

```bash
# Set storage writable
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 📊 Report Tips

### 1. Generate Report Data

```php
// Get attendance dengan summary
$attendances = Attendance::with('user')
    ->whereMonth('date', 11)
    ->whereYear('date', 2025)
    ->get();

// Count by status
$present = $attendances->where('status', 'present')->count();
$late = $attendances->where('status', 'late')->count();
$absent = $attendances->where('status', 'absent')->count();
```

### 2. Export to Array

```php
// Export untuk CSV/Excel
$data = $attendances->map(function($att) {
    return [
        'name' => $att->user->name,
        'date' => $att->date->format('d/m/Y'),
        'check_in' => $att->check_in_time,
        'status' => $att->status,
    ];
})->toArray();
```

---

## 🌍 Deployment Tips

### 1. Pre-deployment Checklist

```bash
# Check Laravel version
php artisan --version

# Check PHP version
php -v

# Check extensions
php -m | grep mysql
php -m | grep bcmath

# Check permissions
ls -la storage/
ls -la bootstrap/cache/
```

### 2. Optimize for Production

```bash
# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 3. Monitor Logs

```bash
# Real-time
tail -f storage/logs/laravel.log

# Last 50 lines
tail -50 storage/logs/laravel.log

# Search errors
grep -i error storage/logs/laravel.log
```

---

## 🚀 Quick Troubleshooting

### Problem: 404 Not Found

**Solution**:

```bash
# Clear route cache
php artisan route:clear

# Check route registered
php artisan route:list | grep attendance

# Verify routes/web.php
```

### Problem: Database Connection Error

**Solution**:

```bash
# Check .env database settings
cat .env | grep DB_

# Test connection
php artisan db

# Check MySQL service
sudo service mysql status
```

### Problem: Permission Denied

**Solution**:

```bash
# Fix permissions
chmod -R 755 /var/www/absensi-bpkad
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

### Problem: Timeout

**Solution**:

```bash
# Clear cache
php artisan cache:clear

# Optimize
php artisan optimize

# Check logs
tail -f storage/logs/laravel.log
```

---

## 📚 Learning Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Tailwind CSS](https://tailwindcss.com/)
-   [Eloquent ORM](https://laravel.com/docs/eloquent)
-   [Blade Templating](https://laravel.com/docs/blade)

---

## ✅ Best Practices

1. **Sempre use migrations** untuk perubahan database
2. **Use Eloquent** bukan raw SQL
3. **Eager load** relationships
4. **Cache expensive** queries
5. **Validate input** selalu
6. **Hash passwords** menggunakan bcrypt
7. **Use middleware** untuk authorization
8. **Log activities** penting
9. **Test code** sebelum production
10. **Document changes** di changelog

---

**Happy Coding! 🎉**

Semoga tips ini membantu mengembangkan Sistem Absensi BPKAD!

---

**Last Updated**: 11 November 2025
