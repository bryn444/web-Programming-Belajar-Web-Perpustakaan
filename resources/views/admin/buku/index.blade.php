@extends('admin.layout.main')

@section('title', 'Master Buku')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('admin.master.buku.create') }}" class="text-dark">
                    <div class="info-box" style="cursor: pointer;">
                        <span class="info-box-icon bg-dark">
                            <i class="fas fa-plus"></i>
                        </span>
                        <div class="info-box-content d-flex align-items-center justify-content-center">
                            <span class="info-box-text">Tambah Buku</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </a>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data-buku" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Gambar</th>
                                    <th style="width: 80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->judul_buku }}</td>
                                        <td>{{ $item->kategori->nama_kategori }}</td>
                                        <td>{{ $item->pengarang }}</td>
                                        <td>{{ $item->penerbit }}</td>
                                        <td>{{ $item->tahun_terbit }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Cover Buku" width="50%">
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.master.buku.destroy', $item->id) }}" method="POST">
                                                <a href="{{ route('admin.master.buku.show', $item->id) }}"
                                                    class="btn btn-xs btn-primary" data-toggle="tooltip"
                                                    data-placement="top" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.master.buku.edit', $item->id) }}"
                                                    class="btn btn-xs btn-warning" data-toggle="tooltip"
                                                    data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-xs btn-danger hapus-data"
                                                    data-toggle="tooltip" data-placement="top" title="Hapus"><i
                                                        class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#data-buku").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
        $('[data-toggle="tooltip"]').tooltip();
        $(document).on('click', '.hapus-data', function() {
            var form = $(this).closest("form");
            if (confirm('Yakin ingin menghapus data??')) {
                form.submit();
            }
        });
    </script>
@endpush