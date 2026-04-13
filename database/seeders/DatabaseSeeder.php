<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\LaporanPengaduan;
use App\Models\Siswa;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin
        $admin = Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('AdminSekolah123!')
            ]
        );

        // Kategori - Common categories for school sarana/prasarana
        $kategoris = [
            'Bangunan & Gedung',
            'Sarana Belajar',
            'Elektronik & IT',
            'Fasilitas Umum',
            'Lainnya'
        ];

        foreach ($kategoris as $k) {
            Kategori::updateOrCreate(['nama_kategori' => $k]);
        }

    }
}
