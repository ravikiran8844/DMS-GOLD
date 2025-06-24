<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Verify | DMS Dashboard</title>

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
                    <div class="dms_login_page_title mb-4 ">ENTER THE OTP:</div>
                    <div class="dms_login_page_text mb-5">Code is sent to
                        {{ '+91 ' . substr($mobile, 0, 2) . '*** **' . substr($mobile, 7, 3) . ' ' }}</div>
                    <input type="hidden" name="dbotp" id="dbotp" value="{{ $otp }}">
                </div>

                <div>
                    <div class="dms_login_page_input-item m-auto">
                        <form action="{{ route('adminloginverfication') }}" method="get"
                            onsubmit="return validateOTP()">
                            @csrf
                            <input type="hidden" name="mobile" value="{{ $mobile }}">
                            <hr class="mb-5">
                            <div id="inputs" class="otp-input-box">
                                <input class="input" type="text" id="otp" name="otp" inputmode="numeric"
                                    minlength="4" maxlength="4" required />
                                {{-- <input class="input" type="text" id="otp2" inputmode="numeric" maxlength="1"
                                    required />
                                <input class="input" type="text" id="otp3" inputmode="numeric" maxlength="1"
                                    required />
                                <input class="input" type="text" id="otp4" inputmode="numeric" maxlength="1"
                                    required />
                                <input type="hidden" name="otp" id="otp" value=""> --}}
                            </div>
                            <div id="error-message" class="mt-4 fw-bold text-danger text-center d-none">
                                Wrong OTP. Please Enter Correct OTP
                            </div>

                            <button id="otp-verify_button"
                                class="spinner-button1 mt-5 btn dms_login_page_button w-100 py-3">
                                <span>Continue</span> <span class="d-none spinner">
                                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                    <span role="status">Loading...</span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                <div id="resendContainer">
                    <div class="text-center mt-3">
                        <div class="otp-not-received-text">
                            Didn't receive the OTP? <span id="resendLinkContainer"><a href="#"
                                    class="resend-otp-text" onclick="restartTimer()">Resend</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Set the initial timer value to 5 minutes (300 seconds)
        let timerSeconds = 300;

        // Function to update the timer text
        function updateTimerText() {
            // Calculate minutes and seconds
            const minutes = Math.floor(timerSeconds / 60);
            const seconds = timerSeconds % 60;

            // Format the timer values to display leading zero if needed
            const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
            const formattedSeconds = seconds < 10 ? `0${seconds}` : seconds;

            document.getElementById('resendLinkContainer').innerHTML =
                `Resend in <span class="text-warning">${formattedMinutes}:${formattedSeconds}</span>`;
        }

        // Function to handle the countdown and show the "Resend" text element
        function startResendTimer() {
            // Update the timer text initially
            updateTimerText();

            // Decrement the timer every second
            const timerInterval = setInterval(() => {
                timerSeconds--;

                // Update the timer text
                updateTimerText();

                // If the timer reaches 0, show the "Resend" text element and clear the interval
                if (timerSeconds === 0) {
                    clearInterval(timerInterval);
                    showResendText();
                }
            }, 1000);
        }

        // Function to show the "Resend" text element
        function showResendText() {
            const resendLinkContainer = document.getElementById('resendLinkContainer');
            resendLinkContainer.innerHTML = '<a href="#" class="resend-otp-text" onclick="restartTimer()">Resend</a>';
        }

        // Function to restart the timer
        function restartTimer() {
            // Reset the timerSeconds value to 5 minutes (300 seconds)
            timerSeconds = 300;

            // Start the timer again
            startResendTimer();
        }

        // Validate entered OTP
        function validateOTP() {
            const inputs = document.getElementById("inputs");
            const enteredOTP = $("#otp").val();

            const expectedOTP = $("#dbotp").val();
            const isValidOTP = enteredOTP === expectedOTP;

            if (!isValidOTP) {
                document.getElementById("error-message").classList.remove("d-none");
                return false;
            } else {
                document.getElementById("error-message").classList.add("d-none");
            }

            return true;
        }

        const continueButton = document.querySelector('#otp-verify_button');
        // continueButton.disabled = true;

        // document.getElementById("inputs").addEventListener('input', function () {
        //     const isValidLength = Array.from(this.children).every(input => input.value.length === 1);
        //     continueButton.disabled = !isValidLength;
        // });

        continueButton.addEventListener('click', function() {
            if (validateOTP()) {
                document.getElementById("error-message").classList.add("d-none");
                // alert("OTP is valid. Continue with the next steps."); // Replace this with your desired action
                window.location.href = 'https://oms-new.vercel.app';

            }
        });

        // Start the timer when the page loads
        startResendTimer();
    </script>

    <script>
        const inputs = document.getElementById("inputs");

        inputs.addEventListener("input", function(e) {
            const target = e.target;
            const val = target.value;

            if (isNaN(val)) {
                target.value = "";
                return;
            }

            if (val != "") {
                const next = target.nextElementSibling;
                if (next) {
                    next.focus();
                }
            }
        });

        inputs.addEventListener("keyup", function(e) {
            const target = e.target;
            const key = e.key.toLowerCase();

            if (key == "backspace" || key == "delete") {
                target.value = "";
                const prev = target.previousElementSibling;
                if (prev) {
                    prev.focus();
                }
                return;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('backend/assets/bundles/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("#otp1, #otp2, #otp3, #otp4").on("keyup", function() {
            var otp = $('#otp1').val() + $('#otp2').val() + $('#otp3').val() + $('#otp4').val();
            $('#otp').val(otp);
        });
    </script>
    <!-- TOASTER -->
    <script src="{{ asset('backend/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/toastr.js') }}"></script>
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
