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
    <title>Login Page - Emerald OMS</title>
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('retailer/assets/img/favicon.ico') }}' />
    <link rel="stylesheet" href="{{ asset('retailer/assets/lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('retailer/assets/css/login.css') }}">

    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet">
    <!---- Toaster ----->
    <link href="{{ asset('retailer/assets/lib/css/toastr.css') }}" rel="stylesheet" />
</head>

<body>
    <section class="sign-in-page-form_wrapper">
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
                        <div class="fs-5">WELCOME TO </div>
                        <div class="fs-4 brittany-font mt-3 mb-3">Retailer Program</div>
                        {{-- <div class="fs-4 fw-bold mb-3">Enter Phone Number</div> --}}
                        <!-- <p class="mb-0">Type your Phone number, we will send
        your verification code
        via Phone number
       </p> -->
                        <p class="mb-0">Verification code will be sent to your registered number.</p>
                        <div class="d-flex justify-content-center align-items-center min-vh-0">
                            <div style="max-width: 350px;">

                                <hr class="my-3">

                                <form action="{{ route('retailergenerateotp') }}" method="get"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold" for="phoneNumber">Phone Number</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-transparent border-0">
                                                <svg width="10" height="17" viewBox="0 0 10 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.66012 1.1217C9.65985 0.824351 9.54153 0.53926 9.33127 0.328986C9.12087 0.118591 8.83577 0.000403181 8.53841 0H1.45276C1.15541 0.000403836 0.870318 0.118591 0.659906 0.328986C0.449645 0.539247 0.331323 0.824347 0.331055 1.1217V12.979H9.66005L9.66012 1.1217Z"
                                                        fill="#ADADAD" />
                                                    <path
                                                        d="M1.45269 16.4601H8.53835C8.8357 16.4597 9.12079 16.3415 9.3312 16.1311C9.54146 15.9209 9.65978 15.6358 9.66005 15.3384V13.6443H0.331055V15.3384C0.331324 15.6358 0.449645 15.9208 0.659906 16.1311C0.870301 16.3415 1.15541 16.4597 1.45276 16.4601H1.45269ZM4.19601 14.5544H5.79489C5.97863 14.5544 6.1275 14.7033 6.1275 14.887C6.1275 15.0708 5.97863 15.2198 5.79489 15.2198H4.19601C4.01227 15.2198 3.8634 15.0708 3.8634 14.887C3.8634 14.7033 4.01227 14.5544 4.19601 14.5544Z"
                                                        fill="#ADADAD" />
                                                </svg>
                                            </span>
                                            <input required type="text" minlength="10" maxlength="10"
                                                id="phoneNumber" name="mobile"
                                                class="form-control border-0 shadow-none"
                                                placeholder="Enter phone number" aria-label="Phone Number"
                                                aria-describedby="login page">
                                        </div>
                                        <div id="phoneNumberError" class="error-message"></div>
                                    </div>

                                    <div class="mb-4">
                                        <button type="submit" id="loginBtn" class="btn login-page_card-btn">
                                            <span class="spinner-border spinner-border-sm" style="display: none;"
                                                aria-hidden="true"></span>
                                            <span class="loginBtn_text">Login</span>
                                        </button>
                                    </div>
                                </form>

                                <p>Don’t have an account? <a href="{{ route('retailerregister') }}"
                                        class="sign-up-text text-decoration-none fw-medium">Sign up now</a></p>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('retailer\assets\lib\js\toastr.js') }}"></script>
    {{-- <script>
			document.getElementById('loginBtn').addEventListener('click', function(event) {
				// event.preventDefault(); // Prevent form submission
				
				var phoneNumberInput = document.getElementById('phoneNumber');
				var phoneNumber = phoneNumberInput.value.trim();
				
				// Regular expression to validate Indian mobile numbers
				var indianPhoneNumberPattern = /^[6-9]\d{9}$/;
				
				// Validate phone number
				if (indianPhoneNumberPattern.test(phoneNumber)) {
					// Phone number is valid, show loader
					let button = this;
					button.classList.add('loading'); // Add loading class to disable clicking
					
					let loader = button.querySelector('.spinner-border');
					loader.style.display = 'inline-block'; // Show the loader
					
					document.querySelector(".loginBtn_text").style.display = "none";
					let errorMessage = document.getElementById('phoneNumberError').textContent = "";
					
					} else {
					// Phone number is invalid, show error message
					let errorMessage = document.getElementById('phoneNumberError');
					errorMessage.classList.add("text-danger")
					errorMessage.textContent = "Please enter a valid 10 digit mobile number.";
				}
			});
		</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // On page load, remove loading class and hide the spinner if they are present
            let button = document.getElementById('loginBtn');
            button.classList.remove('loading');

            let loader = button.querySelector('.spinner-border');
            if (loader) {
                loader.style.display = 'none';
            }

            document.querySelector(".loginBtn_text").style.display = "inline"; // Ensure text is visible
        });

        document.getElementById('loginBtn').addEventListener('click', function(event) {
            // event.preventDefault(); // Prevent form submission if needed

            var phoneNumberInput = document.getElementById('phoneNumber');
            var phoneNumber = phoneNumberInput.value.trim();

            // Regular expression to validate Indian mobile numbers
            var indianPhoneNumberPattern = /^[6-9]\d{9}$/;

            // Validate phone number
            if (indianPhoneNumberPattern.test(phoneNumber)) {
                // Phone number is valid, show loader
                let button = this;
                button.classList.add('loading'); // Add loading class to disable clicking

                let loader = button.querySelector('.spinner-border');
                if (loader) {
                    loader.style.display = 'inline-block'; // Show the loader
                }

                document.querySelector(".loginBtn_text").style.display = "none";
                let errorMessage = document.getElementById('phoneNumberError').textContent = "";

                // Remove loader after 3 seconds
                setTimeout(function() {
                    button.classList.remove('loading'); // Remove loading class to enable clicking
                    if (loader) {
                        loader.style.display = 'none'; // Hide the loader
                    }
                    document.querySelector(".loginBtn_text").style.display = "inline"; // Show button text
                }, 3000); // 3000 milliseconds = 3 seconds

            } else {
                // Phone number is invalid, show error message
                let errorMessage = document.getElementById('phoneNumberError');
                errorMessage.classList.add("text-danger");
                errorMessage.textContent = "Please enter a valid 10 digit mobile number.";
            }
        });
    </script>
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

        .form-label {
            text-align: left;
            display: block;
        }
    </style>
</body>

</html>
