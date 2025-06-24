@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
    Product Detail - Emerald OMS
@endsection
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
<section class="breadcrumbs container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    <li class="breadcrumb-item"><a href="/">HOME</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('projects', encrypt($product->project_id)) }}">{{ str_replace('SIL ', '', $product->project_name) }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('shop', encrypt($product->category_id)) }}">{{ $product->category_name }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->product_unique_id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<input type="hidden" name="weight" id="weight" value="{{ $product->weight }}">
<section class="main-product container-lg">
    <div class="row">
        <div class="col-12 col-lg-6 mb-lg-0">
            {{-- @if (count($allImagesArray) == 0) --}}
            <div class="single-images-block">
                <img class="img-fluid" width="366" height="366"
                    src="{{ file_exists(public_path('upload/product/' . $product->product_image)) ? asset('upload/product/' . $product->product_image) : asset('frontend/img/no-product-image.jpg') }}"
                    alt="">
            </div>
            <div class="product-thumbnail_wrapper splide mt-3 d-none" id="thumbnail-slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide"><img class="img-fluid" width="100" height="100"
                                src="{{ asset('upload/product/' . $product->product_image) }}" alt="thumb img"></li>
                    </ul>
                </div>
            </div>
            {{-- @else
                <div class="product-image_wrapper splide" id="main-slider">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($allImagesArray as $value)
                                <li class="splide__slide"><img class="img-fluid" width="440" height="458"
                                        src="{{ asset($value) }}" alt></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="product-thumbnail_wrapper splide mt-3" id="thumbnail-slider">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($allImagesArray as $value)
                                <li class="splide__slide"><img class="img-fluid" width="440" height="458"
                                        src="{{ asset($value) }}" alt></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif --}}
        </div>
        <div class="col-12 col-lg-6 mt-5 mt-md-0">
            <div class="product-page_content_wrapper">
                <div class="d-flex align-items-center">
                    <div class="product-design_title">Design
                        Code: <span class="product-design_content me-2">{{ $product->product_unique_id }}</span></div>
                    <div class="ml-auto ml-sm-5">
                        @if ($product->qty > 0)
                            <div class="badge in-stock-badge">IN
                                STOCK</div>
                        @else
                            <div class="badge out-stock-badge">OUT OF
                                STOCK</div>
                        @endif

                    </div>
                </div>
                <div class="product-main-title mt-3 mb-4">{{ $product->product_name }}</div>
                @php
                    $weight = $product->weight;
                    $mcCharge = App\Models\Weight::where('is_active', 1)
                        ->where('weight_range_from', '<=', $weight)
                        ->where('weight_range_to', '>=', $weight)
                        ->value('mc_charge');

                    $weightString = (string) $mcCharge;
                    $variable1 = (int) $weightString[0];
                    $variable2 = (int) $weightString[1];

                    $mc1 = App\Models\MakingCharge::where('mc_charge', $variable1)->value('mc_code');
                    $mc2 = App\Models\MakingCharge::where('mc_charge', $variable2)->value('mc_code');
                @endphp
                @if (
                    $product->project_id == App\Enums\Projects::ELECTROFORMING ||
                        $stock == 1 ||
                        ($product->project_id == App\Enums\Projects::SOLIDIDOL && Str::startsWith($product->product_unique_id, 'CSSIDOL')))
                    @php
                        $mc =
                            $product->project_id == App\Enums\Projects::ELECTROFORMING || $stock == 1 ? $mc1 . $mc2 : 'C*';
                    @endphp
                    <div class="mt-2 text-success">Tag Code : <span class="fw-semibold">{{ $mc }}</span>
                    </div>
                @elseif ($product->project_id == App\Enums\Projects::SOLIDIDOL && Str::startsWith($product->product_unique_id, 'CSSIDOL'))
                    @php
                        $mc = 'C*';
                    @endphp
                    <div class="mt-2 text-success">Tag Code : <span class="fw-semibold">{{ $mc }}</span>
                    </div>
                @else
                    @php
                        $mc = $product->weight < 20 ? 'G' : 'F';
                    @endphp
                    <div class="mt-2 text-success">Tag Code : <span class="fw-semibold">{{ $mc }}</span>
                    </div>
                @endif
                @if ($product->size_id != null)
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
                                        name="size" id="size{{ $size->id }}" value="{{ $size->id }}">
                                    <label for="size{{ $size->id }}">{{ $size->size }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- <div class="product-size-options py-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="product-options-title">weight</div>
                        <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="product-size-option_btn" data-bs-toggle="modal"
                                data-bs-target="#weightChartModal">
                                <span>weight ranges</span>
                                <i class="fas fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                    <ul class="list-unstyled d-flex flex-wrap product-swatches">
                        @foreach ($weights as $key => $weight)
                            <li>
                                <input @if ($key == 0) checked @endif type="radio" name="weight"
                                    id="weight{{ $weight->id }}" value="{{ $weight->id }}">
                                <label for="weight{{ $weight->id }}">{{ $weight->weight }}g</label>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
                {{-- <div class="product-size-options py-3">
                    <div class="mb-3">
                        <div class="product-options-title">Color</div>
                    </div>
                    <ul class="list-unstyled d-flex flex-wrap product-swatches-box">
                        @foreach ($colors as $key => $color)
                            <li>
                                <input @if ($key == 0) checked @endif type="radio" name="color"
                                    id="color{{ $color->id }}" value="{{ $color->id }}">
                                <label for="color{{ $color->id }}">{{ $color->color_name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
                {{-- <div class="product-size-options py-3">
                    <div class="mb-3">
                        <div class="product-options-title">Plating</div>
                    </div>
                    <ul class="list-unstyled d-flex flex-wrap product-swatches-box">
                        @foreach ($platings as $key => $plating)
                            <li>
                                <input @if ($key == 0) checked @endif type="radio" name="plating"
                                    id="plating{{ $plating->id }}" value="{{ $plating->id }}">
                                <label for="plating{{ $plating->id }}">{{ $plating->plating_name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div> --}}
                <div class="product-finish-options py-3">
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
                </div>
                @if ($stock == 1 && $product->qty > 0)
                    <div>
                        <div class="text-success">
                            Product Stock - <span class="fw-semibold">{{ $product->qty }}</span>
                        </div>
                    </div>
                @endif

                @if ($product->project_id != 1 && $product->project_id != 11)
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
                @endif
                <div class="my-4 my-mb-5 d-flex gap-4 flex-row flex-wrap align-items-center">
                    <div class="product-weight_text mb-4 mb-md-0">{{ $product->weight }}
                        gm</div>
                    <div class="input-group quantity-input-group quantity-container align-items-center">
                        <input type="hidden" name="moq" id="moq" value="{{ $product->moq }}">
                        <input type="hidden" name="qty" id="qty" value="{{ $product->qty }}">
                        <input type="hidden" name="box" id="box" value="{{ $product->style_id }}">
                        <input type="hidden" name="stockqty" id="stockqty" value="{{ $stock }}">
                        <input type='button' value='-' class='qtyminus' field='quantity' />
                        <input type='text' id="quantity" name='quantity' value="{{ $product->moq }}"
                            class='qty' />
                        <input type='button' value='+' class='qtyplus' field='quantity' />
                    </div>
                    @if (Auth::user()->role_id != App\Enums\Roles::Admin)
                        <div>
                            <a id="cart" onclick="addtocart({{ $product->id }})"
                                class="btn btn-warning product-add-to_cart-btn">Add
                                to Cart</a>
                        </div>
                    @endif
                </div>
                <div id="accordion">
                    <div class="accordion product-specs-accordian">
                        <div class="accordion-header" role="button" data-bs-toggle="collapse"
                            data-bs-target="#panel-body-1" aria-expanded="true">
                            <h4>
                                Product Specs <span class="accordion-icon"><i class="fas fa-angle-down"></i></span>
                            </h4>
                        </div>
                        <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion" style>
                            <div class="row mt-3">
                                {{-- <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">BRAND</div>
                                    <div class="product-specs-item_text">{{ $product->brand_name }}</div>
                                </div> --}}
                                {{-- @if ($product->qty > 0)
                                    <div class="col-4 col-lg-3 mb-4">
                                        <div class="product-specs-item_title mb-2">PRODUCT
                                            STOCK</div>
                                        <div class="product-specs-item_text">{{ $product->qty }}</div>
                                    </div>
                                @endif --}}
                                @if ($product->gender && $product->gender != 'NONE')
                                    <div class="col-4 col-lg-3 mb-4">
                                        <div class="product-specs-item_title mb-2">Gender</div>
                                        <div class="product-specs-item_text">{{ $product->gender }}</div>
                                    </div>
                                @endif
                                {{-- <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">COLLECTION</div>
                                    <div class="product-specs-item_text">{{ $product->collection_name }}</div>
                                </div> --}}
                                <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">METAL</div>
                                    <div class="product-specs-item_text">{{ $product->metal_name }}</div>
                                </div>
                                <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">HEIGHT</div>
                                    <div class="product-specs-item_text">{{ $product->height }}</div>
                                </div>
                                <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">PRODUCT
                                        WIDTH</div>
                                    <div class="product-specs-item_text">{{ $product->width }}</div>
                                </div>

                                {{-- <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">SILVER
                                        SHAPE</div>
                                    <div class="product-specs-item_text">{{ $product->shape }}</div>
                                </div> --}}
                                <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">METAL
                                        COLOR</div>
                                    <div class="product-specs-item_text">{{ $product->plating_name }}</div>
                                </div>
                                {{-- <div class="col-4 col-lg-3 mb-4">
                                    <div class="product-specs-item_title mb-2">PURITY</div>
                                    <div class="product-specs-item_text">{{ $product->silver_purity_percentage }}
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Size Chart Modal -->
<div class="modal fade" id="sizeChartModal" tabindex="-1" role="dialog" aria-labelledby="sizeChartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="sizeChartModalLabel">Size Chart</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SIZE</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">WEIGHT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.25</td>
                            <td>1.5</td>
                            <td>1.75</td>
                        </tr>
                        <tr>
                            <td>40</td>
                            <td>8</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>0.32</td>
                            <td>0.104</td>
                            <td>0.168</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 py-5">
            <div class="text-center mb-4">
                <div class="fs-3 fw-semibold ">You may also like</div>
            </div>
            <div class="col-12 shop-page_product-cards" id="product_page">
                <div class="swiper recommended-products-slider">
                    <div class="swiper-wrapper">
                        @foreach ($relatedProducts as $item)
                            <div class="swiper-slide">

                                <input type="hidden" name="weight{{ $item->id }}"
                                    id="weight{{ $item->id }}" value="{{ $item->weight }}">
                                <input type="hidden" name="finish{{ $item->id }}"
                                    id="finish{{ $item->id }}" value="{{ $item->finish_id }}">
                                <input type="hidden" name="size{{ $item->id }}" id="size{{ $item->id }}"
                                    value="{{ $item->size_id }}">
                                <input type="hidden" name="plating{{ $item->id }}"
                                    id="plating{{ $item->id }}" value="{{ $item->plating_id }}">
                                <input type="hidden" name="color{{ $item->id }}" id="color{{ $item->id }}"
                                    value="{{ $item->color_id }}">
                                <input type="hidden" name="encrypt{{ $item->id }}"
                                    id="encrypt{{ $item->id }}" value="1">
                                <input type="hidden" name="stock{{ $item->id }}" id="stock{{ $item->id }}"
                                    value="{{ $stock }}">
                                <input type="hidden" name="box{{ $item->id }}" id="box{{ $item->id }}"
                                    value="{{ $item->style_id }}">
                                <div class="card shop-page_product-card">
                                    {{-- <div class="card-checkbox_wrapper">
                                <input class="card-checkbox" type="checkbox"
                                    name="product{{ $item->id }}" id="product{{ $item->id }}"
                                    data-id="{{ $item->id }}">
                            </div> --}}
                                    <div class="card-img-top d-flex align-items-center justify-content-center">
                                        <a href="{{ route('productdetail', encrypt($item->id)) }}">
                                            <img class="img-fluid prouduct_card-image" width="154" height="160"
                                                src="{{ file_exists(public_path('upload/product/' . $item->product_image)) ? asset('upload/product/' . $item->product_image) : asset('frontend/img/no-product-image.jpg') }}"
                                                alt>
                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div
                                            class="d-flex justify-content-between  align-items-center card-title_wrapper">
                                            <div class="card-title"><a href="{{ route('productdetail', encrypt($item->id)) }}">{{ $item->product_unique_id }}</a></div>
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

                                            {{-- @if (!$electroFormingProject)
                                        <div class="card-text mt-2">MOQ: {{ $item->moq }} pcs</div>
                                    @elseif ($stock == 1 && $item->qty != 0)
                                        <div class="card-text mt-2">QTY: {{ $item->qty }} pcs</div>
                                    @endif
                                    <input type="hidden" name="stockqty" id="stockqty"
                                        value="{{ $stock }}">

                                    <input type="hidden" name="qty{{ $item->id }}"
                                        id="qty{{ $item->id }}" value="{{ $item->qty }}"> --}}


                                            <div class="mt-3">
                                                {{-- <div class="d-flex">
                                            <label class="me-2">Qty</label>
                                            <div class="input-group quantity-input-group quantity-container"
                                                data-product-id={{ $item->id }}>
                                                <input type="button" value="-" class="qtyminus"
                                                    field="quantity">
                                                <input type="text" name="quantity"
                                                    id="quantity{{ $item->id }}"
                                                    value="{{ $item->moq }}" class="qty">
                                                <input type="button" value="+" class="qtyplus"
                                                    field="quantity">
                                            </div>
                                        </div> --}}
                                                @if (Auth::user()->role_id == App\Enums\Roles::Dealer)
                                                    <div class="mt-3">
                                                        <button onclick="addforcart({{ $item->id }})"
                                                            class="btn add-to-cart-btn mr-2 spinner-button">
                                                            <span>ADD TO CART</span>
                                                            <span class="d-none spinner">
                                                                <span class="spinner-grow spinner-grow-sm"
                                                                    aria-hidden="true"></span>
                                                                <span role="status">Adding...</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="custom-buttons d-flex gap-4 align-items-center">
                    <div class="recommended-products-slider-scrollbar swiper-scrollbar position-relative"></div>
                    <div class="d-flex gap-2">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <!-- Weight Chart Modal -->
<div class="modal fade" id="weightChartModal" tabindex="-1" role="dialog" aria-labelledby="weightChartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="weightChartModalLabel">Weight Chart</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SIZE</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">WEIGHT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.25</td>
                            <td>1.5</td>
                            <td>1.75</td>
                        </tr>
                        <tr>
                            <td>40</td>
                            <td>8</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>0.32</td>
                            <td>0.104</td>
                            <td>0.168</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}
@section('scripts')

    <script src="{{ asset('retailer/assets/lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/shop/product_detail.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
@endsection
@endsection
