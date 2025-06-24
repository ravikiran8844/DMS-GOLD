@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Retailers - Emerald DMS Dashboard
@endsection
{{-- <link rel="stylesheet" href="{{ asset('frontend/lib/css/sumoselect.min.css') }}"> --}}

<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Retailers</div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableRetailer">
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Retailer Name </th>
                                    <th>Retailer Email</th>
                                    <th>Retailer Mobile</th>
                                    <th>Preffered Dealers</th>
                                    <th>Assigned Dealer</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                <h5 class="modal-title" id="myLargeModalLabel">Edit Retailer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('retailerupdate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="userId" id="userId" value="">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Retailer Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="retailer_name" id="retailer_name"
                                    value="{{ old('retailer_name') }}" placeholder="Retailer Name" required>
                                @error('retailer_name')
                                    <div class="text-danger">{{ $errors->first('retailer_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Retailer Email<span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" name="retailer_email" id="retailer_email"
                                    value="{{ old('retailer_email') }}" placeholder="Retailer Email" required>
                                @error('retailer_email')
                                    <div class="text-danger">{{ $errors->first('retailer_email') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Address<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="{{ old('address') }}" placeholder="Address" required>
                                @error('address')
                                    <div class="text-danger">{{ $errors->first('address') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Retailer Phone<span class="text-danger">*</span>
                                </label>
                                <input type="text" maxlength="10" class="form-control" name="mobile" id="mobile"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    value="{{ old('mobile') }}" placeholder="Land Line No" required>
                                @error('mobile')
                                    <div class="text-danger">{{ $errors->first('mobile') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Company Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="company_name" id="company_name"
                                    value="{{ old('company_name') }}" placeholder="company_name" required>
                                @error('company_name')
                                    <div class="text-danger">{{ $errors->first('company_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>GST
                                </label>
                                <input type="text" class="form-control" name="GST" id="GST"
                                    value="{{ old('GST') }}" placeholder="GST">
                                @error('GST')
                                    <div class="text-danger">{{ $errors->first('GST') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6  mb-4">
                                <label class="form-label fw-semibold" for="">Pincode<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pincode" id="pincode"
                                    value="{{ old('pincode') }}" placeholder="pincode" required>
                                @error('pincode')
                                    <div class="text-danger">{{ $errors->first('pincode') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6  mb-4">
                                <label class="form-label fw-semibold" for="">State<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ old('state') }}" placeholder="state" required>
                                @error('state')
                                    <div class="text-danger">{{ $errors->first('state') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6  mb-4">
                                <label class="form-label fw-semibold" for="">District<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="district" id="district"
                                    value="{{ old('district') }}" placeholder="district" required>
                                @error('district')
                                    <div class="text-danger">{{ $errors->first('district') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="">If you
                                    are purchasing from any existing Emerald Dealers, Plaese enter the name</label>
                                <textarea placeholder="Enter Dealer Name" class="form-control" style="height: 100px;" type="text"
                                    name="dealer_details" id="dealer_details"></textarea>

                            </div>
                            <div class="col-12 mt-3 mb-3 text-center">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    form .form-control {
        height: 48px !important;
    }

    form label {
        display: block !important;
    }

    .select2-container--bootstrap4 .select2-selection--multiple {
        box-shadow: none !important;
        border-radius: 5px;
        border: 1px solid #E4E4E4 !important;
    }

    form .select2-container {
        margin: 0px !important;
        width: 100% !important;
        border: 1px solid #d1d1d1 !important;
        border-radius: 5px !important;


    }

    .select2-container--bootstrap4 .select2-selection--single {
        background-color: #fff !important;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        border-radius: 4px;
        background: #2D2D2D !important;
        color: #fff !important;
    }

    .select2-container--bootstrap4 .select2-results__option--highlighted,
    .select2-container--bootstrap4 .select2-results__option--highlighted.select2-results__option[aria-selected="true"] {
        background: #F78D1E !important;
    }

    .sign-up-page-form_wrapper select {
        border-radius: 5px;
        border: 1px solid #E4E4E4;
        height: 48px;
    }

    .select2-container--bootstrap4 .select2-selection--single {
        border-radius: 5px;
        border: 1px solid #E4E4E4;
        height: 48px !important;
        display: flex;
        align-items: center;
    }

    .select2-container--bootstrap4 .select2-search {
        padding-left: 10px;
    }



    .select2-results__options {
        max-height: 300px;
        height: 100%;
        overflow-y: scroll;
    }
</style>
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/retailer/retailer.js') }}"></script>
@endsection
@endsection
