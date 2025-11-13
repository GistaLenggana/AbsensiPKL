@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="text-align: center;">
        <div style="font-size: 120px; margin-bottom: 20px;">💥</div>
        <h1 style="font-size: 48px; font-weight: 700; color: var(--danger); margin: 0 0 10px 0;">500</h1>
        <h2 style="font-size: 24px; color: #6b7280; margin: 0 0 20px 0;">Kesalahan Server Internal</h2>
        <p style="font-size: 16px; color: #9ca3af; margin: 0 0 30px 0; max-width: 500px;">
            Terjadi kesalahan pada server kami. Tim kami sedang menangani masalah ini. Silakan coba beberapa saat lagi.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="display: inline-block;">
            ← Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
