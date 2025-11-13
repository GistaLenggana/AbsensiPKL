<?php

/**
 * ⚙️ Sistem Absensi BPKAD - Configuration File
 * 
 * File ini berisi konfigurasi utama sistem absensi.
 * Ubah nilai di sini untuk mengkustomisasi sistem.
 */

return [
    /**
     * ⏰ KONFIGURASI DEADLINE ABSENSI
     */
    'attendance' => [
        // Jam deadline check-in (format HH:MM:SS)
        // Sebelum jam ini = HADIR
        // Setelah jam ini = TERLAMBAT
        'check_in_deadline' => env('ATTENDANCE_CHECK_IN_DEADLINE', '08:00:00'),

        // Durasi minimal antara check-in dan check-out (dalam menit)
        'min_duration_minutes' => env('ATTENDANCE_MIN_DURATION', 0),

        // Apakah check-out wajib?
        'checkout_required' => env('ATTENDANCE_CHECKOUT_REQUIRED', false),

        // Status default
        'default_status' => 'absent',

        // Status yang tersedia
        'statuses' => [
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'absent' => 'Absen',
        ],

        // Warna untuk setiap status
        'status_colors' => [
            'present' => 'bg-green-500',
            'late' => 'bg-yellow-500',
            'absent' => 'bg-red-500',
        ],
    ],

    /**
     * 👥 KONFIGURASI ROLES & PERMISSIONS
     */
    'roles' => [
        'admin' => [
            'name' => 'Administrator',
            'permissions' => [
                'view_all_attendance',
                'view_reports',
                'manage_users',
                'system_settings',
            ],
        ],
        'user' => [
            'name' => 'Karyawan',
            'permissions' => [
                'check_in',
                'check_out',
                'view_own_attendance',
                'view_own_reports',
            ],
        ],
    ],

    /**
     * 📊 KONFIGURASI LAPORAN
     */
    'reports' => [
        // Items per halaman untuk pagination
        'items_per_page' => env('REPORT_ITEMS_PER_PAGE', 50),

        // Bulan default untuk laporan
        'default_month' => now()->month,
        'default_year' => now()->year,

        // Format tanggal di laporan
        'date_format' => 'd/m/Y',
        'time_format' => 'H:i:s',

        // Kolom yang ditampilkan di laporan
        'columns' => [
            'name',
            'date',
            'check_in_time',
            'check_out_time',
            'status',
            'notes',
        ],
    ],

    /**
     * 📧 KONFIGURASI EMAIL NOTIFICATION
     */
    'notifications' => [
        // Kirim notifikasi saat check-in?
        'send_checkin_notification' => env('SEND_CHECKIN_NOTIFICATION', false),

        // Kirim notifikasi saat absen?
        'send_absent_notification' => env('SEND_ABSENT_NOTIFICATION', false),

        // Email admin untuk notifikasi
        'admin_email' => env('ADMIN_EMAIL', 'admin@bpkad.local'),

        // Template email
        'templates' => [
            'checkin_subject' => 'Konfirmasi Check-in - Sistem Absensi BPKAD',
            'absent_subject' => 'Absensi Tercatat - Sistem Absensi BPKAD',
        ],
    ],

    /**
     * 🎨 KONFIGURASI UI/UX
     */
    'ui' => [
        // Nama aplikasi
        'app_name' => 'Sistem Absensi BPKAD',

        // Logo/brand
        'logo' => '/images/logo.png',

        // Tema warna utama
        'primary_color' => 'blue',
        'secondary_color' => 'gray',

        // Timezone
        'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),

        // Format tanggal lokal
        'date_format_local' => 'd M Y',
        'datetime_format_local' => 'd M Y H:i',
    ],

    /**
     * 🔐 KONFIGURASI KEAMANAN
     */
    'security' => [
        // Maksimum login attempts
        'max_login_attempts' => 5,

        // Durasi lockout setelah max attempts (dalam menit)
        'lockout_duration' => 15,

        // Require email verification?
        'require_email_verification' => false,

        // Session timeout (dalam menit)
        'session_timeout' => 30,

        // Password requirements
        'password_min_length' => 6,
        'password_require_uppercase' => false,
        'password_require_numbers' => false,
        'password_require_special_chars' => false,
    ],

    /**
     * 📱 KONFIGURASI MOBILE/RESPONSIVE
     */
    'mobile' => [
        // Enable mobile check-in?
        'mobile_checkin_enabled' => true,

        // Require GPS untuk mobile check-in?
        'require_gps' => false,

        // Akurasi GPS (dalam meter)
        'gps_accuracy' => 100,
    ],

    /**
     * 📈 KONFIGURASI ANALYTICS & LOGS
     */
    'analytics' => [
        // Enable activity logging?
        'log_activities' => true,

        // Log retention (dalam hari)
        'log_retention_days' => 90,

        // Metrics to track
        'track_metrics' => [
            'checkin_time',
            'checkout_time',
            'attendance_rate',
            'late_rate',
        ],
    ],

    /**
     * 🗄️ KONFIGURASI DATABASE BACKUP
     */
    'backup' => [
        // Auto backup enabled?
        'enabled' => false,

        // Backup schedule (daily, weekly, monthly)
        'schedule' => 'daily',

        // Backup time (format HH:MM)
        'time' => '02:00',

        // Retention (dalam hari)
        'retention_days' => 30,
    ],

    /**
     * 🌍 KONFIGURASI LOKALISASI
     */
    'localization' => [
        // Bahasa default
        'default_language' => 'id',

        // Bahasa yang tersedia
        'supported_languages' => ['id', 'en'],

        // Timezone
        'timezone' => 'Asia/Jakarta',

        // Locale
        'locale' => 'id_ID',
    ],

    /**
     * 🎯 KONFIGURASI BUSINESS RULES
     */
    'business' => [
        // Hari kerja (0=Minggu, 1=Senin, ..., 6=Sabtu)
        'working_days' => [1, 2, 3, 4, 5],

        // Hari libur nasional (format: m-d)
        'holidays' => [
            '01-01', // New Year
            '05-01', // Labour Day
            '08-17', // Independence Day
            '12-25', // Christmas
        ],

        // Durasi jam kerja (dalam jam)
        'working_hours' => 8,

        // Jam kerja mulai
        'work_start_time' => '08:00:00',

        // Jam kerja selesai
        'work_end_time' => '17:00:00',

        // Break time duration (dalam menit)
        'break_duration' => 60,
    ],
];
