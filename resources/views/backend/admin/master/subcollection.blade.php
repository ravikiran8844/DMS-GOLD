@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Sub Collection - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Sub Collection</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('subcollectioncreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="subCollectionId" id="subCollectionId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Project Name<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="project" id="project" required>
                                    <option value="">Select Project Name</option>
                                    @foreach ($project as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('project') == $item->id ? 'selected' : '' }}>
                                            {{ $item->project_name }}</option>
                                    @endforeach
                                </select>
                                @error('project')
                                    <div class="text-danger">{{ $errors->first('project') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Collection Name<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="collection" id="collection" required>
                                    <option value="">Select Collection Name</option>
                                    @foreach ($collection as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('collection') == $item->id ? 'selected' : '' }}>
                                            {{ $item->collection_name }}</option>
                                    @endforeach
                                </select>
                                @error('collection')
                                    <div class="text-danger">{{ $errors->first('collection') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Sub Collection Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="sub_collection_name" name="sub_collection_name"
                                    class="form-control" title="Sub Collection Name" placeholder="Sub Collection Name"
                                    value="{{ old('sub_collection_name') }}" required>
                                @error('sub_collection_name')
                                    <div class="text-danger">{{ $errors->first('sub_collection_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('subcollection') }}" id="cancel"
                                    class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Sub Collection List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableSubCollection">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Project Name</th>
                                    <th>Collection Name</th>
                                    <th>Sub Collection Name</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/subcollection.js') }}"></script>
@endsection
@endsection
