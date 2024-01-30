<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('front') }}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{ asset('front') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('front') }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('front') }}/css/style.css" rel="stylesheet">
    <style>
        .dropdown-item {
            padding: 10px 8px;
        }

        .dropdown-item:hover {
            background-color: #4ac3f3b7;
            color: #ffffff;
        }

        .dropdown-menu {
            padding: 0;
        }

        .dropdown-toogle .show {
            color: #4ac3f3b7;
        }
    </style>
    @yield('css')
</head>

<body>
    <div class="bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="position-relative p-0" id="home">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <div class="container-xxl">
                    <a href="{{ route('home') }}" class="navbar-brand p-0">
                        {{-- <h1 class="m-0">soFFer</h1> --}}
                        <img src="{{ asset('front') }}/img/logo-2.png" id="logo" alt="Logo">
                    </a>
                    <button class="navbar-toggler rounded-pill" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-auto py-0">
                            <a href="{{ request()->routeIs('home') ? route('home') . '#home' : route('home') }}"
                                class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                            <li class="dropdown">
                                <a class="nav-item nav-link dropdown-toggle {{ request()->is('profile/*') ? 'active' : '' }}"
                                    href="#" role="button" data-bs-toggle="dropdown">
                                    Profile
                                </a>
                                <ul class="dropdown-menu rounded-1 border-0" style="top: 65px">
                                    @foreach (navProfile() as $row)
                                        <li><a class="dropdown-item"
                                                href="{{ route('profile', $row->slug) }}">{{ $row->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <a href="{{ request()->routeIs('home') ? route('home') . '#blog' : route('blogs') }}"
                                class="nav-item nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}">Blog</a>
                            <a href="{{ request()->routeIs('home') ? route('home') . '#pelayanan' : route('home') }}"
                                class="nav-item nav-link">Pelayanan</a>
                            <a href="{{ request()->routeIs('home') ? route('home') . '#contact' : route('home') }}"
                                class="nav-item nav-link">Kontak Kami</a>
                            <li class="dropdown">
                                <a class="nav-item nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    Lainnya
                                </a>
                                <ul class="dropdown-menu rounded-1 border-0" style="top: 65px">
                                    @foreach (navLainnya() as $row)
                                        <li><a class="dropdown-item"
                                                href="{{ $row->url == null ? route('page', $row->slug) : $row->url }}">{{ $row->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </div>
                    </div>
                </div>
            </nav>

            @yield('header-container')


        </div>
        <!-- Navbar & Hero End -->

        @yield('content')


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-body footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-sm-4">
                        <p class="section-title text-white h5 mb-4">Alamat<span></span></p>
                        <p><i class="fa fa-map-marker-alt me-3"></i>{{ contacts()->alamat }}</p>
                        <p><i class="fa fa-phone-alt me-3"></i>{{ contacts()->no_telp }}</p>
                        <p><i class="fa fa-envelope me-3"></i>{{ contacts()->email }}</p>
                        <div class="d-flex pt-2">
                            @if (contacts()->twitter)
                                <a class="btn btn-outline-light btn-social" href="{{ contacts()->twitter }}"><i
                                        class="fab fa-twitter"></i></a>
                            @endif
                            @if (contacts()->facebook)
                                <a class="btn btn-outline-light btn-social" href="{{ contacts()->facebook }}"><i
                                        class="fab fa-facebook-f"></i></a>
                            @endif
                            @if (contacts()->instagram)
                                <a class="btn btn-outline-light btn-social" href="{{ contacts()->instagram }}"><i
                                        class="fab fa-instagram"></i></a>
                            @endif
                            @if (contacts()->youtube)
                                <a class="btn btn-outline-light btn-social" href="{{ contacts()->youtube }}"><i
                                        class="fab fa-youtube"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p class="section-title text-white h5 mb-4">Link Cepat<span></span></p>
                        <a class="btn btn-link" href="{{ route('profile', 'visi-misi') }}">Visi dan Misi</a>
                        <a class="btn btn-link" href="{{ route('blogs') }}">Blog</a>
                        <a class="btn btn-link" href="#pelayanan">Pelayanan</a>
                        <a class="btn btn-link" href="{{ route('profile', 'kepegawaian') }}">Kepegawaian</a>
                    </div>
                    <div class="col-sm-4">
                        <p class="section-title text-white h5 mb-4">Aplikasi Kami<span></span></p>
                        <a class="btn btn-link" href="https://sinotrabalaik3medan.kemnaker.go.id/">SINOTRA</a>
                        <a class="btn btn-link" href="https://simpelkan.kemnaker.go.id/">SIMPELKAN</a>
                        <a class="btn btn-link" href="{{ route('pengaduan') }}">Pengaduan Masyarakat</a>
                        <a class="btn btn-link" href="#">Estimasi Biaya</a>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="text-center">
                        Kementerian Ketenagakerjaan Republik Indonesia
                        Direktorat Pembinaan dan Pengawasan Ketenagakerjaan dan K3
                        <br>
                        Hak Cipta Dilindungi Undang-Undang.
                    </div>
                    <div class="text-center mb-3 mb-md-0">
                        Copyright &copy; {{ date('Y') }} <a class="border-bottom"
                            href="{{ route('home') }}">Balai
                            K3
                            Medan</a>. All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('front') }}/js/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front') }}/lib/wow/wow.min.js"></script>
    <script src="{{ asset('front') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('front') }}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{ asset('front') }}/lib/counterup/counterup.min.js"></script>
    <script src="{{ asset('front') }}/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('front') }}/js/main.js"></script>
    <script>
        $(window).scroll(function() {
            changeLogo();
        });

        function changeLogo() {
            var width = $(window).width();
            var scroll = $(window).scrollTop();
            if (width < 992 || scroll > 100) {
                $("img#logo").attr("src", "{{ asset('front/img/logo.png') }}");
            } else {
                $("img#logo").attr("src", "{{ asset('front/img/logo-2.png') }}");
            }
        }

        $(window).resize(function() {
            changeLogo();
        });

        $(document).ready(function() {
            changeLogo();
        });
    </script>
    @yield('js')
</body>

</html>
