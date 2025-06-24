@extends('dealer.layout.dealermaster')
@section('content')
@section('title')
Profile Page - Emerald DMS
@endsection
<main class="myaccount-page">
    <section class="container">
        <div class="row pt-4 pt-lg-5 pb-5">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3 col-xxl-2">
                        <div class="nav flex-row flex-md-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" href="{{ route('myprofile') }}">My Profile</a>
                            <a class="nav-link" href="{{ route('orders') }}">Orders</a>
                            <a class="nav-link d-none d-md-inline" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 col-lg-9 col-xxl-10 mt-4 mt-md-0">
                        <div class="row custom-card">
                            <div class="col-12">
                                <form action="{{ route('profileupdate') }}" enctype="multipart/form-data"
                                    id="profileForm" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                                            <div class="h2 page-main-title mb-0">My Profile</div>

                                            <div>
                                            <a class="d-md-none btn btn-outline-dark" href="{{ route('logout') }}" style=" border: 1px solid #6C6C6C !important; border-radius: 6px !important; "><svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.22517 3.5H7.68764V2H1.53753V17H7.68764V15.5H9.22517V17C9.22517 17.8284 8.53679 18.5 7.68764 18.5H1.53753C0.688372 18.5 0 17.8284 0 17V2C0 1.17157 0.688372 0.5 1.53753 0.5H7.68764C8.53679 0.5 9.22517 1.17157 9.22517 2V3.5ZM15.0568 8.75L11.7566 5.53033L12.8438 4.46967L18 9.5L12.8438 14.5303L11.7566 13.4697L15.0568 10.25H6.15011V8.75H15.0568Z" fill="#6C6C6C"/>
                                                </svg>
                                                Logout</a>
                                            </div>
                                        </div>
                                        <div id="dealer-profile" class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-9">
                                                            <div
                                                                class="d-flex align-items-center flex-column flex-sm-row">
                                                                <div class="mr-3">
                                                                    <div
                                                                        class="profile-page_img-wrapper d-flex justify-content-center align-items-center">
                                                                        <input name="user_image"
                                                                            id="profile-photo-edit-input" class="d-none"
                                                                            type="file" accept="image/*" disabled>

                                                                        <label for="profile-photo-edit-input">
                                                                            <img id="user-profile-img" width="100"
                                                                                height="100"
                                                                                class="img-fluid rounded-5"
                                                                                src="{{ Auth::user()->user_image == null ? asset('no-profile.jpg') : asset(Auth::user()->user_image) }}"
                                                                                alt="user photo">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 my-4 my-md-0">
                                                                    <input class="form-control mb-3" type="text"
                                                                        name="shop_name" id="dealer-name" disabled
                                                                        value="{{ Auth::user()->shop_name == null ? 'no-shop-name' : Auth::user()->shop_name }}">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-3">
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" id="dealer-profile-edit"
                                                                    class="edit-btn">Edit
                                                                    <span class="ml-1">
                                                                        <svg width="12" height="13"
                                                                            viewBox="0 0 12 13" fill="none"
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
                                        <div id="personal-information" class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header pt-4">
                                                    <div class="h3 fw-bold text-dark">Personal Information</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-9">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="name">Name</label>
                                                                        <input class="form-control" type="text"
                                                                            name="name" id="first-name" disabled
                                                                            value="{{ Auth::user()->name }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="email-address">Email address</label>
                                                                        <input class="form-control" type="email"
                                                                            name="email" id="email-address" disabled
                                                                            readonly value="{{ Auth::user()->email }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="phone">Phone</label>
                                                                        <input class="form-control" type="text"
                                                                            name="phone" id="phone" disabled
                                                                            readonly
                                                                            value="{{ Auth::user()->mobile }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="gst">GST</label>
                                                                        <input class="form-control" type="text"
                                                                            name="gst" id="gst" disabled
                                                                            value="{{ Auth::user()->GST }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="preferred_dealer3">Preferred Dealers
                                                                        </label>
                                                                        <input class="form-control" type="text"
                                                                            readonly disabled
                                                                            value="{{ $user->dealer_details }}">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-3 mt-2">
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" id="personal-info-edit"
                                                                    class="edit-btn">Edit
                                                                    <span class="ml-1">
                                                                        <svg width="12" height="13"
                                                                            viewBox="0 0 12 13" fill="none"
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

                                        <div id="address-information" class="col-12 mb-4">
                                            <div class="card">
                                                <div class="card-header pt-4">
                                                    <div class="h3 fw-bold text-dark">Address</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-9">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="country">Address</label>
                                                                        <input class="form-control" type="text"
                                                                            name="address" id="country" disabled
                                                                            value="{{ Auth::user()->address != null ? Auth::user()->address : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="pincode">Pincode</label>
                                                                        <input class="form-control" type="text"
                                                                            name="pincode" id="pincode" disabled
                                                                            value="{{ Auth::user()->pincode != null ? Auth::user()->pincode : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="district">District</label>
                                                                        <input class="form-control" type="text"
                                                                            name="district" id="district" disabled
                                                                            value="{{ Auth::user()->district != null ? Auth::user()->district : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="mb-4">
                                                                        <label class="form-label h6 text-dark"
                                                                            for="state">State</label>
                                                                        <input class="form-control" type="text"
                                                                            name="state" id="state" disabled
                                                                            value="{{ Auth::user()->state != null ? Auth::user()->state : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-3 mt-2">
                                                            <div class="d-flex justify-content-end">
                                                                <button type="button" id="address-info-edit"
                                                                    class="edit-btn">Edit
                                                                    <span class="ml-1">
                                                                        <svg width="12" height="13"
                                                                            viewBox="0 0 12 13" fill="none"
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
                                        <div class="col-12 mb-5">
                                            <button type="submit" class="btn btn-warning px-4"
                                                id="saveButton">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- End Col -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('scripts')
<script>
    $("#dealer-profile-edit").click(function() {
        $("#dealer-profile input").attr("disabled", false);
    })

    $("#personal-info-edit").click(function() {
        $("#personal-information input").attr("disabled", false);
    })

    $("#address-info-edit").click(function() {
        $("#address-information input").attr("disabled", false);
    })

    // Get references to the input and image elements
    const $inputElement = $('#profile-photo-edit-input');
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

    $(document).ready(function() {
        $("#saveButton").on("click", function() {
            $(this).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );
            setTimeout(function() {
                $("#saveButton").html("Save");
            }, 2000);
        });
    });

    $("#pincode").on("keyup", function() {
        var pincode = $(this).val();
        if (pincode.length === 6) {
            getstatecity(pincode);
        }
    });

    function getstatecity(pincode) {
        $.ajax({
            url: "/proxy-pincode/" + pincode,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (
                    result &&
                    result[0] &&
                    result[0].PostOffice &&
                    result[0].PostOffice[0]
                ) {
                    var postOffice = result[0].PostOffice[0];
                    $("#district").val(postOffice.District);
                    $("#state").val(postOffice.State);
                } else {
                    toastr.error("no state and city found");
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1500,
                    };
                    $("#district").val('');
                    $("#state").val('');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            },
        });
    }
</script>
@endsection
