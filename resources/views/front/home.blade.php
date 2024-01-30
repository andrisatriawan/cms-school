@extends('template.front.app')

@section('title', 'Home')

@section('css')
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

        /*** Testimonial ***/
        .blog-carousel .blog-item {
            padding: 0 20px 20px 20px;
        }

        .blog-carousel .owl-nav {
            display: flex;
            justify-content: center;
        }

        .blog-carousel .owl-nav .owl-prev,
        .blog-carousel .owl-nav .owl-next {
            margin: 0 5px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            background: var(--light);
            border-radius: 60px;
            font-size: 22px;
            transition: .5s;
        }

        .blog-carousel .owl-nav .owl-prev:hover,
        .blog-carousel .owl-nav .owl-next:hover {
            color: #FFFFFF;
            background: var(--primary);
            box-shadow: 0 0 10px rgba(0, 0, 0, .5);
        }
    </style>
@endsection

@section('header-container')
    <div class="bg-home hero-header">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="container">
                <div class="carousel-inner">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($sliders as $slider)
                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}" data-bs-interval="5000">
                            <div class="row g-5 align-items-center">
                                <div class="col-lg-6 text-center text-lg-start">
                                    <h1 class="text-white mb-4 animated slideInDown">{{ $slider->title }}</h1>
                                    <p class="text-white pb-3 animated slideInDown">{{ strip_tags($slider->desc) }}</p>
                                    <div class="position-relative w-100 mt-3 d-flex justify-content-lg-center-custom">
                                        @if ($slider->url != null)
                                            <a href="{{ $slider->url }}"
                                                class="btn btn-primary rounded-pill py-2 px-3 shadow-none position-absolute top-0">Kunjungi</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 text-center text-lg-start">
                                    <img class="img-fluid rounded animated zoomIn"
                                        src="{{ asset('client/slider') }}/{{ $slider->photo }}" alt="">
                                </div>
                            </div>
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
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-xxl py-6" id="blog">
        <div class="container">
            <div class="mx-auto text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Blog</h1>
                <a class="icon-link icon-link-hover" href="{{ route('blogs') }}">
                    Selengkapnya >>
                </a>
                <hr>
            </div>
            <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="2s">
                @foreach ($blogs as $blog)
                    <div class="blog-item rounded">
                        <div class="card">
                            <img src="{{ asset('client/blog') . '/' . $blog->photo }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <small>{{ tgl_indo($blog->created_at) }}</small>
                                <h5 class="card-title">{{ $blog->title }}</h5>
                                @php
                                    $fullText = $blog->deskripsi;
                                    $shortText = substr($fullText, 0, 100);
                                    $shortText = substr($shortText, 0, strrpos($shortText, ' '));
                                    $shortText = strip_tags($shortText);
                                    $shortText = preg_replace('/&\w+;/', '', $shortText);
                                @endphp
                                {{ $shortText . '... ' }} <a
                                    href="{{ route('blogs.article', base64_encode($blog->id)) }}">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-xxl py-4" id="pelayanan">
        <div class="container">
            <div class="mx-auto mb-5 text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Pelayanan</h1>
                <hr>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-item bg-light rounded text-center p-5">
                        <i class="fas fa-award fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">Pelatihan</h5>
                        <p class="m-0">Balai K3 Medan saat ini memfasilitasi 2 pelatihan, yaitu Pelatihan Hiperkes dan
                            KK Bagi Dokter Perusahaan dan juga Pelatihan Hiperkes dan KK Bagi Paramedis Perusahaan.</p>
                        <a class="icon-link icon-link-hover" href="{{ route('page', 'pelatihan') }}">
                            Selengkapnya >>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="feature-item bg-light rounded text-center p-5">
                        <i class="fas fa-file-signature fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">Pelayanan Pengujian</h5>
                        <p class="m-0">Balai K3 Medan saat ini memfasilitasi beberapa pelayanan pengujian lingkungan
                            kerja dan juga ergonomi bagi perusahaan.</p>
                        <a class="icon-link icon-link-hover" href="{{ route('page', 'pelayanan-pengujian') }}">
                            Selengkapnya >>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="feature-item bg-light rounded text-center p-5">
                        <i class="fas fa-file-medical-alt fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">Pelayanan Kesehatan</h5>
                        <p class="m-0">Balai K3 Medan saat ini memfasilitasi pemeriksaan kesehatan bagi tenaga kerja
                            perusahaan.</p>
                        <a class="icon-link icon-link-hover" href="{{ route('page', 'pelayanan-kesehatan') }}">
                            Selengkapnya >>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Contact Start -->
    <div class="container-xxl py-6" id="contact">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="mb-3">Hubungi Kami</h1>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Telp:</p>
                            <h5 class="mb-0">{{ $contacts->no_telp }}</h5>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 btn-square rounded-circle bg-primary text-white">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Alamat</p>
                            <h5 class="mb-0">{{ $contacts->alamat }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <iframe src="{{ $contacts->maps }}" style="border:0; width:100%;height:100%" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

@section('js')
    <script>
        $(".blog-carousel").owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            margin: 0,
            dots: false,
            loop: true,
            nav: true,
            navText: [
                '<i class="bi bi-chevron-left"></i>',
                '<i class="bi bi-chevron-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });
    </script>
@endsection
