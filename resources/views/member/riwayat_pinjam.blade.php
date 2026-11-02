@extends('member.layout.main')

@section('title', 'Riwayat Pinjam')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-12">
                <table id="riwayat-pinjam" class="table table-bordered table-striped" style="font-size: medium;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Pinjam</th>
                            <th>Tgl. Pinjam</th>
                            <th>Tgl. Kembali</th>
                            <th>Lama Pinjam</th>
                            <th>Tgl. Pengembalian</th>
                            <th>Judul Buku</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Gambar</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat_pinjam as $pinjam)
                            @foreach ($pinjam->pinjam_detail as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pinjam->no_pinjam }}</td>
                                    <td>{{ date('d-m-Y', strtotime($pinjam->tgl_pinjam)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($detail->tgl_kembali)) }}</td>
                                    <td>{{ $detail->lama_pinjam }} hari</td>
                                    <td>{{ $detail->tgl_pengembalian == null ? '-' : date('d-m-Y', strtotime($detail->tgl_pengembalian)) }}
                                    </td>
                                    <td>{{ $detail->buku->judul_buku }}</td>
                                    <td>
                                        @if ($detail->status == 'Pinjam')
                                            <span class="badge badge-info">{{ $detail->status }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $detail->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p>
                                            <b>Denda : </b><br>
                                            {{ $detail->denda }}
                                        </p>
                                        <p>
                                            <b>Terlambat : </b><br>
                                            @php
                                                $tglKembali = \Carbon\Carbon::parse($detail->tgl_kembali);
                                                $terlambat = '-';

                                                if (!is_null($detail->tgl_pengembalian)) {
                                                    $tglPengembalian = \Carbon\Carbon::parse($detail->tgl_pengembalian);

                                                    if ($tglPengembalian->lt($tglKembali)) {
                                                        $terlambat = 0;
                                                    } elseif ($tglPengembalian->gt($tglKembali)) {
                                                        // abs(): hasil selalu positif (jumlah hari terlambat)
                                                        $terlambat = ceil(abs($tglPengembalian->diffInDays($tglKembali, false)));
                                                    }
                                                }
                                            @endphp
                                            {{ $terlambat }} hari
                                        </p>
                                        <p>
                                            <b>Total Denda : </b><br>
                                            @php
                                                if ($terlambat == '-') {
                                                    $totalDenda = '-';
                                                } else {
                                                    $totalDenda = $detail->denda * $terlambat;
                                                }
                                            @endphp
                                            {{ $totalDenda }}
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $detail->buku->image) }}" alt="Cover Buku" class="img-pinjam">
                                    </td>
                                    <td>
                                        <p>
                                            <b>Pinjam : </b><br>
                                            {{ $pinjam->petugas_pinjam->nama }}
                                        </p>
                                        <p><b>Kembali : </b><br>
                                            {{ $detail->petugas_kembali != null ? $detail->petugas_kembali->nama : '-' }}
                                        </p>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#riwayat-pinjam").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endpush
