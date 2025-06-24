@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Style - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Style</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('stylecreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="styleId" id="styleId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Style<span class="text-danger">*</span></label>
                                <input type="text" id="style" name="style" class="form-control" title="Style"
                                    placeholder="Style" value="{{ old('style') }}" required>
                                @error('style')
                                    <div class="text-danger">{{ $errors->first('style') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('style') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Style List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableStyle">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Style Name</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/style.js') }}"></script>
@endsection
@endsection
