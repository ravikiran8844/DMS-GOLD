@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Jewel Type - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Jewel Type</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('jewelcreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jewelId" id="jewelId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Jewel Type Name<span class="text-danger">*</span></label>
                                <input type="text" id="jewel" name="jewel" class="form-control"
                                    title="Jewel Type Name" placeholder="Jewel Type Name" value="{{ old('jewel') }}"
                                    required>
                                @error('jewel')
                                    <div class="text-danger">{{ $errors->first('jewel') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('jeweltype') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">jewel Type List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableJewel">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Jewel Type</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/jewel.js') }}"></script>
@endsection
@endsection
