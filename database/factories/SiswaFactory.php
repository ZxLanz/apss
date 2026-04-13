<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake('id_ID')->unique()->numerify('1020##'),
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'nama' => fake('id_ID')->name(),
            'kelas' => fake('id_ID')->randomElement([
                'X PPLG 1', 'X PPLG 2', 'X TKJ 1',
                'XI PPLG 1', 'XI PPLG 2', 'XI TKJ 1',
                'XII PPLG 1', 'XII PPLG 2', 'XII TKJ 1',
            ]),
        ];
    }
}
