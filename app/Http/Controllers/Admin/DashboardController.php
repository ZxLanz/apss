<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\LaporanPengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil total keseluruhan data
        $totalSiswa = Siswa::count();
        $totalLaporan = LaporanPengaduan::count();

        // Menghitung laporan dengan status 'proses' melalui relasi 'aspirasi'
        $laporanProses = LaporanPengaduan::whereHas('aspirasi', function (\Illuminate\Database\Eloquent\Builder $q) {
            $q->where('status', 'proses');
        })->count();

        // Menghitung laporan dengan status 'selesai' melalui relasi 'aspirasi'
        $laporanSelesai = LaporanPengaduan::whereHas('aspirasi', function (\Illuminate\Database\Eloquent\Builder $q) {
            $q->where('status', 'selesai');
        })->count();

        // Menghitung laporan dengan status 'menunggu' (belum di-approve/diproses)
        $laporanMenunggu = LaporanPengaduan::where(function (\Illuminate\Database\Eloquent\Builder $q) {
            $q->whereDoesntHave('aspirasi')
              ->orWhereHas('aspirasi', function (\Illuminate\Database\Eloquent\Builder $sub) {
                  $sub->where('status', 'menunggu');
              });
        })->count();

        // Mengambil 5 laporan terbaru beserta relasinya
        $laporanTerbaru = LaporanPengaduan::with(['siswa', 'kategori', 'aspirasi'])
            ->latest()
            ->take(5)
            ->get();
        // Mengambil data untuk chart kategori
        $kategoriStats = \App\Models\Kategori::withCount('laporan')->get();
        $chartLabels = $kategoriStats->pluck('nama_kategori');
        $chartData = $kategoriStats->pluck('laporan_count');

        // Mengirimkan data ke view admin.dashboard
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalLaporan',
            'laporanMenunggu',
            'laporanProses',
            'laporanSelesai',
            'laporanTerbaru',
            'chartLabels',
            'chartData'
        ));
    }
}
