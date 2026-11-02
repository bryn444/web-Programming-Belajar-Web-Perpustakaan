@extends('member.layout.main')

@section('title', 'Data Keranjang')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <a href="{{ route('member.index') }}" class="btn btn-outline-primary">Lanjutkan Booking</a>
                    <form action="{{ route('member.simpanBooking') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                        <button type="submit" class="btn btn-outline-success">Selesai Booking</button>
                    </form>
                </div>
                <table id="data-keranjang" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th style="width: 170px;">Gambar</th>
                            <th style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_keranjang as $item)
                            <tr class="{{ $item->buku->stok == 0 ? 'bg-danger' : '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->buku->judul_buku }}</td>
                                <td>{{ $item->buku->kategori->nama_kategori }}</td>
                                <td>{{ $item->buku->pengarang }}</td>
                                <td>{{ $item->buku->penerbit }}</td>
                                <td>{{ $item->buku->tahun_terbit }}</td>
                                <td>{{ $item->buku->stok }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $item->buku->image) }}" alt="Cover Buku" height="100%">
                                </td>
                                <td>
                                    <form action="{{ route('member.hapusKeranjang', ['buku' => $item->buku->id, 'user' => Auth::user()->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-xs btn-danger hapus-data" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
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
        $(document).on('click', '.hapus-data', function() {
            var form = $(this).closest("form");
            if (confirm('Yakin ingin menghapus data??')) {
                form.submit();
            }
        });
    </script>
@endpush
