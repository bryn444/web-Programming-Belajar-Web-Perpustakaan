@extends('admin.layout.main')

@section('title', 'Master Buku')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detail Data Buku</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="judul_buku">Judul Buku</label>
                                            <p>{{ $buku->judul_buku }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="id_kategori">Kategori Buku</label>
                                            <p>{{ $buku->kategori->nama_kategori }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="pengarang">Pengarang</label>
                                            <p>{{ $buku->pengarang }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="penerbit">Penerbit</label>
                                            <p>{{ $buku->penerbit }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="isbn">ISBN</label>
                                            <p>{{ $buku->isbn }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="tahun_terbit">Tahun Terbit</label>
                                            <p>{{ $buku->tahun_terbit }}</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-6">
                                        <div class="form-group">
                                            <label for="stok">Stok</label>
                                            <p>{{ $buku->stok }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="dipinjam">Dipinjam</label>
                                            <p>{{ $buku->dipinjam }}</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="dibooking">Dibooking</label>
                                            <p>{{ $buku->dibooking }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <img class="img-preview img-fluid mb-3 col-sm-5 d-block"
                                                    src="{{ asset('storage/' . $buku->image) }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="{{ URL::previous() }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection