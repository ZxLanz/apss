<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hanya tambah migration untuk membuat tabel jurusans tanpa mengubah siswas dulu
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan')->unique();
            $table->string('kode_jurusan')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Insert data jurusan
        DB::table('jurusans')->insert([
            [
                'nama_jurusan' => 'TJKT',
                'kode_jurusan' => 'TJKT',
                'deskripsi' => 'Teknik Jaringan Komputer & Telekomunikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => '13 TGP',
                'kode_jurusan' => 'TGP',
                'deskripsi' => 'Teknik Geomatika Pertambangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'BC',
                'kode_jurusan' => 'BC',
                'deskripsi' => 'Broadcast',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'OTO',
                'kode_jurusan' => 'OTO',
                'deskripsi' => 'Otomotif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'PPLG',
                'kode_jurusan' => 'PPLG',
                'deskripsi' => 'Pengembangan Perangkat Lunak & Gim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'TOI',
                'kode_jurusan' => 'TOI',
                'deskripsi' => 'Teknik Otomotif Industri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jurusan' => 'TPM',
                'kode_jurusan' => 'TPM',
                'deskripsi' => 'Teknik Pemeliharaan Mesin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
