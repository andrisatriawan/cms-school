<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/hyper/saas/pages-login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Apr 2022 16:20:09 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Log In | Balai K3 Medan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('back') }}/assets/images/favicon.ico">
    <!-- App css -->
    <link href="{{ asset('back') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link rel="stylesheet" href="{{ asset('back') }}/assets/css/vendor/sweetalert2.min.css">
    <style>
        .auth-user-testimonial {
            padding: 0;
            bottom: 0;
            top: 0;
        }

        .row>* {
            padding: 0;
        }

        body.authentication-bg {
            background: none;
        }

        .auth-fluid {
            background: none;
        }
    </style>
</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <a href="index.html" class="logo-dark">
                            <span><img src="{{ asset('back') }}/assets/images/logo - blue.png" alt=""
                                    height="100"></span>
                        </a>
                        <a href="index.html" class="logo-light">
                            <span><img src="{{ asset('back') }}/assets/images/logo - blue.png" alt=""
                                    height="100"></span>
                        </a>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Masukkan username dan password untuk masuk ke laman admin.</p>

                    <!-- form -->
                    <form action="#" id="form-login">
                        <fieldset>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input class="form-control" type="text" id="username" required
                                    placeholder="Masukkan username anda">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" type="password" required id="password"
                                    placeholder="Masukkan password anda">
                            </div>
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit" id="submit-button">
                                    <i class="mdi mdi-login"></i> Log In
                                </button>

                                <button class="btn btn-primary d-none" type="button" id="spinner-button" disabled>
                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </fieldset>
                        <!-- social-->
                        <div class="text-center mt-4">
                            <ul class="social-list list-inline mt-3">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);"
                                        class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);"
                                        class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                    </form>
                    <!-- end form-->

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial row" style="height:100%">
                {{-- <div class="row"> --}}
                <div class="d-flex align-items-center">
                    <div id="carouselExampleInterval" class="carousel slide my-auto" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($sliders as $slider)
                                <div class="carousel-item {{ $i == 1 ? 'active' : '' }}" data-bs-interval="10000">
                                    <img src="{{ asset('client/slider') }}/{{ $slider->photo }}" class="d-block w-100"
                                        alt="...">
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                {{-- </div> --}}
                {{-- </div> <!-- end auth-user-testimonial--> --}}
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="{{ asset('back') }}/assets/js/vendor.min.js"></script>
        <script src="{{ asset('back') }}/assets/js/app.min.js"></script>
        <script src="{{ asset('back') }}/assets/js/vendor/sweetalert2.all.min.js"></script>


        <script>
            $("#submit-button").click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    dataType: "JSON",
                    url: "{{ route('auth') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'username': $("#username").val(),
                        'password': $("#password").val(),
                    },
                    beforeSend: function() {
                        $("fieldset").attr('disabled', true);
                        $("#submit-button").addClass('d-none');
                        $("#spinner-button").removeClass('d-none');
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Anda berhasil login.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location = data.redirect
                        });
                    },
                    error: function(e) {
                        let message = e.responseJSON.message;
                        Swal.fire(
                            'Gagal!',
                            message,
                            'error'
                        );
                        $("fieldset").attr('disabled', false);
                        $("#submit-button").removeClass('d-none');
                        $("#spinner-button").addClass('d-none');
                    }
                });

            })
        </script>

</body>


<!-- Mirrored from coderthemes.com/hyper/saas/pages-login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Apr 2022 16:20:09 GMT -->

</html>
