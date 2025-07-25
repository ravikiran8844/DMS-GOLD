@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
    Wishlist - Emerald OMS
@endsection
<section class="container dms-cart-page">
    <div class="nav-bold-heading my-4">Wishlist</div>

    <div class="row" id="wishlist">
        <div class="col-12 position-relative mb-4">
            <div class="d-none d-md-block card cart-items_card desktop-cart">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>SKU</th>
                                <th>Name</th>
                                <th>Stock</th>
                                <th></th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>

                        <tbody id="wishlist-items">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-block d-md-none mobile-cart mb-5">
                <div class="cart-container">
                    <div id="mobile-wishlist-items">
                        <!-- Items will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5 pagination-links">
            <nav class="large-devices_pagination d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div>
                        Showing {{ $wishlist->firstItem() }} - {{ $wishlist->lastItem() }} of
                        {{ $wishlist->total() }} results
                    </div>
                    <ul class="pagination">
                        @if ($wishlist->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $wishlist->previousPageUrl() }}"
                                    tabindex="-1">Previous</a>
                            </li>
                        @endif

                        @for ($page = max(1, $wishlist->currentPage() - 2); $page <= min($wishlist->lastPage(), $wishlist->currentPage() + 2); $page++)
                            @if ($page == $wishlist->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $wishlist->url($page) }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endfor

                        @if ($wishlist->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $wishlist->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            <nav class="small-devices_pagination d-block d-lg-none">
                <div class="text-center">
                    <a class="btn btn-dark px-4 py-2" href="{{ $wishlist->nextPageUrl() }}">See More
                        Products</a>
                </div>
            </nav>
        </div>
    </div>
</section>
@section('scripts')
    <script src="{{ asset('frontend/js/wishlist/wishlist.js') }}"></script>
@endsection
@endsection
