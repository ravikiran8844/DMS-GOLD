@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Role Permissions - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="h2 page-main-heading" id="heading">Role Permission</div>
            </div>
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rolepermissioncreate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="roleId" id="roleId" value="">
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label h6 text-dark">
                                                Role Name</label>
                                            <select class="form-control" name="role_name" id="role_name" required>
                                                <option value="">Select Role Name</option>
                                                @foreach ($roles as $item)
                                                    <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_name')
                                                <div class="text-danger">{{ $errors->first('role_name') }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button id="save" class="btn custom-orange-button">Save</button>
                                        <button type="button" id="cancel" class="btn btn-dark px-3"
                                            onclick="cancels();">Cancel</button>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label h6 text-dark">
                                                Menus</label>
                                            <div class="form-group" style="max-height: 330px; overflow-y: auto;">
                                                @foreach ($menus as $item)
                                                    <div class="pretty p-switch p-fill mb-2">
                                                        <input type="checkbox" name="menu{{ $item->id }}[]"
                                                            id="menu{{ $item->id }}" class="mainmenu"
                                                            data-parent-id="{{ $item->parent_id }}"
                                                            {{ $item->id === 1 ? 'checked' : '' }}
                                                            value={{ $item->id }}>
                                                        <div class="state p-success">
                                                            <label
                                                                class="{{ $item->is_mainmenu ? 'font-weight-bold text-dark' : '' }}">{{ $item->menu_name }}</label>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12 mb-4">
                <div class="h5 page-main-heading">Role Permission List</div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tablePermission">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Role Name</th>
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
    </div>
</section>
@section('scripts')
    <script src="{{ asset('backend/assets/js/admin/permission/permission.js') }}"></script>
@endsection
@endsection
