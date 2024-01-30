@extends('back.template.app')

@section('title', 'Contacts')

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
                    <h4 class="card-title mb-0">Contacts</h4>
                </div>
                <div class="card-body">
                    <div id="cardCollpase1" class="collapse show">
                        <div id="alerts">

                        </div>
                        <form class="form-horizontal" id="form-create">
                            <fieldset>
                                <div class="row mb-3">
                                    <label for="maps" class="col-2 col-form-label">Maps</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="maps" id="maps"
                                            placeholder="Maps" value="{{ $contact->maps }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="alamat" class="col-2 col-form-label">Alamat</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="alamat" id="alamat"
                                            placeholder="Alamat" value="{{ $contact->alamat }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="no_telp" class="col-2 col-form-label">No. Telp</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="no_telp" id="no_telp"
                                            placeholder="No Telp" value="{{ $contact->no_telp }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-2 col-form-label">Email</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Email" value="{{ $contact->email }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="facebook" class="col-2 col-form-label">Facebook</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="facebook" id="facebook"
                                            placeholder="Facebook" value="{{ $contact->facebook }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="twitter" class="col-2 col-form-label">Twitter</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="twitter" id="twitter"
                                            placeholder="Twitter" value="{{ $contact->twitter }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="instagram" class="col-2 col-form-label">Instagram</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="instagram" id="instagram"
                                            placeholder="Instagram" value="{{ $contact->instagram }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="linkedin" class="col-2 col-form-label">Linkedin</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="linkedin" id="linkedin"
                                            placeholder="Linkedin" value="{{ $contact->linkedin }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="youtube" class="col-2 col-form-label">Youtube</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="youtube" id="youtube"
                                            placeholder="Youtube" value="{{ $contact->youtube }}">
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
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="{{ asset('back') }}/assets/js/vendor/sweetalert2.all.min.js"></script>

    <script>
        $("#btn-simpan").on('click', function(e) {
            e.preventDefault();

            let form = new FormData();




            form.append('maps', $("#maps").val());
            form.append('alamat', $("#alamat").val());
            form.append('no_telp', $("#no_telp").val());
            form.append('email', $("#email").val());
            form.append('facebook', $("#facebook").val());
            form.append('twitter', $("#twitter").val());
            form.append('instagram', $("#instagram").val());
            form.append('linkedin', $("#linkedin").val());
            form.append('youtube', $("#youtube").val());

            form.append('_token', "{{ csrf_token() }}");
            form.append('_method', 'PUT')

            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.contacts-update', $contact->id) }}",
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
