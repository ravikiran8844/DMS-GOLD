@extends('dealer.layout.dealermaster')
@section('content')
@section('title')
Home Page - Emerald DMS
@endsection
<main>
    <section class="container py-4">
        <div class="col-12 mb-4">
            <div class="fs-3 fw-bold">Categories</div>
        </div>

        <div class="col-12 mb-3">
                <div class="card category-page-card drop-down-menu__mobile">
                    <div class="card-body">
                        <button class="btn w-100 p-0 border-0 outline-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileDropDownMenu1" aria-expanded="false" aria-controls="mobileDropDownMenu1">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="category-page-card__img-wrapper">
                                    <img width="50" height="50" class="img-fluid" src="{{ asset('dealer/img/list-item-img-1.png') }}" alt="">
                                </div>
                                <div class="item-title">
                                    Ready Stocks
                                </div>
                            </div>

                            <div>

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 18L15 12L9 6" stroke="#F78D1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>

                            </div>
                        </div>
                        </button>


                        <div class="collapse" id="mobileDropDownMenu1">
                            <div class="mt-2">
                                <ul class="list-group text-start">
                                    <li class="list-group-item"><a href="{{ route('efreadystock') }}">Electroforming</a></li>
                                    <li class="list-group-item"><a href="{{ route('sireadystock') }}">Solid Idols</a></li>
                                    <li class="list-group-item"><a href="{{ route('jewelleryreadystock') }}">Casting</a></li>
                                    <li class="list-group-item"><a href="{{ route('indianiareadystock') }}">Indiania</a></li>
                                    <li class="list-group-item"><a href="{{ route('utensilreadystock') }}">Utensil</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            

        </div>


        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route('efreadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid" src="{{ asset('dealer/img/img1.png') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                        Electro Forming 
                                    </div>
                                </div>

                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#F78D1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('sireadystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid" src="{{ asset('dealer/img/img2.png') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                        Solid Idols 
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#F78D1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('jewellerystock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid" src="{{ asset('dealer/img/img3.jpg') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                    Casting
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#F78D1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('indianiastock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid" src="{{ asset('dealer/img/img3.jpg') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                    Indiania
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#F78D1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-12 mb-3">
                <a href="{{ route('utensilstock') }}" class="text-decoration-none">
                    <div class="card category-page-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  align-items-center">
                                <div class="d-flex gap-2 align-items-center">

                                    <div class="category-page-card__img-wrapper">
                                        <img width="50" height="50" class="img-fluid" src="{{ asset('dealer/img/img3.jpg') }}" alt="">
                                    </div>
                                    <div class="item-title">
                                    Utensil
                                    </div>
                                </div>
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 18L15 12L9 6" stroke="#F78D1E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</main>

@endsection