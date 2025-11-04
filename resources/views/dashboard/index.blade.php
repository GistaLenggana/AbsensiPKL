@extends('layouts.app')

@section('title', 'Dashboard Admin - BPKAD Garut')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h3 style="font-size: 16px; opacity: 0.9; margin-bottom: 10px;">Total Absensi Hari Ini</h3>
        <div style="font-size: 36px; font-weight: bold;">{{ $stats['total_hari_ini'] }}</div>
    </div>
    
    <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
        <h3 style="font-size: 16px; opacity: 0.9; margin-bottom: 10px;">Absen Masuk</h3>
        <div style="font-size: 36px; font-weight: bold;">{{ $stats['masuk_hari_ini'] }}</div>
    </div>
    
    <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <h3 style="font-size: 16px; opacity: 0.9; margin-bottom: 10px;">Absen Pulang</h3>
        <div style="font-size: 36px; font-weight: bold;">{{ $stats['pulang_hari_ini'] }}</div>
    </div>
    
    <div class="card" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white;">
        <h3 style="font-size: 16px; opacity: 0.9; margin-bottom: 10px;">Total Bulan Ini</h3>
        <div style="font-size: 36px; font-weight: bold;">{{ $stats['total_bulan_ini'] }}</div>
    </div>
</div>

<!-- Filter Section -->
<div class="card">
    <div class="card-header">
        <h2>Filter Data Absensi</h2>
    </div>
    
    <form method="GET" action="{{ route('dashboard.index') }}">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ request('tanggal', today()->format('Y-m-d')) }}">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="bidang_id">Bidang</label>
                <select id="bidang_id" name="bidang_id" class="form-control">
                    <option value="">-- Semua Bidang --</option>
                    @foreach($bidangs as $bidang)
                        <option value="{{ $bidang->id }}" {{ request('bidang_id') == $bidang->id ? 'selected' : '' }}>
                            {{ $bidang->nama_bidang }}
                        </option>
                    @endforeach
                </select>
            </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">🔍 Cari</button>
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">🔄 Reset</a>
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h2>Data Absensi</h2>
    </div>
    
    @if($absensis->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--light); text-align: left;">
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">No</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Tanggal & Jam</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Nama</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Instansi</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Bidang</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Absensi</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Lokasi</th>
                        <th style="padding: 12px; border-bottom: 2px solid #e2e8f0;">Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $index => $absensi)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 12px;">{{ $absensis->firstItem() + $index }}</td>
                            <td style="padding: 12px;">
                                {{ $absensi->tanggal->format('d/m/Y') }}<br>
                                <small style="color: var(--gray);">{{ date('H:i', strtotime($absensi->jam)) }} WIB</small>
                            </td>
                            <td style="padding: 12px; font-weight: 600;">{{ $absensi->nama }}</td>
                            <td style="padding: 12px;">{{ $absensi->instansi }}</td>
                            <td style="padding: 12px;">
                                <span style="background: var(--light); padding: 4px 10px; border-radius: 4px; font-size: 13px;">
                                    {{ $absensi->bidang->nama_bidang }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                @if($absensi->jenis_absen == 'masuk')
                                    <span style="background: #d1fae5; color: #065f46; padding: 4px 12px; border-radius: 4px; font-size: 13px; font-weight: 600;">
                                        Masuk
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 4px; font-size: 13px; font-weight: 600;">
                                        Pulang
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 12px; font-size: 12px;">
                                @if($absensi->latitude && $absensi->longitude)
                                    <a href="https://www.google.com/maps?q={{ $absensi->latitude }},{{ $absensi->longitude }}" 
                                       target="_blank" 
                                       style="color: var(--primary); text-decoration: none;">
                                        📍 Lihat Map
                                    </a>
                                    <br>
                                    <small style="color: var(--gray);">{{ Str::limit($absensi->alamat_lokasi ?? 'Lokasi tidak tersedia', 30) }}</small>
                                @else
                                    <span style="color: var(--gray);">-</span>
                                @endif
                            </td>
                            <td style="padding: 12px;">
                                @if($absensi->foto)
                                    <img src="{{ asset($absensi->foto) }}" 
                                         alt="Foto" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                                         onclick="showImageModal('{{ asset($absensi->foto) }}')">
                                @else
                                    <span style="color: var(--gray);">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            {{ $absensis->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: var(--gray);">
            <div style="font-size: 60px; margin-bottom: 15px;">📭</div>
            <p style="font-size: 16px;">Tidak ada data absensi yang ditemukan.</p>
        </div>
    @endif
</div>

<!-- Modal for image preview -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;" onclick="closeImageModal()">
    <div style="position: relative; max-width: 90%; max-height: 90%;">
        <img id="modalImage" src="" alt="Preview" style="max-width: 100%; max-height: 90vh; border-radius: 8px;">
        <button onclick="closeImageModal()" style="position: absolute; top: 10px; right: 10px; background: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; font-size: 20px;">×</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Pagination styling */
    nav[role="navigation"] {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    nav[role="navigation"] a,
    nav[role="navigation"] span {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        text-decoration: none;
        color: var(--primary);
        background: white;
    }

    nav[role="navigation"] span[aria-current="page"] {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    nav[role="navigation"] a:hover {
        background: var(--light);
    }
</style>
@endpush