@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Roles - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Roles</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('rolecreate')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdRoleId" id="hdRoleId" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Role Name<span class="text-danger">*</span></label>
                                <input type="text" id="role_name" name="role_name" class="form-control"
                                    title="Role Name" placeholder="Role Name" value="{{ old('role_name') }}" required>
                                @error('role_name')
                                    <div class="text-danger">{{ $errors->first('role_name') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-8 mb-4 text-right">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#importrole">Import</button>
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
            <div class="h5 page-main-heading">Role List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableRole">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Role Name</th>
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
<div class="modal fade" id="importrole" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Import Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <form action="{{route('importrole')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="roleimport" id="roleimport" required>
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
    <script src="{{ asset('backend/assets/js/admin/permission/role.js') }}"></script>
@endsection
@endsection
