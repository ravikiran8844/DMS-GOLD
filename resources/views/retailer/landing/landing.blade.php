@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    Home Page - Emerald RMS
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<main>
    <section id="home-main-slider" class="splide main-slider container-fluid" aria-label="Home page Main Slider">
        <div class="splide__track">
            <ul class="splide__list">
                <a href="{{ route('retailersireadystock') }}" class="w-100">
                    <li class="splide__slide">
                        <picture>
                            <!-- Set the mobile image source -->
                            <source media="(max-width: 768px)" srcset="{{ asset($mobilebanner->banner_image) }}">

                            <!-- Set the desktop image source -->
                            <source media="(min-width: 769px)" srcset="{{ asset($banner->banner_image) }}">

                            <!-- Fallback image -->
                            <img height="358" src="{{ asset($banner->banner_image) }}" alt="slide"
                                class="img-fluid w-100">
                        </picture>
                    </li>
                </a>
            </ul>

        </div>
    </section>
    <section class="container" id="ef-ready-stock">
        <div class="row py-4 py-lg-5">

            <div
                class="col-12 mb-4 mb-lg-5 position-relative d-flex justify-content-between align-items-center justify-content-md-center gap-2">
                <div class="section-main-title fw-bold">
                    Electroforming - Ready Stock
                </div>
                <div>
                    <a href="{{ route('retailerefreadystock') }}" class="btn view-all-btn ">View All
                        <span> <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                    fill="inherit" />
                            </svg></span>
                    </a>
                </div>
            </div>

            <div class="col-12">
                <div class="home-products-grid">
                    <div class="home-products-grid-item">
                        <a href="{{ route('efkrishna') }}">
                            <div class="home-products-grid-item__img-wrapper">
                                {{-- <span class="pro-badge">new</span> --}}
                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/electro-forming-img3.png') }}"
                                    alt="">

                            </div>
                        </a>
                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('efkrishna') }}"> Krishna </a>
                            </div>
                            <div>
                                <a href="{{ route('efkrishna') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>
                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('efganesha') }}">
                            <div class="home-products-grid-item__img-wrapper">
                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/electro-forming-img1.png') }}"
                                    alt="">
                            </div>
                        </a>
                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('efganesha') }}"> Ganesha </a>
                            </div>
                            <div>
                                <a href="{{ route('efganesha') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>
                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('efhanuman') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/electro-forming-img2.png') }}"
                                    alt="">

                            </div>
                        </a>
                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('efhanuman') }}"> Hanuman </a>
                            </div>
                            <div>
                                <a href="{{ route('efhanuman') }}" class="btn explore-btn px-4">Explore <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>
                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('eflakshmi') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/electro-forming-img4.png') }}"
                                    alt="">

                            </div>
                        </a>
                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('eflakshmi') }}"> Lakshmi </a>
                            </div>
                            <div>
                                <a href="{{ route('eflakshmi') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>
                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('efbuddha') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/electro-forming-img5.png') }}"
                                    alt="">

                            </div>
                        </a>
                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('efbuddha') }}"> Buddha </a>
                            </div>
                            <div>
                                <a href="{{ route('efbuddha') }}" class="btn explore-btn px-4">Explore <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container" id="solid-ready-stock">
        <div class="row  py-4 py-lg-5">

            <div
                class="col-12 mb-4 mb-lg-5 position-relative d-flex justify-content-between align-items-center justify-content-md-center gap-2">
                <div class="section-main-title fw-bold">
                    Solid Idols - Ready Stock
                </div>
                <div>
                    <a href="{{ route('retailersireadystock') }}" class="btn view-all-btn ">View
                        All
                        <span> <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                    fill="inherit" />
                            </svg></span></a>
                </div>
            </div>


            <div class="col-12">
                <div class="home-products-grid">
                    <div class="home-products-grid-item">
                        <a href="{{ route('sikrishna') }}">
                            <div class="home-products-grid-item__img-wrapper">
                                {{-- <span class="pro-badge">new</span> --}}
                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/solid-idol-3.jpg') }}"
                                    alt="">

                            </div>
                        </a>
                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('sikrishna') }}"> Krishna </a>
                            </div>
                            <div>
                                <a href="{{ route('sikrishna') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>

                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('siganesha') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/solid-idol-1.jpg') }}"
                                    alt="">

                            </div>
                        </a>

                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('siganesha') }}"> Ganesha </a>
                            </div>
                            <div>
                                <a href="{{ route('siganesha') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>

                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('sihanuman') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/solid-idol-2.jpg') }}"
                                    alt="">

                            </div>
                        </a>

                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('sihanuman') }}"> Hanuman </a>
                            </div>
                            <div>
                                <a href="{{ route('sihanuman') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>

                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('silakshmi') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/solid-idol-4.jpg') }}"
                                    alt="">

                            </div>
                        </a>

                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('silakshmi') }}"> Lakshmi </a>
                            </div>
                            <div>
                                <a href="{{ route('silakshmi') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>

                    </div>
                    <div class="home-products-grid-item">
                        <a href="{{ route('sivishnu') }}">
                            <div class="home-products-grid-item__img-wrapper">

                                <img class="img-fluid"
                                    src="{{ asset('retailer/assets/img/new-home/solid-idol-5.jpg') }}"
                                    alt="">

                            </div>
                        </a>

                        <div class="text-center mt-3">
                            <div class="mb-2 fs-6 fw-semibold">
                                <a href="{{ route('sivishnu') }}"> Vishnu </a>
                            </div>
                            <div>
                                <a href="{{ route('sivishnu') }}" class="btn explore-btn px-4">Explore
                                    <span>
                                        <svg width="18" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M21.944 5.46744L17.7383 0.679772C17.6772 0.61166 17.6044 0.557793 17.5241 0.520865C17.4438 0.483937 17.3576 0.464844 17.2705 0.464844C17.1834 0.464844 17.0972 0.483937 17.0168 0.520865C16.9365 0.557793 16.8637 0.61166 16.8026 0.679772C16.6813 0.824023 16.6139 1.01305 16.6139 1.20928C16.6139 1.40552 16.6813 1.59454 16.8026 1.73879L19.8914 5.24713H0.684231C0.502776 5.24713 0.32875 5.32622 0.200442 5.4669C0.0721344 5.60759 0 5.79853 0 5.99749C0 6.19645 0.0721344 6.38685 0.200442 6.52754C0.32875 6.66822 0.502776 6.74731 0.684231 6.74731H19.8914L16.8026 10.2557C16.6813 10.3999 16.6139 10.5889 16.6139 10.7852C16.6139 10.9814 16.6813 11.1704 16.8026 11.3147C16.8629 11.3843 16.9354 11.4395 17.0159 11.4773C17.0963 11.5152 17.1829 11.535 17.2705 11.535C17.358 11.535 17.4446 11.5152 17.5251 11.4773C17.6055 11.4395 17.678 11.3843 17.7383 11.3147L21.944 6.527C22.0699 6.38528 22.1403 6.1953 22.1403 5.99749C22.1403 5.79968 22.0699 5.60916 21.944 5.46744Z"
                                                fill="inherit" />
                                        </svg>
                                    </span></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="home-multicolumn-section mt-4 mt-lg-5">
        <div class="container py-5">
            <div class="row gx-lg-5">
                <div class="col-12 col-md-4 col-lg-6">
                    <img class="img-fluid h-100 object-fit-cover rounded-4 w-100" width="850" height="688"
                        src="{{ asset('retailer/assets/img/new-home/emerald-jewel-industry.webp') }}" alt="">
                </div>
                <div class="col-12 col-md-8  col-lg-6 mt-5 mt-md-0">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <div class="fs-3 fw-bold mb-3">40 Years of Legacy with Emerald Jewel Industry</div>
                            <div class="fs-6">
                                We at Emerald believe in crafting your dream product to your hearts content. We take up
                                highest levels of customisation to manufacture your dream product, just the way you like
                                it.
                                <br><br> Get ready to dive into our world of co-creation with Emerald's first step -
                                Retailer Penetration Program.
                                <br><br> #StayAhead with Emerald!
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 col-md-3 col-lg-4">
                                <img class="img-fluid h-100 object-fit-cover rounded-4 w-100" width="246"
                                    card-header 265 src="{{ asset('retailer/assets/img/new-home/SRINIVASAN.png') }}"
                                    alt="" srcset="">
                            </div>
                            <div class="col-12 col-md-9 col-lg-8 mt-4 mt-md-0">
                                <div class="d-flex flex-column justify-content-between h-100">
                                    <div class="fs-6 order-1 order-md-0">
                                        “ Having been our guiding light, Quality has been that single most thing that
                                        has taken us to the greatest height. Ensuring excellence in finish and high
                                        business ethics in all our work has truly been a key differentiator and has
                                        helped us soar high to be one of the world’s largest jewellery manufacturer ”
                                    </div>

                                    <div class="mb-4 mt-md-4 mb-md-0 order-0 order-md-1 ">
                                        <div class="fw-semibold">K. SRINIVASAN</div>
                                        <div>Chairman & Managing Director</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container">
        <div class="row py-5">
            <div class="col-12">
                <div class="text-center mb-4 mb-lg-5">
                    <div class="fs-3 main-title mb-2 fw-bold  section-item-title">
                        Accreditations
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="3" viewBox="0 0 124 3"
                            fill="none">
                            <path d="M0 1.43994H123.816" stroke="#003836" stroke-width="2.21101" />
                        </svg>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-8 m-auto">

                <!-- Swiper -->
                <div class="swiper accreditations-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img width="191" height="135" class="img-fluid"
                                src="{{ asset('retailer/assets/img/new-home/logo-section-img1.png') }}"
                                alt="">
                        </div>
                        <div class="swiper-slide">
                            <img width="191" height="135" class="img-fluid"
                                src="{{ asset('retailer/assets/img/new-home/logo-section-img2.png') }}"
                                alt="">
                        </div>
                        <div class="swiper-slide">
                            <img width="191" height="135" class="img-fluid"
                                src="{{ asset('retailer/assets/img/new-home/logo-section-img4.png') }}"
                                alt="">
                        </div>
                        <div class="swiper-slide">
                            <img width="191" height="135" class="img-fluid"
                                src="{{ asset('retailer/assets/img/new-home/logo-section-img5.png') }}"
                                alt="">
                        </div>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-12 text-center my-5 d-none d-sm-block">
                <a href="tel:+918220017619" class="btn btn-warning px-4 py-2 rounded-5 no-login-required">
                    For Queries: <span class="text-white fw-semibold">Vivin - +9182200 17619</span>
                </a>
            </div>
        </div>
    </section>
    <section class="bg-dark d-block d-sm-none">
        <div class="container p-4">
            <div class="col-12 text-center">

                <div class="fs-6 fw-medium text-white">
                    For Queries:
                </div>
                <div class="mt-2">
                    <a href="tel:+918220017619" class="text-decoration-none fs-5 no-login-required">
                        <span class="text-white fw-semibold">Vivin - +9182200 17619</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let year = new Date().getFullYear();
        document.getElementById("current-year").textContent = year;
    });
</script>
<script>
    var swiper3 = new Swiper(".accreditations-slider", {
        slidesPerView: 3,
        spaceBetween: 10,

        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 4,
                spaceBetween: 20
            },
            // when window width is >= 640px
            640: {
                slidesPerView: 5,
                spaceBetween: 20
            },
            740: {
                slidesPerView: 6,
                spaceBetween: 20
            }
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var splide1 = new Splide('#home-main-slider').mount();
        var splide2 = new Splide('#category-slider', {
            type: 'slide',
            autoplay: 'pause',
            gap: '1rem',
            pagination: false,
            perPage: 6,
            breakpoints: {
                1640: {
                    perPage: 5,
                },
                1340: {
                    perPage: 4,
                },
                1040: {
                    perPage: 3,
                },
                740: {
                    perPage: 2,
                },
                640: {
                    perPage: 2,
                },
                340: {
                    perPage: 1,
                },
            }

        }).mount();
    });
</script>
@endsection
