@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Orders - Emerald DMS Dashboard
@endsection
<style>
    .order-page-card1 {
        border-radius: 11.992px;
        border: 1.036px solid #E1E1E1;
        background: #EBE0FF;
    }

    .order-page-card2 {
        border-radius: 11.992px;
        border: 1.036px solid #E1E1E1;
        background: #FEF0E9;
    }

    .order-page-card3 {
        border-radius: 11.992px;
        border: 1.036px solid #E1E1E1;
        background: #E8FAF5;
    }

    .table tr th {
        vertical-align: middle !important;
    }

    .dt-control.details-control button {
        width: max-content;
    }

    .badge-outline.col-green {
        width: max-content;
    }

    .select2-container--default .select2-selection--single {
        background: transparent !important;
    }

    .select2-container--open .select2-dropdown {
        top: -20px;
    }

    td[colspan="10"] {
        border-radius: 8px;
        border: 1px solid #F78D1E;
        background: #FFF;
        box-shadow: 0px 4px 12px 0px rgba(174, 174, 174, 0.46);
    }

    .select2.select2-container.select2-container--default {
        margin: 0px !important;
    }

    .table:not(.table-sm) thead th {
        height: 40px;
        padding: 5px;
    }

    .order-cards-main-card {
        border-radius: 8.99px;
        border: 1px solid #DADADA;
        background: #FFF;
    }

    .order-cards-black-card {
        border-radius: 8.99px;
        background: #2D2D2D !important;
        box-shadow: 0px 0px 13px 0px rgba(186, 186, 186, 0.25);
    }

    .order-cards-title {
        color: #F78D1E;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .order-cards-item {
        flex: 1;
        position: relative;
        padding-right: 10px;
    }

    @media (min-width:500px) {
        .order-cards-item::after {
            content: "";
            border-right: 1px solid #868686;
            position: absolute;
            right: 0px;
            top: 0px;
            height: 40px;
            margin-right: 30px;
        }

        .order-cards-item:last-child::after {
            content: "";
            display: none;
        }

    }


    .order-cards-item-title {
        color: #868686;
        font-family: Inter;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        margin-bottom: 10px;

    }

    .order-cards-item-big-text {
        font-family: Inter;
        font-size: 22px;
        font-style: normal;
        font-weight: 700;
        line-height: 100%;
        /* 22px */
    }
</style>
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Orders</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card order-cards-main-card">
                <div class="row">
                    <div class="col-12 col-lg-6 p-0">
                        <div class="card order-cards-black-card mb-0">
                            <div class="card-body">
                                <div class="order-cards-title mb-3">OVERALL ORDERS</div>

                                <div class="d-flex gap-2 justify-content-between">
                                    <div class="order-cards-item">
                                        <div class="order-cards-item-title">Total Orders</div>
                                        <div class="order-cards-item-big-text text-white">{{ $ordercount }}</div>
                                    </div>
                                    <div class="order-cards-item">
                                        <div class="order-cards-item-title">Total Pieces</div>
                                        <div class="order-cards-item-big-text text-white">{{ $orderpiececount }}</div>
                                    </div>
                                    <div class="order-cards-item">
                                        <div class="order-cards-item-title">Total Weight</div>
                                        <div class="order-cards-item-big-text text-white">{{ $orderweightcount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 p-0">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="order-cards-title mb-3">PENDING ORDERS</div>

                                <div class="d-flex gap-2 justify-content-between">
                                    <div class="order-cards-item">
                                        <div class="order-cards-item-title">Total Orders</div>
                                        <div class="order-cards-item-big-text text-dark">{{ $pendingorder }}</div>
                                    </div>
                                    <div class="order-cards-item">
                                        <div class="order-cards-item-title">Total Pieces</div>
                                        <div class="order-cards-item-big-text text-dark">{{ $pendingpiece }}</div>
                                    </div>
                                    <div class="order-cards-item">
                                        <div class="order-cards-item-title">Total Weight</div>
                                        <div class="order-cards-item-big-text text-dark">{{ $pendingweight }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="dealers" value="{{ json_encode($dealer) }}">
    {{-- <div class="row mb-4">
        <div class="col-md-6 col-lg md-me-4">
            <div class="d-flex flex-wrap  justify-content-between align-items-center w-100">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="">User Filter</label>
                        <select name="userfilter" id="userfilter" class="form-control select2">
                            <option value="">Select User Name</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg">
            <div class="d-flex flex-wrap  justify-content-between align-items-center w-100">
                <div class="d-flex flex-wrap align-items-center">
                    <div class="d-flex flex-column">
                        <label class="mb-0" for="">Role</label>
                        <select name="rolefilter" id="rolefilter" class="form-control select2">
                            <option value="">Select Role Name</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12 d-flex flex-wrap" style="gap:20px;">

            <div>
                <div>
                    <label class="mb-0" for="">User Filter</label>
                </div>
                <div>
                    <select name="userfilter" id="userfilter" class="form-select select2">
                        <option value="">Select User Name</option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <div>
                    <label class="mb-0" for="">Role</label>
                </div>
                <div>
                    <select name="rolefilter" id="rolefilter" class="form-control select2">
                        <option value="">Select Role Name</option>
                        @foreach ($roles as $item)
                            <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width:100%" id="orders-table">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-light">S.No</th>
                                    <th class="text-light">Role</th>
                                    <th class="text-light">Order ID</th>
                                    <th class="text-light">Order Date & Time</th>
                                    <th class="text-light">Retailer Name</th>
                                    <th class="text-light">Mobile Number</th>
                                    <th class="text-light">Total weight</th>
                                    <th class="text-light">Total Qty</th>
                                    <th class="text-light">Order Copy</th>
                                    <th class="text-light m-auto">Order Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myLargeModalLabel">Retailer Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <label>Retailer Name<span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="retailer_name" id="retailer_name"
                            readonly>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <label>Retailer Email<span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" name="retailer_email" id="retailer_email"
                            readonly>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <label>Address<span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="address" id="address" readonly>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <label>Retailer Phone<span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="mobile" id="mobile" readonly>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <label>Company Name<span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="company_name" id="company_name"
                            readonly>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <label>GST
                        </label>
                        <input type="text" class="form-control" name="GST" id="GST"
                            placeholder="GST" readonly>
                    </div>
                    <div class="col-12 col-md-6  mb-4">
                        <label class="form-label fw-semibold" for="">Pincode<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="pincode" id="pincode"
                            placeholder="pincode" readonly>
                    </div>
                    <div class="col-12 col-md-6  mb-4">
                        <label class="form-label fw-semibold" for="">State<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="state" id="state"
                            placeholder="state" readonly>
                    </div>
                    <div class="col-12 col-md-6  mb-4">
                        <label class="form-label fw-semibold" for="">District<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="district" id="district"
                            placeholder="district" readonly>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="">If you
                            are purchasing from any existing Emerald Dealers, Please enter the name</label>
                        <textarea placeholder="Enter Dealer Name" class="form-control" style="height: 100px;" type="text"
                            name="dealer_details" id="dealer_details" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
.select2-container--default .select2-selection--single {
    margin-bottom: 20px !important;
    text-align: left;
    width: 300px !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #F78D1E !important;

}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 42px;
}

table textarea.form-control {
    height: 42px !important;
}

.table:not(.table-sm) thead th {
    border-bottom: none !important;
}

.table th.table-dark {
    vertical-align: top !important;
}

table input[type='checkbox']:checked {
    background-color: #F78D1E;
}

table input[type='checkbox']:checked:after {
    content: '\2713';
    font-size: 16px;
    color: white;
    font-weight: bold;
}

table input[type='checkbox'] {
    text-align: center;
    display: table-cell;
    vertical-align: middle;
    width: 24px !important;
    height: 24px !important;
    appearance: none;
    border-radius: 10%;
    border: 1px solid #F78D1E;
    box-shadow: none;
    font-size: 1em;
    margin: auto;
}

table th,
td {
    font-size: 12px !important;
}

#orders-table select {
    max-width: 100%;
    width: 500px;
    margin-right: 10px;
}

table.dataTable thead th,
table.dataTable thead td {
    border-bottom: none !important;
}

table.dataTable td.dt-control:before {
    display: none;
}

td.dt-control {
    cursor: pointer;
}

.details-control {
    display: flex;
    align-items: center;
    justify-content: center;
}

.details-control button {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    background-color: transparent;
    color: #000;
    border: 1px solid #CECECE !important;
    border-radius: 4px;
    cursor: pointer;
}

.details-control button .icon {
    margin-left: 5px;
}

.shown .icon {
    transform: rotate(90deg);
}


table.dataTable th.dt-type-numeric,
table.dataTable th.dt-type-date,
table.dataTable td.dt-type-numeric,
table.dataTable td.dt-type-date {
    text-align: center !important;
}

.table thead th,
.table td {
    text-align: center !important;

}

table .badge {
    padding: 7px 12px;
    font-weight: 600;
    letter-spacing: 0.3px;
    border-radius: 30px !important;
}
</style>
@section('scripts')
<script src="{{ asset('backend\assets\js\admin\order\order.js') }}"></script>
@endsection
