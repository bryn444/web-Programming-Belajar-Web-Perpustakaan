@extends('admin.layout.main')

@section('title', 'Master Kategori')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="info-box" style="cursor: pointer;" data-toggle="modal" data-target="#categoryModal">
                    <span class="info-box-icon bg-dark">
                        <i class="fas fa-plus"></i>
                    </span>
                    <div class="info-box-content d-flex align-items-center justify-content-center">
                        <span class="info-box-text">Tambah Kategori</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            @foreach ($kategori as $index => $item)
                @php
                    $bgArray = ['primary', 'secondary', 'success', 'info', 'danger', 'warning'];
                    $bg_random = $bgArray[$index % count($bgArray)];
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="info-box" style="cursor: pointer;" data-toggle="modal" data-target="#categoryModal"
                        data-kategori="{{ $item->nama_kategori }}" data-id="{{ $item->id }}">
                        <span class="info-box-icon bg-{{ $bg_random }}">{{ $loop->iteration }}</span>

                        <div class="info-box-content d-flex flex-column align-items-center justify-content-center">
                            <span class="info-box-text">{{ $item->nama_kategori }}</span>
                            <span class="badge badge-{{ $bg_random }}">{{ $item->buku_count }} Buku</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            @endforeach
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="categoryModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="categoryModalLabel">Tambah Kategori Baru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.master.kategori.store') }}" method="POST" id="kategoriForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary simpan-ubah">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.info-box').click(function() {
            var attr = $(this).attr('data-kategori');
            var form = $('#kategoriForm');
            var methodInput = form.find('input[name="_method"]');
            var idInput = form.find('input[name="id"]');
            var formHapus = form.find('#hapusKategoriForm');

            if (typeof attr !== 'undefined' && attr !== false) {
                var nama_kategori = $(this).attr('data-kategori');
                var id_kategori = $(this).attr('data-id');

                $('#categoryModalLabel').text('Ubah Kategori');
                $('.simpan-ubah').text('Ubah');
                $('#nama_kategori').val(nama_kategori);
                form.attr('action', '{{ url('admin/master/kategori/') }}/' + id_kategori);

                if (methodInput.length === 0) {
                    form.append('<input type="hidden" name="_method" value="PUT">');
                    form.append('<input type="hidden" name="id" value="' + id_kategori + '">');
                    $(`
                    <form action="{{ url('admin/master/kategori/') }}/` + id_kategori + `" method="POST" id="hapusKategoriForm">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE" class="method_delete">
                        <button type="button" class="btn btn-danger hapus-data">Hapus</button>
                    </form>
                    `).insertAfter(".simpan-ubah");
                } else {
                    methodInput.val('PUT');
                    $('.method_delete').val('DELETE');
                    // Perbaikan: arahkan form Hapus ke kategori yang sedang dipilih
                    formHapus.attr('action', '{{ url('admin/master/kategori/') }}/' + id_kategori);
                    if (idInput.length === 0) {
                        form.append('<input type="hidden" name="id" value="' + id_kategori + '">');
                    } else {
                        idInput.val(id_kategori);
                    }
                }
            } else {
                $('#categoryModalLabel').text('Tambah Kategori Baru');
                $('.simpan-ubah').text('Simpan');
                $('#nama_kategori').val('');
                form.attr('action', '{{ route('admin.master.kategori.store') }}');

                if (methodInput.length > 0) {
                    methodInput.remove();
                }
                if (idInput.length > 0) {
                    idInput.remove();
                }
                if (formHapus.length > 0) {
                    formHapus.remove();
                }
            }
        });

        $(document).on('click', '.hapus-data', function() {
            var form = $(this).closest("form");
            if (confirm('Yakin ingin menghapus data??')) {
                form.submit();
            }
        });
    </script>
@endpush