@extends('member.layout.main')

@section('title', 'Ganti Password')

@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-md-8 col-lg-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ganti Password</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('member.ganti-password') }}" method="POST" id="gantiPasswordForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="password-saat-ini">Password Saat Ini</label>
                                <input type="password" class="form-control @error('password_saat_ini') is-invalid @enderror" name="password_saat_ini" id="password-saat-ini" placeholder="Password Saat Ini">
                                @error('password_saat_ini')
                                    <span id="password-saat-ini-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-baru">Password Baru</label>
                                <input type="password" class="form-control @error('password_baru') is-invalid @enderror" name="password_baru" id="password-baru" placeholder="Password Baru">
                                @error('password_baru')
                                    <span id="password-baru-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="konfirmasi-password">Konfirmasi Password</label>
                                <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" name="konfirmasi_password" id="konfirmasi-password" placeholder="Konfirmasi Password">
                                @error('konfirmasi_password')
                                    <span id="konfirmasi-password-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#password-saat-ini').focus();
        });
    </script>
@endpush
