@extends('template.front.app')

@section('title', 'PENGADUAN MASYARAKAT')

@section('css')
    <link rel="stylesheet" href="{{ asset('back') }}/assets/css/vendor/sweetalert2.min.css">

    <style>
        .hero-header {
            background-size: cover;
            margin-bottom: 0;
        }

        .bg-home {
            background-color: #2604d7 !important;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 8%;
        }

        @media (max-width: 991px) {
            .justify-content-lg-center-custom {
                justify-content: center !important;
            }
        }
    </style>
@endsection

@section('header-container')
    <div class="bg-home" style="padding:10rem 0 6rem 0">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-12 text-center">
                        <h1 class="text-white mb-4 animated slideInDown">PENGADUAN MASYARAKAT</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container-xxl py-6" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="row g-3">
                        <div class="col-md-12">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama">
                        </div>
                        <div class="col-md-6">
                            <label for="instansi" class="form-label">Instansi</label>
                            <input type="text" class="form-control" id="instansi">
                        </div>
                        <div class="col-md-6">
                            <label for="jenis" class="form-label">Jenis Pengaduan</label>
                            <select id="jenis" class="form-select">
                                <option selected disabled>Pilih salah satu...</option>
                                <option value="Gratifikasi">Gratifikasi</option>
                                <option value="Suap">Suap</option>
                                <option value="Pemerasan">Pemerasan</option>
                                <option value="Penyalahgunaan Wewenang">Penyalahgunaan Wewenang</option>
                                <option value="Layanan Balai K3 Medan">Layanan Balai K3 Medan</option>
                                <option value="Disiplin ASN Balai K3 Medan">Disiplin ASN Balai K3 Medan</option>
                                <option value="Lainnya / Tidak tahu">Lainnya / Tidak tahu</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="email" class="form-control" id="no_hp">
                        </div>
                        <div class="col-md-12">
                            <label for="isi_pengaduan" class="form-label">Isi Pengaduan</label>
                            <textarea name="isi_pengaduan" id="isi_pengaduan" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="file" class="form-label">File</label>
                            <input class="form-control" type="file" id="file">
                        </div>
                        <div class="col-12">
                            <button type="submit" id="btn-submit" class="btn btn-info">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('back') }}/assets/js/vendor/sweetalert2.all.min.js"></script>
    <script>
        $("#btn-submit").on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Konfirmasi",
                text: "Apakah anda yakin ingin mengirim pengaduan?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    Swal.showLoading();
                    let form = new FormData();

                    var fileInput = $('#file')[0];
                    var file = fileInput.files[0];

                    form.append('nama', $("#nama").val());
                    form.append('instansi', $("#instansi").val());
                    form.append('jenis', $("#jenis").val());
                    form.append('email', $("#email").val());
                    form.append('no_hp', $("#no_hp").val());
                    form.append('isi_pengaduan', $("#isi_pengaduan").val());
                    form.append('file', file);
                    form.append('_token', "{{ csrf_token() }}");

                    return fetch("{{ route('pengaduan-store') }}", {
                            method: "POST",
                            body: form
                        })
                        .then(response => response.json())
                        .catch(error => {
                            Swal.fire(
                                'Gagal!',
                                error.message,
                                'error'
                            );
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then(function(result) {
                if (result.isConfirmed) {
                    if (result.value.status == true) {
                        Swal.fire(
                            'Berhasil!',
                            result.value.message,
                            'success'
                        );
                        window.location = result.value.redirect;
                    }
                } else {
                    Swal.fire(
                        'Gagal!',
                        result.value.message,
                        'error'
                    );
                }
            });
        })
    </script>
@endsection
