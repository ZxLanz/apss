<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanPengaduan;
use App\Models\Kategori;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanPengaduanController extends Controller
{
    public function create()
    {
        $kategori = Kategori::all();

        return view('siswa.laporan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'ket'         => 'required|string',
            'lokasi'      => 'required|string|max:255',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Smart Duplicate Check: Prevent reporting same thing at same location if not resolved
        $isDuplicate = LaporanPengaduan::where('kategori_id', $request->kategori_id)
            ->whereRaw('LOWER(lokasi) = ?', [strtolower(trim($request->lokasi))])
            ->where(function($query) {
                $query->whereDoesntHave('aspirasi')
                      ->orWhereHas('aspirasi', function($q) {
                          $q->whereIn('status', ['menunggu', 'proses']);
                      });
            })
            ->exists();

        if ($isDuplicate) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Laporan untuk kategori dan lokasi ini sudah ada dan sedang ditangani oleh petugas. Anda tidak perlu mengirim laporan yang sama.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan', 'public');
        }

        LaporanPengaduan::create([
            'siswa_id'    => Auth::guard('siswa')->user()->id,
            'kategori_id' => $request->kategori_id,
            'ket'         => $request->ket,
            'lokasi'      => $request->lokasi,
            'foto'        => $fotoPath,
        ]);

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Laporan berhasil dikirim');
    }

    public function show(LaporanPengaduan $laporan)
    {
        abort_if($laporan->siswa_id !== Auth::guard('siswa')->id(), 403, 'Akses ditolak.');

        $laporan->load(['siswa', 'aspirasi', 'kategori']);

        return view('siswa.laporan.show', [
            'laporan' => $laporan
        ]);
    }

    public function destroy(LaporanPengaduan $laporan)
    {
        abort_if($laporan->siswa_id !== Auth::guard('siswa')->id(), 403, 'Akses ditolak.');

        if ($laporan->foto && Storage::disk('public')->exists($laporan->foto)) {
            Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Laporan berhasil dihapus');
    }

    public function feedback(Request $request, Aspirasi $aspirasi)
    {
        abort_if($aspirasi->laporan->siswa_id !== Auth::guard('siswa')->id(), 403);
        abort_if($aspirasi->feedback !== null, 400, 'Anda sudah memberikan feedback sebelumnya.');

        $request->validate([
            'feedback' => 'required|integer|min:1|max:5',
        ]);

        $aspirasi->update($request->all());

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Terima kasih atas feedback Anda.');
    }
}
