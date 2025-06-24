@extends('frontend.layout.frontendmaster')
@section('content')
@section('title')
    Cart - Emerald OMS
@endsection
<section class="container dms-cart-page">
    <form action="{{ route('placeorder') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="weight" id="hdweight" value="{{ $cartWeight }}">
        @foreach ($cart as $item)
            <input type="hidden" name="moq{{ $item->id }}" id="moq{{ $item->product_id }}"
                value="{{ $item->moq }}">

            <input type="hidden" name="stock{{ $item->product_id }}" id="stock{{ $item->product_id }}"
                value="{{ $item->qty }}">
            <input type="hidden" name="readystock{{ $item->product_id }}" id="readystock{{ $item->product_id }}"
                value="{{ $item->is_ready_stock }}">
            <!-- Add the Bootstrap modal structure -->
            <div class="modal" tabindex="-1" role="dialog" id="remarksModal{{ $item->id }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Remarks</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row">
                                <label for="Finish" class="col-2 col-form-label fw-semibold">Finish</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" name="remark{{ $item->id }}"
                                        id="remark{{ $item->id }}"
                                        value="{{ $item->remarks != null ? $item->remarks : '' }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="Box" class="col-2 col-form-label fw-semibold">Box</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" name="box{{ $item->id }}"
                                        id="box{{ $item->id }}"
                                        value="{{ $item->box != null ? $item->box : '' }}">
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label for="Others" class="col-sm-2 col-form-label fw-semibold">Others</label>
                                </div>
                                <div>
                                    <textarea style="height: 150px;" id="others{{ $item->id }}" name="others{{ $item->id }}" maxlength="255"
                                        class="form-control">{{ $item->others != null ? $item->others : '' }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning"
                                    onclick="saveRemarks({{ $item->id }})" data-bs-dismiss="modal">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row" id="cart">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="nav-bold-heading my-4">Shopping Cart</div>
                @if ($cart->count() > 0)
                    <div id="removeall">
                        <button type="button" onclick="removeAllCart();" class="btn btn-warning">Remove All</button>
                    </div>
                @endif
            </div>

            {{-- @if ($cart->count() > 0)
                <div class="row" id="reference">
                    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                        <div class="input-group mb-4">
                            <span class="input-group-text fw-semibold">Reference</span>
                            <input type="text" class="form-control" name="reference" id="reference">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                        <a href="{{ route('shop') }}" class="btn btn-warning">Continue Shopping</a>
                    </div>
                </div>
            @endif --}}
        </div>

        @if ($cart->isEmpty())
            <div class="text-center" id="empty-cart-image">
                <img class="img-fluid" src="{{ asset('frontend/img/emptycart.gif') }}" alt="">
                {{-- <strong>Your Cart Is Empty!</strong> --}}
            </div>
        @else
            <div class="row" id="cart">
                <div class="col-12 col-xl-9 col-xxl-9  position-relative mb-4">
                    @if ($cart->count() > 0)
                        <div class="col-12 d-flex justify-content-between gap-2" id="reference">
                            <div>
                                <div class="input-group mb-4">
                                    <span class="input-group-text fw-semibold">Reference</span>
                                    <input type="text" class="form-control" name="reference" id="reference">
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('shop') }}" class="btn btn-dark">Continue Shopping</a>
                            </div>
                        </div>
                    @endif
                    <div class="d-none d-md-block card cart-items_card desktop-cart">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Project</th>
                                        <th class="text-center">Product SKU</th>
                                        {{-- <th>Size</th> --}}
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Weight Per Quantity</th>
                                        <th class="text-center">Total Weight</th>
                                        <th class="text-center">Remarks</th>
                                        <th class="text-center">Box</th>
                                        <th class="text-center">Finish</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-block d-md-none mobile-cart mb-5">
                        <div class="cart-container">
                            <div id="items-container">
                                <!-- Items will be displayed here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-3 col-xxl-3">
                    <div class="card cart-page_total-card">
                        <div class="card-body">
                            {{-- <div class="row mb-4">
                            <div class="col-6">
                                <div class="cart-page_card-light-text">Total Order</div>
                            </div>
                            <div class="col-6">
                                <div class="cart-page_card-bold-title">380.52 gms</div>
                            </div>
                        </div> --}}
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="cart-page_card-light-text">Total Qty</div>
                                </div>
                                <div class="col-6">
                                    <div class="cart-page_card-bold-title" id="qty">{{ $cartQty }} Qtys
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="cart-page_card-light-text">Total Weight</div>
                                </div>
                                <div class="col-6">
                                    <div class="cart-page_card-bold-title" id="totweight">{{ $cartWeight }} Gms
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong for="remarks">Finish</strong>
                                <input type="text" class="form-control mt-2 mb-3" name="remark" id="remark">
                                <strong for="remarks">Box</strong>
                                <input type="text" class="form-control mt-2 mb-3" name="box" id="box">
                                <strong for="remarks">Others</strong>
                                <textarea class="mt-3 mb-3 form-control" maxlength="255" name="others" id="others" cols="32"
                                    rows="4"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <div class="mb-3">
                                    <button id="placeOrderBtn"
                                        class="btn py-2 btn-warning w-100 custom-yellow-button">
                                        <span>Place Order</span>
                                        <span class="d-none spinner">
                                            <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                            <span role="status">Processing...</span>
                                        </span>
                                    </button>

                                </div>
                                {{-- <div>
                            <a href="#" class="cart-page_wishlist-link">Add to WISHLIST <span> <svg
                                        width="16" height="14" viewBox="0 0 16 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.175 7.89166L7.97597 13L2.78171 7.89166C-1.80869 3.38511 3.39428 -1.7171 7.98072 2.78945C12.6344 -1.78295 17.8334 3.31927 13.1797 7.89779L13.175 7.89166Z"
                                            stroke="#F78D1E" stroke-width="1.5" stroke-linejoin="round" />
                                    </svg>
                                </span></a>
                        </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
</section>
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('frontend/js/cart/cart.js') }}"></script>

    <script>
        $(document).ready(function() {

            $("#placeOrderBtn").on("click", function() {
                var button = $(this);

                // // Show the spinner
                // button.find('.spinner').removeClass('d-none');

                // Simulate a delay (7 seconds in this case)
                setTimeout(function() {
                    // Disable the button and hide the spinner
                    button.prop("disabled", true);
                    button.find('.spinner').addClass('d-none');

                    // Reset button text
                    button.find('span:first-child').text("Processing...");
                }, 300); // 7 seconds = 7000 milliseconds
            });
        });
    </script>
@endsection
@endsection
