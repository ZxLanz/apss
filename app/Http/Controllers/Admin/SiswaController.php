<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('jurusan')->latest();

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%")
                  ->orWhere('kelas', 'like', "%{$request->search}%");
            });
        }

        $siswa = $query->paginate(15)->withQueryString();

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.siswa.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis|digits_between:5,10',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|in:X,XI,XII,XIII',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nis.required' => 'NIS harus diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nis.digits_between' => 'NIS harus 5-10 digit.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas harus dipilih.',
            'kelas.in' => 'Kelas tidak valid.',
            'jurusan_id.exists' => 'Jurusan tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        Siswa::create([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'jurusan_id' => $validated['jurusan_id'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.siswa.edit', compact('siswa', 'jurusans'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $siswa->id . '|digits_between:5,10',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|in:X,XI,XII,XIII',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nis.required' => 'NIS harus diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nis.digits_between' => 'NIS harus 5-10 digit.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas harus dipilih.',
            'kelas.in' => 'Kelas tidak valid.',
            'jurusan_id.exists' => 'Jurusan tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $siswa->update([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas' => $validated['kelas'],
            'jurusan_id' => $validated['jurusan_id'] ?? null,
            ...(filled($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['jurusan', 'laporan' => function($q) {
            $q->latest()->take(10);
        }]);
        
        return view('admin.siswa.show', compact('siswa'));
    }

    public function destroy(Siswa $siswa)
    {
        // Hapus foto profil siswa jika ada
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        // Hapus semua laporan dan media terkait secara individual untuk memastikan file storage terhapus
        foreach ($siswa->laporan as $laporan) {
            // Hapus foto laporan asli
            if ($laporan->foto && Storage::disk('public')->exists($laporan->foto)) {
                Storage::disk('public')->delete($laporan->foto);
            }

            // Hapus foto perbaikan jika ada aspirasi
            if ($laporan->aspirasi && $laporan->aspirasi->foto_perbaikan && Storage::disk('public')->exists($laporan->aspirasi->foto_perbaikan)) {
                Storage::disk('public')->delete($laporan->aspirasi->foto_perbaikan);
            }

            $laporan->delete();
        }

        // Hapus notifikasi terkait
        $siswa->notifications()->delete();

        // Hapus siswa
        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $filename = "Template_Import_Siswa_" . date('Ymd_His') . ".csv";
        
        // Create CSV content with proper formatting
        $output = "NIS,Nama,Kelas,Jurusan ID,Email\n";
        $output .= "75323623,Syarahatu Milkiyyah,XII BC A,1,ahmad@example.com\n";
        $output .= "96900874,Syifa Febriani,XII BC A,2,budi@example.com\n";
        $output .= "86592792,Taurina Azzahra,XII BC A,3,citra@example.com\n";
        $output .= "82222939,Tia Ramadani,XII BC A,4,\n";
        $output .= "87158319,Wafiq Azizah,XII BC A,5,\n";
        $output .= "82621994,Wira Wardana,XII BC A,6,\n";
        $output .= "89543244,Wisnu Hidayat,XII BC A,7,\n";
        
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Add BOM for Excel UTF-8 support
        echo "\xEF\xBB\xBF" . $output;
        exit;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('file');
            $data = [];

            // Handle Excel by reading as CSV
            if (in_array($file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
                // For Excel files, try to read as CSV-like structure
                if (($handle = fopen($file->getRealPath(), "r")) !== false) {
                    // Skip header
                    $header = fgetcsv($handle);
                    
                    while (($row = fgetcsv($handle)) !== false) {
                        if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                            // Extract kelas prefix from full format (e.g., "XII BC A" -> "XII")
                            $kelasRaw = trim($row[2]);
                            $kelasPrefix = explode(' ', $kelasRaw)[0]; // Get first part before space
                            
                            $data[] = [
                                'nis' => trim($row[0]),
                                'nama' => trim($row[1]),
                                'kelas' => $kelasPrefix,
                                'jurusan_id' => !empty($row[3]) ? (int)$row[3] : null,
                                'email' => !empty($row[4]) ? trim($row[4]) : null,
                            ];
                        }
                    }
                    fclose($handle);
                }
            } else {
                // Handle CSV
                if (($handle = fopen($file->getRealPath(), "r")) !== false) {
                    // Skip header
                    $header = fgetcsv($handle);
                    
                    while (($row = fgetcsv($handle)) !== false) {
                        if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                            // Extract kelas prefix from full format (e.g., "XII BC A" -> "XII")
                            $kelasRaw = trim($row[2]);
                            $kelasPrefix = explode(' ', $kelasRaw)[0]; // Get first part before space
                            
                            $data[] = [
                                'nis' => trim($row[0]),
                                'nama' => trim($row[1]),
                                'kelas' => $kelasPrefix,
                                'jurusan_id' => !empty($row[3]) ? (int)$row[3] : null,
                                'email' => !empty($row[4]) ? trim($row[4]) : null,
                            ];
                        }
                    }
                    fclose($handle);
                }
            }

            if (empty($data)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak memiliki data atau format tidak sesuai.'
                ], 422);
            }

            // Import data
            $imported = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                try {
                    // Check if NIS already exists
                    if (Siswa::where('nis', $row['nis'])->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": NIS {$row['nis']} sudah terdaftar.";
                        continue;
                    }

                    // Validate kelas - must be X, XI, XII, or XIII
                    if (!in_array($row['kelas'], ['X', 'XI', 'XII', 'XIII'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Kelas '{$row['kelas']}' tidak valid.";
                        continue;
                    }

                    // Validate jurusan_id if provided
                    if ($row['jurusan_id'] && !Jurusan::where('id', $row['jurusan_id'])->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": Jurusan ID {$row['jurusan_id']} tidak ditemukan.";
                        continue;
                    }

                    // Create siswa with default password
                    Siswa::create([
                        'nis' => $row['nis'],
                        'nama' => $row['nama'],
                        'kelas' => $row['kelas'],
                        'jurusan_id' => $row['jurusan_id'],
                        'email' => $row['email'],
                        'password' => Hash::make($row['nis']), // Default password is NIS
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            $message = "$imported siswa berhasil diimport.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " baris memiliki error.";
                if (count($errors) <= 5) {
                    $message .= "\n\nError:\n" . implode("\n", $errors);
                }
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file: ' . $e->getMessage()
            ], 422);
        }
    }
}
