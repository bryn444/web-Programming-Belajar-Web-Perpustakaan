@extends('member.layout.main')

@section('title', 'Katalog Buku')

@section('content')

    <main role="main" class="container pt-4">
        <div class="row">
            @foreach ($buku as $index => $item)
                <div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch">
                    <div class="card" style="width: 100%;">
                        @if ($item->stok > 0)
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon bg-success">
                                    Stok: {{ $item->stok }}
                                </div>
                            </div>
                        @else
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon bg-danger">
                                    Tidak Tersedia
                                </div>
                            </div>
                        @endif

                        <div class="card-header d-flex justify-content-center" style="background-color: lightgrey">
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="..." style="max-width: 120px;">
                        </div>
                        <div class="card-body text-center pb-1">
                            <p class="card-text text-bold">{{ $item->judul_buku }}</p>
                            <h6 class="text-center">
                                <span class="badge badge-pill badge-info">{{ $item->kategori->nama_kategori }}</span>
                            </h6>
                            <p class="card-text text-center text-primary mb-0" style="">
                                {{ $item->pengarang }}
                            </p>
                            <p class="card-text text-center text-danger mb-0">{{ $item->penerbit }}</p>
                            <p class="card-text text-center text-success mb-0">{{ $item->tahun_terbit }}</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" onclick="detailBuku('{{ $item->id }}');">Detail</button>
                            @if ($item->stok > 0)
                                <form action="{{ route('member.tambahKeranjang') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-sm btn-success">Tambah ke keranjang</button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $buku->links() }}
    </main>

    <!-- Modal Detail Buku -->
    <div class="modal fade" id="detailBukuModal" tabindex="-1" role="dialog" aria-labelledby="detailBukuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="detailBukuModalLabel">Detail Buku</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3 d-flex justify-content-center align-items-center" style="border-right: 1px solid black">
                            <img src="" class="card-img-top" alt="Cover Buku" style="max-width: 120px;" id="gambar">
                        </div>

                        <div class="col-lg-9 pl-2">
                            <dl>
                                <dt>Judul Buku</dt>
                                <dd id="judul_buku"></dd>
                                <dt>Kategori</dt>
                                <dd id="kategori"></dd>
                                <dt>Pengarang</dt>
                                <dd id="pengarang"></dd>
                                <dt>Penerbit</dt>
                                <dd id="penerbit"></dd>
                                <dt>Tahun Terbit</dt>
                                <dd id="tahun_terbit"></dd>
                                <dt>ISBN</dt>
                                <dd id="isbn"></dd>
                                <dt>Stok</dt>
                                <dd id="stok"></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <form action="{{ route('member.tambahKeranjang') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" id="idBukuKeranjang" value="">
                        <button type="submit" class="btn btn-success" id="tambahKeranjang">Tambah ke keranjang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('loginMember') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Login Member</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <p>Belum punya akun? <span class="text-primary" style="cursor: pointer;" onclick="daftarModal();">Daftar di sini</span></p>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Daftar Member -->
    <div class="modal fade" id="daftarMemberModal" tabindex="-1" role="dialog" aria-labelledby="daftarMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="daftarMemberForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Daftar Member</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama lengkap">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="konfirmasi_password">Konfirmasi Password</label>
                                    <input type="password" name="konfirmasi_password" class="form-control" id="konfirmasi_password" placeholder="Konfirmasi Password">
                                    <span class="invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <p>Sudah punya akun? <span class="text-primary" style="cursor: pointer;" onclick="loginModal();">Login di sini</span></p>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function detailBuku(id) {
            $.ajax({
                url: '{{ url('/') }}/detail-buku/' + id,
                dataType: 'json',
                type: 'GET',
                error: function() {
                    toastr.error('Server error occurred', 'Error', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                success: function(data) {
                    $('#gambar').attr('src', APP_URL + '/storage/' + data.image);
                    $('#judul_buku').html(data.judul_buku)
                    $('#kategori').html(data.kategori.nama_kategori)
                    $('#pengarang').html(data.pengarang)
                    $('#penerbit').html(data.penerbit)
                    $('#tahun_terbit').html(data.tahun_terbit)
                    $('#isbn').html(data.isbn)
                    $('#stok').html(data.stok)
                    $('#idBukuKeranjang').val(data.id)
                    if (data.stok > 0) {
                        $('#tambahKeranjang').removeClass('d-none')
                    } else {
                        $('#tambahKeranjang').addClass('d-none')
                    }
                },
            });
            $('#detailBukuModal').modal('show');
        }

        function daftarModal() {
            $('#daftarMemberModal').modal('show');
            $('#loginModal').modal('hide');
        }

        function loginModal() {
            $('#daftarMemberModal').modal('hide');
            $('#loginModal').modal('show');
        }

        $('#daftarMemberForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('registerMember') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        $('#daftarMemberModal').modal('hide');
                        $('#daftarMemberForm')[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').empty();

                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').html(value[0]);
                        });
                    }
                }
            });
        });
    </script>
@endpush
