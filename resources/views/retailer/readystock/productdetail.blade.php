@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    Product Details Page - Emerald RMS
@endsection
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" /> -->
    <style>
        body,
        .product-page_content_wrapper {
            background: #F6F6F6 !important;
        }
    </style>                              
@endsection
<section class="breadcrumbs container mt-4">
    <div class="row">
        <div class="col-12 my-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="{{ route('retailerlanding') }}">HOME</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ $product->project_id == App\Enums\Projects::ELECTROFORMING ? route('retailerefreadystock') : ($product->project_id == App\Enums\Projects::SOLIDIDOL ? route('retailersireadystock') : route('retailerjewelleryreadystock')) }}">
                            {{ $product->project_id == App\Enums\Projects::ELECTROFORMING ? 'ELECTROFORMING' : ($product->project_id == App\Enums\Projects::SOLIDIDOL ? 'SOLIDIDOL' : 'JEWELLERY') }}
                        </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->product_unique_id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<input type="hidden" name="weight" id="weight" value="{{ $product->weight }}">

<div class="container">
    <div class="col-12">
        <section class="main-product">
            <div class="row g-4">
                <div class="col-12 col-lg-6 mb-lg-0">
                    <div class="single-images-block position-relative">
                        <!-- <a data-fancybox
                            href="{{ file_exists(public_path('upload/product/' . $product->product_image)) ? asset('upload/product/' . $product->product_image) : asset('no-product-image.jpg') }}"
                            data-caption="{{ $product->product_unique_id }}">
                            <img class="img-fluid product-main-image" width="1000" height="1000"
                                src="{{ file_exists(public_path('upload/product/' . $product->product_image)) ? asset('upload/product/' . $product->product_image) : asset('no-product-image.jpg') }}"
                                alt="{{ $product->product_unique_id }}">

                        </a> -->

                        <img id="product-main-image" class="img-fluid product-main-image"
                            src="{{ file_exists(public_path('upload/product/' . $product->product_image)) ? asset('upload/product/' . $product->product_image) : asset('no-product-image.jpg') }}"
                            alt="{{ $product->product_unique_id }}">




                        <div style=" position: absolute; top: 10px; right: 10px; ">
                            <button
                                class="ml-2 custom-icon-btn wishlist-svg @if ($product->is_favourite == 1) active @endif"
                                onclick="addtowishlist({{ $product->id }})">
                                <svg width="26" height="23" viewBox="0 0 26 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                        stroke="#F78D1E" stroke-width="1.5" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="product-thumbnail_wrapper splide mt-3 d-none" id="thumbnail-slider">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <li class="splide__slide"><img class="img-fluid" width="100" height="100"
                                        src="{{ asset('upload/product/' . $product->product_image) }}" alt="thumb img">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="product-page_content_wrapper d-flex flex-column h-100 justify-content-center">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <div class="product-design_title">Design
                                Code: <span
                                    class="product-design_content me-2">{{ $product->product_unique_id }}</span>
                            </div>
                            <div class="ml-auto ml-sm-5 ">
                                @if ($product->qty > 0)
                                    <div class="badge in-stock-badge d-flex gap-1 align-items-center">IN
                                        STOCK
                                        <span class="d-block d-md-none">- <span
                                                class="fw-semibold">{{ $product->qty }}</span></span>
                                    </div>
                                @else
                                    <div class="badge out-stock-badge">OUT OF
                                        STOCK</div>
                                @endif

                            </div>
                        </div>
                        <div class="product-main-title my-3">{{ $product->product_name }}</div>
                        {{-- @if ($product->size_id != null)
                            <div class="product-size-options py-3">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="product-options-title">SIZE</div>
                                    <div>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="product-size-option_btn" data-bs-toggle="modal"
                                            data-bs-target="#sizeChartModal">
                                            <span>Size guide</span>
                                            <i class="fas fa-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <ul class="list-unstyled d-flex flex-wrap product-swatches">
                                    @foreach ($sizes as $key => $size)
                                        <li>
                                            <input @if ($key == 0) checked @endif type="radio"
                                                name="size" id="size{{ $size->id }}"
                                                value="{{ $size->id }}">
                                            <label for="size{{ $size->id }}">{{ $size->size }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                        {{-- <div class="product-finish-options py-3">
								<div class="mb-3">
									<div class="product-options-title">Finish</div>
								</div>
								<ul class="list-unstyled d-flex flex-wrap product-swatches-box">
									@foreach ($finishes as $finish)
									<li>
										<input @if ($finish->id == $product->finish_id) checked @endif type="radio" name="finish"
										id="finish{{ $finish->id }}" value="{{ $finish->id }}">
                        <label for="finish{{ $finish->id }}">{{ $finish->finish_name }}</label>
                        </li>
                        @endforeach
                        </ul>
                    </div> --}}

                        @if ($stock == 1 && $product->qty > 0)
                            <div class="d-none d-md-block">
                                <div class="text-success">
                                    Product Stock - <span class="fw-semibold">{{ $product->qty }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- @if ($product->project_id == App\Enums\Projects::SOLIDIDOL)
							<div class="product-size-options py-3">
								<div class="d-flex justify-content-between mb-3">
									<div class="product-options-title">MOQ</div>
								</div>
								<ul class="list-unstyled d-flex flex-wrap product-swatches">
									<li>
										<label for="">{{ $product->moq }}</label>
                    </li>
                    </ul>
                </div>
                @endif --}}
                        <div class="my-4 my-mb-5 pt-5 d-flex gap-5 flex-row flex-wrap align-items-center"
                            style=" border-top: 1px solid #bcbcbc;">
                            <div class="product-weight_text mb-0 mb-md-0">{{ $product->weight }}gm</div>

                            <div class="d-flex gap-2 align-items-center">
                                <div class="fs-6" style=" color: #717171; ">Qty</div>
                                <div class="input-group quantity-input-group quantity-container align-items-center">
                                    <input type="hidden" name="moq" id="moq" value="{{ $product->moq }}">
                                    <input type="hidden" name="qty" id="qty" value="{{ $product->qty }}">
                                    <input type="hidden" name="box" id="box"
                                        value="{{ $product->style_id }}">
                                    <input type="hidden" name="stockqty" id="stockqty"
                                        value="{{ $stock }}">
                                    <input type='button' value='-' class='qtyminus' field='quantity' />
                                    <input type='text' id="quantity" name='quantity'
                                        value="{{ $currentcartcount ?? $product->moq }}" class='qty' />
                                    <input type='button' value='+' class='qtyplus' field='quantity' />
                                </div>
                            </div>
                            {{-- @if (Auth::user()->role_id != App\Enums\Roles::Admin) --}}
                            <div>
                                @php
                                    $isCart = App\Models\Cart::where('user_id', Auth::user()->id)
                                        ->where('product_id', $product->id)
                                        ->get();

                                @endphp
                                <div class="position-relative">
                                    <button onclick="addtocart({{ $product->id }})"
                                        class="btn product-add-to_cart-btn px-5 spinner-button"
                                        data_id="card_id_{{ $product->id }}">
                                        <span
                                            class="submit-text">{{ count($isCart) ? 'ADDED TO CART' : 'ADD TO CART' }}</span>
                                        <span class="d-none spinner">
                                            <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                            <span role="status">Adding...</span>
                                        </span>
                                    </button>

                                    @if (count($isCart))
                                        <div class="product-page-addtocart-badge">
                                            {{ $currentcartcount }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>
                        <div id="accordion">
                            <div class="accordion product-specs-accordian">
                                <div class="accordion-header" role="button" data-bs-toggle="collapse"
                                    data-bs-target="#panel-body-1" aria-expanded="true">
                                    <h4>
                                        Product Specs <span class="accordion-icon"><i
                                                class="fas fa-angle-up"></i></span>
                                    </h4>
                                </div>
                                <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                                    <div class="row mt-3">
                                        @if ($product->gender && $product->gender != 'NONE')
                                            <div class="col-4 col-lg-3 mb-4">
                                                <div class="product-specs-item_title mb-2">Gender</div>
                                                <div class="product-specs-item_text">{{ $product->gender }}</div>
                                            </div>
                                        @endif
                                        @if ($product->metal_name)
                                            <div class="col-4 col-lg-3 mb-4">
                                                <div class="product-specs-item_title mb-2">METAL</div>
                                                <div class="product-specs-item_text">{{ $product->metal_name }}</div>
                                            </div>
                                        @endif
                                        @if ($product->height)
                                            <div class="col-4 col-lg-3 mb-4">
                                                <div class="product-specs-item_title mb-2">HEIGHT</div>
                                                <div class="product-specs-item_text">{{ $product->height }}cm</div>
                                            </div>
                                        @endif
                                        @if ($product->width)
                                            <div class="col-4 col-lg-3 mb-4">
                                                <div class="product-specs-item_title mb-2">WIDTH</div>
                                                <div class="product-specs-item_text">{{ $product->width }}cm</div>
                                            </div>
                                        @endif
                                        @if ($product->plating_name)
                                            <div class="col-4 col-lg-3 mb-4">
                                                <div class="product-specs-item_title mb-2">COLOR</div>
                                                <div class="product-specs-item_text">{{ $product->plating_name }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($product->silver_purity_percentage)
                                            <div class="col-4 col-lg-3 mb-4">
                                                <div class="product-specs-item_title mb-2">PURITY</div>
                                                <div class="product-specs-item_text">
                                                    {{ str_replace('SIL-','',$product->silver_purity_percentage) }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-12 py-5 mt-lg-5 you-may-like-section_wrapper">
                    <div class="text-center mb-4">
                        <div class="fs-3 fw-semibold ">You may also like</div>
                    </div>
                    <div class="col-12" id="product_page">
                        <div class="swiper recommended-products-slider">
                            <div class="swiper-wrapper">
                                @foreach ($relatedProducts as $item)
                                    <div class="swiper-slide">

                                        <input type="hidden" name="weight{{ $item->id }}"
                                            id="weight{{ $item->id }}" value="{{ $item->weight }}">
                                        <input type="hidden" name="finish{{ $item->id }}"
                                            id="finish{{ $item->id }}" value="{{ $item->finish_id }}">
                                        <input type="hidden" name="size{{ $item->id }}"
                                            id="size{{ $item->id }}" value="{{ $item->size_id }}">
                                        <input type="hidden" name="plating{{ $item->id }}"
                                            id="plating{{ $item->id }}" value="{{ $item->plating_id }}">
                                        <input type="hidden" name="color{{ $item->id }}"
                                            id="color{{ $item->id }}" value="{{ $item->color_id }}">
                                        <input type="hidden" name="encrypt{{ $item->id }}"
                                            id="encrypt{{ $item->id }}" value="1">
                                        <input type="hidden" name="stock{{ $item->id }}"
                                            id="stock{{ $item->id }}" value="{{ $stock }}">
                                        <input type="hidden" name="box{{ $item->id }}"
                                            id="box{{ $item->id }}" value="{{ $item->style_id }}">
                                        <div class="card shop-page_product-card">
                                            <div class="card-img-top d-flex align-items-center justify-content-center position-relative">
                                                <a href="{{ route('retailerproductdetail', encrypt($item->id)) }}">
                                                    <img class="img-fluid prouduct_card-image" width="154"
                                                        height="160"
                                                        src="{{ file_exists(public_path('upload/product/' . $item->product_image)) ? asset('upload/product/' . $item->product_image) : asset('no-product-image.jpg') }}"
                                                        alt>
                                                </a>
                                                <div class="position-absolute recommended-products__purity">
                                            Purity: {{ str_replace('SIL-','',$product->silver_purity_percentage) }}
                                                 </div>
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <div class="d-flex justify-content-between  gap-2 card-title_wrapper">
                                                    <div class="card-title"><a
                                                            href="{{ route('retailerproductdetail', encrypt($item->id)) }}">{{ $item->product_unique_id }}</a>
                                                    </div>
                                                    @if ($item->weight)
                                                        <div class="card-text">{{ $item->weight }}g</div>
                                                    @endif
                                                    <button
                                                        class="ml-2 custom-icon-btn wishlist-svg @if ($item->is_favourite == 1) active @endif"
                                                        onclick="addtowishlist({{ $item->id }})">
                                                        <svg width="26" height="23" viewBox="0 0 26 23"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                                stroke="#F78D1E" stroke-width="1.5"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="moq{{ $item->id }}"
                                                    id="moq{{ $item->id }}" value="{{ $item->moq }}">
                                                <input type="hidden" name="quantity{{ $item->id }}"
                                                    id="quantity{{ $item->id }}" value="1">
                                                <input type="hidden" name="box{{ $item->id }}"
                                                    id="box{{ $item->id }}" value="{{ $item->style_id }}">
                                                <div>
                                                    @php
                                                        $electroFormingProject = App\Models\Project::where(
                                                            'project_name',
                                                            'ELECTRO FORMING',
                                                        )->first();
                                                    @endphp

                                                    <div class="mt-3">
                                                        {{-- @if (Auth::user()->role_id == App\Enums\Roles::Dealer) --}}
                                                        <div class="mt-3">
                                                            <button onclick="addforcart({{ $item->id }})"
                                                                class="btn add-to-cart-btn mr-2 spinner-button">
                                                                <span class="submit-text">ADD TO CART</span>
                                                                <span class="d-none spinner">
                                                                    <span class="spinner-grow spinner-grow-sm"
                                                                        aria-hidden="true"></span>
                                                                    <span role="status">Adding...</span>
                                                                </span>
                                                            </button>
                                                        </div>
                                                        {{-- @endif --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="custom-buttons d-flex gap-4 align-items-center">
                            <div class="recommended-products-slider-scrollbar swiper-scrollbar position-relative">
                            </div>
                            <div class="d-flex gap-2">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div>

</div>



@section('scripts')
    <script src="{{ asset('retailer/assets/lib/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('retailer/assets/js/readystock/product_detail.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script> -->
    <script src="{{ asset('retailer/assets/lib/js/jquery.ez-plus.js') }}"></script>

    <script>
        var swiper = new Swiper(".recommended-products-slider", {
            slidesPerView: "auto",
            loop: true,
            spaceBetween: 20,
            scrollbar: {
                el: ".recommended-products-slider-scrollbar",
                draggable: true,
                hide: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },

        });
    </script>



    <script>
        $('#product-main-image').ezPlus({
            zoomType: 'inner',
            cursor: 'crosshair'
        });
    </script>

    <script>
        const wishlistButtons = document.querySelectorAll(".wishlist-svg");
        wishlistButtons.forEach((button) => {
            button.addEventListener("click", function() {
                // Toggle the 'active' class to change the color on click
                this.classList.toggle("active");
            });
        });
    </script>

    <!-- <script>
        Fancybox.bind('[data-fancybox]', {
            //
        });
    </script> -->
@endsection
@endsection
