@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Add Users Phone - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Users Phone</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('userphonecreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdUserPhoneId" id="hdUserPhoneId" value="">
                        <div class="row">
                            <div class="col-6 col-md-4 mb-4">
                                <label class="form-label h6 text-dark">
                                    Select User</label>
                                <select class="form-control" name="user" id="user" required>
                                    <option value="">Select User Name</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <div class="text-danger">{{ $errors->first('user') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-6 col-md-4 mb-4">
                                <label class="form-label h6 text-dark">
                                    Enter Phone Number</label>
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    placeholder="Enter Phone Number" required 
                                    maxlength="10" />
                                @if ($errors->has('mobile'))
                                    <div class="text-danger">{{ $errors->first('mobile') }}
                                    </div>
                                @endif
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
            <div class="h5 page-main-heading">User Phone Number List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tableUserPhone">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User Name</th>
                                    <th>Mobile</th>
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
    <script src="{{ asset('backend/assets/js/admin/permission/userphone.js') }}"></script>
@endsection
@endsection
