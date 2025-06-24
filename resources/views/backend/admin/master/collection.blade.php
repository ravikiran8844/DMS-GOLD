@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Collection - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Collection</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('collectioncreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="collectionId" id="collectionId" value="">
                        <input type="hidden" name="collectionImage" id="collectionImage" value="">
                        <input type="hidden" name="height" id="height" value="">
                        <input type="hidden" name="width" id="width" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Project Name<span class="text-danger">*</span></label>
                                <select class="form-control" name="project_name" id="project_name">
                                    <option value="">Select Project Name</option>
                                    @foreach ($project as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('project_name') == $item->id ? 'selected' : '' }}>
                                            {{ $item->project_name }}</option>
                                    @endforeach
                                </select>
                                @error('project_name')
                                    <div class="text-danger">{{ $errors->first('project_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Category Name<span class="text-danger">*</span></label>
                                <select class="form-control" name="category_name" id="category_name">
                                    <option value="">Select Category Name</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('category_name') == $item->id ? 'selected' : '' }}>
                                            {{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category_name')
                                    <div class="text-danger">{{ $errors->first('category_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Collection Name<span class="text-danger">*</span></label>
                                <input type="text" id="collection_name" name="collection_name" class="form-control"
                                    title="Collection Name" placeholder="Collection Name"
                                    value="{{ old('collection_name') }}" required>
                                @error('collection_name')
                                    <div class="text-danger">{{ $errors->first('collection_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Collection Image Type</label>
                                <select class="form-control" name="image_type" id="image_type">
                                    <option value="">Select Image Type</option>
                                    @foreach ($imageType as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('image_type') == $item->id ? 'selected' : '' }}>
                                            {{ $item->size_name }}</option>
                                    @endforeach
                                </select>
                                @error('image_type')
                                    <div class="text-danger">{{ $errors->first('image_type') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Collection Image</label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="file" class="form-control" name="collection_image"
                                        id="collection_image" accept="image/*">
                                    <div id="img-preview">
                                        <a href="" id="imglink" data-lightbox="uploaded-image-1"
                                            data-title="Selected Image"><img id="img" class="img-fluid ml-2"
                                                width="40" height="40"
                                                src="{{ asset('/backend/assets/img/no-image.jpg') }}" /></a>
                                    </div>
                                </div>
                                @error('collection_image')
                                    <div class="text-danger">{{ $errors->first('collection_image') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Content</label>
                                <textarea id="content" name="content" class="form-control" title="Content" placeholder="Content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $errors->first('content') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('collection') }}" id="cancel" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Collection List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableCollection">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Collection Image</th>
                                    <th>Collection Name</th>
                                    <th>Project Name</th>
                                    <th>Category Name</th>
                                    <th>Collection Image Type</th>
                                    <th>Collection Content</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/collection.js') }}"></script>
@endsection
@endsection
