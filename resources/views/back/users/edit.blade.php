@extends('back.template.app')

@section('title', 'Edit User')

@section('css')
    <link rel="stylesheet" href="{{ asset('back') }}/assets/css/vendor/sweetalert2.min.css">

@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Portlet card -->
            <div class="card mb-md-0 mb-3">
                <div class="card-header">
                    <div class="card-widgets">
                        <a href="javascript:;" id="refresh" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-bs-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false"
                            aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                        <a href="#" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                    </div>
                    <h4 class="card-title mb-0">Edit User</h4>
                </div>
                <div class="card-body">
                    <div id="cardCollpase1" class="collapse show">
                        <div id="alerts">

                        </div>
                        <form class="form-horizontal" id="form-create" method="POST">
                            <fieldset>
                                <div class="row mb-3">
                                    <label for="nama" class="col-2 col-form-label">Nama</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="nama" id="nama"
                                            placeholder="Nama" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-2 col-form-label">Email</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Email" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="tempat_lahir" class="col-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                            placeholder="Tempat Lahir" value="{{ $user->tempat_lahir }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="tanggal_lahir" class="col-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-10">
                                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                                            placeholder="Tanggal Lahir" value="{{ $user->tanggal_lahir }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="j_k" class="col-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-10">
                                        <select name="j_k" id="j_k" class="form-select">
                                            <option value="" selected disabled>Pilih salah satu...</option>
                                            <option value="l" {{ $user->j_k == 'l' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="p" {{ $user->j_k == 'p' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="agama" class="col-2 col-form-label">Agama</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="agama" id="agama"
                                            placeholder="Agama" value="{{ $user->agama }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="no_hp" class="col-2 col-form-label">Nomor HP</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="no_hp" id="no_hp"
                                            placeholder="Nomor HP" value="{{ $user->no_hp }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="alamat" class="col-2 col-form-label">Alamat</label>
                                    <div class="col-10">
                                        <textarea name="alamat" id="alamat" rows="3" class="form-control">{{ $user->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-2 col-form-label">Password</label>
                                    <div class="col-10">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password">
                                        <span class="text-muted small">Password default <strong>123456</strong></span>
                                    </div>
                                </div>

                                <div class="justify-content-end row">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-info" id="btn-simpan">Simpan</button>
                                        <button class="btn btn-info d-none" type="button" id="spinner-button" disabled>
                                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                                aria-hidden="true"></span>
                                            Loading...
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div> <!-- end card-->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('back') }}/assets/js/vendor/sweetalert2.all.min.js"></script>

    <script>
        $("#btn-simpan").on('click', function(e) {
            e.preventDefault();

            let formData = new FormData();

            formData.append('nama', $("#nama").val());
            formData.append('email', $("#email").val());
            formData.append('tempat_lahir', $("#tempat_lahir").val());
            formData.append('tanggal_lahir', $("#tanggal_lahir").val());
            formData.append('j_k', $("#j_k").val());
            formData.append('agama', $("#agama").val());
            formData.append('no_hp', $("#no_hp").val());
            formData.append('alamat', $("#alamat").val());
            formData.append('password', $("#password").val());
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('_method', "PUT");

            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.users-update', $user->id) }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false,
                    }).then(function() {
                        window.location = data.redirect
                    });
                },
                beforeSend: function() {
                    $("fieldset").attr('disabled', true);
                    $("#btn-simpan").addClass('d-none');
                    $("#spinner-button").removeClass('d-none');
                },
                error: function(e) {
                    let message = e.responseJSON.message;
                    let errors = e.responseJSON.error;
                    Swal.fire(
                        'Gagal!',
                        message,
                        'error'
                    );
                    $("fieldset").attr('disabled', false);
                    $("#btn-simpan").removeClass('d-none');
                    $("#spinner-button").addClass('d-none');

                    $('.alert').remove();

                    $.each(errors, function(key, obj) {
                        let html = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>Eror - </strong> ${obj}
                            </div>`;

                        $('#alerts').append(html);
                    })
                }
            })

        })
    </script>
@endsection
