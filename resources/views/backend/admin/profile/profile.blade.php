@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Profile - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="section-body">
        <form action="{{ route('profileupdate') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="userImage" id="userImage" value="{{ $user->image }}">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="h2 page-main-heading">My Profile</div>
                </div>
                <div class="col-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between  flex-column flex-sm-row align-items-center">
                                <div class="d-flex align-items-center flex-column flex-sm-row">
                                    <div class="mr-3">
                                        <div
                                            class="profile-page_img-wrapper d-flex justify-content-center align-items-center">
                                            <img id="user-profile-img" class="img-fluid rounded-5"
                                                src="{{ $user->user_image ? asset($user->user_image) : asset('backend/assets/img/user-profile.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="h3 fw-bold text-dark">{{ $user->name }}</div>
                                        <div>{{ strtoupper($user->role_name) }}</div>
                                    </div>
                                </div>
                                <div>
                                    <input id="profile-phone-edit-input" class="d-none" name="user_image" type="file"
                                        accept="image/*">
                                    <label for="profile-phone-edit-input" class="edit-btn">
                                        Edit Photo <span class="ml-1">
                                            <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.0629 9.88692C9.0629 10.518 8.54538 11.0356 7.91426 11.0356H2.10794C1.47682 11.0356 0.959304 10.518 0.959304 9.88692V4.0806C0.959304 3.44948 1.47682 2.93196 2.10794 2.93196H4.96061L5.91992 1.97266H2.10794C0.946682 1.97266 0 2.91934 0 4.0806V9.89954C0 11.0608 0.946682 12.0075 2.10794 12.0075H7.92688C9.08815 12.0075 10.0348 11.0608 10.0348 9.89954V6.08757L9.07552 7.04687V9.88692H9.0629Z"
                                                    fill="#7E7E7E" />
                                                <path
                                                    d="M3.5849 5.64552C3.4713 5.75912 3.40819 5.89797 3.39557 6.04944L3.19361 8.47294C3.18098 8.64966 3.33245 8.80112 3.50917 8.7885L5.93267 8.58654C6.08414 8.57392 6.23561 8.51081 6.33659 8.39721L10.2243 4.5095L7.48523 1.75781L3.5849 5.64552Z"
                                                    fill="#7E7E7E" />
                                                <path
                                                    d="M11.8523 2.23732L9.75703 0.142002C9.56769 -0.0473341 9.27738 -0.0473341 9.08804 0.142002L8.14136 1.08868L10.893 3.84037L11.8397 2.89369C12.0417 2.71698 12.0417 2.41404 11.8523 2.23732Z"
                                                    fill="#7E7E7E" />
                                            </svg>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="personal-information" class="col-12 mb-2">
                    <div class="card">
                        <div class="card-header py-4">
                            <div class="h3 fw-bold text-dark">Personal Information</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label class="form-label h6 text-dark" for="email-address">Email
                                                    address</label>
                                                <input class="form-control" type="email" name="email"
                                                    id="email-address" readonly disabled value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label class="form-label h6 text-dark" for="phone">Phone</label>
                                                <input class="form-control" type="text" name="mobile" id="phone"
                                                    readonly disabled value="{{ $user->mobile }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label class="form-label h6 text-dark" for="first-name">
                                                    Name</label>
                                                <input class="form-control" type="text" name="name"
                                                    id="first-name" disabled value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-4">
                                                <label class="form-label h6 text-dark" for="Admin">Bio</label>
                                                <input class="form-control" type="text" name="bio" id="Admin"
                                                    disabled value="{{ $user->bio }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 mt-2">
                                    <div class="ml-auto ">
                                        <button id="personalinfoedit" type="button" class="edit-btn">Edit <span
                                                class="ml-1">
                                                <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.0629 9.88692C9.0629 10.518 8.54538 11.0356 7.91426 11.0356H2.10794C1.47682 11.0356 0.959304 10.518 0.959304 9.88692V4.0806C0.959304 3.44948 1.47682 2.93196 2.10794 2.93196H4.96061L5.91992 1.97266H2.10794C0.946682 1.97266 0 2.91934 0 4.0806V9.89954C0 11.0608 0.946682 12.0075 2.10794 12.0075H7.92688C9.08815 12.0075 10.0348 11.0608 10.0348 9.89954V6.08757L9.07552 7.04687V9.88692H9.0629Z"
                                                        fill="#7E7E7E" />
                                                    <path
                                                        d="M3.5849 5.64552C3.4713 5.75912 3.40819 5.89797 3.39557 6.04944L3.19361 8.47294C3.18098 8.64966 3.33245 8.80112 3.50917 8.7885L5.93267 8.58654C6.08414 8.57392 6.23561 8.51081 6.33659 8.39721L10.2243 4.5095L7.48523 1.75781L3.5849 5.64552Z"
                                                        fill="#7E7E7E" />
                                                    <path
                                                        d="M11.8523 2.23732L9.75703 0.142002C9.56769 -0.0473341 9.27738 -0.0473341 9.08804 0.142002L8.14136 1.08868L10.893 3.84037L11.8397 2.89369C12.0417 2.71698 12.0417 2.41404 11.8523 2.23732Z"
                                                        fill="#7E7E7E" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn custom-orange-button">Update</button>
            </div>
        </form>
    </div>
    </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#personalinfoedit").click(function() {
        $("#personal-information input").attr("disabled", false);
    })

    // Get references to the input and image elements
    const $inputElement = $('#profile-phone-edit-input');
    const $imageElement = $('#user-profile-img');

    // Add an event listener to the input element for the 'change' event
    $inputElement.on('change', function() {
        // Check if a file was selected
        if ($inputElement[0].files.length > 0) {
            // Get the selected file
            const selectedFile = $inputElement[0].files[0];

            // Create a FileReader to read the selected file
            const reader = new FileReader();

            // Define a function to execute when the FileReader has loaded the file
            reader.onload = function(e) {
                // Set the 'src' attribute of the image element to the data URL of the selected file
                $imageElement.attr('src', e.target.result);
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(selectedFile);
        }
    });
</script>
@endsection
