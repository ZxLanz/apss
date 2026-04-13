<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AkunController extends Controller
{
    public function edit()
    {
        return view('siswa.akun', [
            'siswa' => Auth::guard('siswa')->user()
        ]);
    }

    public function update(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'nama'  => 'required|string|max:100',
            'kelas' => 'required|string|max:50',
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama'  => $request->input('nama'),
            'kelas' => $request->input('kelas'),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($siswa->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($siswa->foto);
            }

            $path = $request->file('foto')->store('profile_pictures', 'public');
            $data['foto'] = $path;
        }

        $siswa->update($data);

        return redirect()
            ->route('siswa.dashboard')
            ->with('success', 'Data akun berhasil diperbarui');
    }
}
