@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Dealers - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Dealers</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
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
                <div class="text-right">
                    <a href="{{ route('dealerdetails') }}" class="btn custom-orange-button"><i
                            class="fas fa-plus-circle"></i> Add New Dealer</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableDealer">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Dealer Name</th>
                                    <th>Dealer Mobile</th>
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
                <h5 class="modal-title" id="myLargeModalLabel">Edit Dealer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dealerupdate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="dealerId" id="dealerId" value="">
                    <input type="hidden" name="userId" id="userId" value="">
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
                                        <input type="text" class="form-control" name="party_name" id="party_name"
                                            value="{{ old('party_name') }}" placeholder="Party Name" required>
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
                                        <input type="text" class="form-control" name="customer_code"
                                            id="customer_code" value="{{ old('customer_code') }}"
                                            placeholder="customer_code" required>
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
    </div>
</div>
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/dealer/dealerlist.js') }}"></script>
@endsection
@endsection
