@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Assign Role - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-6 mb-4">
                <div class="h2 page-main-heading" id="heading">Add Users</div>
            </div>
            <div class="col-6 mb-4 text-right">
                <a title="Add Users Mobile" href="{{ route('adduserphone') }}" class="btn btn-success">Add Users Phone</a>
            </div>
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('createuser') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="userId" id="userId" value="">
                            <div class="row">
                                <div class="col-4 col-lg-4">
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
                                        <div class="mb-4">
                                            <label class="form-label h6 text-dark">
                                                Name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Name" required />
                                            @if ($errors->has('name'))
                                                <div class="text-danger">{{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label h6 text-dark">
                                                Login Mobile</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                placeholder="Login Mobile" required />
                                            @if ($errors->has('mobile'))
                                                <div class="text-danger">{{ $errors->first('mobile') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label h6 text-dark">
                                                Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Email" required />
                                            @if ($errors->has('email'))
                                                <div class="text-danger">{{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button id="save" class="btn custom-orange-button">Save</button>
                                        <button type="button" id="cancel" class="btn btn-dark px-3"
                                            onclick="cancels();">Cancel</button>
                                    </div>
                                </div>
                                <div class="col-8 col-lg-8">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <h6>List of Menu Permissions <span class="text-danger">*</span>
                                                <span class="d-flex justify-content-end">
                                                    <div class="pretty p-switch p-fill mb-2">
                                                        <input type="checkbox" id="chkall">
                                                        <div class="state p-success">
                                                            <label>Select All</label>
                                                        </div>
                                                    </div>
                                                </span>
                                            </h6>
                                            <div class="card-datatable table-responsive pt-0 scrollUser">
                                                <table class="table">
                                                    <thead class="border-bottom">
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Menu</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                            <th>Print</th>
                                                            <th>View</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyMenuList">
                                                        <tr>
                                                            <td colspan="7" class="text-center">Please Choose
                                                                Role Name
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
                <div class="h5 page-main-heading">Users List</div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tableUsers">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>LOGIN MOBILE</th>
                                        <th>ROLE NAME</th>
                                        <th>EMAIL</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
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
    <script src="{{ asset('backend/assets/js/admin/permission/users.js') }}"></script>
@endsection
@endsection
