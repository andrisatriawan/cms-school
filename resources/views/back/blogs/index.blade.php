@extends('back.template.app')

@section('title', 'Blogs')

@section('css')
    <!-- Datatables css -->
    <link href="{{ asset('back') }}/assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back') }}/assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

    {{-- sweetalert --}}
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
                    <h4 class="card-title mb-0">Blogs</h4>
                </div>
                <div class="card-body">
                    <div id="cardCollpase1" class="collapse show">
                        <div class="page-title-box mb-2">
                            <div class="page-title-right">
                                <div class="app-search">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <span class="mdi mdi-magnify search-icon"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <h4 class="page-title"><a href="{{ route('admin.blogs-create') }}"
                                    class="btn btn-success btn-sm"><i class="mdi mdi-plus"></i> Tambah</a>
                            </h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table dt-responsive w-100" id="table-blogs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Deskripsi</th>
                                        <th>Foto</th>
                                        <th>Terakhir diubah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div>
    </div>
@endsection

@section('js')
    <!-- Datatables js -->
    <script src="{{ asset('back') }}/assets/js/vendor/jquery.dataTables.min.js"></script>
    <script src="{{ asset('back') }}/assets/js/vendor/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('back') }}/assets/js/vendor/dataTables.responsive.min.js"></script>
    <script src="{{ asset('back') }}/assets/js/vendor/responsive.bootstrap5.min.js"></script>

    {{-- Sweetalert --}}
    <script src="{{ asset('back') }}/assets/js/vendor/sweetalert2.all.min.js"></script>



    <script>
        $("#refresh").click(function() {
            loadTable();
        });

        function loadTable() {

            $("#table-blogs").DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('admin.blogs') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,

                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi',
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        searchable: false,
                        orderable: false,
                    },
                ]
            });
        }

        $("body").on('click', '.btn-delete', function(e) {
            e.preventDefault();

            console.log('btn delete dipanggil');

            let id = $(this).data('id');

            Swal.fire({
                title: "Konfirmasi",
                text: "Apakah anda yakin ingin menghapus data blog ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    Swal.showLoading();

                    return $.ajax({
                        type: "DELETE",
                        url: "{{ url('admin/blogs/delete/') }}" + '/' + id,
                        data: {
                            '_token': "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            return data.json();
                        },
                        error: function(e) {
                            let message = e.responseJSON.message;
                            Swal.fire(
                                'Gagal!',
                                message,
                                'error'
                            );
                        }
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
                        loadTable()
                    }
                } else {
                    Swal.fire(
                        'Gagal!',
                        result.value.message,
                        'error'
                    );
                }
            });
        });

        loadTable();
    </script>
@endsection
