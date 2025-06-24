@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Finish - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Finish</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('finishcreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="finishId" id="finishId" value="">
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
                                <label class="fs-5 form-label">Finish Name<span class="text-danger">*</span></label>
                                <input type="text" id="finish_name" name="finish_name" class="form-control"
                                    title="Finish Name" placeholder="Finish Name" value="{{ old('finish_name') }}"
                                    required>
                                @error('finish_name')
                                    <div class="text-danger">{{ $errors->first('finish_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('finish') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Finish List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableFinish">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Project Name</th>
                                    <th>Finish Name</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/finish.js') }}"></script>
@endsection
@endsection
