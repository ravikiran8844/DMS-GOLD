@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    DisApproved Orders - Emerald DMS Dashboard
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

    .select2.select2-container.select2-container--default {
        min-width: 300px !important;
    }
</style>
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">DisApproved Orders</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-4  col-xl-3">
                            <div class="card mb-0 order-page-card1">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div>
                                            <div class="fs-6 text-muted">Total Orders</div>
                                            <h4 class="text-dark">{{ $ordercount }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mb-4 mb-lg-0  col-lg-4  col-xl-3">
                            <div class="card mb-0 order-page-card2">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div>
                                            <div class="fs-6 text-muted">Total Pieces</div>
                                            <h4 class="text-dark">{{ $orderpiececount }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6  col-lg-4  col-xl-3">
                            <div class="card mb-0 order-page-card3">
                                <div class="card-body text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div>
                                            <div class="fs-6 text-muted">Total Weight</div>
                                            <h4 class="text-dark">{{ $orderweightcount }}</h4>
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
    {{-- <div class="row">
        <div class="col-4 mb-4">
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
        <div class="col-4 mb-4">
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
    <div class="row mt-4">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width:100%" id="disapprovedorder">
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
                            <input type="text" class="form-control" name="retailer_name" id="retailer_name" readonly>
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

    table th {
        font-size: 14px !important;
    }

    table input.form-control {
        width: 400px !important;
    }

    #approvedorder select {
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
    <script src="{{ asset('backend\assets\js\admin\order\disapprovedorder.js') }}"></script>
@endsection
@endsection
