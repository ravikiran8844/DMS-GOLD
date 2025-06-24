@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Subcategory - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-6 col-sm-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Sub Category</div>
        </div>
        <div class="col-6 col-sm-12 mb-3 text-right">
            <!-- Button trigger modal -->
            <a data-bs-toggle="tooltip" data-placement="top" title="Sample Sheet" href="{{ url('downloadsubcategory') }}"
                class="btn btn-success">Sample Sheet <i class="fas fa-download"></i></a>
            <button data-bs-toggle="tooltip" data-placement="top" title="Import" type="button" class="btn btn-success"
                data-toggle="modal" data-target="#importsubcategory">Import</button>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('subcategorycreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdSubCategoryId" id="hdSubCategoryId" value="">
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
                                <label>Category Name <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="category_name" id="category_name" required>
                                    <option value="">select category name</option>
                                    {{-- @foreach ($category as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('category_name') == $item->id ? 'selected' : '' }}>
                                            {{ $item->category_name }}</option>
                                    @endforeach --}}
                                </select>
                                @error('category_name')
                                    <div class="text-danger">{{ $errors->first('category_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Sub Category Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="sub_category_name" name="sub_category_name"
                                    class="form-control" title="Sub Category Name" placeholder="Sub Category Name"
                                    value="{{ old('sub_category_name') }}" required>
                                @error('sub_category_name')
                                    <div class="text-danger">{{ $errors->first('sub_category_name') }}
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
            <div class="h5 page-main-heading">Sub Category List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableSubCategory">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Project Name</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
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
<div class="modal fade" id="importsubcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Import Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <form action="{{ route('importsubcategory') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="subcategoryimport" id="subcategoryimport"
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
    <script src="{{ asset('backend/assets/js/admin/master/subcategory.js') }}"></script>
@endsection
@endsection
