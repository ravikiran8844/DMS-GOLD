@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    Product Details Page - Emerald RMS
@endsection
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
                            href="{{ $product->project_id == App\Enums\Projects::EF ? route('retailerefreadystock') : ($product->project_id == App\Enums\Projects::CASTING ? route('retailersireadystock') : route('retailerjewelleryreadystock')) }}">
                            {{ $product->project_id == App\Enums\Projects::EF ? 'EF' : ($product->project_id == App\Enums\Projects::CASTING ? 'CASTING' : 'CASTING') }}
                        </a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->DesignNo }}</li>
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

                        <img id="product-main-image" class="img-fluid product-main-image load-secure-image"
                            src="http://imageurl.ejindia.com/api/image/secure"
                            data-secure="{{ $product->secureFilename }}" alt>

                        <script>
                            document.addEventListener("DOMContentLoaded", async function() {
                                try {
                                    const res = await fetch("/retailer/proxy/token");
                                    const data = await res.json();
                                    const token = data.token;

                                    if (!token) {
                                        throw new Error("Token not received from /retailer/proxy/token");
                                    }

                                    // Loop through all secure images
                                    document.querySelectorAll(".load-secure-image").forEach(async (img) => {
                                        const secureFilename = img.dataset.secure;

                                        try {
                                            const res = await fetch("/retailer/proxy/secure-image", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                    "Authorization": `${token}`
                                                },
                                                body: JSON.stringify({
                                                    secureFilename
                                                })
                                            });

                                            if (!res.ok) throw new Error("Failed to fetch image");

                                            const blob = await res.blob();
                                            const imageUrl = URL.createObjectURL(blob);
                                            img.src = imageUrl;
                                        } catch (error) {
                                            console.error("Image load failed:", error);
                                            img.alt = "Image load failed";
                                        }
                                    });
                                } catch (err) {
                                    console.error("Token fetch failed:", err);
                                }
                            });
                        </script>

                        <div style=" position: absolute; top: 10px; right: 10px; ">
                            <button
                                class="ml-2 custom-icon-btn wishlist-svg @if ($product->is_favourite == 1) active @endif"
                                onclick="addtowishlist({{ $product->id }})">
                                <svg width="26" height="23" viewBox="0 0 26 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                        stroke="#003836" stroke-width="1.5" stroke-linejoin="round" />
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
                                Code: <span class="product-design_content me-2">{{ $product->DesignNo }}</span>
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

                        @if ($stock == 1 && $product->qty > 0)
                            <div class="d-none d-md-block">
                                <div class="text-success">
                                    Product Stock - <span class="fw-semibold">{{ $product->qty }}</span>
                                </div>
                            </div>
                        @endif

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
                                    <input type="hidden" name="stockqty" id="stockqty" value="{{ $stock }}">
                                    <input type='button' value='-' class='qtyminus' field='quantity' />
                                    <input type='text' id="quantity" name='quantity'
                                        value="{{ $currentcartcount ?? $product->moq }}" class='qty' />
                                    <input type='button' value='+' class='qtyplus' field='quantity' />
                                </div>
                            </div>
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
                                                    {{ str_replace('SIL-', '', $product->silver_purity_percentage) }}
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
        </section>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('retailer/assets/lib/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('retailer/assets/js/readystock/product_detail.js') }}"></script>
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
@endsection
@endsection
