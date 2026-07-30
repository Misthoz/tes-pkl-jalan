<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jalan extends Model
{
    use SoftDeletes;

    protected $table = 'jalan';

    protected $fillable = [
        'kelurahan_id',
        'nama_jalan',
        'panjang_meter',
        'lebar_meter',
        'jenis_permukaan',
        'kondisi',
        'tahun_pendataan',
        'keterangan'
    ];

    public function kelurahan()
    {
        return $this->belongsTo(kelurahan::class);
    }
}
