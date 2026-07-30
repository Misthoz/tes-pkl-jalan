<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kelurahan extends Model
{
    use SoftDeletes;

    protected $table = 'kelurahan';
    
    protected $fillable = [
        'kecamatan_id',
        'nama_kelurahan'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(kecamatan::class);
    }

    public function jalan()
    {
        return $this->hasMany(jalan::class);
    }
}
