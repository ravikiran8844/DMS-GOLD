@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    Home Page - Emerald OMS
@endsection
<main>
    <section class="container py-4">
        <div class="col-12 mb-4">
            <div class="fs-3 fw-bold">Categories</div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route('retailerefreadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img1.png') }}" alt="">
                                    </div> --}}
                                    <div class="item-title">
                                        EF
                                    </div>
                                </div>

                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('retailersireadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img2.png') }}" alt="">
                                    </div> --}}
                                    <div class="item-title">
                                        CASTING
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('retailerjewelleryreadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div> --}}
                                    <div class="item-title">
                                        IMPREZ
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('retailerindianiareadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div> --}}
                                    <div class="item-title">
                                        INDIANIA
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- <div class="col-12 mb-3">
                <a href="{{ route('retailerutensilreadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                        LASERCUT
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
            <div class="col-12 mb-3">
                <a href="{{ route('mmd') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div> --}}
                                    <div class="item-title">
                                        MMD
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('stamping') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div> --}}
                                    <div class="item-title">
                                        STAMPING
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- <div class="col-12 mb-3">
                <a href="{{ route('turkish') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                        TURKISH
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('unikraft') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid"
                                            src="{{ asset('retailer/assets/img/img3.jpg') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                        UNIKRAFT
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#003836" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>
    </section>
</main>

@endsection
