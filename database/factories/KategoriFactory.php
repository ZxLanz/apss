<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategori>
 */
class KategoriFactory extends Factory
{
    public function definition(): array
    {
        $facilities = ['Fasilitas Kelas', 'Kantin', 'Toilet', 'Perpustakaan', 'Laboratorium Komputer', 'Laboratorium IPA', 'Lapangan Olahraga', 'Ruang Guru', 'Area Parkir', 'Masjid/Mushola'];
        return [
            'nama_kategori' => empty($facilities) ? fake('id_ID')->unique()->word() : $this->faker->unique()->randomElement($facilities),
        ];
    }
}
