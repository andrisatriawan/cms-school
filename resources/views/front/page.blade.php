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
            padding: 0 30px 30px 30px;
        }

        .blog-carousel .owl-nav {
            display: flex;
            justify-content: center;
        }

        .blog-carousel .owl-nav .owl-prev,
        .blog-carousel .owl-nav .owl-next {
            margin: 0 12px;
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
                    <div class="carousel-item active" data-bs-interval="5000">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 text-center text-lg-start">
                                <h1 class="text-white mb-4 animated slideInDown">SINOTRA</h1>
                                <p class="text-white pb-3 animated slideInDown">Sistem Notifikasi Tracking
                                    Hasil
                                    Pengujian Balai Keselamatan dan Kesehatan Kerja Medan.</p>
                                <div class="position-relative w-100 mt-3 d-flex justify-content-lg-center-custom">
                                    <a href=""
                                        class="btn btn-primary rounded-pill py-2 px-3 shadow-none position-absolute top-0">Kunjungi</a>
                                </div>
                            </div>
                            <div class="col-lg-6 text-center text-lg-start">
                                <img class="img-fluid rounded animated zoomIn" src="{{ asset('front') }}/img/hero.jpg"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="container-xxl py-6" id="blog">
        <div class="container">
            <div class="mx-auto text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="mb-3">Blog</h1>
                <a class="icon-link icon-link-hover" href="#">
                    Selengkapnya >>
                </a>
                <hr>
            </div>
            <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="1s">
                @foreach ($blogs as $blog)
                    <div class="blog-item rounded">
                        <div class="card">
                            <img src="{{ asset('client/blog') . '/' . $blog->photo }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <small>{{ tgl_indo($blog->created_at) }}</small>
                                <h5 class="card-title">{{ $blog->title }}</h5>
                                @php
                                    $fullText = $blog->deskripsi;
                                    $shortText = substr($fullText, 0, 150);
                                    $shortText = substr($shortText, 0, strrpos($shortText, ' '));
                                    $shortText = strip_tags($shortText);
                                    $shortText = preg_replace('/&\w+;/', '', $shortText);
                                @endphp
                                {{ $shortText . '... ' }} <a href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
