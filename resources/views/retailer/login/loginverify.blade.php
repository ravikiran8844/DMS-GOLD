<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "mopb0nhhuf");
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification Page - Emerald OMS</title>
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('retailer/assets/img/favicon.ico') }}' />
    <link rel="stylesheet" href="{{ asset('retailer/assets/lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('retailer/assets/css/login.css') }}">
    <!---- Toaster ----->
    <link href="{{ asset('retailer/assets/lib/css/toastr.css') }}" rel="stylesheet" />
</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <!-- <div class="col-12 col-md-6 p-0 position-relative ">
      <img class="img-fluid h-100 w-100 login-page-banner"
                        src="{{ asset('retailer/assets/img/login-page-banner.webp') }}" alt>
      
      <div class="text-center text-white position-absolute bottom-0 w-100 p-2 pb-4">
                        <div class="fs-5 fw-bold">Welcome to Emerald Retailer Program</div>
      </div>
     </div> -->
                <div class="col-12 col-md-12 py-5 login-page_card px-4 px-lg-5">
                    <div class="flex-grow-1 text-center">
                        <div class="mb-4">
                            <img width="120" height="120" class="img-fluid"
                                src="{{ asset('retailer/assets/img/emerald-logo.png') }}" alt>
                        </div>
                        <div class="fs-4 brittany-font mt-3 mb-3">Retailer Program</div>
                        <div class="fs-4 fw-bold mb-3">Enter OTP</div>
                        <p class="mb-4">Code is sent to
                            <span>{{ '+91 ' . substr($mobile, 0, 2) . '*** **' . substr($mobile, 7, 3) . ' ' }}</span>
                        </p>
                        <div class="d-flex justify-content-center align-items-center min-vh-0">
                            <div style="max-width: 350px;">

                                <form id="loginVerifyForm" action="{{ route('retailerloginverfication') }}"
                                    method="get" onsubmit="return validateOTP()">
                                    @csrf
                                    <input type="hidden" name="mobile" value="{{ $mobile }}">
                                    <div class="mb-4">
                                        <div class="otp-input_wrapper">
                                            <input id="otp-input" name="otp" minlength="4" maxlength="4"
                                                type="text" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <button id="loginVerifyBtn" class="btn login-page_card-btn">
                                            <span class="spinner-border spinner-border-sm" style="display: none;"
                                                aria-hidden="true"></span>
                                            <span class="loginBtn_text">Submit</span>
                                        </button>
                                    </div>
                                </form>

                                <p>Didn't receive the OTP? <span id="resendLinkContainer">
                                        <a href="#" class="resend-text text-decoration-none fw-medium"
                                            onclick="restartTimer()">Resend</a></span></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a style=" position: fixed; bottom: 30px; right: 10px; z-index: 9999; " target="_blank"
            href="https://api.whatsapp.com/send?phone=919791714333&text=I%20have%20questions%20regarding%20Retailer%20Management%20System">
            <img src="{{ asset('retailer/assets/img/whatsapp.png') }}" width="42" height="42"
                alt="whatsapp icon">
        </a>
    </section>
    <script>
        // Set the initial timer value to 5 minutes (300 seconds)
        let timerSeconds = 30;

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

        // Start the timer when the page loads
        startResendTimer();
    </script>
    <script>
        // JavaScript to handle OTP input and enable button when 4 digits are filled
        document.addEventListener('DOMContentLoaded', function() {
            var otpInput = document.getElementById('otp-input');
            var loginVerifyBtn = document.getElementById('loginVerifyBtn');

            // Listen for input event on OTP input field
            otpInput.addEventListener('input', function() {
                // Remove any non-numeric characters from the input
                this.value = this.value.replace(/\D/g, '');
                // Enable the button only when 4 digits are filled
                loginVerifyBtn.disabled = this.value.length !== 4;
            });

            // Handle button click event
            loginVerifyBtn.addEventListener("click", function() {
                // Hide text when button is clicked
                const buttonText = this.querySelector(".loginBtn_text");
                buttonText.style.display = "none";

                // Show loader when button is clicked
                const loader = this.querySelector(".spinner-border");
                loader.style.display = "inline-block";

                // Simulate loading process for 2 seconds (replace with actual logic)
                setTimeout(() => {
                    // After 2 seconds, you can redirect or perform other actions
                    // For demonstration purposes, we're just hiding the loader and showing the text again
                    loader.style.display = "none";
                    buttonText.style.display = "inline"; // Show the text again
                }, 2000);
            });

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('retailer\assets\lib\js\toastr.js') }}"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert', 'info') }}";
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": 1500 // Adjust the timeOut value (in milliseconds) as per your requirement
            };
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: Poppins;
        }

        @font-face {
            font-family: "Brittany Signature";
            src: url("/retailer/assets/fonts/BrittanySignature.ttf");
        }

        .brittany-font {
            font-family: "Brittany Signature";
        }

        @media (min-width:768px) {
            .login-page_card {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

        }

        .login-page-banner {
            max-height: 100vh;
        }

        .login-page_card p {
            color: #8A8A8A;
        }

        .login-page_card .phone-input {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
        }

        .otp-input_wrapper input {
            border-radius: 4.177px;
            border: 0.835px solid #DADADA;
            background: #FFF;
            box-shadow: 0px 0px 14.202px 0px #D7D7D7;
            height: 48px;
            width: 100%;
            outline: none;

        }

        .login-page_card-btn {
            border-radius: 4.264px;
            background: #1D3B2D !important;
            color: #FFF !important;
            text-align: center;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            width: 100%;
            height: 52.237px;
        }

        .login-page_card .input-group {
            border-radius: 5px;
            border: 1px solid #E4E4E4;
            width: 100%;
            height: 48px;
            flex-shrink: 0;
        }

        .sign-up-text,
        .resend-text {
            color: #1D3B2D;

        }

        .otp-field {
            flex-direction: row;
            column-gap: 10px;
            display: flex;
            align-items: center;
        }

        .otp-field input {
            height: 45px;
            width: 42px;
            border-radius: 4.177px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 0.835px solid #DADADA;

        }

        .otp-field input:focus {
            border-radius: 4.177px;
            border: 0.835px solid #DADADA;
            background: #FFF;
            box-shadow: 0px 0px 14.202px 0px #D7D7D7;
        }

        .otp-field input::-webkit-inner-spin-button,
        .otp-field input::-webkit-outer-spin-button {
            display: none;
        }
    </style>
</body>

</html>
