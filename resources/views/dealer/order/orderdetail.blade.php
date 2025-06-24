@extends('dealer.layout.dealermaster')
@section('content')
@section('title')
    Order Details Page - Emerald DMS
@endsection
<main class="myaccount-page">
    <section class="container">
        <div class="row pt-4 pt-lg-5 pb-5">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 col-xxl-12 mt-4 mt-md-0">
                        <div class="row mb-4">
                            <div class="col-12 mb-5">
                                <div class="card order-details-card">
                                    <div
                                        class="card-body d-flex gap-2 justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h5 class="fw-bold">{{ Auth::user()->shop_name }}</h5>
                                            <div>Order Id : {{ $order->order_no }}</div>
                                            @if ($order->reference)
                                                <div>Reference : {{ $order->reference }}</div>
                                            @endif
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-warning ms-2"
                                                onclick="repeatOrder()">Repeat Order</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="fw-bold mt-2 mb-4">
                                            Order Details
                                        </h4>
                                        <div class="table-responsive">
                                            <table class="table  table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Product Image</th>
                                                        <th class="text-center">Product SKU</th>
                                                        <th class="text-center">Product Name</th>
                                                        <th class="text-center">Project</th>
                                                        <th class="text-center">Color</th>
                                                        <th class="text-center">Style</th>
                                                        <th class="text-center">Weight/Piece (in gms)</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Weight (in gms)</th>
                                                        <th class="text-center">Order Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $productIds = [];
                                                        foreach ($orderdetails as $item) {
                                                            $productIds[] = $item->product_id;
                                                        }
                                                        $productIdsString = implode(',', $productIds);
                                                    @endphp
                                                    <input type="hidden" name="productIds" id="productIds"
                                                        value="{{ $productIdsString }}">
                                                    @foreach ($orderdetails as $item)
                                                        <input type="hidden" name="quantitys{{ $item->product_id }}"
                                                            id="quantitys{{ $item->product_id }}"
                                                            value="{{ $item->qty }}">
                                                        <input type="hidden" name="finishs{{ $item->product_id }}"
                                                            id="finishs{{ $item->product_id }}"
                                                            value="{{ $item->finish }}">
                                                        <tr>
                                                            <td class="text-center"><a
                                                                    href="{{ asset('/upload/product/' . $item->product_image) }}"
                                                                    data-lightbox="image-{{ asset('/upload/product/' . $item->product_image) }}"
                                                                    data-title="{{ $item->product_unique_id }}"><img
                                                                        src="{{ asset('/upload/product/' . $item->product_image) }}"
                                                                        width="60" height="60"></td>
                                                            <td class="text-center">{{ $item->product_unique_id }}</td>
                                                            <td class="text-center">{{ $item->product_name }}</td>
                                                            <td class="text-center">
                                                                {{ str_replace('SIL ', '', $item->project_name) }}</td>
                                                            {{-- <td class="text-center">SIL-99.9</td> --}}
                                                            <td class="text-center">{{ $item->color_name }}</td>
                                                            <td class="text-center">{{ $item->style_name }}</td>
                                                            <td class="text-center">{{ $item->weight }}</td>
                                                            <td class="text-center">{{ $item->qty }}</td>
                                                            <td class="text-center">{{ $item->qty * $item->weight }}
                                                            </td>
                                                            <td class="text-center">
                                                                <span
                                                                    class="badge @if ($item->is_approved == 1) text-bg-success @else text-bg-danger @endif">
                                                                    @if ($item->is_approved == 1)
                                                                        Confirmed
                                                                    @else
                                                                        Not yet confirmed
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Grand Total :</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="text-center">{{ $orderdetails->sum('qty') }}</th>
                                                        <th class="text-center">
                                                            {{ $totalWeight }}
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="col-12 col-lg-6 ms-auto mt-4 order-details-page__remarks">

                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="fw-semibold">
                                                    Remarks
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Finish</span>
                                                        <input type="text" class="form-control"
                                                            value="{{ $order->remarks ? $order->remarks : '-' }}"
                                                            readonly>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Box</span>
                                                        <input type="text" class="form-control"
                                                            value="{{ $order->box ? $order->box : '-' }}" readonly>
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Others</span>
                                                        <input type="text" class="form-control"
                                                            value="{{ $order->others ? $order->others : '-' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@section('scripts')
@endsection
@endsection
