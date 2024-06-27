<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwaFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemodal_id',
        'swa_photo'
    ];

    protected $table = 'pemodal_berkas';
}
