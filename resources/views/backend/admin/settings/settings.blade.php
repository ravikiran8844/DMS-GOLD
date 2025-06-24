@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Profile - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="section-body">
        <!-- add content here -->
        <div class="row settings-page">
            <div class="col-12 mb-4">
                <div class="h2 page-main-heading">Admin Settings</div>
            </div>
            <div class="col-12 mb-5">
                <div class="card p-3 py-4 h-100 m-auto">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <div>
                            <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.65232 0C8.72219 0 7.95402 0.768247 7.95402 1.69837V2.32569C7.45954 2.47955 6.98018 2.6779 6.52154 2.9184L6.07876 2.47561C5.42083 1.81768 4.33422 1.81768 3.6763 2.47561L2.47554 3.67637C1.81764 4.33429 1.81764 5.4209 2.47554 6.0788L2.91835 6.52161C2.67786 6.98025 2.47953 7.45956 2.32562 7.95402H1.6983C0.768177 7.95402 0 8.72227 0 9.65237V11.3519C0 12.282 0.768177 13.0502 1.6983 13.0502H2.32562C2.47948 13.5447 2.67786 14.024 2.91835 14.4826L2.47554 14.9254C1.81764 15.5834 1.81764 16.67 2.47554 17.3279L3.6763 18.5286C4.33422 19.1866 5.42083 19.1866 6.07876 18.5286L6.52154 18.0859C6.98018 18.3263 7.45954 18.5247 7.95402 18.6786V19.3059C7.95402 20.236 8.72219 21.0042 9.65232 21.0042H11.3519C12.282 21.0042 13.0502 20.236 13.0502 19.3059V18.6786C13.5446 18.5247 14.0239 18.3263 14.4826 18.0859L14.9254 18.5286C15.5833 19.1866 16.67 19.1866 17.3279 18.5286L18.5286 17.3279C19.1865 16.67 19.1865 15.5834 18.5286 14.9254L18.0858 14.4826C18.3263 14.024 18.5246 13.5447 18.6786 13.0502H19.3059C20.236 13.0502 21.0042 12.282 21.0042 11.3519V9.65237C21.0042 8.72227 20.236 7.95402 19.3059 7.95402H18.6822C18.5279 7.45879 18.329 6.97878 18.0879 6.51953L18.5286 6.0788C19.1865 5.42088 19.1865 4.33429 18.5286 3.67637L17.3279 2.47561C16.67 1.81768 15.5833 1.81768 14.9254 2.47561L14.4847 2.91632C14.0254 2.67517 13.5454 2.47629 13.0502 2.32197V1.69837C13.0502 0.768247 12.282 0 11.3519 0H9.65232ZM9.65232 1.23557H11.3519C11.6196 1.23557 11.8147 1.43054 11.8147 1.69837V2.78846C11.8147 2.92619 11.8607 3.05997 11.9454 3.16855C12.0302 3.27712 12.1488 3.35427 12.2824 3.38773C12.9832 3.56308 13.6543 3.84121 14.2739 4.21283C14.392 4.28368 14.5304 4.31302 14.6672 4.29618C14.8039 4.27934 14.931 4.2173 15.0285 4.1199L15.7991 3.3493C15.9882 3.16017 16.2651 3.16017 16.4542 3.3493L17.6549 4.55001C17.8441 4.73914 17.8441 5.01608 17.6549 5.2052L16.8844 5.97579C16.787 6.0732 16.7249 6.20037 16.7081 6.33708C16.6913 6.4738 16.7206 6.61222 16.7914 6.73035C17.163 7.34991 17.4411 8.02101 17.6165 8.72184C17.65 8.85546 17.7271 8.97406 17.8357 9.05881C17.9443 9.14356 18.0781 9.1896 18.2158 9.18962H19.3059C19.5737 9.18962 19.7687 9.38458 19.7687 9.65239V11.3519C19.7687 11.6197 19.5737 11.8147 19.3059 11.8147H18.212C18.0742 11.8147 17.9404 11.8608 17.8318 11.9456C17.7232 12.0303 17.6461 12.149 17.6126 12.2826C17.4375 12.9828 17.1601 13.6533 16.7893 14.2724C16.7186 14.3905 16.6893 14.5289 16.7062 14.6655C16.7231 14.8022 16.7851 14.9293 16.8825 15.0266L17.6549 15.7992C17.8441 15.9883 17.8441 16.2652 17.6549 16.4543L16.4542 17.655C16.2651 17.8442 15.9882 17.8442 15.7991 17.655L15.0265 16.8825C14.9292 16.7852 14.8021 16.7231 14.6654 16.7063C14.5288 16.6894 14.3904 16.7186 14.2723 16.7894C13.6532 17.1602 12.9827 17.4376 12.2825 17.6127C12.1489 17.6461 12.0303 17.7233 11.9455 17.8319C11.8607 17.9405 11.8147 18.0743 11.8147 18.212V19.3059C11.8147 19.5737 11.6197 19.7687 11.3519 19.7687H9.65232C9.38455 19.7687 9.18952 19.5737 9.18952 19.3059V18.212C9.18951 18.0743 9.14346 17.9405 9.05869 17.8319C8.97391 17.7233 8.85528 17.6461 8.72163 17.6127C8.0215 17.4376 7.35101 17.1602 6.73189 16.7894C6.61376 16.7186 6.47539 16.6894 6.33874 16.7063C6.20209 16.7231 6.075 16.7852 5.97763 16.8825L5.20511 17.655C5.01599 17.8442 4.73907 17.8442 4.54994 17.655L3.34923 16.4543C3.1601 16.2652 3.1601 15.9883 3.34923 15.7992L4.12175 15.0266C4.2191 14.9293 4.28114 14.8022 4.29802 14.6655C4.3149 14.5289 4.28565 14.3905 4.21491 14.2724C3.84406 13.6533 3.56665 12.9828 3.39161 12.2826C3.35818 12.149 3.28105 12.0303 3.17246 11.9456C3.06387 11.8608 2.93006 11.8147 2.79229 11.8147H1.69835C1.43058 11.8147 1.23557 11.6197 1.23557 11.3519V9.65239C1.23557 9.38463 1.43054 9.18962 1.69835 9.18962H2.79229C2.93006 9.1896 3.06387 9.14355 3.17246 9.05876C3.28105 8.97398 3.35818 8.85533 3.39161 8.72168C3.56672 8.02154 3.84406 7.3511 4.21491 6.73199C4.28565 6.61386 4.31491 6.47548 4.29803 6.33882C4.28115 6.20217 4.21911 6.07507 4.12175 5.9777L3.34923 5.2052C3.1601 5.01608 3.1601 4.73914 3.34923 4.55001L4.54994 3.3493C4.73907 3.16017 5.01599 3.16017 5.20511 3.3493L5.97763 4.12182C6.075 4.21917 6.20209 4.28121 6.33874 4.29809C6.47539 4.31497 6.61376 4.28572 6.73189 4.21498C7.35101 3.84413 8.0215 3.56672 8.72163 3.39165C8.85528 3.35822 8.97391 3.28108 9.05869 3.17249C9.14346 3.0639 9.18951 2.9301 9.18952 2.79234V1.69842C9.18952 1.43063 9.38448 1.23557 9.65232 1.23557ZM10.5021 5.21574C7.58982 5.21574 5.21571 7.58987 5.21571 10.5021C5.21571 13.4144 7.58982 15.7885 10.5021 15.7885C13.4144 15.7885 15.7885 13.4144 15.7885 10.5021C15.7885 7.58987 13.4144 5.21574 10.5021 5.21574ZM10.5021 6.45129C12.7466 6.45129 14.553 8.25762 14.553 10.5021C14.553 12.7467 12.7466 14.553 10.5021 14.553C8.25755 14.553 6.45124 12.7467 6.45124 10.5021C6.45124 8.25762 8.25755 6.45129 10.5021 6.45129Z"
                                    fill="#BEBEBE" />
                            </svg>
                        </div>
                        <div>
                            Maintanance Mode
                        </div>
                        <form action="{{ route('settingstore') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="pretty p-switch p-fill">
                                <input type="checkbox" name="is_maintanance_mode" id="is_maintanance_mode"
                                    @if (isset($setting)) {{ $setting->is_maintanance_mode == 1 ? 'checked' : '' }} @endif>
                                <div class="state">
                                    <label></label>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <ul class="nav nav-pills" id="myTab3" role="tablist" style="gap: 10px;">
                    <li class="nav-item">
                        <a class="nav-link active" id="Admin-tab3" data-toggle="tab" href="#Admin3" role="tab"
                            aria-controls="Admin" aria-selected="true"><i class="fas fa-user"></i> Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Order-tab3" data-toggle="tab" href="#Order3" role="tab"
                            aria-controls="Order" aria-selected="false"><i class="fab fa-empire"></i> Order No</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent2">
                    <input type="hidden" name="settingId" id="settingId" value="{{ isset($setting) ? 1 : null }}">
                    <input type="hidden" name="logo" id="logo"
                        value="{{ isset($setting->company_logo) ? $setting->company_logo : '' }}">
                    <div class="tab-pane fade show active" id="Admin3" role="tabpanel" aria-labelledby="Admin-tab3">
                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                        <label class="form-label" for="otp-length">OTP Length<span
                                                class="text-danger">*</span></label>
                                        <input id="otp_length" class="form-control" type="text" name="otp_length"
                                            placeholder="OTP Length"
                                            value="{{ isset($setting->otp_length) ? $setting->otp_length : '' }}">
                                        @error('otp_length')
                                            <div class="text-danger">{{ $errors->first('otp_length') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                        <label class="form-label" for="otp-expiry">OTP Expiry Duration
                                            <sup class="text-muted">(mins)</sup><span
                                                class="text-danger">*</span></label>
                                        <input id="otp_expiry_duration" class="form-control" type="text"
                                            name="otp_expiry_duration" placeholder="OTP Expiry Duration"
                                            value="{{ isset($setting->otp_expiry_duration) ? $setting->otp_expiry_duration : '' }}">
                                        @error('otp_expiry_duration')
                                            <div class="text-danger">{{ $errors->first('otp_expiry_duration') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6 mb-4 mb-lg-0">
                                        <label class="form-label" for="company-logo">Company Logo<span
                                                class="text-danger">*</span></label>
                                        <div class="d-flex" style="gap:20px">
                                            <div class="custom-file">
                                                <input id="company_logo" name="company_logo" type="file"
                                                    class="custom-file-input" accept="image/*"
                                                    onchange="previewImage(event)">
                                                @error('company_logo')
                                                    <div class="text-danger">{{ $errors->first('company_logo') }}
                                                    </div>
                                                @enderror
                                                <label class="custom-file-label" id="file-label"
                                                    for="customFile">Choose
                                                    file</label>
                                            </div>
                                            <div>
                                                <img class="img-fluid" id="preview"
                                                    src="{{ isset($setting->company_logo) ? asset($setting->company_logo) : asset('backend/assets/img/logo.png') }}"
                                                    width="60" height="60" alt="logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-pills" id="myTab3" role="tablist" style="gap: 10px;">
                            <li class="nav-item">
                                <a class="nav-link active" id="East-Zone-tab3" data-toggle="tab" href="#East-Zone3"
                                    role="tab" aria-controls="East-Zone" aria-selected="true">East Zone</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="West-Zone-tab3" data-toggle="tab" href="#West-Zone3"
                                    role="tab" aria-controls="West-Zone" aria-selected="false">West Zone</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="North-Zone-tab3" data-toggle="tab" href="#North-Zone3"
                                    role="tab" aria-controls="North-Zone" aria-selected="false">North
                                    Zone</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="South-Zone-tab3" data-toggle="tab" href="#South-Zone3"
                                    role="tab" aria-controls="South-Zone" aria-selected="false">South
                                    Zone</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="East-Zone3" role="tabpanel"
                                aria-labelledby="East-Zone-tab3">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="east_zone_name" class="form-control" type="text"
                                                    value="{{ isset($setting->east_zone_name) ? $setting->east_zone_name : '' }}"
                                                    name="east_zone_name" placeholder="Zone Name">
                                                @error('east_zone_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('east_zone_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="east_zone_incharge_name" class="form-control"
                                                    type="text" name="east_zone_incharge_name"
                                                    placeholder="Incharge Name"
                                                    value="{{ isset($setting->east_zone_incharge_name) ? $setting->east_zone_incharge_name : '' }}">
                                                @error('east_zone_incharge_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('east_zone_incharge_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Mobile
                                                    No<span class="text-danger">*</span></label>
                                                <input id="east_zone_mobile_no" class="form-control" type="text"
                                                    name="east_zone_mobile_no" placeholder="Incharge Mobile No"
                                                    value="{{ isset($setting->east_zone_mobile_no) ? $setting->east_zone_mobile_no : '' }}">
                                                @error('east_zone_mobile_no')
                                                    <div class="text-danger">
                                                        {{ $errors->first('east_zone_mobile_no') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Email<span
                                                        class="text-danger">*</span></label>
                                                <input id="east_zone_incharge_email" class="form-control"
                                                    type="text" name="east_zone_incharge_email"
                                                    placeholder="Incharge Email"
                                                    value="{{ isset($setting->east_zone_incharge_email) ? $setting->east_zone_incharge_email : '' }}">
                                                @error('east_zone_incharge_email')
                                                    <div class="text-danger">
                                                        {{ $errors->first('east_zone_incharge_email') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="West-Zone3" role="tabpanel"
                                aria-labelledby="West-Zone-tab3">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="west_zone_name" class="form-control" type="text"
                                                    value="{{ isset($setting->west_zone_name) ? $setting->west_zone_name : '' }}"
                                                    name="west_zone_name" placeholder="Zone Name">
                                                @error('west_zone_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('west_zone_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="west_zone_incharge_name" class="form-control"
                                                    type="text" name="west_zone_incharge_name"
                                                    placeholder="Incharge Name"
                                                    value="{{ isset($setting->west_zone_incharge_name) ? $setting->west_zone_incharge_name : '' }}">
                                                @error('west_zone_incharge_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('west_zone_incharge_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Mobile
                                                    No<span class="text-danger">*</span></label>
                                                <input id="west_zone_mobile_no" class="form-control" type="text"
                                                    name="west_zone_mobile_no" placeholder="Incharge Mobile No"
                                                    value="{{ isset($setting->west_zone_mobile_no) ? $setting->west_zone_mobile_no : '' }}">
                                                @error('west_zone_mobile_no')
                                                    <div class="text-danger">
                                                        {{ $errors->first('west_zone_mobile_no') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Email<span
                                                        class="text-danger">*</span></label>
                                                <input id="west_zone_incharge_email" class="form-control"
                                                    type="text" name="west_zone_incharge_email"
                                                    placeholder="Incharge Email"
                                                    value="{{ isset($setting->west_zone_incharge_email) ? $setting->west_zone_incharge_email : '' }}">
                                                @error('west_zone_incharge_email')
                                                    <div class="text-danger">
                                                        {{ $errors->first('west_zone_incharge_email') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="North-Zone3" role="tabpanel"
                                aria-labelledby="North-Zone-tab3">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="north_zone_name" class="form-control" type="text"
                                                    value="{{ isset($setting->north_zone_name) ? $setting->north_zone_name : '' }}"
                                                    name="north_zone_name" placeholder="Zone Name">
                                                @error('north_zone_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="north_zone_incharge_name" class="form-control"
                                                    type="text" name="north_zone_incharge_name"
                                                    placeholder="Incharge Name"
                                                    value="{{ isset($setting->north_zone_incharge_name) ? $setting->north_zone_incharge_name : '' }}">
                                                @error('north_zone_incharge_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_incharge_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Mobile
                                                    No<span class="text-danger">*</span></label>
                                                <input id="north_zone_mobile_no" class="form-control" type="text"
                                                    name="north_zone_mobile_no" placeholder="Incharge Mobile No"
                                                    value="{{ isset($setting->north_zone_mobile_no) ? $setting->north_zone_mobile_no : '' }}">
                                                @error('north_zone_mobile_no')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_mobile_no') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Email<span
                                                        class="text-danger">*</span></label>
                                                <input id="north_zone_incharge_email" class="form-control"
                                                    type="text" name="north_zone_incharge_email"
                                                    placeholder="Incharge Email"
                                                    value="{{ isset($setting->north_zone_incharge_email) ? $setting->north_zone_incharge_email : '' }}">
                                                @error('north_zone_incharge_email')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_incharge_email') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="north_zone_name1" class="form-control" type="text"
                                                    value="{{ isset($setting->north_zone_name1) ? $setting->north_zone_name1 : '' }}"
                                                    name="north_zone_name1" placeholder="Zone Name">
                                                @error('north_zone_name1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_name1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="north_zone_incharge_name1" class="form-control"
                                                    type="text" name="north_zone_incharge_name1"
                                                    placeholder="Incharge Name"
                                                    value="{{ isset($setting->north_zone_incharge_name1) ? $setting->north_zone_incharge_name1 : '' }}">
                                                @error('north_zone_incharge_name1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_incharge_name1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Mobile
                                                    No<span class="text-danger">*</span></label>
                                                <input id="north_zone_mobile_no1" class="form-control" type="text"
                                                    name="north_zone_mobile_no1" placeholder="Incharge Mobile No"
                                                    value="{{ isset($setting->north_zone_mobile_no1) ? $setting->north_zone_mobile_no1 : '' }}">
                                                @error('north_zone_mobile_no1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_mobile_no1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Email<span
                                                        class="text-danger">*</span></label>
                                                <input id="north_zone_incharge_email1" class="form-control"
                                                    type="text" name="north_zone_incharge_email1"
                                                    placeholder="Incharge Email"
                                                    value="{{ isset($setting->north_zone_incharge_email1) ? $setting->north_zone_incharge_email1 : '' }}">
                                                @error('north_zone_incharge_email1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('north_zone_incharge_email1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="South-Zone3" role="tabpanel"
                                aria-labelledby="South-Zone-tab3">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="south_zone_name" class="form-control" type="text"
                                                    name="south_zone_name" placeholder="Zone Name"
                                                    value="{{ isset($setting->south_zone_name) ? $setting->south_zone_name : '' }}">
                                                @error('south_zone_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="south_zone_incharge_name" class="form-control"
                                                    type="text" name="south_zone_incharge_name"
                                                    placeholder="Incharge Name"
                                                    value="{{ isset($setting->south_zone_incharge_name) ? $setting->south_zone_incharge_name : '' }}">
                                                @error('south_zone_incharge_name')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_incharge_name') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Mobile
                                                    No<span class="text-danger">*</span></label>
                                                <input id="south_zone_mobile_no" class="form-control" type="text"
                                                    name="south_zone_mobile_no" placeholder="Incharge Mobile No"
                                                    value="{{ isset($setting->south_zone_mobile_no) ? $setting->south_zone_mobile_no : '' }}">
                                                @error('south_zone_mobile_no')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_mobile_no') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Email<span
                                                        class="text-danger">*</span></label>
                                                <input id="south_zone_incharge_email" class="form-control"
                                                    type="text" name="south_zone_incharge_email"
                                                    placeholder="Incharge Email"
                                                    value="{{ isset($setting->south_zone_incharge_email) ? $setting->south_zone_incharge_email : '' }}">
                                                @error('south_zone_incharge_email')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_incharge_email') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="south_zone_name1" class="form-control" type="text"
                                                    name="south_zone_name1" placeholder="Zone Name"
                                                    value="{{ isset($setting->south_zone_name1) ? $setting->south_zone_name1 : '' }}">
                                                @error('south_zone_name1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_name1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Name<span
                                                        class="text-danger">*</span></label>
                                                <input id="south_zone_incharge_name1" class="form-control"
                                                    type="text" name="south_zone_incharge_name1"
                                                    placeholder="Incharge Name"
                                                    value="{{ isset($setting->south_zone_incharge_name1) ? $setting->south_zone_incharge_name1 : '' }}">
                                                @error('south_zone_incharge_name1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_incharge_name1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Mobile
                                                    No<span class="text-danger">*</span></label>
                                                <input id="south_zone_mobile_no1" class="form-control" type="text"
                                                    name="south_zone_mobile_no1" placeholder="Incharge Mobile No"
                                                    value="{{ isset($setting->south_zone_mobile_no1) ? $setting->south_zone_mobile_no1 : '' }}">
                                                @error('south_zone_mobile_no1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_mobile_no1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                                                <label class="form-label" for="">Zone Incharge Email<span
                                                        class="text-danger">*</span></label>
                                                <input id="south_zone_incharge_email1" class="form-control"
                                                    type="text" name="south_zone_incharge_email1"
                                                    placeholder="Incharge Email"
                                                    value="{{ isset($setting->south_zone_incharge_email1) ? $setting->south_zone_incharge_email1 : '' }}">
                                                @error('south_zone_incharge_email1')
                                                    <div class="text-danger">
                                                        {{ $errors->first('south_zone_incharge_email1') }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center bt-5">
                            <button class="btn custom-orange-button px-4">Save</button>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="Order3" role="tabpanel" aria-labelledby="Order-tab3">
                        <form action="{{ route('ordersettingstore') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card mt-4">
                                <div class="card-body">
                                    <input type="hidden" name="orderId" id="orderId"
                                        value="{{ isset($data) ? 1 : null }}">
                                    <div class="row">
                                        <div class="col-12 col-lg-2 mb-4 mb-lg-0 d-flex align-items-center">
                                            <div class="select-zones__tab-item-title">Order</div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                            <label class="form-label" for="">Prefix<span
                                                    class="text-danger">*</span></label>
                                            <input id="prefix" class="form-control" type="text" name="prefix"
                                                placeholder="Prefix" value="{{ isset($data) ? $data->prefix : '' }}">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                            <label class="form-label" for="">Length<span
                                                    class="text-danger">*</span></label>
                                            <input id="length" class="form-control" type="text" name="length"
                                                placeholder="Length" value="{{ isset($data) ? $data->length : '' }}">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                            <label class="form-label" for="">Live<span
                                                    class="text-danger">*</span></label>
                                            <input id="live" class="form-control" type="text" name="live"
                                                placeholder="Live" value="{{ isset($data) ? $data->live : '' }}"
                                                disabled>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg mb-4 mb-lg-0">
                                            <label class="form-label" for="">Example<span
                                                    class="text-danger">*</span></label>
                                            <div><strong>{{ $example }}</strong></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn custom-orange-button px-4">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('scripts')
    <script>
        function previewImage(event) {
            const input = event.target;
            const img = document.getElementById("preview");
            const label = document.getElementById("file-label");

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    img.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);

                // Update label text with the selected file name
                label.textContent = input.files[0].name;
            } else {
                // If no file is selected, reset label text
                label.textContent = "Choose file";
            }
        }
    </script>
@endsection
@endsection
