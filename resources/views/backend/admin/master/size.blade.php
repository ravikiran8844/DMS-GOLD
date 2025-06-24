@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Size - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Size</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sizecreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sizeId" id="sizeId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Size<span class="text-danger">*</span></label>
                                <input type="text" id="size" name="size" class="form-control" title="Size"
                                    placeholder="Size" value="{{ old('size') }}" required>
                                @error('size')
                                    <div class="text-danger">{{ $errors->first('size') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('size') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Size List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableSize">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Size</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/size.js') }}"></script>
@endsection
@endsection
