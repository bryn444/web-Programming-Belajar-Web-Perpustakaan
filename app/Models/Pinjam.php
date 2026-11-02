<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;
    protected $table = 'pinjam';

    protected $guarded = [
        'id',
    ];

    public function pinjam_detail()
    {
        return $this->hasMany(PinjamDetail::class, 'no_pinjam', 'no_pinjam');
    }

    public function petugas_pinjam()
    {
        return $this->belongsTo(User::class, 'id_petugas_pinjam');
    }

    public function anggota()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
