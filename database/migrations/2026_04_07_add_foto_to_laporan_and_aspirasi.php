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
        // Tambah kolom foto ke laporan_pengaduans untuk foto kerusakan
        Schema::table('laporan_pengaduans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_pengaduans', 'foto')) {
                $table->string('foto')->nullable()->after('lokasi');
            }
        });

        // Tambah kolom foto_perbaikan ke aspirasis untuk foto hasil perbaikan
        Schema::table('aspirasis', function (Blueprint $table) {
            if (!Schema::hasColumn('aspirasis', 'foto_perbaikan')) {
                $table->string('foto_perbaikan')->nullable()->after('feedback');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pengaduans', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_pengaduans', 'foto')) {
                $table->dropColumn('foto');
            }
        });

        Schema::table('aspirasis', function (Blueprint $table) {
            if (Schema::hasColumn('aspirasis', 'foto_perbaikan')) {
                $table->dropColumn('foto_perbaikan');
            }
        });
    }
};
