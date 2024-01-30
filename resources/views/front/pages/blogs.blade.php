@extends('template.front.app')

@section('title', 'Blog')

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
    </style>
@endsection

@section('header-container')
    <div class="bg-home" style="padding:10rem 0 6rem 0">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-12 text-center">
                        <h1 class="text-white mb-4 animated slideInDown">BLOG</h1>
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
                <div class="col-8">
                    @foreach ($blogs as $blog)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('client/blog') . '/' . $blog->photo }}"
                                        class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        @php
                                            $fullText = $blog->deskripsi;
                                            $shortText = substr($fullText, 0, 100);
                                            $shortText = substr($shortText, 0, strrpos($shortText, ' '));
                                            $shortText = strip_tags($shortText);
                                            $shortText = preg_replace('/&\w+;/', '', $shortText);
                                        @endphp

                                        <p class="card-text">{{ $shortText . '... ' }} <a
                                                href="{{ route('blogs.article', base64_encode($blog->id)) }}">Selengkapnya</a>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-body-secondary">Terakhir diubah
                                                {{ lastUpdate($blog->created_at) }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="pagination"> --}}
                    {{ $blogs->links('pagination::bootstrap-5') }}
                    {{-- </div> --}}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')

@endsection
