<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bidang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with('bidang')->orderBy('created_at', 'desc');

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            $query->whereDate('tanggal', today());
        }

        // Filter by bidang
        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }

        // Filter by jenis absen
        if ($request->filled('jenis_absen')) {
            $query->where('jenis_absen', $request->jenis_absen);
        }

        $absensis = $query->paginate(20);
        $bidangs = Bidang::where('is_active', true)->orderBy('nama_bidang')->get();

        $stats = [
            'total_hari_ini' => Absensi::whereDate('tanggal', today())->count(),
            'masuk_hari_ini' => Absensi::whereDate('tanggal', today())->where('jenis_absen', 'masuk')->count(),
            'pulang_hari_ini' => Absensi::whereDate('tanggal', today())->where('jenis_absen', 'pulang')->count(),
            'total_bulan_ini' => Absensi::whereMonth('tanggal', now()->month)->count(),
        ];

        return view('dashboard.index', compact('absensis', 'bidangs', 'stats'));
    }
}