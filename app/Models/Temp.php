<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Temp extends Model
{
    use HasFactory;
    protected $table = 'temp';

    protected $fillable = [
        'id_buku',
        'id_user',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
