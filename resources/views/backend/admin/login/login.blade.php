<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | DMS Dashboard</title>
    <meta name="description" content="Some description for the page" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/assets/img/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/custom.css') }}" rel="stylesheet">
    <!-- TOASTER -->
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/izitoast/css/iziToast.min.css') }}">
</head>

<body>
    <main class="dms_login_page d-flex align-items-center">
        <div class="container py-5">
            <div class="col-12 col-md-7 m-auto">
                <div class="text-center mb-5">
                    <img class="img-fluid" src="{{ asset('backend/assets/img/logo.png') }}" height="122"
                        width="160" alt="">
                </div>
                <div>
                    <div class="dms_login_page_title mb-4 ">ENTER YOUR REGISTERED MOBILE NUMBER</div>
                    <div class="dms_login_page_text mb-5">An OTP will be sent to the registered number</div>
                </div>
                <div>
                    <form action="{{ route('admingenerateotp') }}" method="get">
                        @csrf
                        <div class="dms_login_page_input-item m-auto">
                            <hr>
                            <div class="mb-2 dms_login_page_input-item-text mt-4">Phone Number</div>
                            <div class="input-group dms_login_page_input-group">
                                <div class="input-group-prepend">
                                    <span class="bg-transparent border-0  input-group-text h-100"
                                        id="inputGroupPrepend2">
                                        <svg width="10" height="17" viewBox="0 0 10 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9.66012 1.1217C9.65985 0.824351 9.54153 0.53926 9.33127 0.328986C9.12087 0.118591 8.83577 0.000403181 8.53841 0H1.45276C1.15541 0.000403836 0.870318 0.118591 0.659906 0.328986C0.449645 0.539247 0.331323 0.824347 0.331055 1.1217V12.979H9.66005L9.66012 1.1217Z"
                                                fill="#535353" />
                                            <path
                                                d="M1.45294 16.4603H8.53859C8.83594 16.4599 9.12103 16.3417 9.33144 16.1313C9.54171 15.921 9.66003 15.6359 9.6603 15.3386V13.6445H0.331299V15.3386C0.331568 15.6359 0.449889 15.921 0.66015 16.1313C0.870545 16.3417 1.15565 16.4599 1.453 16.4603H1.45294ZM4.19626 14.5546H5.79513C5.97887 14.5546 6.12775 14.7035 6.12775 14.8872C6.12775 15.071 5.97887 15.22 5.79513 15.22H4.19626C4.01252 15.22 3.86364 15.071 3.86364 14.8872C3.86364 14.7035 4.01252 14.5546 4.19626 14.5546Z"
                                                fill="#535353" />
                                        </svg>
                                    </span>
                                </div>
                                <input type="text" class="login-phone-input form-control border-0  bg-transparent"
                                    id="validationDefaultUsername" name="mobile" placeholder="Enter phone number"
                                    maxlength="10" style="border: none !important;" required>
                            </div>
                            <button class="spinner-button1 mt-5 btn dms_login_page_button w-100 py-3">

                                <span>Continue</span> <span class="d-none spinner">
                                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                    <span role="status">Loading...</span>
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- TOASTER -->
    <script src="{{ asset('backend/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/toastr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert', 'info') }}";
            var message = "{{ Session::get('message') }}";

            function showToast(type, message, color, icon) {
                iziToast.show({
                    message: message,
                    icon: icon,
                    timeout: 1500,
                    layout: 2,
                    close: true,
                    color: color,
                    position: "topRight",
                    progressBarColor: color,
                    onOpening: function() {},
                    onClosing: function() {},
                });
            }

            switch (type) {
                case 'info':
                    showToast(type, message, "blue", "ico-info");
                    break;
                case 'success':
                    showToast(type, message, "green", "ico-success");
                    break;
                case 'warning':
                    showToast(type, message, "orange", "ico-warning");
                    break;
                case 'error':
                    showToast(type, message, "red", "ico-error");
                    break;
            }
        @endif
    </script>
    <script>
        const buttons1 = document.querySelectorAll(".spinner-button1");

        // Iterate over each button and attach the event listener
        buttons1.forEach((button) => {
            button.addEventListener("click", function() {
                const submitText = button.querySelector("span"); // Get the submit text element
                const spinner = button.querySelector(".spinner");

                // Get the initial height of the button
                const initialHeight = button.offsetHeight;
                // Set a fixed height for the button to prevent changing size
                button.style.height = `${initialHeight}px`;

                // Hide submit text and show spinner
                submitText.style.display = "none";
                spinner.classList.remove("d-none");

                // Simulate loading process - replace with your actual task
                setTimeout(() => {
                    // Hide spinner and show submit text again
                    spinner.classList.add("d-none");
                    submitText.style.display = "";
                }, 2000); // Adjust the timeout value to match your desired disabled duration
            });
        });
    </script>
</body>

</html>
