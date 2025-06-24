@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Shape - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Shape</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shapecreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="shapeId" id="shapeId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Shape Name<span class="text-danger">*</span></label>
                                <input type="text" id="shape_name" name="shape_name" class="form-control"
                                    title="Shape Name" placeholder="Shape Name" value="{{ old('shape_name') }}"
                                    required>
                                @error('shape_name')
                                    <div class="text-danger">{{ $errors->first('shape_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('shape') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Shape List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableShape">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Shape Name</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/shape.js') }}"></script>
@endsection
@endsection
