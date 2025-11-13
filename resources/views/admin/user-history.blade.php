@extends('layouts.app')

@section('title', 'Riwayat Absensi - Admin Dashboard')

@section('content')
<!-- Back Button & User Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 32px; font-weight: 700; margin: 0 0 8px 0;">👤 {{ $user->name }}</h1>
        <p style="color: #6b7280; margin: 0;">{{ $user->email }}</p>
        @if($user->profile)
            <p style="color: #6b7280; font-size: 14px; margin: 4px 0 0 0;">
                📍 {{ $user->profile->getDivisionLabel() }} | 🎓 {{ $user->profile->school_name }}
            </p>
        @endif
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Kembali</a>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <h3 style="font-size: 14px; margin: 0;">✅ Total Hadir</h3>
        </div>
        <div class="card-body" style="text-align: center; padding: 24px;">
            <p style="font-size: 36px; font-weight: 700; color: var(--success); margin: 0;">
                {{ $attendances->where('status', 'present')->count() }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <h3 style="font-size: 14px; margin: 0;">⏰ Total Terlambat</h3>
        </div>
        <div class="card-body" style="text-align: center; padding: 24px;">
            <p style="font-size: 36px; font-weight: 700; color: var(--warning); margin: 0;">
                {{ $attendances->where('status', 'late')->count() }}
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
            <h3 style="font-size: 14px; margin: 0;">❌ Total Absen</h3>
        </div>
        <div class="card-body" style="text-align: center; padding: 24px;">
            <p style="font-size: 36px; font-weight: 700; color: var(--danger); margin: 0;">
                {{ $attendances->where('status', 'absent')->count() }}
            </p>
        </div>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-header">
        <h2 style="font-size: 20px;">📋 Riwayat Absensi Lengkap</h2>
    </div>
    <div class="card-body" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280; width: 50px;">No</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280;">Tanggal</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280;">Jam Masuk</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280;">Jam Keluar</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #6b7280;">Status</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #6b7280;">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $index => $attendance)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px; font-weight: 600; color: #9ca3af;">{{ $index + 1 }}</td>
                        <td style="padding: 12px;">{{ $attendance->date->format('d M Y') }}</td>
                        <td style="padding: 12px; color: var(--primary); font-weight: 600;">
                            {{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-' }}
                        </td>
                        <td style="padding: 12px; color: #6b7280;">
                            {{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s') : '-' }}
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="
                                display: inline-block;
                                padding: 4px 12px;
                                border-radius: 20px;
                                font-size: 12px;
                                font-weight: 600;
                                @if ($attendance->status == 'present')
                                    background: #dcfce7;
                                    color: #15803d;
                                @elseif ($attendance->status == 'late')
                                    background: #fef3c7;
                                    color: #92400e;
                                @else
                                    background: #fee2e2;
                                    color: #991b1b;
                                @endif
                            ">
                                @if ($attendance->status == 'present')
                                    ✅ Hadir
                                @elseif ($attendance->status == 'late')
                                    ⏰ Terlambat
                                @else
                                    ❌ Absen
                                @endif
                            </span>
                        </td>
                        <td style="padding: 12px; font-size: 13px;">{{ $attendance->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: #6b7280;">
                            📭 Belum ada data absensi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="padding: 16px; border-top: 1px solid #e5e7eb;">
        {{ $attendances->links() }}
    </div>
</div>

@endsection
