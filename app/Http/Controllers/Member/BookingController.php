<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function dataBooking(User $user)
    {
        $data_booking = Booking::with('booking_detail', 'booking_detail.buku')->where('id_user', $user->id)->get();

        if (count($data_booking) == 0) {
            return redirect()->route('member.index')->with('info', 'Tidak ada buku yang dibooking');
        }
        return view('member.data_booking', compact('data_booking'));
    }

    public function bookingPdf(User $user)
    {
        // Perbaikan: hanya booking milik user ini (di modul tanpa where sehingga semua booking ikut)
        $data_booking = Booking::with('booking_detail')->where('id_user', $user->id)->get();
        $pdf = Pdf::loadView('member.booking_pdf', compact('data_booking'));

        return $pdf->stream('data_booking.pdf');
    }
}
