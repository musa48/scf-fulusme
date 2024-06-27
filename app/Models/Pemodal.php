<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemodal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_depan',
        'nama_belakang',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_handphone',
        'no_ktp',
        'no_npwp',
        'no_sid',
        'agama',
        'kewarganegaraan',
        'alamat_ktp',
        'kelurahan_ktp',
        'kecamatan_ktp',
        'kabupaten_ktp',
        'provinsi_ktp',
        'alamat_domisili',
        'kelurahan_domisili',
        'kecamatan_domisili',
        'kabupaten_domisili',
        'provinsi_domisili',
        'pendidikan_terakhir',
        'pekerjaan',
        'industri_pekerjaan',
        'pendapatan_per_bulan',
        'sumber_pendapatan',
        'deskripsi_bisnis',
        'deskripsi_sumber_pendapatan'
    ];

    protected $table = 'pemodals';

    public function akunbank() {
        return $this->hasOne(AkunBank::class);
    }

    public function pemodalBerkas() {
        return $this->hasOne(Berkas::class);
    }
}
