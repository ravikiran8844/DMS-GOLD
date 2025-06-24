@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Zone - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Zone</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('zonecreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="zoneId" id="zoneId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Zone Name<span class="text-danger">*</span></label>
                                <input type="text" id="zone_name" name="zone_name" class="form-control"
                                    title="Zone Name" placeholder="Zone Name" value="{{ old('zone_name') }}" required>
                                @error('zone_name')
                                    <div class="text-danger">{{ $errors->first('zone_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <button type="button" id="cancel" class="btn btn-dark px-3"
                                    onclick="cancels();">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Zone List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableZone">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Zone Name</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/zone.js') }}"></script>
@endsection
@endsection
