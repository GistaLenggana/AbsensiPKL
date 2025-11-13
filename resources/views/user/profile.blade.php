@extends('layouts.app')

@section('title', 'Profil Peserta PKL - Absensi BPKAD')

@section('content')

<!-- Navigation Tabs -->
<div style="display: flex; gap: 12px; margin-bottom: 24px;">
    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">← Dashboard</a>
    <div style="padding: 12px 16px; background: #2563eb; color: white; border-radius: 8px; font-weight: 600;">
        👤 Profil Saya
    </div>
</div>

<!-- Profile Card -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h2 style="font-size: 24px;">📋 Profil PKL/Magang</h2>
    </div>
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success">
                <div style="font-size: 20px;">✅</div>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <div style="font-size: 20px;">❌</div>
                <div>
                    <strong>Validation Error</strong>
                    <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li style="margin: 4px 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <!-- Left Column - User Info -->
            <div>
                <!-- Name -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">👤</span>
                        Nama Lengkap
                    </label>
                    <div style="padding: 12px; background: #f3f4f6; border-radius: 8px; font-weight: 500;">
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">📧</span>
                        Email
                    </label>
                    <div style="padding: 12px; background: #f3f4f6; border-radius: 8px; font-weight: 500;">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <!-- School -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">🎓</span>
                        Sekolah/Universitas
                    </label>
                    <div style="padding: 12px; background: #f0f9ff; border-left: 3px solid var(--primary); border-radius: 6px; font-weight: 500;">
                        {{ Auth::user()->profile?->school_name ?? 'Belum diisi' }}
                    </div>
                </div>

                <!-- Division -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">💼</span>
                        Bidang Penempatan
                    </label>
                    <div style="padding: 12px; background: #f0f9ff; border-left: 3px solid var(--primary); border-radius: 6px;">
                        <span style="display: inline-block; background: var(--primary); color: white; padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 14px;">
                            {{ Auth::user()->profile?->getDivisionLabel() ?? 'Belum diisi' }}
                        </span>
                    </div>
                </div>

                <!-- Registration Date -->
                @if (Auth::user()->profile)
                    <div class="form-group">
                        <label class="form-label">
                            <span style="font-size: 18px;">📅</span>
                            Tanggal Pendaftaran
                        </label>
                        <div style="padding: 12px; background: #f3f4f6; border-radius: 8px; font-weight: 500; font-size: 14px;">
                            {{ Auth::user()->profile->created_at->format('d F Y H:i') }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Statistics -->
            <div>
                <!-- Statistics Title -->
                <h3 style="font-size: 18px; font-weight: 700; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 24px;">📊</span>
                    Statistik Absensi
                </h3>

                <!-- Total -->
                <div style="padding: 14px; background: #f0f9ff; border: 2px solid var(--primary); border-radius: 8px; margin-bottom: 12px;">
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">Total Absensi</p>
                    <p style="font-size: 24px; font-weight: 700; color: var(--primary); margin: 6px 0 0 0;">{{ $stats['total'] ?? 0 }} hari</p>
                </div>

                <!-- Present -->
                <div style="padding: 14px; background: #f0fdf4; border: 2px solid var(--success); border-radius: 8px; margin-bottom: 12px;">
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">✅ Hadir</p>
                    <p style="font-size: 24px; font-weight: 700; color: var(--success); margin: 6px 0 0 0;">{{ $stats['present'] ?? 0 }} hari</p>
                </div>

                <!-- Late -->
                <div style="padding: 14px; background: #fef3c7; border: 2px solid var(--warning); border-radius: 8px; margin-bottom: 12px;">
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">⏰ Terlambat</p>
                    <p style="font-size: 24px; font-weight: 700; color: var(--warning); margin: 6px 0 0 0;">{{ $stats['late'] ?? 0 }} hari</p>
                </div>

                <!-- Absent -->
                <div style="padding: 14px; background: #fee2e2; border: 2px solid var(--danger); border-radius: 8px;">
                    <p style="font-size: 12px; color: #6b7280; margin: 0;">❌ Absen</p>
                    <p style="font-size: 24px; font-weight: 700; color: var(--danger); margin: 6px 0 0 0;">{{ $stats['absent'] ?? 0 }} hari</p>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div style="margin-top: 24px; padding: 16px; background: #f0f9ff; border-left: 3px solid var(--info); border-radius: 8px;">
            <h4 style="margin: 0 0 12px 0; color: #0c4a6e; font-weight: 700; font-size: 14px;">ℹ️ Informasi Penting</h4>
            <ul style="margin: 0; padding-left: 24px; font-size: 14px; color: #0c4a6e; line-height: 1.6;">
                <li>✓ Absensi dibuka setiap hari kerja</li>
                <li>✓ Deadline absensi: <strong>08:00 Pagi</strong></li>
                <li>✓ Setelah jam 08:00 tercatat sebagai TERLAMBAT</li>
                <li>✓ Gunakan foto selfie & GPS saat check-in</li>
            </ul>
        </div>

        <!-- Back Button -->
        <div style="margin-top: 24px;">
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>

@endsection
