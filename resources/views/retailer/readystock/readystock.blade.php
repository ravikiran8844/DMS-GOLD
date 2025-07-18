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
    $weights = App\Models\Weight::where('is_active', 1)->whereNull('deleted_at')->get();
    $colors = App\Models\Color::where('is_active', 1)->whereNull('deleted_at')->get();
    $platings = App\Models\Plating::where('is_active', 1)->whereNull('deleted_at')->get();
    $banners = App\Models\Banner::where('banner_position_id', 3)->get();
    $currentProjectId = $project_id;
    $classifications = App\Models\Classification::where('is_active', 1)->get();
    $projectId = App\Models\Project::where('is_active', 1)->where('id', $currentProjectId)->value('id');
    $collections = App\Models\Collection::where('is_active', 1)
        ->where('collection_name', 'GOD')
        ->whereNull('deleted_at')
        ->get();
    $others = App\Models\Collection::where('is_active', 1)
        ->where('collection_name', '!=', 'GOD')
        ->where('project_id', App\Enums\Projects::EF)
        ->whereNull('deleted_at')
        ->get();
    $jewelcategories = App\Models\Category::where('is_active', 1)
        ->where('project_id', App\Enums\Projects::CASTING)
        ->whereNull('deleted_at')
        ->get();
    // List of URLs to exclude
    $excludedUrls = [
        url('retailer/electroforming/ganesha'),
        url('retailer/electroforming/hanuman'),
        url('retailer/electroforming/krishna'),
        url('retailer/electroforming/lakshmi'),
        url('retailer/electroforming/buddha'),
        url('retailer/solid-idol/ganesha'),
        url('retailer/solid-idol/hanuman'),
        url('retailer/solid-idol/krishna'),
        url('retailer/solid-idol/lakshmi'),
        url('retailer/solid-idol/vishnu'),
    ];
    $validProjects = [
        App\Enums\Projects::CASTING,
        App\Enums\Projects::EF,
        App\Enums\Projects::IMPREZ,
        App\Enums\Projects::INDIANIA,
        App\Enums\Projects::LASERCUT,
    ];
    $weights = App\Models\Weight::where('is_active', 1)->whereNull('deleted_at')->get();
    $colors = App\Models\Color::where('is_active', 1)->whereNull('deleted_at')->get();
    $platings = App\Models\Plating::where('is_active', 1)->whereNull('deleted_at')->get();
    $banners = App\Models\Banner::where('banner_position_id', 3)->get();
    $currentProjectId = $project_id;
    $classifications = App\Models\Classification::where('is_active', 1)->get();
    $projectId = App\Models\Project::where('is_active', 1)->where('id', $currentProjectId)->value('id');
    $collections = App\Models\Collection::where('is_active', 1)
        ->where('collection_name', 'GOD')
        ->whereNull('deleted_at')
        ->get();
    $others = App\Models\Collection::where('is_active', 1)
        ->where('collection_name', '!=', 'GOD')
        ->where('project_id', App\Enums\Projects::EF)
        ->whereNull('deleted_at')
        ->get();
    $jewelcategories = App\Models\Category::where('is_active', 1)
        ->where('project_id', App\Enums\Projects::CASTING)
        ->whereNull('deleted_at')
        ->get();
    // List of URLs to exclude
    $excludedUrls = [
        url('retailer/electroforming/ganesha'),
        url('retailer/electroforming/hanuman'),
        url('retailer/electroforming/krishna'),
        url('retailer/electroforming/lakshmi'),
        url('retailer/electroforming/buddha'),
        url('retailer/solid-idol/ganesha'),
        url('retailer/solid-idol/hanuman'),
        url('retailer/solid-idol/krishna'),
        url('retailer/solid-idol/lakshmi'),
        url('retailer/solid-idol/vishnu'),
    ];
    $validProjects = [App\Enums\Projects::CASTING, App\Enums\Projects::EF, App\Enums\Projects::INDIANIA];

    // if (in_array($currentProjectId, $validProjects)) {
    // $boxes = App\Models\Style::where('is_active', 1)
    // ->where('project_id', $currentProjectId)
    // ->whereNull('deleted_at')
    // ->whereHas('products', function ($query) {
    // $query->where('qty', '>', 0);
    // })
    // ->get();
    // }

    // $purities = App\Models\SilverPurity::with([
    // 'products' => function ($query) use ($currentProjectId) {
    // $query->where('qty', '>', 0)->where('project_id', $currentProjectId);
    // },
    // ])
    // ->whereHas('products', function ($query) use ($currentProjectId) {
    // $query->where('qty', '>', 0)->where('project_id', $currentProjectId);
    // })
    // ->get();

@endphp
<input type="hidden" name="decryptedProjectId" id="decryptedProjectId" value="{{ $decryptedProjectId ?? '' }}">
{{-- <input type="hidden" name="projectSolid" id="projectSolid" value="{{ App\Enums\Projects::CASTING }}"> --}}
<input type="hidden" name="projectEf" id="projectEf" value="{{ App\Enums\Projects::EF }}">
<!-- Main Content -->


<div class="single-banner-container">
    @if ($currentUrl == url('/retailer/sireadystock') && isset($banners[0]))
        <img class="img-fluid w-100" src="{{ asset($banners[1]->banner_image) }}" alt="banner">
    @elseif($currentUrl == url('/retailer/efreadystock') && isset($banners[1]))
        <img class="img-fluid w-100" src="{{ asset($banners[0]->banner_image) }}" alt="banner">
    @endif
</div>

<div class="container-fluid">
    {{-- Navbar --}}
    {{-- <div class="row mb-4 mb-lg-0 d-none d-lg-block">
        <div class="col-12 p-0">
            <div class="swiper shop-page-main-slider" style="--swiper-theme-color:#fff;--swiper-navigation-size:16px;">
                <div class="swiper-wrapper">
                    @foreach ($banners as $banner)
                        <div class="swiper-slide">
                            <img class="img-fluid w-100" src="{{ asset($banner->banner_image) }}" alt="banner">
</div>
@endforeach
</div>

</div>

</div>
</div> --}}

    <div class="my-2 text-center d-block d-lg-none">


        {{-- <div class="mobile-filters-offcanvas" id="mobile-sticky-filter">
            <div>
                <button class="btn mobile-filters-trigger-btn" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMobileFilters" aria-controls="offcanvasMobileFilters">
                    Filter By
                </button>
            </div>
        </div> --}}

        {{-- <div class="offcanvas offcanvas-start mobile-filters-offcanvas" tabindex="-1" id="offcanvasMobileFilters"
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
                                @if ($currentProjectId == App\Enums\Project::CASTING)
                                    <button class="nav-link @if ($currentProjectId == App\Enums\Project::CASTING) active @endif"
                                        id="mobClassificationFilter" data-bs-toggle="pill"
                                        data-bs-target="#mobileClassificationFilter" type="button" role="tab"
                                        aria-controls="mobilClassificationFilter"
                                        aria-selected="true">Classification</button>
                                @endif
                                <button class="nav-link @if ($currentProjectId == App\Enums\Project::EF || $currentProjectId == App\Enums\Projects::CASTING) active @endif"
                                    id="mobWeightFilter" data-bs-toggle="pill" data-bs-target="#mobileWeightFilter"
                                    type="button" role="tab" aria-controls="mobileWeightFilter"
                                    aria-selected="true">Weight
                                    Range</button>
                                @if ($currentProjectId != App\Enums\Projects::CASTING && $currentProjectId != App\Enums\Projects::INDIANIA)
                                    <button class="nav-link" id="mobBoxFilter" data-bs-toggle="pill"
                                        data-bs-target="#mobileBoxFilter" type="button" role="tab"
                                        aria-controls="mobileBoxFilter" aria-selected="true">Box/Style</button>
                                @endif
                                <button class="nav-link" id="mobPurityFilter" data-bs-toggle="pill"
                                    data-bs-target="#mobilePurityFilter" type="button" role="tab"
                                    aria-controls="mobilePurityFilter" aria-selected="true">Purity</button>
                                @if (($currentProjectId == App\Enums\Project::EF || $currentProjectId == App\Enums\Project::CASTING) && !in_array(url()->current(), $excludedUrls))
                                    @foreach ($collections as $collection)
                                        @php
                                            $validProjects = [
                                                App\Enums\Project::CASTING,
                                                App\Enums\Project::EF,
                                            ];

                                            if (in_array($currentProjectId, $validProjects)) {
                                                $subcollections = App\Models\SubCollection::where(
                                                    'sub_collections.is_active',
                                                    1,
                                                )
                                                    ->where('sub_collections.collection_id', $collection->id)
                                                    ->whereHas('products', function ($query) {
                                                        $query
                                                            ->where('products.qty', '>', 0)
                                                            ->whereNull('products.deleted_at');
                                                    });
                                            }

                                            if ($currentProjectId == App\Enums\Project::EF) {
                                                $subcollections->where(
                                                    'sub_collections.project_id',
                                                    App\Enums\Project::EF,
                                                );
                                            }

                                            if ($currentProjectId == App\Enums\Project::CASTING) {
                                                $subcollections->where('project_id', App\Enums\Project::CASTING);
                                            }

                                            $subcollections = $subcollections
                                                ->whereNull('sub_collections.deleted_at')
                                                ->get();

                                            $subcollectionsjson = $subcollections->toJson();
                                        @endphp
                                        <input type="hidden" name="subCollectionData" id="subCollectionData"
                                            value="{{ $subcollectionsjson }}">
    <button class="nav-link" id="subcollectionFilter{{ $collection->id }}"
        data-bs-toggle="pill"
        data-bs-target="#subcollectionFilterContent{{ $collection->id }}"
        type="button" role="tab"
        aria-controls="subcollectionFilterContent{{ $collection->id }}"
        aria-selected="true">{{ $collection->collection_name }}</button>
    @endforeach
    @endif
    @if (in_array(url()->current(), $excludedUrls))
    <div class="mt-3" style="font-size: 13px;">
        Showing results for - <b>{{ $search }}</b>
    </div>
    <div class="mt-3">
        @if ($currentProjectId == App\Enums\Project::EF)
        <a href="{{ route('retailerefreadystock') }}"
            class="btn btn-warning view-all-filter">VIEW ALL
            GODS</a>
        @else
        <a href="{{ route('retailersireadystock') }}"
            class="btn btn-warning view-all-filter">VIEW ALL
            GODS</a>
        @endif
        <style>
            @media (min-width: 992px) {
                .view-all-filter {
                    width: 100%;
                }
            }
        </style>
    </div>
    @endif
    @if ($currentProjectId == App\Enums\Project::EF && !in_array(url()->current(), $excludedUrls))
    <button class="nav-link" id="mobOtherFilterTab" data-bs-toggle="pill"
        data-bs-target="#mobileOtherFilter" type="button" role="tab"
        aria-controls="mobileOtherFilter" aria-selected="false">Others</button>
    @endif
    @if ($currentProjectId == App\Enums\Projects::CASTING)
    <button class="nav-link" id="mobCategoryFilterTab" data-bs-toggle="pill"
        data-bs-target="#mobileCategoryFilter" type="button" role="tab"
        aria-controls="mobileCategoryFilter" aria-selected="false">Category</button>
    @endif
</div>
</div>
<div class="mobile-filters-offcanvas__body-item-filter-inputs">
    <div class="tab-content" id="mob-filters-tabContent">
        <div class="tab-pane fade @if ($currentProjectId == App\Enums\Project::EF || $currentProjectId == App\Enums\Projects::CASTING) show active @endif"
            id="mobileWeightFilter" role="tabpanel" aria-labelledby="mobWeightFilter"
            tabindex="0">
            <div class="filter-inputs_wrapper" id="mobile-weight-filters">
            </div>
        </div>

        <div class="tab-pane fade" id="mobileBoxFilter" role="tabpanel"
            aria-labelledby="mobBoxFilter" tabindex="0">
            <div class="filter-inputs_wrapper" id="mobile-box-filters">
                @foreach ($boxes as $box)
                <div class="form-check d-flex justify-content-between gap-2">
                    <div>
                        <input class="box form-check-input" type="checkbox"
                            id="box{{ $box->id }}" name="box"
                            data-id={{ $box->id }} value="{{ $box->style_name }}"
                            onclick="getBoxProduct({{ $box->id }})">
                        <label class="form-check-label" for="box{{ $box->id }}">
                            {{ $box->style_name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="mobilePurityFilter" role="tabpanel"
            aria-labelledby="mobPurityFilter" tabindex="0">
            <div class="filter-inputs_wrapper" id="mobile-purity-filters">
                @foreach ($purities as $purity)
                <div class="form-check d-flex justify-content-between gap-2">
                    <div>
                        <input class="purity form-check-input" type="checkbox"
                            id="purity{{ $purity->id }}" name="purity"
                            data-id={{ $purity->id }}
                            value="{{ str_replace('SIL-', '', $purity->silver_purity_percentage) }}"
                            onclick="getPurityProduct({{ $purity->id }})">
                        <label class="form-check-label" for="purity{{ $purity->id }}">
                            {{ str_replace('SIL-', '', $purity->silver_purity_percentage) }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="mobileOtherFilter" role="tabpanel"
            aria-labelledby="mobileOtherFilter" tabindex="0">
            <div class="filter-inputs_wrapper">
                @if ($currentProjectId == App\Enums\Project::EF)
                @foreach ($others as $other)
                <div class="form-check d-flex justify-content-between gap-2">
                    <div>
                        <input class="others form-check-input" type="checkbox"
                            id="other{{ $other->id }}" name="other"
                            data-id={{ $other->id }}
                            value="{{ $other->collection_name }}"
                            onclick="getCollectionWiseProducts({{ $other->id }})">
                        <label class="form-check-label"
                            for="other{{ $other->id }}">
                            {{ $other->collection_name }}
                        </label>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="tab-pane fade" id="mobileCategoryFilter" role="tabpanel"
            aria-labelledby="mobileCategoryFilter" tabindex="0">
            <div class="filter-inputs_wrapper">

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
                        <input placeholder="search" class="form-control"
                            type="search" name="" id="">
                    </div>
                    <div>
                        <button type="button" onclick="clearCheckboxes()"
                            class="clear-all-btn sidebar-clear-btn  mb-3">CLEAR
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
        <div class="tab-pane fade @if ($currentProjectId == App\Enums\Project::CASTING) show active @endif"
            id="mobileClassificationFilter" role="tabpanel"
            aria-labelledby="mobileClassificationFilter" tabindex="0">
            <div class="filter-inputs_wrapper">
                @if ($currentProjectId == App\Enums\Project::CASTING)
                @foreach ($classifications as $classification)
                <div class="form-check d-flex justify-content-between gap-2">
                    <div>
                        <input class="form-check-input classification" type="checkbox"
                            id="mob-classification_name{{ $classification->id }}"
                            name="classification-mobile"
                            value="{{ $classification->classification_name }}"
                            onclick="getclassificationproduct({{ $classification->id }})">
                        <label class="form-check-label"
                            for="mob-classification_name{{ $classification->id }}">
                            {{ $classification->classification_name }}
                        </label>
                    </div>
                </div>
                @endforeach
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
</div> --}}
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
                                <div class="card-checkbox_wrapper">
                                    <input class="card-checkbox" type="checkbox" name="product{{ $main->id }}"
                                        id="product{{ $main->id }}" data-id="{{ $main->id }}">
                                </div>

                                <div
                                    class="card-img-top d-flex align-items-center justify-content-center position-relative">
                                    <a href="{{ route('retailerproductdetail', encrypt($main->id)) }}">
                                        <img class="img-fluid prouduct_card-image load-secure-image" width="255"
                                            height="255" src="http://imageurl.ejindia.com/api/image/secure"
                                            data-secure="{{ $main->secureFilename }}" alt>
                                    </a>
                                    <div class="position-absolute card-purity purity-list">
                                        Purity: {{ $main->Purity ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <div
                                            class="d-flex justify-content-between align-items-center card-title_wrapper">
                                            <div class="card-title">
                                                <a class="text-decoration-none"
                                                    href="#">{{ $main->DesignNo }}</a>
                                            </div>
                                            <button class="ml-2 custom-icon-btn wishlist-svg">
                                                <svg width="26" height="23" viewBox="0 0 26 23"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                        stroke="inherit" stroke-width="1.5" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="mt-3 grid cols-3 card-content_wrapper">
                                            @if ($main->color)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Colour</div>
                                                    <div class="product-card-badge product-card-badge-light">
                                                        {{ $main->color ?? '-' }}</div>
                                                </div>
                                            @endif
                                            @if ($main->unit)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Unit</div>
                                                    <div class="product-card-badge product-card-badge-light">
                                                        {{ $main->unit ?? '-' }}</div>
                                                </div>
                                            @endif
                                            @if ($main->style)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">Style</div>
                                                    <div class="product-card-badge product-card-badge-light">
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
                                            @if ($main->size)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">
                                                        Size
                                                    </div>
                                                    <div class="product-card-badge">{{ $main->size ?? '-' }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($main->weight)
                                                <div class="d-flex flex-column gap-1">
                                                    <div class="card-text text-dark">
                                                        Weight
                                                    </div>
                                                    <div class="product-card-badge">
                                                        {{ $main->weight ?? '-' }}g</div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card-multiple-sizes-wrapper">

                                            <div class="d-flex mt-3">
                                                <div class="product-cart-qty-text">In Stock:
                                                    <span> {{ $main->qty ?? '-' }} Pcs</span>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                                    <div class="d-flex align-items-center">
                                                        <label class="me-2">Qty</label>
                                                        <div
                                                            class="input-group quantity-input-group quantity-container">
                                                            <input type="button" value="-" class="qtyminus"
                                                                field="quantity">
                                                            <input type="text" name="quantity"
                                                                id="quantity{{ $main->id }}" value="1"
                                                                class="qty">
                                                            <input type="button" value="+" class="qtyplus"
                                                                field="quantity">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if (Auth::user()->role_id == App\Enums\Roles::Dealer ||
                                            Auth::user()->role_id == App\Enums\Roles::Retailer ||
                                            Auth::user()->role_id == App\Enums\Roles::CRM)
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
                                    @endif
                                </div>


                            </div>
                        @endforeach
                    </div>

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
                    {{-- @if ($product->isEmpty())
                            <div class="text-center" id="empty-cart-image">
                                <img src="{{ asset('emptycart.gif') }}" alt="alternative_text" class="nodata">
                            </div>
                        @else
                            @foreach ($product as $item)
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

                                <div class="card shop-page_product-card">
                                    <div class="card-checkbox_wrapper">
                                        <input class="card-checkbox" type="checkbox"
                                            name="product{{ $item->id }}" id="product{{ $item->id }}"
                                            data-id="{{ $item->id }}">
                                    </div>
                                    <div
                                        class="card-img-top d-flex align-items-center justify-content-center position-relative">

                                        <a href="{{ route('retailerproductdetail', encrypt($item->id)) }}">
                                            <img class="img-fluid prouduct_card-image load-secure-image"
                                                width="255" height="255"
                                                src="http://imageurl.ejindia.com/api/image/secure"
                                                data-secure="{{ $item->secureFilename }}" alt>
                                        </a>

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



                                        @php
                                            $purity = App\Models\SilverPurity::where('id', $item->purity_id)->value(
                                                'silver_purity_percentage',
                                            );
                                            $size = App\Models\Size::where('id', $item->size_id)->value('size');
                                        @endphp
                                        <div class="position-absolute card-purity purity-list">
                                            Purity: {{ str_replace('SIL-', '', $purity) }}
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div
                                            class="d-flex justify-content-between  align-items-center card-title_wrapper">
                                            <div class="card-title"><a class="text-decoration-none"
                                                    href="{{ route('retailerproductdetail', encrypt($item->id)) }}">{{ $item->product_unique_id }}</a>
                                            </div>

                                            <button
                                                class="ml-2 custom-icon-btn wishlist-svg @if ($item->is_favourite == 1) active @endif"
                                                onclick="addtowishlist({{ $item->id }})">
                                                <svg width="26" height="23" viewBox="0 0 26 23"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M21.5109 13.0016L12.7523 21.8976L4.0016 13.0016C-3.73173 5.15359 5.0336 -3.73174 12.7603 4.11626C20.6003 -3.84641 29.3589 5.03893 21.5189 13.0123L21.5109 13.0016Z"
                                                        stroke="inherit" stroke-width="1.5"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>


                                        @php
                                            $weight = $item->weight;
                                        @endphp

                                        @if ($stock == 1)
                                            @php
                                                $boxName = App\Models\Style::where('id', $item->style_id)
                                                    ->where('is_active', 1)
                                                    ->value('style_name');
                                            @endphp
                                            <div
                                                class="d-flex my-2 flex-wrap gap-3 align-items-start card-content_wrapper">


                                                @if ($item->weight)
                                                    <div class="d-flex flex-column gap-1">
                                                        <div class="card-text text-dark">Weight</div>
                                                        <div class="product-card-badge">{{ $item->weight }}g</div>
                                                    </div>
                                                @endif
                                                @if ($boxName != '-')
                                                    <div class="d-flex flex-column gap-1">
                                                        <div class="card-text text-dark">
                                                            @if ($currentProjectId == App\Enums\Projects::CASTING)
                                                                Style
                                                            @else
                                                                Box
                                                            @endif
                                                        </div>
                                                        <div class="product-card-badge">{{ $boxName }}</div>
                                                    </div>
                                                @endif
                                                @if ($size)
                                                    <div class="d-flex flex-column gap-1">
                                                        <div class="card-text text-dark">Size</div>
                                                        <div class="product-card-badge">{{ $size }}</div>
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-wrap gap-2 align-self-end">
                                                    @if ($projectId == App\Enums\Projects::CASTING && $projectId == App\Enums\Projects::EF)
                                                        <div class="card-text">MOQ: {{ $item->moq }} pcs</div>
                                                    @elseif ($stock == 1 && $item->qty != 0)
                                                        <div class="product-cart-qty-text">Stock:
                                                            <span>{{ $item->qty }}
                                                                Pcs</span>
                                                        </div>
                                                    @endif
                                                    <div class="d-flex gap-2 align-items-center purity-inside-card">
                                                        <div class="card-text text-dark">
                                                            Purity
                                                        </div>
                                                        <div class="product-card-badge">
                                                            {{ str_replace('SIL-', '', $purity) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @php
                                            $currentcartcount = App\Models\Cart::where('product_id', $item->id)
                                                ->where('user_id', Auth::user()->id)
                                                ->value('qty');
                                        @endphp

                                        <input type="hidden" name="moq{{ $item->id }}"
                                            id="moq{{ $item->id }}" value="{{ $item->moq }}">
                                        <div>



                                            <input type="hidden" name="stockqty" id="stockqty"
                                                value="{{ $stock }}">

                                            <input type="hidden" name="qty{{ $item->id }}"
                                                id="qty{{ $item->id }}" value="{{ $item->qty }}">


                                            <div class="mt-3 shop-page-qty-add-to-cart-btn_wrapper">
                                                <div class="d-flex align-items-center">
                                                    <label class="me-2">Qty</label>
                                                    <div class="input-group quantity-input-group quantity-container"
                                                        data-product-id={{ $item->id }}>
                                                        <input type="button" value="-" class="qtyminus"
                                                            field="quantity">
                                                        <input type="text" name="quantity"
                                                            id="quantity{{ $item->id }}"
                                                            value="{{ $currentcartcount ?? $item->moq }}"
                                                            class="qty">
                                                        <input type="hidden" name="box{{ $item->id }}"
                                                            id="box{{ $item->id }}"
                                                            value="{{ $item->style_id }}">
                                                        <input type="button" value="+" class="qtyplus"
                                                            field="quantity">
                                                    </div>
                                                </div>
                                                @if (Auth::user()->role_id == App\Enums\Roles::Dealer || Auth::user()->role_id == App\Enums\Roles::Retailer || Auth::user()->role_id == App\Enums\Roles::CRM)
                                                    @php
                                                        $isCart = App\Models\Cart::where('user_id', Auth::user()->id)
                                                            ->where('product_id', $item->id)
                                                            ->where('finish_id', $item->finish_id)
                                                            ->where('plating_id', $item->plating_id)
                                                            ->where('weight', $item->weight)
                                                            ->where('color_id', $item->color_id)
                                                            ->get();

                                                    @endphp
                                                    <div class="shop-page-add-to-cart-btn">
                                                        @if (count($isCart))
                                                            <button onclick="addforcart({{ $item->id }})"
                                                                class="btn added-to-cart-btn mr-2 spinner-button"
                                                                data_id="card_id_{{ $item->id }}">
                                                                <span class="submit-text">Added to cart</span>
                                                                <span class="d-none spinner">
                                                                    <span class="spinner-grow spinner-grow-sm"
                                                                        aria-hidden="true"></span>
                                                                    <span role="status">Adding...</span>
                                                                </span>
                                                                <span id="applycurrentcartcount{{ $item->id }}"
                                                                    class="added-to-cart-badge ms-2">{{ $currentcartcount }}</span>
                                                            </button>
                                                        @else
                                                            <button onclick="addforcart({{ $item->id }})"
                                                                class="btn add-to-cart-btn mr-2 spinner-button"
                                                                data_id="card_id_{{ $item->id }}">
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
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach -->
                        @endif --}}
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




    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.4.9/jquery.sumoselect.min.js"
        integrity="sha512-+Ea4TZ8vBWO588N7H6YOySCtkjerpyiLnV7bgqwrQF+vqR8+q/InGK9WDZx5d6VtdGRoV6uLd5Dwz2vE7EL3oQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let stickyElement = document.querySelector(".sticky-add-to-cart");
            let stickyElementOffset = stickyElement.offsetTop;

            function handleScroll() {
                if (window.pageYOffset > stickyElementOffset) {
                    stickyElement.classList.add("sticky");
                } else {
                    stickyElement.classList.remove("sticky");
                }
            }

            window.addEventListener("scroll", handleScroll);
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

    <!-- <script>
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
    </script> -->

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
                                    <input type="checkbox" class="form-check-input subcollection_filter" id="mobile-${each.sub_collection_name.toLowerCase()}"
                                    value="${each.sub_collection_name}" onclick="getsubcollectionproduct(${each.id})"><label for="mobile-${each.sub_collection_name.toLowerCase()}" class="form-check-label">${each.sub_collection_name}</label>
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
        $(function() {
            $('#popular-searches').SumoSelect({
                okCancelInMulti: true,
                search: true,
                searchText: 'Search...',
                placeholder: 'Popular Searches'
            });

            $('.btnOk').text("Apply");
        })
    </script>

    <script>
        // mobile selected filters
        // document.addEventListener('DOMContentLoaded', function() {
        //     const mobileClassificationFilterContainer = document.getElementById('mobileClassificationFilter');
        //     const mobileGodfilterContainer = document.getElementById('mobile-subcollection-filters1');
        //     const selectedItemsWrapper = document.getElementById('selected-filters-wrapper');


        //     function updateGodFilters() {
        //         const GodfilterContainer = document.getElementById('sidebarMainFilter-subcollection');
        //         const Godcheckboxes = GodfilterContainer.querySelectorAll('input[type="checkbox"]');
        //         Godcheckboxes.forEach(function(checkbox) {
        //             checkbox.addEventListener('change', handleCheckboxChange);
        //         });

        //         const mobileGodcheckboxes = mobileGodfilterContainer.querySelectorAll('input[type="checkbox"]');
        //         mobileGodcheckboxes.forEach(function(checkbox) {
        //             checkbox.addEventListener('change', handleCheckboxChange);
        //         });

        //         const mobileGodcheckboxes = mobileGodfilterContainer.querySelectorAll('input[type="checkbox"]');
        //         mobileGodcheckboxes.forEach(function(checkbox) {
        //             checkbox.addEventListener('change', handleCheckboxChange);
        //         });



        //         const mobileClassificationCheckboxes = mobileClassificationFilterContainer.querySelectorAll(
        //             'input[type="checkbox"]');
        //         mobileClassificationCheckboxes.forEach(function(checkbox) {
        //             checkbox.addEventListener('change', handleCheckboxChange);
        //         });



        //     }




        //     updateGodFilters()

        // })
    </script>



    <script>
        $(document).ready(function() {
            // Parse the JSON string into a JavaScript object
            var weights = JSON.parse($("#weights").val());

            function appendMobileWeightFilters(weights) {
                var container = document.getElementById('mobile-weight-filters');
                container.innerHTML = ''; // Clear existing filters if any

                weights.forEach(function(weight, key) {

                    if (
                        weight.weight_range_from === 50 &&
                        weight.weight_range_to === 10000
                    ) {
                        label = "Above 50grams";
                    } else if (Number.isInteger(weight.weight_range_from)) {
                        label =
                            weight.weight_range_from +
                            " - " +
                            weight.weight_range_to +
                            "gms";
                    } else {
                        label =
                            weight.weight_range_from +
                            " - " +
                            weight.weight_range_to +
                            "gms";
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

            var categories = JSON.parse($("#categoryFilter").val());
            console.log("data", categories)

            function appendMobileCategoryFilters(categories) {
                var container = document.getElementById('mobileCategoryFilter');
                container.innerHTML = ''; // Clear existing filters if any

                categories.forEach(function(category) {
                    var filterHtml = `
            <div class="form-check d-flex justify-content-between gap-2">
                <div>
                    <input class="category form-check-input" type="checkbox"
                        id="category${category.id}-mob" name="category" data-id="${category.id}"
                        value="${category.category_name}" onclick="getcategoryproduct(${category.id})">
                    <label class="form-check-label" for="category${category.id}-mob">
                        ${category.category_name}
                    </label>
                </div>
            </div>
        `;
                    container.insertAdjacentHTML('beforeend', filterHtml);
                });
            }

            // Call the function to append the filters
            appendMobileCategoryFilters(categories);

        });
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
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".multiple-size-btn");

            buttons.forEach((btn) => {
                btn.addEventListener("click", function() {
                    const wrapper = btn.closest(".card-multiple-sizes-wrapper");
                    const content = wrapper.querySelector(".multiple-sizes-content");

                    // Toggle visibility
                    content.classList.toggle("d-none");

                    // Optionally rotate icon
                    const icon = btn.querySelector(".toggle-icon");
                    if (icon) {
                        icon.classList.toggle("rotate-180");
                    }
                });
            });
        });
    </script>
@endsection
@endsection
