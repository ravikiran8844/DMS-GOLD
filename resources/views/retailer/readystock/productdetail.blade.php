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
                    <li class="breadcrumb-item">@php

                        $projectId = $product->Project;
                        $route = '#'; // default
                        $label = $projectId;

                        switch ($projectId) {
                            case App\Enums\Projects::EF:
                                $route = route('retailerefreadystock');
                                $label = 'EF';
                                break;
                            case App\Enums\Projects::CASTING:
                                $route = route('retailersireadystock');
                                $label = 'CASTING';
                                break;
                            case App\Enums\Projects::IMPREZ:
                                $route = route('retailerjewelleryreadystock');
                                $label = 'IMPREZ';
                                break;
                            case App\Enums\Projects::INDIANIA:
                                $route = route('retailerindianiareadystock');
                                $label = 'INDIANIA';
                                break;
                            case App\Enums\Projects::LASERCUT:
                                $route = route('retailerUTENSILreadystock');
                                $label = 'LASER CUT';
                                break;
                            case App\Enums\Projects::MMD:
                                $route = route('mmd');
                                $label = 'MMD';
                                break;
                            case App\Enums\Projects::STAMPING:
                                $route = route('stamping');
                                $label = 'STAMPING';
                                break;
                            case App\Enums\Projects::TURKISH:
                                $route = route('turkish');
                                $label = 'TURKISH';
                                break;
                            case App\Enums\Projects::UNIKRAFT:
                                $route = route('unikraft');
                                $label = 'UNIKRAFT';
                                break;
                            default:
                                $route = '#';
                                $label = 'UNKNOWN';
                                break;
                        }
                    @endphp

                        <a href="{{ $route }}">{{ $label }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->DesignNo }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<input type="hidden" name="weight" id="weight" value="{{ $product->weight }}">

<div class="container">
    <div class="col-12">
        <section class="main-product mb-5">
            <div class="row g-4">
                <div class="col-12 col-lg-5 mb-lg-0">
                    <div class="single-images-block position-relative">

                        <img id="product-main-image" class="img-fluid product-main-image load-secure-image"
                            src="{{ asset('/load-loading.gif') }}" width="500px" height="auto"
                            data-secure="{{ $product->secureFilename }}" data-zoom-image="" alt />

                        <script>
                            document.addEventListener("DOMContentLoaded", async function() {
                                const tokenRes = await fetch("/retailer/proxy/token");
                                const tokenData = await tokenRes.json();
                                const token = tokenData.token;
                                if (!token) return;

                                const secureImages = document.querySelectorAll(".load-secure-image");

                                for (let img of secureImages) {
                                    const secureFilename = img.dataset.secure;

                                    try {
                                        const res = await fetch("/retailer/proxy/secure-image", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "Authorization": `${token}`,
                                            },
                                            body: JSON.stringify({
                                                secureFilename
                                            }),
                                        });

                                        const blob = await res.blob();
                                        const blobUrl = URL.createObjectURL(blob);

                                        // Set both the visible image and zoom image source
                                        img.src = blobUrl;
                                        img.setAttribute("data-zoom-image", blobUrl);

                                        // Wait for jQuery to be ready
                                        $(img).on("load", function() {
                                            // Initialize ezPlus on this image
                                            $(this).ezPlus({
                                                zoomType: 'inner',
                                                cursor: 'crosshair',
                                                scrollZoom: true,
                                                containLensZoom: true
                                            });
                                        });
                                    } catch (e) {
                                        console.error("Secure image fetch failed", e);
                                    }
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
                <div class="col-12 col-lg-7">
                    <div class="product-page_content_wrapper d-flex flex-column h-100">
                        {{-- <div class="purity-badge mb-2">Purity: 22K-91.75</div> --}}
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <div class="product-design_title">Design
                                Code: <span class="product-design_content me-2">{{ $product->DesignNo }}</span>
                            </div>

                        </div>
                        @if ($product->variants->count() > 1)



                        <div id="accordion-parent">
                        <div class="mt-4">
                            <button id="accordion-toggle" class="custom-accordion-button">
                                <span>Product Specification</span>
                                <span id="accordion-icon">
                                    <svg width="14" height="8" viewBox="0 0 17 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.68208 9.63477L8.16563 3.37628L14.7317 9.59317L16.3733 7.98744L8.24811 0.000248548L-7.55998e-08 7.90524L1.68208 9.63477Z" fill="#F78D1E"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div id="accordion-content" class="mt-3" style="display: none;">
                                <!-- <div class="table-responsive d-none d-xl-block overflow-x-auto mt-5">
                                    <table class="table table-bordered text-center align-middle mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Purity</th>
                                                <th>Color</th>
                                                <th>Unit</th>
                                                <th>Style</th>
                                                <th>Making %</th>
                                                <th>Size</th>
                                                <th>Weight</th>
                                                <th>In Stock</th>
                                                <th>Qty</th>
                                                <th>Add to Cart</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->variants as $index => $variant)
                                                <tr>
                                                    <td>{{ $variant['Purity'] ?? '-' }}</td>
                                                    <td>{{ $variant['color'] ?? '-' }}</td>
                                                    <td>{{ $variant['unit'] ?? '-' }}</td>
                                                    <td>{{ $variant['style'] ?? '-' }}</td>
                                                    <td>{{ $variant['making'] ?? '-' }}</td>
                                                    <td>{{ $variant['size'] ?? '-' }}</td>
                                                    <td>{{ $variant['weight'] ?? '-' }}</td>
                                                    <td>{{ $variant['qty'] }}</td>
                                                    <td>
                                                        <div
                                                            class="input-group quantity-input-group quantity-container">
                                                            <input type="button" value="-" class="qtyminus"
                                                                field="quantity">
                                                            <input type="text"
                                                                name="quantity{{ $variant['productID'] }}" 
                                                                value="1" class="qty">
                                                            <input type="button" value="+" class="qtyplus"
                                                                field="quantity">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $isCart = App\Models\Cart::where(
                                                                'user_id',
                                                                Auth::user()->id,
                                                            )
                                                                ->where('product_id', $variant['productID'])
                                                                ->get();
                                                            $currentcartcount = App\Models\Cart::where(
                                                                'product_id',
                                                                $variant['productID'],
                                                            )
                                                                ->where('user_id', Auth::user()->id)
                                                                ->value('qty');
                                                        @endphp
                                                        <div class="shop-page-add-to-cart-btn mt-3">
                                                            @if (count($isCart))
                                                                <button
                                                                    onclick="addtocart({{ $variant['productID'] }})"
                                                                    class="btn added-to-cart-btn mr-2 spinner-button"
                                                                    data_id="card_id_{{ $variant['productID'] }}">
                                                                    <span class="submit-text">ADDED TO CART</span>
                                                                    <span class="d-none spinner">
                                                                        <span class="spinner-grow spinner-grow-sm"
                                                                            aria-hidden="true"></span>
                                                                        <span role="status">Adding...</span>
                                                                    </span>
                                                                    <span
                                                                        id="applycurrentcartcount{{ $variant['productID'] }}"
                                                                        class="added-to-cart-badge ms-2">{{ $currentcartcount }}</span>
                                                                </button>
                                                            @else
                                                                <button
                                                                    onclick="addtocart({{ $variant['productID'] }})"
                                                                    class="btn add-to-cart-btn mr-2 spinner-button"
                                                                    data_id="card_id_{{ $variant['productID'] }}">
                                                                    <span class="submit-text">ADD TO CART</span>

                                                                    <span class="d-none spinner">
                                                                        <span class="spinner-grow spinner-grow-sm"
                                                                            aria-hidden="true"></span>
                                                                        <span role="status">Adding...</span>
                                                                    </span>
                                                                    <span class="added-to-cart-badge"></span>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> -->

                                    <div class="overflow-x-auto">
                                        @if ($product->variants->isNotEmpty())
                                            <table class="table table-bordered text-center align-middle">
                                                <thead class="table-dark border-0">
                                                    <tr class="border-0">
                                                        <th class="bg-transparent border-0"></th>
                                                        @foreach ($product->variants as $i => $v)
                                                            <th>Variant #{{ $i + 1 }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $fields = [
                                                            'Purity',
                                                            'color',
                                                            'unit',
                                                            'style',
                                                            'making',
                                                            'size',
                                                            'weight',
                                                            'qty',
                                                        ];
                                                        $labels = [
                                                            'Purity',
                                                            'Color',
                                                            'Unit',
                                                            'Style',
                                                            'Making %',
                                                            'Size',
                                                            'Weight',
                                                            'In Stock',
                                                        ];
                                                    @endphp

                                                    @foreach ($fields as $fIndex => $field)
                                                        <tr>
                                                            <td>{{ $labels[$fIndex] }}</td>
                                                            @foreach ($product->variants as $variant)
                                                                <td>{{ $field === 'qty' ? $variant[$field] . ' ' . $variant['unit'] : $variant[$field] }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td>Qty</td>
                                                        @foreach ($product->variants as $index => $variant)
                                                            <td>
                                                                <div
                                                                    class="input-group quantity-input-group quantity-container">
                                                                    <input type="button" value="-"
                                                                        class="qtyminus" field="quantity">
                                                                    <input type="text"
                                                                        name="quantity{{ $variant['productID'] }}" id="quantity{{ $variant['productID'] }}"
                                                                        value="1" class="qty">
                                                                    <input type="button" value="+" class="qtyplus"
                                                                        field="quantity">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td>Add to Cart</td>
                                                        @foreach ($product->variants as $index => $variant)
                                                            <td>
                                                                @php
                                                                    $isCart = App\Models\Cart::where(
                                                                        'user_id',
                                                                        Auth::user()->id,
                                                                    )
                                                                        ->where('product_id', $variant['productID'])
                                                                        ->get();
                                                                    $currentcartcount = App\Models\Cart::where(
                                                                        'product_id', $variant['productID']
                                                                    )
                                                                        ->where('user_id', Auth::user()->id)
                                                                        ->value('qty');
                                                                @endphp
                                                                <div class="shop-page-add-to-cart-btn mt-3">
                                                                    @if (count($isCart))
                                                                        <button
                                                                            onclick="addtocart({{ $variant['productID'] }})"
                                                                            class="btn added-to-cart-btn mr-2 spinner-button"
                                                                            data_id="card_id_{{ $variant['productID'] }}">
                                                                            <span class="submit-text">ADDED
                                                                                TO CART</span>
                                                                            <span class="d-none spinner">
                                                                                <span
                                                                                    class="spinner-grow spinner-grow-sm"
                                                                                    aria-hidden="true"></span>
                                                                                <span role="status">Adding...</span>
                                                                            </span>
                                                                            <span
                                                                                id="applycurrentcartcount{{ $variant['productID'] }}"
                                                                                class="added-to-cart-badge ms-2">{{ $currentcartcount }}</span>
                                                                        </button>
                                                                    @else
                                                                        <button
                                                                            onclick="addtocart({{ $variant['productID'] }})"
                                                                            class="btn add-to-cart-btn mr-2 spinner-button"
                                                                            data_id="card_id_{{ $variant['productID'] }}">
                                                                            <span class="submit-text">ADD
                                                                                TO CART</span>

                                                                            <span class="d-none spinner">
                                                                                <span
                                                                                    class="spinner-grow spinner-grow-sm"
                                                                                    aria-hidden="true"></span>
                                                                                <span role="status">Adding...</span>
                                                                            </span>
                                                                            <span class="added-to-cart-badge"></span>
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div>
                                    @if ($product->qty > 0)
                                        <div class="d-none d-md-block mt-3">
                                            <div class="text-success">
                                                Product Stock - <span class="fw-semibold">{{ $product->qty }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="py-4 mt-4 d-flex gap-5 flex-row flex-wrap align-items-center"
                                        style=" border-top: 1px solid #bcbcbc;">

                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="fs-6" style=" color: #717171; ">Quantity</div>
                                            <div
                                                class="input-group quantity-input-group quantity-container align-items-center">
                                                <input type="hidden" name="moq" id="moq" value="1">
                                                <input type="hidden" name="qty" id="qty"
                                                    value="{{ $product->qty }}">
                                                <input type="hidden" name="box" id="box"
                                                    value="{{ $product->style }}">
                                                <input type='button' value='-' class='qtyminus'
                                                    field='quantity' />
                                                <input type='text' id="quantity" name='quantity'
                                                    value="{{ $currentcartcount ?? 1 }}" class='qty' />
                                                <input type='button' value='+' class='qtyplus'
                                                    field='quantity' />
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
                                                        <span class="spinner-grow spinner-grow-sm"
                                                            aria-hidden="true"></span>
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

                                    <div id="accordion mt-4">
                                        <div class="accordion product-specs-accordian py-3">
                                            <div class="accordion-header" role="button" data-bs-toggle="collapse"
                                                data-bs-target="#panel-body-1" aria-expanded="true">
                                                <h5>
                                                    Product Specs <span class="accordion-icon"><i
                                                            class="fas fa-angle-up"></i></span>
                                                </h5>
                                            </div>
                                            <div class="accordion-body collapse show px-0" id="panel-body-1"
                                                data-parent="#accordion">
                                                <div class="d-flex gap-5 flex-wrap">
                                                    @if ($product->color)
                                                        <div>
                                                            <div class="product-specs-item_title mb-2">COLOR</div>
                                                            <div class="product-specs-item_text">
                                                                {{ $product->color }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($product->unit)
                                                        <div>
                                                            <div class="product-specs-item_title mb-2">UNIT</div>
                                                            <div class="product-specs-item_text">
                                                                {{ $product->unit }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($product->style)
                                                        <div>
                                                            <div class="product-specs-item_title mb-2">STYLE</div>
                                                            <div class="product-specs-item_text">
                                                                {{ $product->style }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($product->making)
                                                        <div>
                                                            <div class="product-specs-item_title mb-2">MAKING</div>
                                                            <div class="product-specs-item_text">
                                                                {{ $product->making }}%
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($product->Purity)
                                                        <div>
                                                            <div class="product-specs-item_title mb-2">PURITY</div>
                                                            <div class="product-specs-item_text">
                                                                {{ $product->Purity }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($product->size)
                                                        <div>
                                                            <div class="product-specs-item_title mb-2">SIZE</div>
                                                            <div class="product-specs-item_text">
                                                                {{ $product->size }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
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
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->

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

    <script>
        $(function () {
    // Toggle accordion
    $('#accordion-toggle').on('click', function () {
        var $content = $('#accordion-content');
        $content.slideToggle(200);

        // Optionally rotate the icon
        $('#accordion-icon').toggleClass('rotate-180');
    });

    $('#accordion-content').show();

});

    </script>
@endsection
@endsection
