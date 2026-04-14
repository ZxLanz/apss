<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

    public function export()
    {
        $siswa = Siswa::with('jurusan')->latest()->get();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set Header
        $sheet->setCellValue('A1', 'NIS');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Kelas');
        $sheet->setCellValue('D1', 'Jurusan');
        $sheet->setCellValue('E1', 'Tanggal Terdaftar');
        
        // Style Header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');

        // Add Data
        $row = 2;
        foreach ($siswa as $item) {
            $sheet->setCellValue('A' . $row, $item->nis);
            $sheet->setCellValue('B' . $row, $item->nama);
            $sheet->setCellValue('C' . $row, $item->kelas);
            $sheet->setCellValue('D' . $row, $item->jurusan?->nama_jurusan ?? '-');
            $sheet->setCellValue('E' . $row, $item->created_at->format('d/m/Y H:i'));
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = "Data_Siswa_APSS_" . date('Ymd_His') . ".xlsx";
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function downloadTemplate()
    {
        $filename = "Template_Import_Siswa_" . date('Ymd_His') . ".csv";
        
        // Create CSV content with proper formatting
        $output = "NIS,Nama,Kelas,Jurusan_ID\n";
        $output .= "75323623,Syarahatu Milkiyyah,XII,1\n";
        $output .= "96900874,Syifa Febriani,XII,2\n";
        
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
            $spreadsheet = IOFactory::load($file->getRealPath());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Remove header
            array_shift($rows);

            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak memiliki data atau format tidak sesuai.'
                ], 422);
            }

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty($row[0]) || empty($row[1]) || empty($row[2])) continue;

                try {
                    $nis = trim($row[0]);
                    $nama = trim($row[1]);
                    $kelasRaw = trim($row[2]);
                    
                    // Clean up kelas (e.g., "XII BC A" -> "XII")
                    $kelasPrefix = strtoupper(explode(' ', $kelasRaw)[0]);

                    // Check if NIS already exists
                    if (Siswa::where('nis', $nis)->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": NIS {$nis} sudah terdaftar.";
                        continue;
                    }

                    // Validate kelas
                    if (!in_array($kelasPrefix, ['X', 'XI', 'XII', 'XIII'])) {
                        $errors[] = "Baris " . ($index + 2) . ": Kelas '{$kelasPrefix}' tidak valid. Harus X, XI, XII, atau XIII.";
                        continue;
                    }

                    $jurusan_id = !empty($row[3]) ? (int)$row[3] : null;
                    if ($jurusan_id && !Jurusan::where('id', $jurusan_id)->exists()) {
                        $errors[] = "Baris " . ($index + 2) . ": Jurusan ID {$jurusan_id} tidak ditemukan.";
                        continue;
                    }

                    Siswa::create([
                        'nis' => $nis,
                        'nama' => $nama,
                        'kelas' => $kelasPrefix,
                        'jurusan_id' => $jurusan_id,
                        'password' => Hash::make($nis), // Default password is NIS
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
