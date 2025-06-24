@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
    Home - Emerald OMS
@endsection
<section class="container py-2 d-block d-lg-none">
    <div class="d-flex flex-wrap justify-content-center align-items-center gap-2">
        <div>
            <a class="spinner-button btn new-arrivals-btn px-4" href="{{ route('newarrivals') }}">
                <span>New
                    Arrivals</span> <span class="d-none spinner">
                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                </span></a></a>
        </div>
        <div>
            <a class="spinner-button btn btn-warning px-4" href="{{ route('readystock') }}">
                <span>Ready Stock</span> <span class="d-none spinner">
                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                </span></a>
        </div>
    </div>
</section>
<section id="home-main-slider" class="splide main-slider container-fluid" aria-label="Home page Main Slider">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($banners_up as $banner)
                <li class="splide__slide">
                    <picture>
                        <!-- You can adjust the media queries based on your design -->
                        <source media="(max-width:768px)" srcset="{{ asset($banner->banner_image) }}">
                        <source media="(min-width:768px)" srcset="{{ asset($banner->banner_image) }}">
                        <a href="{{ $banner->banner_url }}"><img height="358" src="{{ asset($banner->banner_image) }}"
                                alt="slide" class="img-fluid w-100"></a>
                    </picture>
                </li>
            @endforeach
        </ul>
    </div>
</section>
<section class="my-5 pb-5 container">
    <div class=" col-12 mb-4">
        <div class="main-title">Category</div>
    </div>
    <div class="splide" id="category-slider">
        <div class="splide__track">
            <ul class="splide__list col-12">
                @foreach ($uniqueCategoryNames as $categoryName)
                    @php
                        $category = $categories->where('category_name', $categoryName)->first();
                        session()->put('selected_category_id', $category->id);
                    @endphp

                    <li class="splide__slide">
                        <div class="card category-slider-card">
                            <div class="card-img-top">
                                <a href="{{ route('shop', encrypt($category->id)) }}">
                                    <img width="220" height="220" class="img-fluid object-fit-cover"
                                        src="{{ asset($category->category_image) }}" alt>
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <div class="category-slider-card_title" data-category-id="{{ $category->id }}">
                                    {{ $category->category_name }}</div>
                                <div class="category-slider-card_text">
                                    <a class="custom-link category-link" data-category-id="{{ $category->id }}"
                                        href="{{ route('shop', encrypt($category->id)) }}">Explore
                                        <svg width="23" height="12" viewBox="0 0 23 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M22.4296 5.16834L18.2239 0.380669C18.1628 0.312557 18.09 0.258691 18.0097 0.221762C17.9294 0.184834 17.8432 0.165741 17.7561 0.165741C17.669 0.165741 17.5828 0.184834 17.5024 0.221762C17.4221 0.258691 17.3493 0.312557 17.2882 0.380669C17.1669 0.52492 17.0995 0.713943 17.0995 0.910178C17.0995 1.10641 17.1669 1.29544 17.2882 1.43969L20.377 4.94802H1.16983C0.988371 4.94802 0.814346 5.02712 0.686038 5.1678C0.55773 5.30848 0.485596 5.49943 0.485596 5.69839C0.485596 5.89734 0.55773 6.08775 0.686038 6.22844C0.814346 6.36912 0.988371 6.44821 1.16983 6.44821H20.377L17.2882 9.95655C17.1669 10.1008 17.0995 10.2898 17.0995 10.4861C17.0995 10.6823 17.1669 10.8713 17.2882 11.0156C17.3485 11.0852 17.421 11.1404 17.5015 11.1782C17.5819 11.2161 17.6685 11.2359 17.7561 11.2359C17.8436 11.2359 17.9302 11.2161 18.0107 11.1782C18.0911 11.1404 18.1636 11.0852 18.2239 11.0156L22.4296 6.2279C22.5555 6.08618 22.6259 5.8962 22.6259 5.69839C22.6259 5.50057 22.5555 5.31006 22.4296 5.16834Z"
                                                fill="#F78D1E" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
{{-- <section class="mt-5 collections-section container">
    <div class=" col-12 mb-4">
        <div class="main-title">Collections</div>
    </div>
    <div class="row">
        @foreach ($collections as $collection)
            @if ($collection->size_id == 1)
                <div class="col-12 col-md-6 position-relative mb-4">
                    <div class="collections-section_item">
                        <img class="img-fluid w-100" height="356" src="{{ asset($collection->collection_image) }}"
                            alt>
                        <div class="collections-section_item-content">
                            <div class="collections-section_title">{{ $collection->collection_name }}</div>
                            <div class="collections-section_caption">{{ $collection->content }}</div>
                            <div><a class="collections-section_text  custom-link"
                                    href="{{ route('collections', encrypt($collection->id)) }}">Explore <i
                                        class="fas fa-long-arrow-alt-right"></i></a></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-sm-6 col-md-4 position-relative mb-4">
                    <div class="collections-section_item">
                        <img class="img-fluid w-100" height="356" src="{{ asset($collection->collection_image) }}"
                            alt>
                        <div class="collections-section_item-content">
                            <div class="collections-section_title">{{ $collection->collection_name }}</div>
                            <div class="collections-section_caption">{{ $collection->content }}</div>
                            <div><a class="collections-section_text  custom-link"
                                    href="{{ route('collections', encrypt($collection->id)) }}">Explore <i
                                        class="fas fa-long-arrow-alt-right"></i></a></div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <div class="col-12 text-center my-4">
        <a class="btn btn-warning py-2 px-4 custom-yellow-button text-white" href="#">Explore the
            Collection</a>
    </div>
</section> --}}
<section class="mb-5 home-section4 container">
    <div class="row">
        <div class="col-12 col-sm-6 mb-4 mb-sm-0">
            <div class="card home-section4_item">
                <div class="card-body text-center py-5 p-lg-5">
                    <div>
                        <img src="{{ asset('frontend/img/home/logo-2.png') }}" width="80" height="80" alt>
                    </div>
                    <div class="home-section4_item-title my-4">40 Years of trust</div>
                    <div class="home-section4_item-text">We stand behind our quality
                        with more than 4 decades of trust from our 500+ dealer network
                        worldwide.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="card home-section4_item">
                <div class="card-body text-center py-5 p-lg-5">
                    <div>
                        <img src="{{ asset('frontend/img/home/logo-1.png') }}" width="80" height="80" alt>
                    </div>
                    <div class="home-section4_item-title my-4">20+ TECHNOLOGIES</div>
                    <div class="home-section4_item-text">Being pioneers in the field
                        of silver and with more than 20+technologies, you dream it we
                        make it!</div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mt-5 container-fluid p-0">
    <div class="col-12 p-0">
        <div>
            <picture>
                @if ($banners_down)
                    <source media="(max-width:567px)" srcset="{{ asset($banners_down->banner_image) }}">
                    <source media="(min-width:568px)" srcset="{{ asset($banners_down->banner_image) }}">
                    <img height="174" src="{{ asset($banners_down->banner_image) }}" alt="slide"
                        class="img-fluid w-100">
                @else
                    <img height="174" src="{{ asset('frontend/img/home/home-bottom-mobile-banner.webp') }}"
                        alt="slide" class="img-fluid w-100">
                @endif
            </picture>
        </div>
    </div>
</section>
<div class="modal fade" id="homePopupModal" tabindex="-1" aria-labelledby="homePopupModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered  modal-xl">
        <div class="modal-content" style="background: #FFF; box-shadow: 0px 4px 14px 0px rgba(151, 151, 151, 0.25);">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <a href="{{ $popup->popup_url }}">
                    <img class="img-fluid" src="{{ $popup->popup_image }}" alt="">
                </a>
            </div>


        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let year = new Date().getFullYear();
        document.getElementById("current-year").textContent = year;
    });
</script>

<!-- <script>
    // Function to open the modal with a delay
    $(document).ready(function() {
        setTimeout(function() {
            $('#homePopupModal').modal('show');
        }, 3000); // 5 seconds delay
    });
</script> -->

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
