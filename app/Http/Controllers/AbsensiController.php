<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;

class AbsensiController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::where('is_active', true)->orderBy('nama_bidang')->get();
        return view('absensi.index', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidangs,id',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'alamat_lokasi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Resize dan compress image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->scale(width: 800);
            
            // Save to public/uploads/absensi
            $path = public_path('uploads/absensi');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            
            $img->save($path . '/' . $filename, quality: 80);
            $validated['foto'] = 'uploads/absensi/' . $filename;
        }

        $validated['tanggal'] = now()->toDateString();
        $validated['jam'] = now()->toTimeString();

        Absensi::create($validated);

        return redirect()->route('absensi.success')->with('success', 'Absensi berhasil dicatat!');

        if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $filename = time() . '_' . uniqid() . '.jpg';
        
        $path = public_path('uploads/absensi');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        // Resize dan compress dengan Intervention Image
        Image::read($image)
            ->scale(width: 800)
            ->save($path . '/' . $filename, quality: 80);
        
        $validated['foto'] = 'uploads/absensi/' . $filename;
        }
    }

    public function success()
    {
        return view('absensi.success');
    }
}