<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'image',
        'password',
        'role_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function totalKeranjang()
    {
        return Temp::where('id_user', $this->id)->count();
    }

    public function totalBooking()
    {
        return BookingDetail::whereIn('id_booking', function ($query) {
            $query->select('id_booking')
                ->from(with(new Booking)->getTable())
                ->where('id_user', $this->id);
        })->count();
    }

    public function totalSedangPinjam()
    {
        // status ada di tabel pinjam_detail, bukan di tabel pinjam
        return PinjamDetail::where('status', 'Pinjam')
            ->whereIn('no_pinjam', function ($query) {
                $query->select('no_pinjam')
                    ->from(with(new Pinjam)->getTable())
                    ->where('id_user', $this->id);
            })->count();
    }

    public function totalRiwayatPinjam()
    {
        return PinjamDetail::whereIn('no_pinjam', function ($query) {
            $query->select('no_pinjam')
                ->from(with(new Pinjam)->getTable())
                ->where('id_user', $this->id);
        })->count();
    }
}
