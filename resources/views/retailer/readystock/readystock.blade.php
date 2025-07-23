@php
    $currentUrl = url()->current();
@endphp
@extends('retailer.layout.retailermaster')
@section('content')
@section('title')
    @if ($currentUrl == route('efganesha'))
        Electroforming/Ganesha
    @elseif($currentUrl == route('efhanuman'))
        Electroforming/Hanuman
    @elseif($currentUrl == route('efkrishna'))
        Electroforming/Krishna
    @elseif($currentUrl == route('eflakshmi'))
        Electroforming/Lakshmi
    @elseif($currentUrl == route('efbuddha'))
        Electroforming/Buddha
    @elseif($currentUrl == route('siganesha'))
        Solid Idol/Ganesh
    @elseif($currentUrl == route('sihanuman'))
        Solid Idol/Hanuman
    @elseif($currentUrl == route('sikrishna'))
        Solid Idol/Krishna
    @elseif($currentUrl == route('silakshmi'))
        Solid Idol/Lakshmi
    @elseif($currentUrl == route('sivishnu'))
        Solid Idol/Vishnu
    @elseif($currentUrl == route('retailerefreadystock'))
        EF
    @elseif($currentUrl == route('retailersireadystock'))
        CASTING
    @elseif($currentUrl == route('retailerjewelleryreadystock'))
        IMPREZ
    @elseif($currentUrl == route('retailerindianiareadystock'))
        INDIANIA
    @elseif($currentUrl == route('retailerutensilreadystock'))
        LASERCUT
    @elseif($currentUrl == route('mmd'))
        MMD
    @elseif($currentUrl == route('stamping'))
        STAMPING
    @elseif($currentUrl == route('turkish'))
        TURKISH
    @elseif($currentUrl == route('unikraft'))
        UNIKRAFT
    @elseif($currentUrl == route('retailersearch'))
        search
    @endif- Emerald RMS
@endsection
@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.9/sumoselect.min.css"
        integrity="sha512-vU7JgiHMfDcQR9wyT/Ye0EAAPJDHchJrouBpS9gfnq3vs4UGGE++HNL3laUYQCoxGLboeFD+EwbZafw7tbsLvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@php
    $usedWeights = App\Models\ProductVariant::where('qty', '>', 0)->pluck('weight')->toArray();

    $weights = App\Models\Weight::where(function ($query) use ($usedWeights) {
        foreach ($usedWeights as $productWeight) {
            $query->orWhere(function ($q) use ($productWeight) {
                $q->where('weight_range_from', '<=', $productWeight)->where('weight_range_to', '>=', $productWeight);
            });
        }
    })->get();
    $currentProjectId = $project_id;
    $projectId = App\Models\Project::where('is_active', 1)->where('id', $currentProjectId)->value('id');
    $products = App\Models\Product::where('Project', $currentProjectId)
        ->where('qty', '>', 0)
        ->select('Item', DB::raw('MIN(id) as id'))
        ->groupBy('Item')
        ->get();
@endphp
<input type="hidden" name="decryptedProjectId" id="decryptedProjectId" value="{{ $decryptedProjectId ?? '' }}">

<div class="container-fluid">
    <div class="my-2 text-center d-block d-lg-none">
        <div class="mobile-filters-offcanvas" id="mobile-sticky-filter">
            <div>
                <button class="btn mobile-filters-trigger-btn" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMobileFilters" aria-controls="offcanvasMobileFilters">
                    Filter By
                </button>
            </div>
        </div>

        <div class="offcanvas offcanvas-start mobile-filters-offcanvas" tabindex="-1" id="offcanvasMobileFilters"
            aria-labelledby="offcanvasMobileFiltersLabel">
            <div class="offcanvas-body">
                <div class="d-flex justify-content-between mobile-filters-offcanvas__header">
                    <div class="mobile-filters-offcanvas__header--filters-text">Filters</div>
                    <div>
                        <button type="button" onclick="clearFilters();"
                            class="mobile-filters-offcanvas__header--clear-btn">Clear
                            all</button>
                    </div>
                </div>
                <div class="mobile-filters-offcanvas__body">
                    <div class="mobile-filters-offcanvas__body-items">
                        <div class="mobile-filters-offcanvas__body-item-filter-labels">
                            <div class="nav flex-column" id="mob-filters-tab" role="tablist"
                                aria-orientation="vertical">

                                <button class="nav-link" id="mobProductFilterTab" data-bs-toggle="pill"
                                    data-bs-target="#mobileProductFilter" type="button" role="tab"
                                    aria-controls="mobileProductFilter" aria-selected="false">Product</button>
                                <button class="nav-link" id="mobWeightFilter" data-bs-toggle="pill"
                                    data-bs-target="#mobileWeightFilter" type="button" role="tab"
                                    aria-controls="mobileWeightFilter" aria-selected="true">Weight
                                    Range</button>
                                <button class="nav-link" id="mobProcategoryFilter" data-bs-toggle="pill"
                                    data-bs-target="#mobileprocategoryFilter" type="button" role="tab"
                                    aria-controls="mobileprocategoryFilter" aria-selected="true">Pro Category</button>
                            </div>
                        </div>
                        <div class="mobile-filters-offcanvas__body-item-filter-inputs">
                            <div class="tab-content" id="mob-filters-tabContent">
                                <div class="tab-pane fade show active" id="mobileProductFilter" role="tabpanel"
                                    aria-labelledby="mobileProductFilter" tabindex="0">
                                    <div class="filter-inputs_wrapper">
                                        @foreach ($products as $item)
                                            <div class="form-check d-flex justify-content-between gap-2">
                                                <div>
                                                    <input class="product form-check-input" type="checkbox"
                                                        id="product{{ $item->id }}" name="product"
                                                        data-id={{ $item->id }} value="{{ $item->Item }}"
                                                        onclick="getProduct({{ $item->id }})">
                                                    <label class="form-check-label" for="product{{ $item->id }}">
                                                        {{ $item->Item }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="mobileWeightFilter" role="tabpanel"
                                    aria-labelledby="mobWeightFilter" tabindex="0">
                                    <div class="filter-inputs_wrapper" id="mobile-weight-filters">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="mobileprocategoryFilter" role="tabpanel"
                                    aria-labelledby="mobileprocategoryFilter" tabindex="0">
                                    <div class="filter-inputs_wrapper" id="mobile-procategory-filters">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mobile-filters-offcanvas__footer">
                    <button type="button" class="mobile-filters-offcanvas__footer--close-btn"
                        data-bs-dismiss="offcanvas" aria-label="Close">CLOSE</button>
                    <button class="mobile-filters-offcanvas__footer--apply-btn" id="apply-filters-btn"
                        data-bs-dismiss="offcanvas" aria-label="Close">APPLY</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none d-lg-block">
        <div class="shop-page-breadcrumbs mt-3 ps-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    @if ($breadcrumUrl != null && $breadcrum != null)
                        <li class="breadcrumb-item"><a href="{{ route('retailerlanding') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ $breadcrumUrl }}">{{ $breadcrum }}</a>
                        </li>
                        @if (!empty($search))
                            <li class="breadcrumb-item">{{ $search }}</li>
                        @endif
                    @else
                        <li><b>Search results for: {{ $search }}</b></li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-0">
        {{-- Sidebar --}}
        @include('retailer.readystock.sidebar')
        {{-- product list --}}
        <section class="col-lg-9 col-xxl-10 ms-auto">

            <div class="shop-page-breadcrumbs d-lg-none">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-0">
                        <li class="breadcrumb-item"><a href="{{ route('retailerlanding') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ $breadcrumUrl }}">{{ $breadcrum }}</a></li>
                        @if (!empty($search))
                            <li class="breadcrumb-item"><b>{{ $search }}</b></li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2 flex-wrap  flex-lg-nowrap justify-content-between">
                <div class="d-flex gap-2 align-items-center flex-wrap">

                    <div id="selected-filters-wrapper"></div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="view-toggle ms-auto me-2 d-none">
                        <button class="custom-icon-btn grid-view active">
                            <i class="fas fa-th-large"></i>
                        </button>

                        <button class="custom-icon-btn list-view">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="product-cards_wrapper position-relative pt-0">
                <div class="col-12 mb-3 d-flex justify-content-end gap-3 align-items-center sticky-add-to-cart">
                    @if (!$product->isEmpty())
                        <div class="moq-inputs_wrapper" id="checkboxhidden">
                            <input id="add-moq" type="checkbox" class="card-checkbox">
                            <label for="add-moq">Select All</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div id="addtocarthidden">
                                <span data-bs-toggle="tooltip" data-placement="top"
                                    data-bs-title="Please add atleast one product to the cart">
                                    <button id="addalltocart" onclick="addAllToCart()"
                                        class="spinner-button1 btn btn-warning card-button text-uppercase" disabled>
                                        <span>Add All to cart</span> <span class="d-none spinner">
                                            <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                            <span role="status">Adding...</span>
                                        </span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="pageloader">
                    <div class="text-center d-flex flex-column h-100 justify-content-center align-items-center">
                        <div class="mb-2">
                            <img class="spinner-image" width="60" height="60"
                                src="{{ asset('retailer/assets/img/loader.png') }}" alt="">
                        </div>
                        <div>Please wait!</div>
                    </div>
                </div>
                <div id="notfound">
                </div>
                @foreach ($allProduct as $item)
                    <input type="hidden" name="encrypt{{ $item->id }}" id="encrypt{{ $item->id }}"
                        value="{{ encrypt($item->id) }}">
                @endforeach

                <div class="row">
                    <div class="col-12 shop-page_product-cards grid" id="product_page">
                        @foreach ($product as $main)
                            <input type="hidden" name="weight{{ $main->id }}" id="weight{{ $main->id }}"
                                value="{{ $main->weight }}">
                            <input type="hidden" name="size{{ $main->id }}" id="size{{ $main->id }}"
                                value="{{ $main->size }}">
                            <input type="hidden" name="box{{ $main->id }}" id="box{{ $main->id }}"
                                value="{{ $main->style }}">

                            <div class="card shop-page_product-card">
                                <div
                                    class="card-img-top d-flex align-items-center justify-content-center position-relative">
                                    <a href="{{ route('retailerproductdetail', encrypt($main->id)) }}">
                                        <img class="img-fluid prouduct_card-image load-secure-image"
                                            src="{{ asset('/load-loading.gif') }}"
                                            data-secure="{{ $main->secureFilename }}" width="255" height="255"
                                            alt="">
                                    </a>
                                    <div class="position-absolute card-purity purity-list">
                                        Purity: {{ $main->Purity ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="card-title">
                                        <a href="#" class="text-decoration-none">{{ $main->DesignNo }}</a>
                                    </div>

                                    @if ($main->variant_count > 1)
                                        {{-- Multiple Variants View (Second Image Layout) --}}
                                        <div class="mt-3">
                                            <div class="card-text fw-bold">Multiple Sizes Available</div>
                                            <a href="{{ route('retailerproductdetail', encrypt($main->id)) }}"
                                                class="btn btn-warning mt-2">
                                                View All Options
                                            </a>
                                        </div>
                                    @else
                                        {{-- Single Variant Detailed View (First Image Layout) --}}
                                        <div class="mt-3 grid cols-3 card-content_wrapper">
                                           @if ($main->unit)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Unit</div>
                                                    <div class="product-card-badge product-card-badge">
                                                        {{ $main->unit ?? '-' }}</div>
                                                </div>
                                            @endif
                                            @if ($main->style)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Style</div>
                                                    <div class="product-card-badge product-card-badge">
                                                        {{ $main->style ?? '-' }}</div>
                                                </div>
                                            @endif
                                            @if ($main->making)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Making %</div>
                                                    <div class="product-card-badge">{{ $main->making ?? '-' }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($main->color)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Colour</div>
                                                    <div class="product-card-badge product-card-badge-light">
                                                        {{ $main->color ?? '-' }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($main->size)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Size</div>
                                                    <div class="product-card-badge product-card-badge-light">
                                                        {{ $main->size ?? '-' }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($main->weight)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Weight</div>
                                                    <div class="product-card-badge product-card-badge-light">
                                                        {{ $main->weight ?? '-' }}g
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="product-cart-qty-text mt-2">
                                            In Stock: <span>{{ $main->qty ?? '-' }} Pcs</span>
                                        </div>

                                        {{-- Add to Cart Section --}}
                                        <div class="shop-page-add-to-cart-btn mt-3">
                                            <div class="d-flex align-items-center">
                                                <label class="me-2">Qty</label>
                                                <div class="input-group quantity-input-group quantity-container">
                                                    <input type="button" value="-" class="qtyminus"
                                                        field="quantity">
                                                    <input type="text" name="quantity"
                                                        id="quantity{{ $main->id }}" value="1"
                                                        class="qty">
                                                    <input type="button" value="+" class="qtyplus"
                                                        field="quantity">
                                                </div>
                                            </div>

                                            @php
                                                $isCart = App\Models\Cart::where('user_id', Auth::user()->id)
                                                    ->where('product_id', $main->id)
                                                    ->get();
                                                $currentcartcount = App\Models\Cart::where('product_id', $main->id)
                                                    ->where('user_id', Auth::user()->id)
                                                    ->value('qty');
                                            @endphp
                                            <div class="shop-page-add-to-cart-btn mt-3">
                                                @if (count($isCart))
                                                    <button onclick="addforcart({{ $main->id }})"
                                                        class="btn added-to-cart-btn mr-2 spinner-button"
                                                        data_id="card_id_{{ $main->id }}">
                                                        <span class="submit-text">ADDED TO CART</span>
                                                        <span class="d-none spinner">
                                                            <span class="spinner-grow spinner-grow-sm"
                                                                aria-hidden="true"></span>
                                                            <span role="status">Adding...</span>
                                                        </span>
                                                        <span id="applycurrentcartcount{{ $main->id }}"
                                                            class="added-to-cart-badge ms-2">{{ $currentcartcount }}</span>
                                                    </button>
                                                @else
                                                    <button onclick="addforcart({{ $main->id }})"
                                                        class="btn add-to-cart-btn mr-2 spinner-button"
                                                        data_id="card_id_{{ $main->id }}">
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
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="pagination"></div>
            @if (!$product->isEmpty())
                <div class="my-5 pagination-links">
                    <nav class="large-devices_pagination">
                        <div class="d-flex gap-3 flex-wrap justify-content-between">
                            <div>
                                Showing {{ $product->firstItem() }} - {{ $product->lastItem() }} of
                                {{ $product->total() }} results
                            </div>
                            <ul class="pagination">
                                @if ($product->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $product->previousPageUrl() }}"
                                            tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                @for ($page = max(1, $product->currentPage() - 2); $page <= min($product->lastPage(), $product->currentPage() + 2); $page++)
                                    @if ($page == $product->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $product->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                @if ($product->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $product->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                    <nav class="small-devices_pagination d-none">
                        <div class="text-center">
                            <a class="btn btn-dark px-4 py-2" href="{{ $product->nextPageUrl() }}">See More
                                Products</a>
                        </div>
                    </nav>
                </div>
            @endif
    </div>
    </section>
</div>
</div>
<style>
    .fixed-button-container {
        position: fixed;
        bottom: 1 0px;
        /* Adjust the distance from the bottom */
        right: 20px;
        /* Adjust the distance from the right */
        z-index: 1000;
        /* Adjust the z-index if needed */
    }

    .main-mega-nav ul li a.has-submenu::after {
        top: -5px !important;
    }
</style>
@section('scripts')
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->

    <script src="{{ asset('retailer\assets\js\readystock\readystock.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.card-checkbox').click(function() {
                if ($(this).is(':checked')) {
                    $('#addalltocart').removeAttr('disabled');
                    var tooltipTriggerEl = $('#addtocarthidden').find('[data-bs-toggle="tooltip"]'),
                        tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
                    tooltip.dispose(); // Destroy the old tooltip
                } else {
                    $('#addalltocart').attr('disabled', 'disabled');
                    var tooltipTriggerEl = $('#addtocarthidden').find('[data-bs-toggle="tooltip"]'),
                        tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
                    var newTitle = "Please add atleast one product to the cart";
                    $('#addtocarthidden').find('[data-bs-toggle="tooltip"]').attr('data-bs-title', newTitle)
                        .attr('title', newTitle).attr('data-bs-original-title', newTitle);
                    tooltip.dispose(); // Destroy the old tooltip
                    tooltip = new bootstrap.Tooltip(tooltipTriggerEl);
                }
            });
        });
        $(document).ready(function() {
            $('.top-dropdown-filters .btn').click(function() {
                var target = $(this).attr('data-target');
                var isExpanded = $(this).attr('aria-expanded') === 'true';
                // Remove "show" class from all other collapses and set icons to 'down'
                $('.top-dropdown-filters .collapse').not(target).removeClass('show');
                $('.top-dropdown-filters .btn .collapse-icon').removeClass('fa-chevron-up').addClass(
                    'fa-chevron-down');
                // Remove custom class from all other buttons
                $('.top-dropdown-filters .btn').not(this).removeClass('active-btn');
                // Toggle the current collapse
                $(target).toggleClass('show');
                // Set "aria-expanded" to the opposite of its current state for the clicked button
                $(this).attr('aria-expanded', !isExpanded);
                // Toggle the icons based on the collapse state
                if (!isExpanded) {
                    $(this).find('.collapse-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                } else {
                    $(this).find('.collapse-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
                // Add custom class to the active button
                $(this).toggleClass('active-btn');
            });
            // Add click event listener to wishlist-svg buttons
            const wishlistButtons = document.querySelectorAll(".wishlist-svg");
            wishlistButtons.forEach((button) => {
                button.addEventListener("click", function() {
                    // Toggle the 'active' class to change the color on click
                    this.classList.toggle("active");
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let showAlert = false; // Flag to track if alert has been shown

        // Event listener for APPLY button
        $('#apply-filters-btn').click(function(event) {
            if (!anyCheckboxChecked()) {
                showAlert = true;
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'Please select at least one filter',
                });
            } else {
                showAlert = false; // Reset the flag if filters are selected
            }
        });

        // Event listener for closing the offcanvas
        $('#mobileFiltersOffcanvas').on('hide.bs.offcanvas', function(event) {
            if (showAlert) {
                return false; // Prevent the offcanvas from closing
            }
        });

        // Function to check if any checkbox is checked
        function anyCheckboxChecked() {
            let checkboxes = $('.form-check-input');
            for (let checkbox of checkboxes) {
                if (checkbox.checked) {
                    return true;
                }
            }
            return false;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Define the header element
            let header = document.querySelector('#mobile-sticky-filter');

            // Function to add or remove sticky class on scroll
            function handleScroll() {
                if (window.innerWidth <= 992) { // Only apply on mobile devices (992px and below)
                    if (window.scrollY > 50) { // If scrolled down
                        header.classList.add('active');
                    } else {
                        header.classList.remove('active');
                    }
                } else {
                    header.classList.remove('active'); // Remove sticky on desktop view
                }
            }

            // Listen for scroll events
            window.addEventListener('scroll', handleScroll);
        });
    </script>

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
@endsection
@endsection
