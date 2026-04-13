<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterSiswa extends Model
{
    use HasFactory;

    protected $fillable = ['nis', 'nama', 'kelas'];
}
