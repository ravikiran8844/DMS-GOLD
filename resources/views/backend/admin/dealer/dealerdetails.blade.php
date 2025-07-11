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
            <a data-bs-toggle="tooltip" data-placement="top" title="Sample Sheet" href="{{ url('dearlerdownload') }}"
                class="btn btn-success">Sample Sheet <i class="fas fa-download"></i></a>
            <button data-bs-toggle="tooltip" data-placement="top" title="Import" type="button" class="btn btn-success"
                data-toggle="modal" data-target="#importdealer">Import</button>
        </div>
        <form action="{{ route('dealercreate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Zone<span class="text-danger">*</span>
                                </label>
                                <select name="zone" id="zone" class="form-control" required>
                                    <option value="">Select Zone Name</option>
                                    <option value="DELHI">DELHI</option>
                                    <option value="KOLKATTA">KOLKATTA</option>
                                    <option value="MUMBAI">MUMBAI</option>
                                    <option value="SOUTH">SOUTH</option>
                                    <option value="UP">UP</option>
                                </select>
                                @error('zone')
                                    <div class="text-danger">{{ $errors->first('zone') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Code<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="code" id="code"
                                    value="{{ old('code') }}" placeholder="Code" required>
                                @error('code')
                                    <div class="text-danger">{{ $errors->first('code') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Party Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="party_name"
                                    id="party_name" value="{{ old('party_name') }}"
                                    placeholder="Party Name" required>
                                @error('party_name')
                                    <div class="text-danger">{{ $errors->first('party_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Person Name<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="person_name" id="person_name"
                                    value="{{ old('person_name') }}" placeholder="Mail ID" required>
                                @error('person_name')
                                    <div class="text-danger">{{ $errors->first('person_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Phone No<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="10"
                                    value="{{ old('mobile') }}" placeholder="Land Line No" required>
                                @error('mobile')
                                    <div class="text-danger">{{ $errors->first('mobile') }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <label>Customer Code<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="customer_code" id="customer_code"
                                    value="{{ old('customer_code') }}" placeholder="customer_code" required>
                                @error('customer_code')
                                    <div class="text-danger">{{ $errors->first('customer_code') }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3 mb-3">
                        <button class="btn btn-warning custom-orange-button mr-3 px-3">Save</button>
                        <a href="{{ route('dealerlist') }}" class="btn btn-dark px-3">Cancel</a>
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