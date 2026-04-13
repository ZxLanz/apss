<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPengaduan;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanAspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanPengaduan::with(['kategori', 'aspirasi', 'siswa'])->latest();
        $this->applyFilters($query, $request);

        $laporan = $query->paginate(10)->withQueryString();
        $kategoriList = \App\Models\Kategori::all();

        return view('admin.laporan.index', compact('laporan', 'kategoriList'));
    }

    public function show(LaporanPengaduan $laporan)
    {
        $laporan->load(['kategori', 'aspirasi']);

        return view('admin.laporan.show', compact('laporan'));
    }

    public function update(Request $request, LaporanPengaduan $laporan)
    {
        // Validasi perubahan status oleh admin
        $request->validate([
            'status' => 'required|in:proses,selesai',
            'foto_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $currentStatus = $laporan->aspirasi?->status ?? 'menunggu';

        // Handle upload foto perbaikan jika status selesai
        $fotoPerbaikanPath = null;
        if ($request->status === 'selesai' && $request->hasFile('foto_perbaikan')) {
            $fotoPerbaikanPath = $request->file('foto_perbaikan')->store('perbaikan', 'public');
        } elseif ($laporan->aspirasi && $laporan->aspirasi->foto_perbaikan) {
            // Keep existing foto if not updating
            $fotoPerbaikanPath = $laporan->aspirasi->foto_perbaikan;
        }

        // Menggunakan updateOrCreate agar lebih fleksibel
        Aspirasi::updateOrCreate(
            ['laporan_id' => $laporan->id], // Cari berdasarkan laporan_id
            [
                'admin_id'   => Auth::guard('admin')->id(),
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
                'foto_perbaikan' => $fotoPerbaikanPath,
            ]
        );

        // Notifikasi ke Siswa
        if ($laporan->siswa) {
            $laporan->siswa->notify(new \App\Notifications\StatusLaporanUpdated($laporan));
        }

        return redirect()
            ->route('admin.laporan.index')
            ->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    public function destroy(LaporanPengaduan $laporan)
    {
        try {
            // Hapus foto laporan asli jika ada
            if ($laporan->foto && Storage::disk('public')->exists($laporan->foto)) {
                Storage::disk('public')->delete($laporan->foto);
            }

            // Hapus aspirasi dan foto perbaikannya
            if ($laporan->aspirasi) {
                if ($laporan->aspirasi->foto_perbaikan && Storage::disk('public')->exists($laporan->aspirasi->foto_perbaikan)) {
                    Storage::disk('public')->delete($laporan->aspirasi->foto_perbaikan);
                }
                $laporan->aspirasi->delete();
            }

            // Hapus laporan pengaduan
            $laporan->delete();

            return redirect()
                ->route('admin.laporan.index')
                ->with('success', 'Laporan pengaduan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.laporan.index')
                ->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $query = LaporanPengaduan::with(['kategori', 'aspirasi', 'siswa'])->latest();
        $this->applyFilters($query, $request);
        $laporan = $query->get();

        $filename = "Laporan_APSS_" . date('Ymd_Hi') . ".xls";

        // Generate XML Spreadsheet 2003 (SpreadsheetML)
        $xml = view('admin.laporan.export_xml', compact('laporan'))->render();

        return response($xml)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"")
            ->header('Cache-Control', 'max-age=0');
    }

    private function applyFilters($query, Request $request)
    {
        // Logika Filter Status
        if ($request->filled('status') && $request->status !== 'semua') {
            if ($request->status === 'belum') {
                $query->where(function (\Illuminate\Database\Eloquent\Builder $q) {
                    $q->whereDoesntHave('aspirasi')
                      ->orWhereHas('aspirasi', function (\Illuminate\Database\Eloquent\Builder $sub) {
                          $sub->where('status', 'menunggu');
                      });
                });
            } else {
                $query->whereHas('aspirasi', function (\Illuminate\Database\Eloquent\Builder $q) use ($request) {
                    $q->where('status', $request->status);
                });
            }
        }
        
        // Logika Filter Kategori
        if ($request->filled('kategori_id') && $request->kategori_id !== 'semua') {
            $query->where('kategori_id', $request->kategori_id);
        }
        
        // Logika Filter Search string
        if ($request->filled('search')) {
            $query->where(function (\Illuminate\Database\Eloquent\Builder $q) use ($request) {
                $q->where('ket', 'like', "%{$request->search}%")
                  ->orWhereHas('siswa', function (\Illuminate\Database\Eloquent\Builder $s) use ($request) {
                      $s->where('nama', 'like', "%{$request->search}%");
                  });
            });
        }
        
        // Logika Filter Kelas
        if ($request->filled('kelas') && $request->kelas !== 'semua') {
            $query->whereHas('siswa', function (\Illuminate\Database\Eloquent\Builder $q) use ($request) {
                $q->where('kelas', 'like', $request->kelas . '%');
            });
        }
        
        // Logika Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
    }
}