@extends('layouts.app')

@section('title', 'Register - Absensi BPKAD Garut')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px;">
    <div class="card" style="width: 100%; max-width: 500px;">
        <!-- Header with Logo -->
        <div style="text-align: center; padding: 24px; background: linear-gradient(135deg, var(--primary) 0%, #1d4ed8 100%); border-radius: 12px 12px 0 0;">
            <img src="{{ asset('image/logonav.png') }}" alt="Logo" style="height: 60px; margin-bottom: 12px;">
            <h1 style="color: white; font-size: 28px; font-weight: 700; margin: 0;">Daftar Akun</h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin: 4px 0 0 0;">Bergabunglah dengan Program PKL/Magang</p>
        </div>

        <!-- Body -->
        <div class="card-body" style="padding: 24px;">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div style="font-size: 20px;">❌</div>
                    <div>
                        <strong>Validasi Gagal!</strong>
                        <ul style="margin: 6px 0 0 0; padding-left: 20px; font-size: 13px;">
                            @foreach ($errors->all() as $error)
                                <li style="margin: 2px 0;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">👤</span>
                        Nama Lengkap
                        <span class="required">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" 
                        placeholder="Contoh: Ahmad Rizki" required autofocus>
                    <small class="form-hint">Nama sesuai dengan identitas resmi</small>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">📧</span>
                        Email Address
                        <span class="required">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" 
                        placeholder="example@email.com" required>
                    <small class="form-hint">Gunakan email yang aktif dan valid</small>
                </div>

                <!-- School/University -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">🎓</span>
                        Sekolah / Universitas
                        <span class="required">*</span>
                    </label>
                    <input type="text" name="school_name" value="{{ old('school_name') }}" class="form-control" 
                        placeholder="Contoh: SMA Negeri 1 / Universitas ABC" required>
                    <small class="form-hint">Nama lengkap institusi pendidikan</small>
                </div>

                <!-- Division/Bidang Penempatan -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">💼</span>
                        Bidang Penempatan
                        <span class="required">*</span>
                    </label>
                    <select name="division" class="form-control" required>
                        <option value="">-- Pilih Bidang Penempatan --</option>
                        <option value="akuntansi">📊 Akuntansi</option>
                        <option value="sekretaria">📝 Sekretaria</option>
                        <option value="anggaran">💰 Anggaran</option>
                        <option value="keuangan">🏦 Keuangan</option>
                        <option value="perbendaharaan">💎 Perbendaharaan</option>
                    </select>
                    <small class="form-hint">Pilih bidang sesuai penempatan Anda</small>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">🔒</span>
                        Password
                        <span class="required">*</span>
                    </label>
                    <input type="password" name="password" class="form-control" 
                        placeholder="Minimal 6 karakter" required>
                    <small class="form-hint">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal</small>
                </div>

                <!-- Password Confirmation -->
                <div class="form-group">
                    <label class="form-label">
                        <span style="font-size: 18px;">🔒</span>
                        Konfirmasi Password
                        <span class="required">*</span>
                    </label>
                    <input type="password" name="password_confirmation" class="form-control" 
                        placeholder="Ulangi password Anda" required>
                    <small class="form-hint">Pastikan password cocok dengan inputan di atas</small>
                </div>

                <!-- Consent -->
                <div style="background: #f0fdf4; border-left: 3px solid var(--success); padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; color: #166534;">
                    <p style="margin: 0; font-weight: 600;">✅ Syarat & Ketentuan</p>
                    <p style="margin: 4px 0 0 0; line-height: 1.4;">Dengan mendaftar, Anda setuju dengan syarat dan ketentuan berlaku serta kebijakan privasi kami.</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block" style="font-size: 16px; font-weight: 600; padding: 12px;">
                    ✓ Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div style="display: flex; align-items: center; margin: 20px 0; gap: 8px;">
                <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                <span style="color: #9ca3af; font-size: 12px; font-weight: 600;">SUDAH PUNYA AKUN?</span>
                <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
            </div>

            <!-- Login Link -->
            <p style="text-align: center; color: #6b7280; margin: 0; font-size: 14px;">
                <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none; cursor: pointer;">
                    Login di Sini →
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
