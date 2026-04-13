<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
   use HasFactory;

   protected $fillable = [
      'laporan_id',
      'admin_id',
      'status',
      'feedback',
      'keterangan',
      'foto_perbaikan',
   ];

   public static function getFeedbackLabels()
   {
       return [
            1 => 'Tidak Puas',
            2 => 'Kurang Puas',
            3 => 'Cukup Puas',
            4 => 'Puas',
            5 => 'Sangat Puas',
       ];
   }

   public function getFeedbackLabelAttribute()
   {
       if (!$this->feedback) return 'Belum ada feedback';
       return self::getFeedbackLabels()[$this->feedback] ?? '-';
   }

   public function laporan()
   {
      return $this->belongsTo(LaporanPengaduan::class, 'laporan_id');
   }

   public function admin()
   {
      return $this->belongsTo(Admin::class);
   }
}
