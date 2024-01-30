@extends('back.template.app')

@section('title', 'Pengaduan')

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
                    <h4 class="card-title mb-0">Pengaduan</h4>
                </div>
                <div class="card-body">
                    <div id="cardCollpase1" class="collapse show">
                        <div class="d-lg-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-light" type="button">Terapkan</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table dt-responsive w-100" id="table-profile">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Detail Kontak</th>
                                        <th>Detail Pengaduan</th>
                                        <th>Tanggal Masuk</th>
                                        {{-- <th>Aksi</th> --}}
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

            $("#table-profile").DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('admin.pengaduan') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,

                    },
                    {
                        data: 'nama',
                        name: 'nama',
                    },
                    {
                        data: 'detail_kontak',
                        name: 'detail_kontak',
                    },
                    {
                        data: 'isi_pengaduan',
                        name: 'isi_pengaduan',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                    // {
                    //     data: 'aksi',
                    //     name: 'aksi',
                    //     searchable: false,
                    //     orderable: false,
                    // },
                ]
            });
        }

        loadTable();
    </script>
@endsection
