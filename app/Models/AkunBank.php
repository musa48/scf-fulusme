<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemodal_id',
        'nomer_rekening',
        'nama_pemilik_rekening',
        'nama_bank',
        'kabupaten_cabang_bank',
        'provinsi_cabang_bank',
        'nama_ibu_kandung',
        'nama_ahli_waris',
        'nomor_rekening_custodian',
        'nama_rekening_custodian'
    ];

    protected $table = 'pemodal_akun_bank';

    public function pemodal()
    {
        return $this->belongsTo(Pemodal::class);
    }
}
