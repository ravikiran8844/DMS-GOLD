@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Popup - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="h5 page-main-heading" id="heading">Add Popup</div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('popupcreate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="popupId" id="popupId" value="">
                        <input type="hidden" name="popupImage" id="popupImage" value="">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Popup URL<span class="text-danger">*</span></label>
                                <input type="text" id="popup_url" name="popup_url" class="form-control"
                                    title="Popup URL" placeholder="Popup URL" value="{{ old('popup_url') }}" required>
                                @error('popup_url')
                                    <div class="text-danger">{{ $errors->first('popup_url') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="fs-5 form-label">Popup Image <sup><strong>(1106 * 414 px)</strong></sup>
                                    <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center justify-content-between">
                                    <input type="file" class="form-control" name="popup_image" id="popup_image"
                                        accept="image/*" required>
                                    <div id="img-preview">
                                        <a href="" id="imglink" data-lightbox="uploaded-image-1"
                                            data-title="Selected Image"><img id="img" class="img-fluid ml-2"
                                                width="40" height="40"
                                                src="{{ asset('/backend/assets/img/no-image.jpg') }}" /></a>
                                    </div>
                                </div>
                                @error('popup_image')
                                    <div class="text-danger">{{ $errors->first('popup_image') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-warning custom-orange-button mr-3 px-3"
                                    id="save">Save</button>
                                <a href="{{ route('popup') }}" class="btn btn-dark px-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12 mb-4">
            <div class="h5 page-main-heading">Popup List</div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tablePopup">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Popup Image</th>
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
    <script src="{{ asset('backend/assets/js/admin/master/popup.js') }}"></script>
@endsection
@endsection
