<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\Temp;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TempController extends Controller
{
    public function tambahKeranjang(Request $request)
    {
        // Cek apakah buku yang diklik booking dengan user yang sedang login sudah ada di tabel temp atau belum
        $cek_keranjang = Temp::where(['id_buku' => $request->id, 'id_user' => auth()->user()->id])->count();
        $cek_pinjam = DB::table('pinjam as a')
            ->join('pinjam_detail as b', 'a.no_pinjam', '=', 'b.no_pinjam')
            ->where('a.id_user', auth()->user()->id)
            ->where('b.id_buku', $request->id)
            ->where('b.status', 'Pinjam')
            ->count();

        // Jika buku yang diklik booking sudah ada di temp
        if ($cek_keranjang > 0 || $cek_pinjam > 0) {
            return redirect()->route('member.index')->with('error', 'Buku sudah ada di keranjang atau sedang dipinjam');
        }

        // Cek apakah ada data buku yang belum diambil (masih booking)
        $cek_booking = Booking::where('id_user', auth()->user()->id)->count();
        if ($cek_booking > 0) {
            return redirect()->route('member.index')->with('error', 'Masih ada buku yang belum diambil, silakan ambil buku atau menunggu pembatalan otomatis');
        }

        // Cek jumlah buku dalam keranjang
        $cek_limit = Temp::where(['id_user' => auth()->user()->id])->count();

        // Cek jumlah buku yang sedang dipinjam
        $total_pinjam = DB::table('pinjam as a')
            ->join('pinjam_detail as b', 'a.no_pinjam', '=', 'b.no_pinjam')
            ->where('a.id_user', auth()->user()->id)
            ->where('b.status', 'Pinjam')
            ->count();

        // Jika jumlah keranjang + booking + pinjam sama dengan/lebih dari 3
        if (($total_pinjam + $cek_booking + $cek_limit) >= 3) {
            return redirect()->route('member.index')->with('error', 'Total buku di keranjang, booking dan sedang pinjam tidak boleh lebih dari 3');
        }

        $data['id_buku'] = $request->id;
        $data['id_user'] = auth()->user()->id;

        Temp::create($data);

        return redirect()->route('member.index')->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    public function dataKeranjang(User $user)
    {
        $data_keranjang = Temp::with('buku', 'buku.kategori')->where('id_user', $user->id)->get();
        if (count($data_keranjang) == 0) {
            return redirect()->route('member.index')->with('info', 'Tidak ada buku di keranjang');
        }
        return view('member.data_keranjang', compact('data_keranjang'));
    }

    public function hapusKeranjang($buku, $user)
    {
        $temp = Temp::where('id_buku', $buku)
            ->where('id_user', $user)
            ->delete();

        return redirect()->back()->with(['success' => 'Buku berhasil dihapus dari keranjang!']);
    }

    public function simpanBooking(Request $request)
    {
        $cek_stok = Temp::with('buku')->where('id_user', $request->id)->get();
        // Loop melalui setiap buku untuk memeriksa stok
        foreach ($cek_stok as $item) {
            if ($item->buku->stok <= 0) {
                // Redirect back dengan pesan kesalahan jika stok buku kosong
                return redirect()->back()->with('error', 'Ada buku yang stoknya kosong, silakan hapus terlebih dahulu.');
            }
        }

        // Jika semua buku memiliki stok, lanjutkan dengan menyimpan booking
        // Generate id_booking
        $today = Carbon::today()->format('ymd');

        // Mendapatkan id_booking terbaru dari tabel booking
        $latestBooking = DB::table('booking')
            ->whereDate('tgl_booking', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $latestBookingId = $latestBooking ? intval(substr($latestBooking->id_booking, -3)) : 0;

        // Mendapatkan id_booking terbaru dari tabel pinjam
        $latestPinjam = DB::table('pinjam')
            ->whereDate('tgl_pinjam', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $latestPinjamId = $latestPinjam ? intval(substr($latestPinjam->id_booking, -3)) : 0;

        // Bandingkan id_booking dari kedua tabel
        $latestIdBooking = max($latestBookingId, $latestPinjamId);

        // Membuat id_booking baru
        $newIdBooking = 'B' . $today . str_pad($latestIdBooking + 1, 3, '0', STR_PAD_LEFT);

        // Tanggal booking dan batas ambil
        $tgl_booking = Carbon::now();
        $batas_ambil = $tgl_booking->copy()->addDay();

        // Logika untuk menyimpan booking
        // Simpan ke tabel booking
        DB::beginTransaction();
        try {
            DB::table('booking')->insert([
                'id_booking' => $newIdBooking,
                'tgl_booking' => $tgl_booking,
                'batas_ambil' => $batas_ambil,
                'id_user' => $request->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan ke tabel booking_detail
            foreach ($cek_stok as $item) {
                DB::table('booking_detail')->insert([
                    'id_booking' => $newIdBooking,
                    'id_buku' => $item->id_buku,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update stok buku dan kolom dibooking
                DB::table('buku')->where('id', $item->id_buku)->update([
                    'stok' => DB::raw('stok - 1'),
                    'dibooking' => DB::raw('dibooking + 1'),
                ]);
            }

            // Hapus data dari tabel temp
            Temp::where('id_user', $request->id)->delete();

            DB::commit();

            return redirect()->route('member.index')->with('success', 'Booking berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan booking.');
        }
    }
}
