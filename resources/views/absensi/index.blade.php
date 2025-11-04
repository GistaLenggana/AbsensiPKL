@extends('layouts.app')

@section('title', 'Form Absensi - BPKAD Garut')

@section('content')
<div class="card" style="max-width: 680px; margin: 0 auto;">
    <div class="card-header">
        <h2>Form Absensi</h2>
        <p>Lengkapi formulir di bawah ini untuk mencatat kehadiran Anda</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <div style="font-size: 20px;">⚠️</div>
            <div>
                <strong>Terjadi Kesalahan:</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data" id="absensiForm">
        @csrf
        
        <!-- Nama Lengkap -->
        <div class="form-group">
            <label class="form-label">
                <span class="icon">👤</span>
                Nama Lengkap
                <span class="required">*</span>
            </label>
            <input 
                type="text" 
                id="nama" 
                name="nama" 
                class="form-control" 
                value="{{ old('nama') }}" 
                required 
                placeholder="Contoh: Gista"
            >
        </div>

        <!-- Sekolah/Universitas -->
        <div class="form-group">
            <label class="form-label">
                <span class="icon">🏫</span>
                Sekolah / Universitas
                <span class="required">*</span>
            </label>
            <input 
                type="text" 
                id="instansi" 
                name="instansi" 
                class="form-control" 
                value="{{ old('instansi') }}" 
                required 
                placeholder="Contoh: SMK Negeri 1 Garut"
            >
        </div>

        <!-- Bidang Penempatan -->
        <div class="form-group">
            <label class="form-label">
                <span class="icon">🏢</span>
                Bidang Penempatan
                <span class="required">*</span>
            </label>
            <select id="bidang_id" name="bidang_id" class="form-control" required>
                <option value="">Pilih bidang penempatan...</option>
                @foreach($bidangs as $bidang)
                    <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                        {{ $bidang->nama_bidang }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Foto Selfie -->
        <div class="form-group">
            <label class="form-label">
                <span class="icon">📸</span>
                Foto Selfie
                <span class="required">*</span>
            </label>
            <input 
                type="file" 
                id="foto" 
                name="foto" 
                class="form-control" 
                accept="image/*" 
                capture="user" 
                required
            >
            <small class="form-hint">Format: JPG, PNG | Maksimal: 5 MB</small>
            
            <div class="preview-container" id="preview">
                <img id="previewImage" alt="Preview Foto">
            </div>
        </div>

        <!-- Lokasi -->
        <div class="form-group">
            <label class="form-label">
                <span class="icon">📍</span>
                Lokasi Keberadaan
                <span class="required">*</span>
            </label>
            <button type="button" class="btn btn-secondary btn-block" id="getLocationBtn" onclick="getLocation()">
                📡 Ambil Lokasi Saya
            </button>
            <small class="form-hint">Pastikan GPS/lokasi di perangkat Anda aktif</small>
            
            <div class="location-info" id="locationInfo"></div>
            
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <input type="hidden" id="alamat_lokasi" name="alamat_lokasi">
        </div>

        <!-- Loading State -->
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p style="color: var(--primary); font-weight: 600;">Memproses absensi...</p>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
            ✅ Kirim Absensi
        </button>

<!-- Info Box -->
<div class="card" style="max-width: 680px; margin: 24px auto 0;">
    <div class="alert alert-info" style="margin: 0;">
        <div style="font-size: 20px;">💡</div>
        <div>
            <strong>Catatan Penting:</strong>
            <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                <li>Pastikan foto selfie Anda jelas dan terlihat wajah</li>
                <li>Izinkan akses lokasi saat diminta oleh browser</li>
                <li>Lakukan absensi masuk saat tiba dan absensi pulang saat selesai</li>
                <li>Hubungi pembimbing jika mengalami kendala</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview foto dengan feedback visual
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        const previewImage = document.getElementById('previewImage');
        
        if (file) {
            // Validasi ukuran file
            if (file.size > 5 * 1024 * 1024) {
                alert('❌ Ukuran file terlalu besar! Maksimal 5 MB.');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                preview.classList.add('active');
            }
            reader.readAsDataURL(file);
        }
    });

    // Get location dengan feedback yang jelas
    function getLocation() {
        const btn = document.getElementById('getLocationBtn');
        const info = document.getElementById('locationInfo');
        
        if (!navigator.geolocation) {
            alert('❌ Browser Anda tidak mendukung fitur lokasi');
            return;
        }

        // Update button state
        btn.innerHTML = '⏳ Mengambil lokasi...';
        btn.disabled = true;
        btn.style.opacity = '0.7';

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Reverse geocoding
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const alamat = data.display_name || `${lat}, ${lng}`;
                        document.getElementById('alamat_lokasi').value = alamat;
                        
                        info.innerHTML = `
                            <div style="display: flex; align-items: start; gap: 12px;">
                                <div style="font-size: 24px;">✅</div>
                                <div style="flex: 1;">
                                    <strong style="color: var(--success); display: block; margin-bottom: 6px;">Lokasi Berhasil Didapat!</strong>
                                    <div style="font-size: 13px; line-height: 1.6;">
                                        <div style="margin-bottom: 4px;">
                                            <strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}
                                        </div>
                                        <div>
                                            <strong>Alamat:</strong> ${alamat}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        info.classList.add('active');
                        
                        btn.innerHTML = '✅ Lokasi Sudah Didapat';
                        btn.style.background = 'linear-gradient(135deg, var(--success) 0%, #059669 100%)';
                        btn.style.opacity = '1';
                    })
                    .catch(error => {
                        const alamat = `${lat}, ${lng}`;
                        document.getElementById('alamat_lokasi').value = alamat;
                        
                        info.innerHTML = `
                            <div style="display: flex; align-items: start; gap: 12px;">
                                <div style="font-size: 24px;">✅</div>
                                <div>
                                    <strong style="color: var(--success); display: block; margin-bottom: 6px;">Lokasi Berhasil Didapat!</strong>
                                    <div style="font-size: 13px;">
                                        <strong>Koordinat:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}
                                    </div>
                                </div>
                            </div>
                        `;
                        info.classList.add('active');
                        
                        btn.innerHTML = '✅ Lokasi Sudah Didapat';
                        btn.style.background = 'linear-gradient(135deg, var(--success) 0%, #059669 100%)';
                        btn.style.opacity = '1';
                    });
            },
            function(error) {
                let errorMessage = 'Gagal mendapatkan lokasi.';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Akses lokasi ditolak. Mohon izinkan akses lokasi di pengaturan browser.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Informasi lokasi tidak tersedia.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Waktu permintaan lokasi habis.';
                        break;
                }
                
                alert('❌ ' + errorMessage);
                btn.innerHTML = '📡 Ambil Lokasi Saya';
                btn.disabled = false;
                btn.style.opacity = '1';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    // Form validation
    document.getElementById('absensiForm').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        
        if (!lat || !lng) {
            e.preventDefault();
            alert('⚠️ Mohon ambil lokasi Anda terlebih dahulu!');
            document.getElementById('getLocationBtn').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }

        // Show loading
        document.getElementById('loading').classList.add('active');
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').style.opacity = '0.6';
    });

    // Auto scroll to error
    window.addEventListener('load', function() {
        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endpush