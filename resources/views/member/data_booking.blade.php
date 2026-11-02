@extends('member.layout.main')

@section('title', 'Data Booking')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info" role="alert">
                    Waktu Pengambilan Buku 1x24 jam dari Booking!!!<br>
                    Jika tidak diambil setelah batas waktu, maka booking akan dibatalkan otomatis oleh sistem
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 d-flex align-items-center">
                <dl class="pr-4 pl-4" style="border-right: 1px solid black; border-left: 1px solid black">
                    <dt>ID Booking</dt>
                    <dd>{{ $data_booking[0]->id_booking }}</dd>
                </dl>
                <dl class="pr-4 pl-4" style="border-right: 1px solid black">
                    <dt>Tanggal Booking</dt>
                    <dd>{{ $data_booking[0]->tgl_booking }}</dd>
                </dl>
                <dl class="pr-4 pl-4" style="border-right: 1px solid black">
                    <dt>Batas Ambil</dt>
                    <dd>{{ $data_booking[0]->batas_ambil }}</dd>
                </dl>
                <dl class="pr-4 pl-4">
                    <a href="{{ route('member.bookingPdf', $data_booking[0]->id_user) }}" class="btn btn-outline-primary">Cetak Bukti</a>
                </dl>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table id="data-booking" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th style="width: 170px;">Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_booking as $booking)
                            @foreach ($booking->booking_detail as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->buku->judul_buku }}</td>
                                    <td>{{ $detail->buku->kategori->nama_kategori }}</td>
                                    <td>{{ $detail->buku->pengarang }}</td>
                                    <td>{{ $detail->buku->penerbit }}</td>
                                    <td>{{ $detail->buku->tahun_terbit }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $detail->buku->image) }}" alt="Cover Buku" height="100%">
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
