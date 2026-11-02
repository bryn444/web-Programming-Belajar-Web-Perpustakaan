<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table = 'booking_detail';

    protected $guarded = [
        'id',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
