@extends('back.template.app')

@section('title', 'Tambah Profile')

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
                    <h4 class="card-title mb-0">Tambah Profile</h4>
                </div>
                <div class="card-body">
                    <div id="cardCollpase1" class="collapse show">
                        <div id="alerts">

                        </div>
                        <form class="form-horizontal" id="form-create">
                            <fieldset>
                                <div class="row mb-3">
                                    <label for="slug" class="col-2 col-form-label">Jenis</label>
                                    <div class="col-10">
                                        <select name="slug" id="slug" class="form-control">
                                            <option value="" selected disabled>Pilih salah satu...</option>
                                            @foreach (config('constant.profiles') as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="title" class="col-2 col-form-label">Title</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Title">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="deskripsi" class="col-2 col-form-label">Content</label>
                                    <div class="col-10">
                                        <textarea name="content" id="content" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-2 col-form-label">Foto</label>
                                    <div class="col-10">
                                        <input type="file" name="foto" class="form-control" id="foto">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="order" class="col-2 col-form-label">Urutan</label>
                                    <div class="col-10">
                                        <input type="number" name="order" class="form-control" id="order">
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
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <script src="{{ asset('back') }}/assets/js/vendor/sweetalert2.all.min.js"></script>

    <script>
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('ckeditor.image-upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

        $("#btn-simpan").on('click', function(e) {
            e.preventDefault();

            let form = new FormData();

            var fileInput = $('#foto')[0];
            var file = fileInput.files[0];

            var content = CKEDITOR.instances.content.getData();;

            form.append('slug', $("#slug").val());
            form.append('title', $("#title").val());
            form.append('order', $("#order").val());
            form.append('content', content);
            form.append('foto', file);
            form.append('_token', "{{ csrf_token() }}");

            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.profile-store') }}",
                data: form,
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
