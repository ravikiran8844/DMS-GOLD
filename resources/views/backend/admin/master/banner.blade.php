@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Banner - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Banner</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('bannercreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="bannerId" id="bannerId" value="">
                        <input type="hidden" name="bannerImage" id="bannerImage" value="">
                        <input type="hidden" name="height" id="height" value="">
                        <input type="hidden" name="width" id="width" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label>Project <span class="text-danger">*</span></label>
                                <select class="form-control" name="project" id="project" required>
                                    <option value="">select Project Name</option>
                                    <option value="DMS" {{ old('project') == 'DMS' ? 'selected' : '' }}>
                                        DMS</option>
                                    <option value="RMS" {{ old('project') == 'RMS' ? 'selected' : '' }}>
                                        RMS</option>
                                </select>
                                @error('bannerposition')
                                    <div class="text-danger">{{ $errors->first('bannerposition') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label>Banner Position <span class="text-danger">*</span></label>
                                <select class="form-control" name="bannerposition" id="bannerposition" required>
                                    <option value="">select Banner Position</option>
                                    @foreach ($bannerposition as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('bannerposition') == $item->id ? 'selected' : '' }}>
                                            {{ $item->banner_position }}</option>
                                    @endforeach
                                </select>
                                @error('bannerposition')
                                    <div class="text-danger">{{ $errors->first('bannerposition') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Banner URL<span class="text-danger">*</span></label>
                                <input type="text" id="banner_url" name="banner_url" class="form-control"
                                    title="Banner URL" placeholder="Banner URL" value="{{ old('banner_url') }}"
                                    required>
                                @error('banner_url')
                                    <div class="text-danger">{{ $errors->first('banner_url') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Banner Image <sup><strong id="size"></strong></sup>
                                    <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="file" class="form-control" name="banner_image" id="banner_image"
                                        accept="image/*" required>
                                    <div id="img-preview">
                                        <a href="" id="imglink" data-lightbox="uploaded-image-1"
                                            data-title="Selected Image"><img id="img" class="img-fluid ml-2"
                                                width="40" height="40"
                                                src="{{ asset('/backend/assets/img/no-image.jpg') }}" /></a>
                                    </div>
                                </div>
                                @error('banner_image')
                                    <div class="text-danger">{{ $errors->first('banner_image') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('banner') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Banner List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableBanner">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Banner Image</th>
                                    <th>Project</th>
                                    <th>Banner URL</th>
                                    <th>Banner Position</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/banner.js') }}"></script>
@endsection
@endsection
