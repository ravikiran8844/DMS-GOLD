@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Weight - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Weight</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('weightcreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="weightId" id="weightId" value="">
                        <div class="row">
                            <div class="col-6 col-md-4 mb-4">
                                <label class="fs-5 form-label">Weight Range From<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="weight_range_from" name="weight_range_from"
                                    class="form-control" title="weight_range_from" placeholder="Weight Range From"
                                    value="{{ old('weight_range_from') }}" required>
                                @error('weight_range_from')
                                    <div class="text-danger">{{ $errors->first('weight_range_from') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 col-md-4 mb-4">
                                <label class="fs-5 form-label">Weight Range To<span class="text-danger">*</span></label>
                                <input type="text" id="weight_range_to" name="weight_range_to" class="form-control"
                                    title="weight_range_to" placeholder="Weight Range To"
                                    value="{{ old('weight_range_to') }}" required>
                                @error('weight_range_to')
                                    <div class="text-danger">{{ $errors->first('weight_range_to') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 col-md-4 mb-4">
                                <label class="fs-5 form-label">MC Charge<span class="text-danger">*</span></label>
                                <input type="text" id="mc_charge" name="mc_charge" class="form-control"
                                    title="mc_charge" placeholder="MC Charge" value="{{ old('mc_charge') }}" required>
                                @error('mc_charge')
                                    <div class="text-danger">{{ $errors->first('mc_charge') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('weight') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Weight List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableWeight">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Weight Rang From</th>
                                    <th>Weight Rang To</th>
                                    <th>MC Charge</th>
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
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/master/weight.js') }}"></script>
@endsection
@endsection
