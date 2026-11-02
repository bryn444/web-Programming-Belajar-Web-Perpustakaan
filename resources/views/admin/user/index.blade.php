@extends('admin.layout.main')

@section('title', 'Master User')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box" style="cursor: pointer;" onclick="tampilUserModal()">
                    <span class="info-box-icon bg-dark">
                        <i class="fas fa-plus"></i>
                    </span>
                    <div class="info-box-content d-flex align-items-center justify-content-center">
                        <span class="info-box-text">Tambah User</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama User</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th style="width: 100px;">Gambar</th>
                                    <th style="width: 80px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="nama-user">{{ $item->nama }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $item->is_active == 1 ? 'primary' : 'danger' }}">{{ $item->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $item->role_id == 1 ? 'success' : 'warning' }}">{{ $item->role_id == 1 ? 'Administrator' : 'Member' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="User Image" width="70%">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Detail" onclick="tampilUserModal('{{ $item->id }}', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"
                                                onclick="tampilUserModal('{{ $item->id }}', this)">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <div class="d-inline">
                                                <form action="{{ route('admin.master.user.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-xs btn-danger hapus-data" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="d-inline">
                                                <form action="{{ route('admin.master.user.resetPassword', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-xs btn-info reset-password" data-toggle="tooltip" data-placement="top" title="Reset Password">
                                                        <i class="fas fa-unlock"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nama User</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Gambar</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div><!-- /.container-fluid -->

    <!-- Modal Tambah/Edit User -->
    <div class="modal fade" id="userModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalLabel">Tambah User Baru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.master.user.store') }}" method="POST" id="userForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="nama">Nama User</label>
                                    <input type="hidden" name="id" value="" id="id">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan nama user" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Isikan alamat" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Isikan email" required readonly>
                                </div>
                                <div class="form-group d-none" id="status">
                                    <label for="status">Status</label>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline pr-4">
                                            <input type="radio" id="aktif" name="status" value="1">
                                            <label for="aktif"> Aktif</label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="tidak_aktif" name="status" value="0">
                                            <label for="tidak_aktif"> Tidak Aktif</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline pr-4">
                                            <input type="radio" id="role_admin" name="role_id" value="1">
                                            <label for="role_admin"> Administrator</label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="role_anggota" name="role_id" value="2">
                                            <label for="role_anggota"> Anggota</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="image">Gambar</label>
                                        <a href="#" class="d-none" onclick="resetImage()" id="reset"> [ Reset Image ]</a>
                                        <img class="img-preview img-fluid mb-3 col-sm-5 d-block" src=""
                                            style="width: 100%;">
                                        <div class="custom-file">
                                            <input type="hidden" name="oldImage" value="" id="oldImage">
                                            <input type="file" class="custom-file-input" id="image"
                                                name="image" accept="image/png,image/jpg,image/jpeg"
                                                onchange="previewImage()">
                                            <label class="custom-file-label" for="image">Pilih file...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $(document).ready(function() {
            $("#example1").DataTable({
                responsive: true,
                autoWidth: false,
            });
        });

        $('[data-toggle="tooltip"]').tooltip();

        function tampilUserModal(id = null, element) {
            let $userModal = $('#userModal');
            let $title = $(element).attr("data-original-title");
            let $actionButton = $userModal.find('.simpan-ubah');
            let $form = $('#userForm');
            let $formMethod = $('#formMethod');
            let $status = $('#status');
            $userModal.modal('toggle');

            function setFormData(data, isReadOnly) {
                $('#id').val(data.id || '');
                $('#nama').val(data.nama || '').prop('readonly', isReadOnly);
                $('#alamat').val(data.alamat || '').prop('readonly', isReadOnly);
                $('#email').val(data.email || '').prop('readonly', true);
                $('input[name=status]').prop('disabled', isReadOnly);
                $('input[name=role_id]').prop('disabled', isReadOnly);
                data.is_active == '1' ? $('#aktif').prop('checked', true) :
                    $('#tidak_aktif').prop('checked', true);

                data.role_id == '1' ? $('#role_admin').prop('checked', true) :
                    $('#role_anggota').prop('checked', true);
                $('.img-preview').attr('src', data.image ? (APP_URL + '/storage/' + data.image) : '');
                $('.custom-file-label').text('Pilih file...');
                $('#image').prop('disabled', isReadOnly);
                isReadOnly ? $('.custom-file-label').hide() : $('.custom-file-label').show();
                $('#oldImage').val(data.image);
            }

            if (id == null) {
                $('#userModalLabel').text('Tambah User Baru');
                setFormData({}, false);
                $actionButton.text('Simpan').show();
                $form.attr('action', '{{ route('admin.master.user.store') }}');
                $formMethod.val('POST');
                $status.addClass('d-none');
                $('#email').prop('readonly', false);
                $('input[name=status]').prop('disabled', false);
                $('input[name=role_id]').prop('disabled', false);
            } else {
                let isReadOnly = $title == 'Detail';
                $('#userModalLabel').text(isReadOnly ? 'Detail User' : 'Edit User');
                $status.removeClass('d-none');
                $.ajax({
                    url: '{{ url('/') }}/admin/master/user/' + id,
                    dataType: 'json',
                    type: 'GET',
                    error: function() {
                        toastr.error('Server error occurred', 'Error', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    success: function(data) {
                        setFormData(data, isReadOnly);
                        if (isReadOnly) {
                            $actionButton.hide();
                            $form.attr('action', ''); // No action for detail view
                        } else {
                            $actionButton.text('Ubah').show();
                            $form.attr('action', '{{ url('/') }}/admin/master/user/' + id); // Edit route
                            $formMethod.val('PUT');
                        }
                    },
                });
            }
        }

        function previewImage() {
            const image = $('#image');
            const imgPreview = $('.img-preview');
            const file = image[0].files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                imgPreview.attr('src', event.target.result);
            }

            if (file) {
                reader.readAsDataURL(file);
                $('.custom-file-label').html(file.name);
                $('#reset').removeClass('d-none');
            }
        }

        function resetImage() {
            const imgPreview = $('.img-preview');
            const oldImage = $('#oldImage').val();
            if (oldImage) {
                imgPreview.attr('src', APP_URL + '/storage/' + oldImage);
            } else {
                imgPreview.attr('src', '');
            }
            $('.custom-file-label').html('Pilih file...');
            $('#reset').addClass('d-none');
        }

        $(document).on('click', '.hapus-data', function() {
            var form = $(this).closest("form");
            var nama_user = $(this).closest("tr").find('.nama-user').html();
            if (confirm('Yakin ingin menghapus data user ' + nama_user + '??')) {
                form.submit();
            }
        });

        $(document).on('click', '.reset-password', function() {
            var form = $(this).closest("form");
            var nama_user = $(this).closest("tr").find('.nama-user').html();
            if (confirm('Yakin ingin reset password user ' + nama_user + '??')) {
                form.submit();
            }
        });

        @error('image')
            toastr.error('{{ $message }}');
        @enderror

        @error('email')
            toastr.error('{{ $message }}');
        @enderror
    </script>
@endpush