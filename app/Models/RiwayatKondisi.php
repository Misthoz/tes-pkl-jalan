<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKondisi extends Model
{
    protected $table = 'riwayat_kondisi';

    protected $fillable = [
        'jalan_id',
        'tanggal_survei',
        'kondisi',
        'keterangan',
        'user_id'
    ];

    public function jalan()
    {
        return $this->belongsTo(jalan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
