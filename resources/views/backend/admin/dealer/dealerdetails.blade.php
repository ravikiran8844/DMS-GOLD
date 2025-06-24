@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Dealers Details - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-6 mb-4">
            <div class="h5 page-main-heading">Dealer Details</div>
            <div>KYC (Know Your Customer) for New Customers </div>
        </div>
        <div class="col-6 mb-4 text-right">
             <a data-bs-toggle="tooltip" data-placement="top" title="Sample Sheet" href="{{url('dearlerdownload')}}" class="btn btn-success">Sample Sheet <i class="fas fa-download"></i></a>
            <button data-bs-toggle="tooltip" data-placement="top" title="Import" type="button" class="btn btn-success" data-toggle="modal" data-target="#importdealer">Import</button>
        </div>
        <form action="{{ route('dealercreate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Company Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="company_name" id="company_name"
                                    value="{{ old('company_name') }}" placeholder="Company Name" required>
                                @error('company_name')
                                    <div class="text-danger">{{ $errors->first('company_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Communication /
                                    Delivery Address<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="communication_address"
                                    id="communication_address" value="{{ old('communication_address') }}"
                                    placeholder="Communication / Delivery Address" required>
                                @error('communication_address')
                                    <div class="text-danger">{{ $errors->first('communication_address') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Mail ID<span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email') }}" placeholder="Mail ID" required>
                                @error('email')
                                    <div class="text-danger">{{ $errors->first('email') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Land Line No<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    maxlength="10"
                                    value="{{ old('mobile') }}" placeholder="Land Line No" required>
                                @error('mobile')
                                    <div class="text-danger">{{ $errors->first('mobile') }}
                                    </div>
                                @enderror
                            </div>
                            @php
                               $zones = App\Models\Zone::get();

                            @endphp
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Zone<span class="text-danger">*</span>
                                </label>
                                <select name="zone" id="zone" class="form-control select2" required>
                                    <option value="">Select Zone Name</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                    @endforeach
                                </select>
                                @error('zone')
                                    <div class="text-danger">{{ $errors->first('zone') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>City<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="city" id="city"
                                    value="{{ old('city') }}" placeholder="City" required>
                                @error('city')
                                    <div class="text-danger">{{ $errors->first('city') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>State<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ old('state') }}" placeholder="State" required>
                                @error('state')
                                    <div class="text-danger">{{ $errors->first('state') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title m-0 me-2">(A) For Orders</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="a_name" id="a_name"
                                            value="{{ old('a_name') }}" placeholder="Name" required>
                                        @error('a_name')
                                            <div class="text-danger">{{ $errors->first('a_name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Designation<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="a_designation"
                                            id="a_desingation" value="{{ old('a_designation') }}"
                                            placeholder="Designation" required>
                                        @error('a_designation')
                                            <div class="text-danger">{{ $errors->first('a_designation') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Mobile No<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="a_mobile" id="a_mobile"
                                        maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            value="{{ old('a_mobile') }}" placeholder="Mobile No" required>
                                        @error('a_mobile')
                                            <div class="text-danger">{{ $errors->first('a_mobile') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Mail ID<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="a_email" id="a_email"
                                            value="{{ old('a_email') }}" placeholder="Mail ID" required>
                                        @error('a_email')
                                            <div class="text-danger">{{ $errors->first('a_email') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title m-0 me-2">(B) For Orders</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Name<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="b_name" id="b_name"
                                            value="{{ old('b_name') }}" placeholder="Name" required>
                                        @error('b_name')
                                            <div class="text-danger">{{ $errors->first('b_name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Designation<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="b_designation"
                                            id="b_designation" value="{{ old('b_designation') }}"
                                            placeholder="Desgination" required>
                                        @error('b_designation')
                                            <div class="text-danger">{{ $errors->first('b_designation') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Mobile No<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="b_mobile" id="b_mobile"
                                        maxlength="10"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            value="{{ old('b_mobile') }}" placeholder="Mobile No" required>
                                        @error('b_mobile')
                                            <div class="text-danger">{{ $errors->first('b_mobile') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                                        <label>Mail ID<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="b_email" id="b_email"
                                            value="{{ old('b_email') }}" placeholder="Mail ID" required>
                                        @error('b_email')
                                            <div class="text-danger">{{ $errors->first('b_email') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title m-0 me-2">CIN (Only for Companies)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>GSTN<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="gst" id="gst"
                                    value="{{ old('gst') }}" placeholder="GSTN" required>
                                @error('gst')
                                    <div class="text-danger">{{ $errors->first('gst') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Income Tax Pan<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="income_tax_pan" id="income_tax_pan"
                                    value="{{ old('income_tax_pan') }}" placeholder="Income Tax Pan" required>
                                @error('income_tax_pan')
                                    <div class="text-danger">{{ $errors->first('income_tax_pan') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title m-0 me-2">Bank Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Bank Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="bank_name" id="bank_name"
                                    value="{{ old('bank_name') }}" placeholder="Bank Name" required>
                                @error('bank_name')
                                    <div class="text-danger">{{ $errors->first('bank_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Branch Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="branch_name" id="branch_name"
                                    value="{{ old('branch_name') }}" placeholder="Branch Name" required>
                                @error('branch_name')
                                    <div class="text-danger">{{ $errors->first('branch_name') }}
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
                                <label>Account No<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_number"
                                    value="{{ old('account_number') }}" id="account_number" placeholder="Account No"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                @error('account_number')
                                    <div class="text-danger">{{ $errors->first('account_number') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Type of Account<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="account_type" id="account_type"
                                    value="{{ old('account_type') }}" placeholder="Type Of Account" required>
                                @error('account_type')
                                    <div class="text-danger">{{ $errors->first('account_type') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>IFSC No<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="ifsc" id="ifsc"
                                    value="{{ old('ifsc') }}" placeholder="IFSC No" required>
                                @error('ifsc')
                                    <div class="text-danger">{{ $errors->first('ifsc') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Cancelled Check Leaf<span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="file" class="form-control" id="cheque_leaf" name="cheque_leaf"
                                        >
                                </div>
                                @error('cheque_leaf')
                                    <div class="text-danger">{{ $errors->first('ifsc') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>GST Certificate<span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="file" class="form-control" id="gst_certificate"
                                        name="gst_certificate" >
                                </div>
                                @error('gst_certificate')
                                    <div class="text-danger">
                                        {{ $errors->first('gst_certificate') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3">Save</button>
                                <a href="{{ route('dealerlist') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="importdealer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Import Dealer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <form action="{{ route('importdealer') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="dealerimport" id="dealerimport"
                                required>
                        </div>
                        <div class="text-center mt-3">
                            <button class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- @extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Dealers Details - Emerald DMS Dashboard
@endsection
<section class="section container">
    <div class="row">
        <div class="col-12 mb-4 px-4">
            <div class="h2 page-main-heading">Dealer Details</div>
            <div>KYC (Know Your Customer) for New Customers </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 p-4 m-auto custom-form">
            <div class="custom-nav-tabs">
                <ul class="nav nav-pills" id="myTabNew" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab1" href="#content1" role="tab"
                            aria-controls="content1" aria-selected="true" disabled>KYC For New Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab2" href="#content2" role="tab" aria-controls="content2"
                            aria-selected="false" disabled>For Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab3" href="#content3" role="tab" aria-controls="content3"
                            aria-selected="false" disabled>Bank details</a>
                    </li>
                </ul>
                <form action="{{ route('dealercreate') }}" method="POST">
                    @csrf
                    <div class="tab-content" id="myTabContentNew">
                        <div class="tab-pane fade active show" id="content1" role="tabpanel" aria-labelledby="tab1">
                            <div class="my-5">
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Company Name<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="company_name" id="company_name"
                                        value="{{ old('company_name') }}" required>
                                    @error('company_name')
                                        <div class="text-danger">{{ $errors->first('company_name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Communication /
                                        Delivery Address<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="communication_address"
                                        id="communication_address" value="{{ old('communication_address') }}" required>
                                    @error('communication_address')
                                        <div class="text-danger">{{ $errors->first('communication_address') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Land Line No<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                        value="{{ old('mobile') }}" required>
                                    @error('mobile')
                                        <div class="text-danger">{{ $errors->first('mobile') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Mail ID<span>*</span>
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $errors->first('email') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="float-right">
                                    <a href="#" class="btn btn-outline-dark next-button"
                                        data-next="content2">Next</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content2" role="tabpanel" aria-labelledby="tab2">
                            <div class="my-5">
                                <div class="text-center mb-4">
                                    <div class="h5 text-dark">(A) For Orders</div>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Name<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="a_name" id="a_name"
                                        value="{{ old('a_name') }}" required>
                                    @error('a_name')
                                        <div class="text-danger">{{ $errors->first('a_name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Designation<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="a_designation" id="a_desingation"
                                        value="{{ old('a_designation') }}" required>
                                    @error('a_designation')
                                        <div class="text-danger">{{ $errors->first('a_designation') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Mobile No<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="a_mobile" id="a_mobile"
                                        value="{{ old('a_mobile') }}" required>
                                    @error('a_mobile')
                                        <div class="text-danger">{{ $errors->first('a_mobile') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Mail ID<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="a_email" id="a_email"
                                        value="{{ old('a_email') }}" required>
                                    @error('a_email')
                                        <div class="text-danger">{{ $errors->first('a_email') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="text-center mb-4">
                                    <div class="h5 text-dark">(B) For Orders</div>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Name<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="b_name" id="b_name"
                                        value="{{ old('b_name') }}" required>
                                    @error('b_name')
                                        <div class="text-danger">{{ $errors->first('b_name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Designation<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="b_designation"
                                        id="b_designation" value="{{ old('b_designation') }}" required>
                                    @error('b_designation')
                                        <div class="text-danger">{{ $errors->first('b_designation') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Mobile No<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="b_mobile" id="b_mobile"
                                        value="{{ old('b_mobile') }}" required>
                                    @error('b_mobile')
                                        <div class="text-danger">{{ $errors->first('b_mobile') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Mail ID<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="b_email" id="b_email"
                                        value="{{ old('b_email') }}" required>
                                    @error('b_email')
                                        <div class="text-danger">{{ $errors->first('b_email') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="float-right">
                                    <a href="#" class="btn btn-outline-dark next-button"
                                        data-next="content3">Next</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content3" role="tabpanel" aria-labelledby="tab3">
                            <div class="my-5">
                                <div class="text-center mb-4">
                                    <div class="h5 text-dark">CIN (Only for Companies)</div>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>GSTN<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="gst" id="gst"
                                        value="{{ old('gst') }}" required>
                                    @error('gst')
                                        <div class="text-danger">{{ $errors->first('gst') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Income Tax Pan<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="income_tax_pan"
                                        id="income_tax_pan" value="{{ old('income_tax_pan') }}" required>
                                    @error('income_tax_pan')
                                        <div class="text-danger">{{ $errors->first('income_tax_pan') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="text-center mb-4">
                                    <div class="h5 text-dark">Bank Details</div>
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Bank Name<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="bank_name" id="bank_name"
                                        value="{{ old('bank_name') }}" required>
                                    @error('bank_name')
                                        <div class="text-danger">{{ $errors->first('bank_name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Branch Name<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="branch_name" id="branch_name"
                                        value="{{ old('branch_name') }}" required>
                                    @error('branch_name')
                                        <div class="text-danger">{{ $errors->first('branch_name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Address<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        value="{{ old('address') }}" required>
                                    @error('address')
                                        <div class="text-danger">{{ $errors->first('address') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Account No<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="account_number"
                                        value="{{ old('account_number') }}" id="account_number" required>
                                    @error('account_number')
                                        <div class="text-danger">{{ $errors->first('account_number') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>Type of Account<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="account_type" id="account_type"
                                        value="{{ old('account_type') }}" required>
                                    @error('account_type')
                                        <div class="text-danger">{{ $errors->first('account_type') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                                    <label>IFSC No<span>*</span>
                                    </label>
                                    <input type="text" class="form-control" name="ifsc" id="ifsc"
                                        value="{{ old('ifsc') }}" required>
                                    @error('ifsc')
                                        <div class="text-danger">{{ $errors->first('ifsc') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="footer-card">
                                        <div class="upload-text mb-3">Upload Your Cancelled Check Leaf</div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <div>Cancelled Check Leaf<span>*</span></div>
                                                <input type="file" id="check-leaf" name="cheque_leaf"
                                                    class="d-none"
                                                    onchange="displayFileName('check-leaf', 'check-leaf-label')"
                                                    value="{{ old('cheque_leaf') }}" required>
                                                <div>
                                                    <label class="browse-file-label text-center" for="check-leaf">
                                                        <div>Browse</div>
                                                    </label>
                                                </div>
                                                <div id="check-leaf-label"></div>
                                                @error('cheque_leaf')
                                                    <div class="text-danger">{{ $errors->first('ifsc') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 mb-4">
                                                <div>GST Certificate<span>*</span></div>
                                                <input type="file" id="gst-certificate" name="gst_certificate"
                                                    class="d-none"
                                                    onchange="displayFileName('gst-certificate', 'gst-certificate-label')"
                                                    value="{{ old('gst_certificate') }}" required>
                                                <div>
                                                    <label class="browse-file-label text-center"
                                                        for="gst-certificate">
                                                        <div>Browse</div>
                                                    </label>
                                                </div>
                                                <div id="gst-certificate-label"></div>
                                                @error('gst_certificate')
                                                    <div class="text-danger">{{ $errors->first('gst_certificate') }}
                                                    </div>
                                                @enderror
                                            </div>  
                                        </div>
                                        <div>
                                            <button type="submit" class="btn finish-button">Continue</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $(".next-button").click(function() {
            var nextTabId = $(this).data("next");
            $('a[href="#' + nextTabId + '"]').tab('show');
        });
    });

    function displayFileName(inputId, labelId) {
        const inputElement = document.getElementById(inputId);
        const labelElement = document.getElementById(labelId);

        if (inputElement.files.length > 0) {
            labelElement.textContent = "Selected file: " + inputElement.files[0].name;
        } else {
            labelElement.textContent = "";
        }
    }
</script>
@endsection --}}
