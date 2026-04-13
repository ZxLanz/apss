<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus kolom jurusan string jika masih ada
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'jurusan')) {
                $table->dropColumn('jurusan');
            }
        });

        // Tambah kolom jurusan_id jika belum ada
        Schema::table('siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas', 'jurusan_id')) {
                $table->unsignedBigInteger('jurusan_id')->nullable()->after('kelas');
                $table->foreign('jurusan_id')->references('id')->on('jurusans')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Drop foreign key
            if (Schema::hasColumn('siswas', 'jurusan_id')) {
                $table->dropForeign(['jurusan_id']);
                $table->dropColumn('jurusan_id');
            }
        });

        // Add back string jurusan column
        Schema::table('siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas', 'jurusan')) {
                $table->string('jurusan')->nullable();
            }
        });
    }
};
