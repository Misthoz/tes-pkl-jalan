<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kecamatan extends Model
{
    use SoftDeletes;    

    protected $table = 'kecamatan';
    
    protected $fillable = [
        'nama_kecamatan'
    ];

    public function kelurahan()
    {
        return $this->hasMany(kelurahan::class);
    }
}
