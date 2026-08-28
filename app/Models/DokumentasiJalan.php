<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiJalan extends Model
{
    protected $table = 'dokumentasi_jalan';

    protected $fillable = [
        'jalan_id',
        'foto',
        'tanggal_dokumentasi',
        'keterangan'
    ];

    public function jalan()
    {
        return $this->belongsTo(jalan::class);
    }
}
