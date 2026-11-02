<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamDetail extends Model
{
    use HasFactory;
    protected $table = 'pinjam_detail';

    protected $guarded = [
        'id',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function petugas_kembali()
    {
        return $this->belongsTo(User::class, 'id_petugas_kembali');
    }
}
