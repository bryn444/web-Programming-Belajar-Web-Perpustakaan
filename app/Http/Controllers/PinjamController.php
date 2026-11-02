<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjam;
use Illuminate\Http\Request;

class PinjamController extends Controller
{
    public function sedangPinjam(User $user)
    {
        // Mengambil data peminjaman yang belum dikembalikan (sedang pinjam)
        $sedang_pinjam = Pinjam::with(['pinjam_detail' => function ($query) {
            $query->where('status', 'Pinjam');
        }, 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam'])
            ->where('id_user', $user->id)
            ->orderBy('no_pinjam', 'ASC')
            ->get();

        if (count($sedang_pinjam) == 0) {
            return redirect()->route('member.index')->with('info', 'Tidak ada buku yang sedang dipinjam');
        }

        // echo json_encode($sedang_pinjam);exit;
        return view('member.sedang_pinjam', compact('sedang_pinjam'));
    }

    public function riwayatPinjam(User $user)
    {
        $riwayat_pinjam = Pinjam::with('pinjam_detail', 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam')->where('id_user', $user->id)
            ->orderBy('no_pinjam', 'ASC')
            ->get();

        if (count($riwayat_pinjam) == 0) {
            return redirect()->route('member.index')->with('info', 'Tidak ada riwayat peminjaman');
        }

        // echo json_encode($riwayat_pinjam);exit;
        return view('member.riwayat_pinjam', compact('riwayat_pinjam'));
    }
}
