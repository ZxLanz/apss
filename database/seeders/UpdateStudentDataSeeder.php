<?php

namespace Database\Seeders;

use App\Models\MasterSiswa;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class UpdateStudentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filename = base_path('Data Siswa kls 12 dan 13.xlsx');

        if (!file_exists($filename)) {
            $this->command->error("File not found: $filename");
            return;
        }

        $this->command->info("Reading student data from Excel...");

        $zip = new ZipArchive();
        if ($zip->open($filename) !== TRUE) {
            $this->command->error("Could not open $filename");
            return;
        }

        // 1. Read shared strings
        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml) {
            $xml = simplexml_load_string($sharedStringsXml);
            foreach ($xml->si as $si) {
                // Shared strings can be in <t> or nested in <r><t>
                if (isset($si->t)) {
                    $sharedStrings[] = (string)$si->t;
                } else if (isset($si->r)) {
                    $t = "";
                    foreach ($si->r as $r) {
                        $t .= (string)$r->t;
                    }
                    $sharedStrings[] = $t;
                } else {
                    $sharedStrings[] = "";
                }
            }
        }

        // 2. Read sheet1
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (!$sheetXml) {
            $this->command->error("Sheet1 not found in $filename");
            $zip->close();
            return;
        }

        $xml = simplexml_load_string($sheetXml);
        
        // Truncate master_siswas first to refresh data
        DB::table('master_siswas')->truncate();
        
        $count = 0;
        foreach ($xml->sheetData->row as $row) {
            $rowData = [];
            
            // Map cells by their reference column (A, B, C...)
            // This is safer because empty cells might be skipped in sheetData
            foreach ($row->c as $cell) {
                $ref = (string)$cell['r'];
                $col = preg_replace('/[0-9]/', '', $ref);
                
                $value = (string)$cell->v;
                $type = (string)$cell['t'];
                
                if ($type == 's') {
                    $value = $sharedStrings[(int)$value] ?? '';
                }
                
                $rowData[$col] = trim($value);
            }

            // Based on observation:
            // Column B (B) = Nama
            // Column C (C) = NIS
            // Column F (F) = Kelas
            
            $nama = $rowData['B'] ?? null;
            $nis = $rowData['C'] ?? null;
            $kelas = $rowData['F'] ?? null;

            // Skip header if it's "Nama" or empty
            if (!$nis || $nis == "NIS" || !is_numeric($nis)) {
                continue;
            }

            if ($nama && $nis && $kelas) {
                MasterSiswa::create([
                    'nis'   => $nis,
                    'nama'  => $nama,
                    'kelas' => $kelas,
                ]);

                // Also ensure every student has a default login record in 'siswas'
                Siswa::updateOrCreate(
                    ['nis' => $nis],
                    [
                        'nama'     => $nama,
                        'kelas'    => $kelas,
                        'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                    ]
                );

                $count++;
            }
        }

        $zip->close();
        $this->command->info("Successfully imported $count students into master_siswas.");
    }
}
