<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemodal_id',
        'ktp',
        'npwp',
        'swa_photo',
        'slip_gaji',
        'kartu_keluarga'
    ];

    protected $table = 'pemodal_berkas';

    public function pemodal()
    {
        return $this->belongsTo(Pemodal::class);
    }
}
