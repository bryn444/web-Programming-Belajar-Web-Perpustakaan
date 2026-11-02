<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';

    protected $guarded = [
        'id',
    ];

    public function booking_detail()
    {
        return $this->hasMany(BookingDetail::class, 'id_booking', 'id_booking');
    }

    public function anggota()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
