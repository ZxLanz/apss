<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = [
            [
                'nama_jurusan' => 'TJKT',
                'kode_jurusan' => 'TJKT',
                'deskripsi' => 'Teknik Jaringan Komputer & Telekomunikasi',
            ],
            [
                'nama_jurusan' => '13 TGP',
                'kode_jurusan' => 'TGP',
                'deskripsi' => 'Teknik Geomatika Pertambangan',
            ],
            [
                'nama_jurusan' => 'BC',
                'kode_jurusan' => 'BC',
                'deskripsi' => 'Broadcast',
            ],
            [
                'nama_jurusan' => 'OTO',
                'kode_jurusan' => 'OTO',
                'deskripsi' => 'Otomotif',
            ],
            [
                'nama_jurusan' => 'PPLG',
                'kode_jurusan' => 'PPLG',
                'deskripsi' => 'Pengembangan Perangkat Lunak & Gim',
            ],
            [
                'nama_jurusan' => 'TOI',
                'kode_jurusan' => 'TOI',
                'deskripsi' => 'Teknik Otomotif Industri',
            ],
            [
                'nama_jurusan' => 'TPM',
                'kode_jurusan' => 'TPM',
                'deskripsi' => 'Teknik Pemeliharaan Mesin',
            ],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::updateOrCreate(
                ['kode_jurusan' => $jurusan['kode_jurusan']],
                $jurusan
            );
        }
    }
}
