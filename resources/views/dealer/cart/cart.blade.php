@extends('dealer.layout.dealermaster')
@section('content')
@section('title')
    Cart Page - Emerald DMS
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet">
<style>
    @media (max-width:992px) {
        footer {
            margin-bottom: 135px;
        }
    }
</style>


<div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
        <div class="loading-text">Order being processed...</div>
    </div>
</div>

<main>
    <section class="container dms-cart-page">
        <form action="{{ route('placeorder') }}" method="POST" enctype="multipart/form-data" id="orderForm">
            @csrf
            <input type="hidden" name="weight" id="hdweight" value="{{ $cartWeight }}">
            @foreach ($cart as $item)
                <input type="hidden" name="moq{{ $item->id }}" id="moq{{ $item->product_id }}"
                    value="{{ $item->moq }}">

                <input type="hidden" name="stock{{ $item->product_id }}" id="stock{{ $item->product_id }}"
                    value="{{ $item->qty }}">
                <input type="hidden" name="readystock{{ $item->product_id }}" id="readystock{{ $item->product_id }}"
                    value="{{ $item->is_ready_stock }}">
                <input type="hidden" name="encrypt{{ $item->product_id }}" id="encrypt{{ $item->product_id }}"
                    value="{{ encrypt($item->product_id) }}">
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
                                        onclick="saveRemarks({{ $item->id }})"
                                        data-bs-dismiss="modal">Submit</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 my-4">
                    <div class="nav-bold-heading">Shopping Cart</div>
                    @if ($cart->count() > 0)
                        <div id="removeall">
                            <button type="button" onclick="removeAllCart();" class="btn btn-outline-dark">Remove
                                All</button>
                        </div>
                    @endif
                </div>
            </div>

            @if ($cart->isEmpty())
                <div id="cart-no-items" class="py-4">
                    <div class="text-center">

                        <div>
                            <img class="img-fluid" width="212" height="212"
                                src="{{ asset('cart-no-tems.gif') }}" alt="">
                        </div>
                        <div class="fw-semibold fs-3">Your Shopping Cart is empty</div>

                        <div class="my-4">
                            <a id="dynamicRouteLink"
                                class="btn custom-btn btn-warning px-5 py-2 fw-semibold text-uppercase">Start
                                Shopping</a>
                        </div>

                        <div class="d-flex gap-2 flex-column flex-md-row align-items-center justify-content-center">
                            <div class=" text-uppercase">For Queries :</div>
                            <div><a href="tel:+918220017619" class="link-yellow fw-semibold fs-5">Vivin - +91 82200
                                    17619</a></div>
                        </div>
                    </div>
                </div>

                <!--
            <div class="text-center" id="empty-cart-image">
                <img class="img-fluid" src="{{ asset('emptycart.gif') }}" alt="">
                {{-- <strong>Your Cart Is Empty!</strong> --}}
            </div> -->
            @else
                <div class="row" id="cart">
                    <div class="col-12 col-xl-9 col-xxl-9  position-relative mb-4">

                        @if ($cart->count() > 0)
                            <div class="row g-3">

                                @if (Auth::user()->role_id == App\Enums\Roles::CRM)
                                    <div class="col-12 col-lg-4">
                                        <select name="preferredDealer" id="preferredDealer" required>
                                            <option value="">Select Dealer</option>
                                            @foreach ($dealer as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-12 col-lg-4">


                                    <input placeholder="Reference" type="text" class="form-control"
                                        name="reference" id="reference"
                                        @if (Auth::user()->role_id == App\Enums\Roles::CRM) required @endif>


                                </div>


                                <div class="col-12 col-lg-4 text-center text-lg-end">
                                    <div>
                                        <a href="{{ $previousUrl }}" class="btn btn-dark px-3">Continue Shopping</a>
                                    </div>
                                </div>


                            </div>
                        @endif
                        <div class="d-none d-md-block card cart-items_card desktop-cart mt-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Product SKU</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Weight Per Piece</th>
                                            <th class="text-center">Total Weight</th>
                                            <th class="text-center">Size(cm)</th>
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
                        <div class="d-block d-md-none mobile-cart mt-5 mb-2">
                            <div class="cart-container">
                                <div id="items-container">
                                    <!-- Items will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-3 col-xxl-3">
                        <div class="card cart-page_total-card mb-4">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="cart-page_card-light-text">Total Qty</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="cart-page_card-bold-title" id="qty">{{ $cartQty }}
                                            Qtys
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
                                    <strong for="remarks">Remarks</strong>
                                    <textarea class="mt-3 mb-3 form-control" maxlength="255" name="others" id="others" cols="32"
                                        rows="4"></textarea>
                                </div>
                                <div class="col-12 text-center">
                                    <div class="mb-3">
                                        <div class="cart-container">
                                            <!-- Your cart items go here -->
                                            <div class="cart-footer">
                                                <button id="placeOrderBtn"
                                                    class="btn py-2 btn-warning w-100 custom-yellow-button">
                                                    <span>Place Order</span>
                                                    <span class="d-none spinner">
                                                        <span class="spinner-grow spinner-grow-sm"
                                                            aria-hidden="true"></span>
                                                        <span role="status">Order being processed...</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <style>
                                            .mobile-fixed-menu {
                                                display: none;
                                            }

                                            @media (max-width: 767px) {
                                                .cart-footer {
                                                    position: fixed;
                                                    bottom: 10px;
                                                    left: 0;
                                                    /* Ensure the footer spans the entire width of the viewport */
                                                    right: 0;
                                                    /* Ensure the footer spans the entire width of the viewport */
                                                    width: 100%;
                                                    background-color: white;
                                                    padding: 10px 0;
                                                    z-index: 1000;
                                                    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
                                                    display: flex;
                                                    justify-content: center;
                                                    align-items: center;
                                                }

                                                .cart-footer button {
                                                    margin: 0 auto;
                                                    /* Center the button horizontally */
                                                    max-width: 90%;
                                                    /* Optional: limit the button's width for better appearance */
                                                }
                                            }
                                        </style>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-4 text-center" style="max-width: 350px;">
                            <div class="mb-2 fw-medium fs-6">For Queries:</div>
                            <div>
                                <a href="tel:+918220017619" class="btn btn-dark px-4 py-2 rounded-5">
                                    <span class="text-white fw-semibold">Vivin - +9182200 17619</span>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            @endif
        </form>
    </section>
</main>
<style>
    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .cv-spinner .spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #667B68 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    .loading-text {
        margin-top: 10px;
        font-size: 16px;
        color: #fff;
    }

    .error {
        color: red;
        font-weight: bold;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
</style>
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('dealer/js/cart/cart.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize form validation
            $("#orderForm").validate({
                rules: {
                    preferredDealer: {
                        required: true
                    },
                    reference: {
                        required: false
                    }
                },
                messages: {
                    preferredDealer: {
                        required: "Please select a dealer."
                    },
                    reference: {
                        required: "Reference is required."
                    }
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

            $("#placeOrderBtn").on("click", function(e) {
                e.preventDefault();

                if ($("#orderForm").valid()) {
                    // Show the overlay
                    $("#overlay").show();

                    var button = $("#placeOrderBtn");

                    // Disable the button and show the spinner
                    button.prop("disabled", true);
                    button.find('.spinner-border').removeClass('d-none');

                    // Change button text to "Processing..."
                    button.find('span:first-child').text("Order being processed...");

                    setTimeout(() => {
                        // Submit the form
                        $("#orderForm").submit();
                    }, 5000); // Change to 7000 for 7 seconds if needed
                }
            });
        });
    </script>


    <script>
        $(function() {
            $("#preferredDealer").select2({
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $("#preferredDealer").attr('placeholder'),
                allowClear: Boolean($("#preferredDealer").data('allow-clear')),
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var linkElement = document.getElementById('dynamicRouteLink');
            var isDesktopView = window.matchMedia("(min-width: 992px)")
                .matches; // You can adjust the breakpoint based on your design

            if (isDesktopView) {
                linkElement.href = "{{ route('landing') }}";
            } else {
                linkElement.href = "{{ route('category') }}";
            }
        });
    </script>
    <script>
        @if (session('notification'))
            Swal.fire({
                icon: "{{ session('notification.alert') }}",
                html: "{!! session('notification.message') !!}",
                title: "We are sorry!"
            });
        @endif
    </script>
@endsection
@endsection
