@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
Shop - Emerald OMS
@endsection
@section('header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@php
$selectedProjectId = session('selected_project_id');
$selectedCategoryId = session('selected_category_id');
$weights = App\Models\Weight::where('is_active', 1)->whereNull('deleted_at')->get();
$colors = App\Models\Color::where('is_active', 1)->whereNull('deleted_at')->get();
$platings = App\Models\Plating::where('is_active', 1)->whereNull('deleted_at')->get();
$banners = App\Models\Banner::where('banner_position_id', 3)->get();
$currentProjectId = $_COOKIE['currentProjectId'] ?? null;
$currentCategoryId = $_COOKIE['currentCategoryId'] ?? null;
$projectId = App\Models\Project::where('is_active', 1)->where('id', $currentProjectId)->value('id');
// $collections = App\Models\Collection::where('is_active', 1)
// ->where(function ($query) use ($currentProjectId, $currentCategoryId) {
// if ($currentProjectId && $currentCategoryId) {
// $query->where('project_id', $currentProjectId)->where('category_id', $currentCategoryId);
// } elseif ($currentProjectId) {
// $query->where('project_id', $currentProjectId)->where(function ($innerQuery) {
// $innerQuery->whereNotNull('category_id')->orWhereNull('category_id');
// });
// } elseif ($currentCategoryId) {
// $query->where('category_id', $currentCategoryId)->where(function ($innerQuery) {
// $innerQuery->whereNotNull('project_id')->orWhereNull('project_id');
// });
// }
// })
// ->whereNull('deleted_at')
// ->get();
$collections = App\Models\Collection::where('is_active', 1)
->where('collection_name', 'GOD')
->whereNull('deleted_at')
->get();
$others = App\Models\Collection::where('is_active', 1)
->where('collection_name', '!=', 'GOD')
->whereNull('deleted_at')
->get();
@endphp
<input type="hidden" name="decryptedCategoryId" id="decryptedCategoryId" value="{{ $decryptedCategoryId ?? '' }}">
<input type="hidden" name="decryptedProjectId" id="decryptedProjectId" value="{{ $decryptedProjectId ?? '' }}">
<input type="hidden" name="decryptedSubCategoryId" id="decryptedSubCategoryId"
    value="{{ $decryptedSubCategoryId ?? '' }}">
<input type="hidden" name="projectSolid" id="projectSolid" value="{{ App\Enums\Projects::SOLIDIDOL }}">
<input type="hidden" name="projectEf" id="projectEf" value="{{ App\Enums\Projects::ELECTROFORMING }}">
<!-- Main Content -->
<div class="container-fluid">
    {{-- Navbar --}}
    <div class="row mb-4 mb-lg-0 d-none d-lg-block">
        <div class="col-12 p-0">
            <div class="swiper shop-page-main-slider" style="--swiper-theme-color:#fff;--swiper-navigation-size:16px;">
                <div class="swiper-wrapper">
                    @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <img class="img-fluid w-100" src="{{ asset($banner->banner_image) }}" alt="banner">
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </div>
    </div>

    @include('frontend.shop.product_catelogue')
    <div class="my-2 text-center d-block d-lg-none">


        <div class="mobile-filters-offcanvas">
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
                                @if (
                                $currentProjectId == App\Enums\Projects::SOLIDIDOL ||
                                $currentCategoryId == App\Enums\SICategories::IDOL ||
                                $currentCategoryId == App\Enums\SICategories::POOJAITEMS)
                                <button class="nav-link @if (
                                        $currentProjectId == App\Enums\Projects::SOLIDIDOL ||
                                            $currentCategoryId == App\Enums\SICategories::IDOL ||
                                            $currentCategoryId == App\Enums\SICategories::POOJAITEMS) active @endif"
                                    id="mobClassificationFilter" data-bs-toggle="pill"
                                    data-bs-target="#mobileClassificationFilter" type="button" role="tab"
                                    aria-controls="mobilClassificationFilter"
                                    aria-selected="true">Classification</button>
                                @endif
                                <button class="nav-link @if (
                                    $currentProjectId == App\Enums\Projects::ELECTROFORMING ||
                                        $currentCategoryId == App\Enums\EFCategories::IDOL ||
                                        $currentCategoryId == App\Enums\EFCategories::DIYA ||
                                        $currentCategoryId == App\Enums\EFCategories::MURAL) active @endif"
                                    id="mobWeightFilter" data-bs-toggle="pill" data-bs-target="#mobileWeightFilter"
                                    type="button" role="tab" aria-controls="mobileWeightFilter"
                                    aria-selected="true">Weight Range</button>
                                @foreach ($collections as $collection)
                                @php
                                $subcollections = App\Models\SubCollection::where('is_active', 1)->where(
                                'collection_id',
                                $collection->id,
                                );

                                if ($currentProjectId == App\Enums\Projects::ELECTROFORMING) {
                                $subcollections->where('project_id', App\Enums\Projects::ELECTROFORMING);
                                }

                                if ($currentProjectId == App\Enums\Projects::SOLIDIDOL) {
                                $subcollections->where('project_id', App\Enums\Projects::SOLIDIDOL);
                                }

                                $subcollections = $subcollections->whereNull('deleted_at')->get();
                                $subcollectionsjson = $subcollections->toJson();
                                @endphp
                                <input type="hidden" name="subCollectionData" id="subCollectionData"
                                    value="{{ $subcollectionsjson }}">
                                <button class="nav-link" id="subcollectionFilter{{ $collection->id }}"
                                    data-bs-toggle="pill"
                                    data-bs-target="#subcollectionFilterContent{{ $collection->id }}" type="button"
                                    role="tab" aria-controls="subcollectionFilterContent{{ $collection->id }}"
                                    aria-selected="true">{{ $collection->collection_name }}</button>
                                @endforeach
                                @if (
                                $currentProjectId == App\Enums\Projects::ELECTROFORMING ||
                                $currentCategoryId == App\Enums\EFCategories::IDOL ||
                                $currentCategoryId == App\Enums\EFCategories::DIYA ||
                                $currentCategoryId == App\Enums\EFCategories::MURAL)
                                <button class="nav-link" id="mobOtherFilterTab" data-bs-toggle="pill"
                                    data-bs-target="#mobileOtherFilter" type="button" role="tab"
                                    aria-controls="mobileOtherFilter" aria-selected="false">Others</button>
                                @endif
                            </div>
                        </div>
                        <div class="mobile-filters-offcanvas__body-item-filter-inputs">
                            <div class="tab-content" id="mob-filters-tabContent">
                                <div class="tab-pane fade @if (
                                    $currentProjectId == App\Enums\Projects::ELECTROFORMING ||
                                        $currentCategoryId == App\Enums\EFCategories::IDOL ||
                                        $currentCategoryId == App\Enums\EFCategories::DIYA ||
                                        $currentCategoryId == App\Enums\EFCategories::MURAL) show active @endif"
                                    id="mobileWeightFilter" role="tabpanel" aria-labelledby="mobWeightFilter"
                                    tabindex="0">
                                    <div class="filter-inputs_wrapper" id="mobile-weight-filters">
                                        <!-- @foreach ($weights as $key => $weight)
                                            <div class="form-check d-flex justify-content-between gap-2">
                                                <div>
                                                    <input class="weight_filter form-check-input" type="checkbox"
                                                        id="weightfrommob{{ $weight->id }}" name="weightfrommob"
                                                        data-id={{ $weight->id }}
                                                        value="{{ $weight->weight_range_from }}"
                                                        onclick="getWeightRange({{ $weight->id }})">
                                                    <input class="weight_filter" type="hidden" name="weightto"
                                                        id="weightto{{ $weight->id }}"
                                                        value="{{ $weight->weight_range_to }}">
                                                    <label class="form-check-label"
                                                        for="weightRange-{{ $key + 1 }}">
                                                        {{ $weight->weight_range_from }} -
                                                        {{ $weight->weight_range_to }} gms
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach -->



                                    </div>
                                </div>
                                <div class="tab-pane fade" id="mobileOtherFilter" role="tabpanel"
                                    aria-labelledby="mobileOtherFilter" tabindex="0">
                                    <div class="filter-inputs_wrapper">
                                        @if (
                                        $currentProjectId == App\Enums\Projects::ELECTROFORMING ||
                                        $currentCategoryId == App\Enums\EFCategories::IDOL ||
                                        $currentCategoryId == App\Enums\EFCategories::DIYA ||
                                        $currentCategoryId == App\Enums\EFCategories::MURAL)
                                        @foreach ($others as $other)
                                        <div class="form-check d-flex justify-content-between gap-2">
                                            <div>
                                                <input class="others form-check-input" type="checkbox" id="other"
                                                    name="other" data-id={{ $other->id }}
                                                    value="{{ $other->collection_name }}"
                                                    onclick="getCollectionWiseProducts({{ $other->id }})">
                                                <label class="form-check-label" for="other">
                                                    {{ $other->collection_name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                @foreach ($collections as $collection)
                                @php
                                $subcollections = App\Models\SubCollection::where('is_active', 1)
                                ->where('collection_id', $collection->id)
                                ->whereNull('deleted_at')
                                ->get();
                                @endphp

                                <div class="tab-pane fade" id="subcollectionFilterContent{{ $collection->id }}"
                                    role="tabpanel" aria-labelledby="subcollectionFilter{{ $collection->id }}"
                                    tabindex="0">
                                    <div class="filter-inputs_wrapper">
                                        <input type="hidden" id="collectionId" value="{{ $collection->id }}">
                                        <div id="mobile-subcollection-filters{{ $collection->id }}"
                                            data-id="{{ $collection->id }}">

                                            @if ($subcollections->isNotEmpty())
                                            <div class="mb-2">
                                                <input placeholder="search" class="form-control" type="search" name=""
                                                    id="">
                                            </div>
                                            <div>
                                                <button type="button" onclick="clearCheckboxes()"
                                                    class="clear-all-btn sidebar-clear-btn  mb-1">CLEAR
                                                    ALL</button>
                                            </div>
                                            @else
                                            <div class="text-center p-0">
                                                <label>No Records!</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="tab-pane fade @if (
                                    $currentProjectId == App\Enums\Projects::SOLIDIDOL ||
                                        $currentCategoryId == App\Enums\SICategories::IDOL ||
                                        $currentCategoryId == App\Enums\SICategories::POOJAITEMS) show active @endif"
                                    id="mobileClassificationFilter" role="tabpanel"
                                    aria-labelledby="mobileClassificationFilter" tabindex="0">
                                    <div class="filter-inputs_wrapper">
                                        @if (
                                        $currentProjectId == App\Enums\Projects::SOLIDIDOL ||
                                        $currentCategoryId == App\Enums\SICategories::IDOL ||
                                        $currentCategoryId == App\Enums\SICategories::POOJAITEMS)
                                        <div class="form-check d-flex justify-content-between gap-2">
                                            <div>
                                                <input class="form-check-input classification" type="radio" id="2D-mob"
                                                    name="classification-mobile" value="2D"
                                                    onclick="getclassificationproduct()">
                                                <label class="form-check-label" for="2D-mob">
                                                    2D
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-check d-flex justify-content-between gap-2">
                                            <div>
                                                <input class="form-check-input classification" type="radio" id="3D-mob"
                                                    name="classification-mobile" value="3D"
                                                    onclick="getclassificationproduct()">
                                                <label class="form-check-label" for="3D-mob">
                                                    3D Solid
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-check d-flex justify-content-between gap-2">
                                            <div>
                                                <input class="form-check-input classification" type="radio" id="SE-mob"
                                                    name="classification-mobile" value="SE"
                                                    onclick="getclassificationproduct()">
                                                <label class="form-check-label" for="SE-mob">
                                                    3D Semi Solid
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-check d-flex justify-content-between gap-2">
                                            <div>
                                                <input class="form-check-input classification" type="radio" id="SC-mob"
                                                    name="classification-mobile" value="SC"
                                                    onclick="getclassificationproduct()">
                                                <label class="form-check-label" for="SC-mob">
                                                    3D Scooping
                                                </label>
                                            </div>
                                        </div>
                                        @endif
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

    <!-- Filter Options Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter By</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body mobile-filters_wrapper">
                    <div class="accordion" id="mobile-Filters">
                        <div class="accordion-item mb-4">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#mobile-weightFilter" aria-expanded="false"
                                    aria-controls="mobile-weightFilter">
                                    Weight
                            </h2>
                            <div id="mobile-weightFilter" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    @foreach ($weights as $key => $weight)
                                    <div class="form-check {{ $key > 2 ? 'additional-option' : '' }}"
                                        style="{{ $key > 2 ? 'display: none;' : '' }}">
                                        <input class="weight_filter" type="checkbox" id="weightfrommob{{ $weight->id }}"
                                            name="weightfrommob" data-id={{ $weight->id }}
                                            value="{{ $weight->weight_range_from }}"
                                            onclick="getWeightRange({{ $weight->id }})">
                                        <input class="weight_filter" type="hidden" name="weightto"
                                            id="weightto{{ $weight->id }}" value="{{ $weight->weight_range_to }}">
                                        <label class="form-check-label" for="weightRange-{{ $key + 1 }}">
                                            {{ $weight->weight_range_from }} - {{ $weight->weight_range_to }} gms
                                        </label>
                                    </div>
                                    @endforeach
                                    @if (count($weights) > 3)
                                    <!-- Show More button -->
                                    <button id="showMore" type="button" class="btn btn-link text-black">Show
                                        More</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sort Options Modal -->
    <div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="sortModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sortModalLabel">Sort Options</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mobile-sort_options">
                    <!-- Add your sort options here -->
                    <select name id>
                        <option value>Price Low to High</option>
                        <option value>Price High to Low</option>
                    </select>
                    <!-- Add more sort options as needed -->
                </div>

                <div class="modal-footer m-auto">
                    <div class="text-center">
                        <button type="button" class="btn btn-warning">
                            Apply Sorting
                        </button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline-warning"
                            data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        {{-- Sidebar --}}
        @include('frontend.shop.shopsidebar')
        {{-- product list --}}
        <section class="col-lg-10 p-lg-2">

            <div class="shop-page-breadcrumbs d-lg-none">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb px-0">
                        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ $breadcrumUrl }}">{{ ucwords(strtolower(str_replace('SIL ', '', $breadcrum))) }}</a>
                        </li>
                    </ol>
                </nav>
            </div>


            <div class="d-flex gap-2 flex-wrap  flex-lg-nowrap justify-content-between mt-3 mt-lg-0 mb-3">

                <div>
                    <div id="selected-filters-wrapper"></div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="view-toggle mt-2 ms-auto">
                        @if (Auth::user()->role_id != App\Enums\Roles::Dealer)
                        <button id="download-catalogue" class="btn btn-warning">
                            Download Catalogue
                        </button>
                        @endif
                        <button class="custom-icon-btn grid-view active">
                            <i class="fas fa-th-large"></i>
                        </button>

                        <button class="custom-icon-btn list-view">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

            </div>

            <div class="product-cards_wrapper">
                <div class="col-12 mb-2 d-flex justify-content-between  align-items-center sticky-add-to-cart">
                    @if (!$product->isEmpty())
                    <div class="moq-inputs_wrapper" id="checkboxhidden">
                        <input id="add-moq" type="checkbox" class="card-checkbox">
                        <label for="add-moq">Select All</label>
                    </div>
                    @if (Auth::user()->role_id == App\Enums\Roles::Dealer)
                    <div class="d-flex align-items-center justify-content-between">
                        <div id="addtocarthidden">
                            <span data-bs-toggle="tooltip" data-placement="top"
                                data-bs-title="Plese select atleast one product to cart">
                                {{-- <button id="addalltocart" onclick="addAllToCart()"
                                        class="btn btn-warning card-button mr-2 text-uppercase" disabled>Add
                                        All to cart</button> --}}
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
                        @if ($product->isEmpty())
                        <div class="text-center" id="empty-cart-image">
                            <img src="{{ asset('frontend/img/emptycart.gif') }}" alt="alternative_text" class="nodata">
                        </div>
                        @else
                        @foreach ($product as $item)
                        <input type="hidden" name="weight{{ $item->id }}" id="weight{{ $item->id }}"
                            value="{{ $item->weight }}">
                        <input type="hidden" name="finish{{ $item->id }}" id="finish{{ $item->id }}"
                            value="{{ $item->finish_id }}">
                        <input type="hidden" name="size{{ $item->id }}" id="size{{ $item->id }}"
                            value="{{ $item->size_id }}">
                        <input type="hidden" name="plating{{ $item->id }}" id="plating{{ $item->id }}"
                            value="{{ $item->plating_id }}">
                        <input type="hidden" name="color{{ $item->id }}" id="color{{ $item->id }}"
                            value="{{ $item->color_id }}">
                        <input type="hidden" name="encrypt{{ $item->id }}" id="encrypt{{ $item->id }}" value="1">
                        <input type="hidden" name="stock{{ $item->id }}" id="stock{{ $item->id }}" value="{{ $stock }}">

                        <div class="card shop-page_product-card">
                            <div class="card-checkbox_wrapper">
                                <input class="card-checkbox" type="checkbox" name="product{{ $item->id }}"
                                    id="product{{ $item->id }}" data-id="{{ $item->id }}">
                            </div>
                            <div class="card-img-top d-flex align-items-center justify-content-center">
                                <!-- <a href="{{ route('productdetail', encrypt($item->id)) }}">
                                            <img class="img-fluid prouduct_card-image" width="154" height="160"
                                                src="{{ asset('upload/product/' . $item->product_image) }}" alt>
                                        </a> -->
                                <a href="{{ route('productdetail', encrypt($item->id)) }}">
                                    <img class="img-fluid prouduct_card-image" width="154" height="160"
                                        src="{{ file_exists(public_path('upload/product/' . $item->product_image)) ? asset('upload/product/' . $item->product_image) : asset('frontend/img/no-product-image.jpg') }}"
                                        alt>
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex justify-content-between  align-items-center card-title_wrapper">
                                    <div class="card-title">{{ $item->product_unique_id }}</div>
                                    @if ($item->weight)
                                    <div class="card-text">{{ $item->weight }}g</div>
                                    @endif
                                    <button
                                        class="ml-2 custom-icon-btn wishlist-svg @if ($item->is_favourite == 1) active @endif"
                                        onclick="addtowishlist({{ $item->id }})">
                                        <svg width="26" height="23" viewBox="0 0 26 23" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                stroke="#F78D1E" stroke-width="1.5" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                @php
                                $weight = $item->weight;
                                $mcCharge = App\Models\Weight::where('is_active', 1)
                                ->where('weight_range_from', '<=', $weight) ->where('weight_range_to', '>=', $weight)
                                    ->value('mc_charge');

                                    $weightString = (string) $mcCharge;
                                    $variable1 = (int) $weightString[0];
                                    $variable2 = (int) $weightString[1];

                                    $mc1 = App\Models\MakingCharge::where('mc_charge', $variable1)->value(
                                    'mc_code',
                                    );
                                    $mc2 = App\Models\MakingCharge::where('mc_charge', $variable2)->value(
                                    'mc_code',
                                    );
                                    @endphp

                                    <div class="d-flex mt-2 flex-wrap gap-2 align-items-center justify-content-between">
                                        @if (
                                        $item->project_id == App\Enums\Projects::ELECTROFORMING ||
                                        $stock == 1 ||
                                        ($item->project_id == App\Enums\Projects::SOLIDIDOL &&
                                        Str::startsWith($item->product_unique_id, 'CSSIDOL')))
                                        @php
                                        $mc =
                                        $item->project_id == App\Enums\Projects::ELECTROFORMING ||
                                        $stock == 1
                                        ? $mc1 . $mc2
                                        : 'C*';
                                        @endphp
                                        <div class="mt-2 text-success">Tag Code : <span
                                                class="fw-semibold">{{ $mc }}</span></div>
                                        @elseif ($item->project_id == App\Enums\Projects::SOLIDIDOL &&
                                        Str::startsWith($item->product_unique_id, 'CSSIDOL'))
                                        @php
                                        $mc = 'C*';
                                        @endphp
                                        <div class="mt-2 text-success">Tag Code : <span
                                                class="fw-semibold">{{ $mc }}</span></div>
                                        @else
                                        @php
                                        $mc = $item->weight < 20 ? 'G' : 'F' ; @endphp @if ($item->project_id ==
                                            App\Enums\Projects::SOLIDIDOL)
                                            <div class="mt-2 text-success">Tag Code : <span
                                                    class="fw-semibold">{{ $mc }}</span></div>
                                            @endif
                                            @endif

                                            @if ($stock == 1)
                                            @php
                                            $boxName = App\Models\Style::where('id', $item->style_id)
                                            ->where('is_active', 1)
                                            ->value('style_name');
                                            @endphp
                                            <div>
                                                <div class="card-text shop-page-card__select-option">
                                                    {{ $boxName }}</div>
                                            </div>
                                            @endif
                                    </div>
                                    <input type="hidden" name="moq{{ $item->id }}" id="moq{{ $item->id }}"
                                        value="{{ $item->moq }}">
                                    <div>
                                        {{-- @php
                                                $electroFormingProject = App\Models\Project::where(
                                                    'project_name',
                                                    'ELECTRO FORMING',
                                                )->first();
                                            @endphp --}}

                                        @if ($projectId == App\Enums\Projects::SOLIDIDOL && $projectId ==
                                        App\Enums\Projects::ELECTROFORMING)
                                        <div class="card-text mt-2">MOQ: {{ $item->moq }} pcs</div>
                                        @elseif ($stock == 1 && $item->qty != 0)
                                        <div class="product-cart-qty-text mt-2">In Stock: <span>{{ $item->qty }}
                                                pcs</span>
                                        </div>
                                        @endif

                                        <input type="hidden" name="stockqty" id="stockqty" value="{{ $stock }}">

                                        <input type="hidden" name="qty{{ $item->id }}" id="qty{{ $item->id }}"
                                            value="{{ $item->qty }}">


                                        <div class="mt-3">
                                            <div class="d-flex">
                                                <label class="me-2">Qty</label>
                                                <div class="input-group quantity-input-group quantity-container"
                                                    data-product-id={{ $item->id }}>
                                                    <input type="button" value="-" class="qtyminus" field="quantity">
                                                    <input type="text" name="quantity" id="quantity{{ $item->id }}"
                                                        value="{{ $item->moq }}" class="qty">
                                                    <input type="hidden" name="box{{ $item->id }}"
                                                        id="box{{ $item->id }}" value="{{ $item->style_id }}">
                                                    <input type="button" value="+" class="qtyplus" field="quantity">
                                                </div>
                                            </div>
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
                        @endforeach
                        @endif
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

                                @for ($page = max(1, $product->currentPage() - 2); $page <= min($product->lastPage(),
                                    $product->currentPage() + 2); $page++)
                                    @if ($page == $product->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                    @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $product->url($page) }}">{{ $page }}</a>
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
<script src="{{ asset('frontend/js/shop/shop.js') }}"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var stickyElement = document.querySelector('.sticky-add-to-cart');
    var stickyElementOffset = stickyElement.offsetTop;

    function handleScroll() {
        if (window.pageYOffset > stickyElementOffset) {
            stickyElement.classList.add('sticky');
        } else {
            stickyElement.classList.remove('sticky');
        }
    }
    window.addEventListener('scroll', handleScroll);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => {
        const button = tooltipTriggerEl.querySelector('#addalltocart');
        if (!button || button.disabled === true) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var showMoreButton = document.getElementById('showMore');
    showMoreButton.classList.add('showMore');
    var additionalOptions = document.querySelectorAll('.additional-option');
    if (showMoreButton) {
        showMoreButton.addEventListener('click', function() {
            // Toggle the display of additional options
            additionalOptions.forEach(function(option) {
                option.style.display = option.style.display === 'none' ? 'flex' : 'none';
            });
            // Toggle the text of the button
            showMoreButton.textContent = showMoreButton.textContent === 'Show Less' ? 'Show More' :
                'Show Less';
        });
    }
});
</script>
<script>
var shopMainSlider = new Swiper(".shop-page-main-slider", {
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let jsonData = JSON.parse($("#subCollectionData").val());
    let collectionId = $("#collectionId").val();
    let mobileCollectionFiltersContainer = document.getElementById("mobile-subcollection-filters" +
        collectionId);
    let filterItems = []; // Array to store filter items

    // Create a new container dynamically
    let newContainer = document.createElement('div');
    newContainer.id = "filter-elements" + collectionId;
    mobileCollectionFiltersContainer.appendChild(newContainer);

    // Function to add input elements inside the container
    function addInputElements(data) {
        data.forEach(each => {
            let filterItem = document.createElement('div');

            filterItem.innerHTML = `<div class="form-check d-flex justify-content-between gap-2">
                                <div>
                                    <input type="checkbox" class="form-check-input subcollection_filter" id="strtolowzermobile-${each.sub_collection_name.toLowerCase()}"
                                    value="${each.sub_collection_name}" onclick="getsubcollectionproduct(${each.id})"><label for="mobile-${each.sub_collection_name}" class="form-check-label">${each.sub_collection_name}</label>
                                </div>
                            </div>`;
            newContainer.appendChild(filterItem);
            filterItems.push(filterItem); // Push filter items to the array
        });
    }

    // Add input elements inside the container
    addInputElements(jsonData);

    // Add event listener to the search input
    let searchInput = mobileCollectionFiltersContainer.querySelector('input');

    searchInput.addEventListener('input', () => {
        let searchText = searchInput.value
            .toLowerCase(); // Convert search input to lowercase for case-insensitive search
        // Clear the container
        newContainer.innerHTML = "";
        // Filter items and append filtered ones
        filterItems.forEach(item => {
            let label = item.querySelector('.form-check-label');
            if (label.textContent.toLowerCase().includes(searchText)) {
                newContainer.appendChild(item); // Append the item if it matches the search
            }
        });
    });

});
</script>


<script>
// Function to clear all checked checkboxes
function clearCheckboxes() {
    var selectedsubcollectionString = $("#subcol").val();
    var selectedsubcollection = selectedsubcollectionString.split(",");

    // Clear all checkboxes
    $(".subcollection_filter").prop("checked", false);

    // Remove selected filters
    const selectedFiltersWrapper = document.getElementById("selected-filters-wrapper");
    selectedsubcollection.forEach(id => {
        // If unchecked, remove the corresponding selected filter
        const selectedFilter = document.getElementById(
            `selected-filter-${id.toLowerCase()}-subcollection-sidebar`);
        if (selectedFilter) {
            selectedFiltersWrapper.removeChild(selectedFilter); // Remove the selected filter from the list
        }

        const selectedPopupFilter = document.getElementById(
            `selected-filter-${id.toLowerCase()}-subcollection-popup`);
        if (selectedPopupFilter) {
            selectedFiltersWrapper.removeChild(
                selectedPopupFilter); // Remove the selected filter from the list
        }
    });
    if (selectedsubcollectionString != '') {
        getsubcollectionproduct();
    }
}
</script>




<script>
$(document).ready(function() {
    // Retrieve the JSON string from the input field
    var jsonString = $("#weights").val();

    // Parse the JSON string into a JavaScript object
    let weights = JSON.parse(jsonString);

    function appendMobileWeightFilters(weights) {
        var container = document.getElementById('mobile-weight-filters');
        container.innerHTML = ''; // Clear existing filters if any

        weights.forEach(function(weight, key) {
            var label = '';

            if (weight.weight_range_from === 50 && weight.weight_range_to === 10000) {
                label = 'Above 50grams';
            } else if (Number.isInteger(weight.weight_range_from)) {
                label = weight.weight_range_from + ' - ' + weight.weight_range_to + 'gms';
            } else {
                label = weight.weight_range_from + ' - ' + weight.weight_range_to + 'gms';
            }

            var filterHtml = `
                    <div class="form-check">
                        <input class="form-check-input weight_filter" type="checkbox"
                            id="weightfrommob${weight.id}" name="weightfrom"
                            data-id="${weight.id}" value="${weight.weight_range_from}"
                            onclick="getWeightRange(${weight.id})">
                        <input class="weight_filter" type="hidden" name="weightto"
                            id="weighttomob${weight.id}" value="${weight.weight_range_to}">
                        <label class="form-check-label" for="weightfrommob${weight.id}">
                            ${label}
                        </label>
                    </div>
                `;
            container.insertAdjacentHTML('beforeend', filterHtml);
        });
    }

    // Call the function to append the filters
    appendMobileWeightFilters(weights);
});
</script>



@endsection
@endsection