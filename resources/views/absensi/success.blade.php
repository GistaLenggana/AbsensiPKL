@extends('layouts.app')

@section('title', 'Absensi Berhasil - BPKAD Garut')

@section('content')
<div class="card" style="text-align: center; padding: 60px 40px; max-width: 600px; margin: 0 auto;">
    <div style="font-size: 100px; margin-bottom: 20px; animation: bounceIn 0.6s ease;">✅</div>
    
    <h2 style="background: linear-gradient(135deg, var(--success) 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 15px; font-size: 32px;">
        Absensi Berhasil Dicatat!
    </h2>
    
    <p style="font-size: 16px; color: var(--gray); margin-bottom: 35px; line-height: 1.6;">
        Terima kasih telah melakukan absensi. Data Anda telah tersimpan dengan baik di sistem BPKAD Garut.
    </p>

    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; max-width: 500px; margin: 0 auto;">
        <a href="{{ route('absensi.index') }}" class="btn btn-primary" style="flex: 1; min-width: 200px;">
            <span style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                📝 Absensi Lagi
            </span>
        </a>
    </div>

    <div style="margin-top: 40px; padding: 24px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 197, 253, 0.1) 100%); border-radius: 16px; border: 1px solid rgba(59, 130, 246, 0.2);">
        <p style="font-size: 14px; color: var(--dark); line-height: 1.8;">
            <strong style="font-size: 16px; color: var(--primary);">⏰ Waktu Absensi:</strong><br>
            <span style="font-size: 18px; font-weight: 600; color: var(--dark);">{{ now()->format('l, d F Y | H:i') }} WIB</span>
        </p>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: rgba(16, 185, 129, 0.1); border-radius: 12px; border-left: 4px solid var(--success);">
        <p style="font-size: 13px; color: var(--gray); line-height: 1.6;">
            💡 <strong>Tips:</strong> Pastikan Anda melakukan absensi pulang di akhir jam kerja/magang Anda hari ini.
        </p>
    </div>
</div>

<style>
    @keyframes bounceIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
@endsection