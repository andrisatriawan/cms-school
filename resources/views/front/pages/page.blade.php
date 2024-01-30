@extends('template.front.app')

@section('title', $page->title)

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
                    <div class="col-lg-12 text-left">
                        <h1 class="text-white mb-4 animated slideInDown">{{ $page->title }}</h1>
                        <p class="item-text text-white">Terakhir diubah {{ lastUpdate($page->updated_at) }}</p>
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
                    <div class="clearfix">
                        @if ($page->photo)
                            <img src="{{ asset('client/page') . '/' . $page->photo }}"
                                class="img-fluid col-md-4 float-md-end mb-3 ms-md-3" alt="...">
                        @endif
                        {!! $page->deskripsi !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')

@endsection
