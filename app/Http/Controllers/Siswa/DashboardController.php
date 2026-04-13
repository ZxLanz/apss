<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        // Calculate stats
        $stats = [
            'menunggu' => $siswa->laporan()->whereDoesntHave('aspirasi', function($q){
                $q->where('status', '!=', 'menunggu');
            })->count(),
            'proses' => $siswa->laporan()->whereHas('aspirasi', function($q) {
                $q->where('status', 'proses');
            })->count(),
            'selesai' => $siswa->laporan()->whereHas('aspirasi', function($q) {
                $q->where('status', 'selesai');
            })->count(),
        ];

        $query = $siswa->laporan()->with(['kategori', 'aspirasi'])->latest();
        
        // Search & Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ket', 'like', "%{$request->search}%")
                  ->orWhere('lokasi', 'like', "%{$request->search}%")
                  ->orWhereHas('kategori', function($qKategori) use ($request) {
                      $qKategori->where('nama_kategori', 'like', "%{$request->search}%");
                  });
            });
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'menunggu') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('aspirasi')
                      ->orWhereHas('aspirasi', function ($sub) {
                          $sub->where('status', 'menunggu');
                      });
                });
            } else {
                $query->whereHas('aspirasi', function($q) use ($request) {
                    $q->where('status', $request->status);
                });
            }
        }

        $laporan = $query->paginate(10)->withQueryString();

        $kepuasan = [
            1 => 'Tidak Puas',
            2 => 'Kurang Puas',
            3 => 'Cukup Puas',
            4 => 'Puas',
            5 => 'Sangat Puas',
        ];

        $laporan->getCollection()->transform(function ($item) use ($kepuasan) {
            $item->status = $item->aspirasi?->status ?? 'menunggu';

            $nilai = $item->aspirasi?->feedback ?? null;
            $item->feedback = $nilai 
                ? ($kepuasan[$nilai] ?? '-') 
                : 'Belum ada feedback';

            return $item;
        });

        return view('siswa.dashboard', compact('laporan', 'stats'));
    }
}
