@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Category - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-6 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Category</div>
        </div>
        <div class="col-6 col-md-6 mb-4 text-right">
            <!-- Button trigger modal -->
            <a data-bs-toggle="tooltip" data-placement="top" title="Sample Sheet" href="{{ url('downloadcategory') }}"
                class="btn btn-success">Sample Sheet <i class="fas fa-download"></i></a>
            <button data-bs-toggle="tooltip" data-placement="top" title="Import" type="button" class="btn btn-success"
                data-toggle="modal" data-target="#importcategory">Import</button>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categorycreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdCategoryId" id="hdCategoryId" value="">
                        <input type="hidden" name="categoryImage" id="categoryImage" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label>Project Name <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="project_name" id="project_name" required>
                                    <option value="">select project name</option>
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
                                <input type="text" id="category_name" name="category_name" class="form-control"
                                    title="Category Name" placeholder="Category Name" value="{{ old('category_name') }}"
                                    required>
                                @error('category_name')
                                    <div class="text-danger">{{ $errors->first('category_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Category Image <sup><strong>(280px *
                                            280px)</strong></sup>
                                    <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="file" class="form-control" name="category_image" id="category_image"
                                        accept="image/*" required>
                                    <div id="img-preview">
                                        <a href="" id="imglink" data-lightbox="uploaded-image-1"
                                            data-title="Selected Image"><img id="img" class="img-fluid ml-2"
                                                width="40" height="40"
                                                src="{{ asset('/backend/assets/img/no-image.jpg') }}" /></a>
                                    </div>
                                </div>
                                @error('category_image')
                                    <div class="text-danger">{{ $errors->first('category_image') }}
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
            <div class="h5 page-main-heading">Category List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableCategory">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Category Image</th>
                                    <th>Project Name</th>
                                    <th>Category Name</th>
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
<div class="modal fade" id="importcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Import Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <form action="{{ route('importcategory') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="categoryimport" id="categoryimport"
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
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/master/category.js') }}"></script>
@endsection
@endsection
