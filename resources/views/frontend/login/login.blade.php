<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login - Emerald</title>
    <!-- General CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('frontend/img/favicon.ico') }}' />
</head>

<body>
    <div class="dms_login-page">
        <div class="dms-login-img_wrapper position-relative">
            <img class="img-fluid dms_login-image" src="{{ asset('frontend/img/login-banner.webp') }}" alt="">
            <div class="dms-login_overlay-item">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="text-center mb-5">
                        <img class="img-fluid" height="154" width="200"
                            src="{{ asset('frontend/img/emerald-logo.png') }}" alt="logo">
                    </div>
                    <div class="mb-4">
                        <div class="input-group dms-input-group">
                            <div class="input-group-prepend">
                                <span class="bg-transparent border-0  input-group-text h-100" id="inputGroupPrepend2">
                                    <svg width="17" height="19" viewBox="0 0 17 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.71837 9.22189C11.0735 9.22189 12.9826 7.31271 12.9826 4.95762C12.9826 2.60254 11.0735 0.693359 8.71837 0.693359C6.36328 0.693359 4.4541 2.60254 4.4541 4.95762C4.4541 7.31271 6.36328 9.22189 8.71837 9.22189Z"
                                            stroke="white" stroke-width="1.06607" />
                                        <path
                                            d="M12.9902 11.354H13.2909C13.9155 11.3542 14.5186 11.5678 14.9868 11.9547C15.455 12.3416 15.7561 12.8752 15.8335 13.4552L16.1676 15.953C16.1976 16.178 16.1762 16.4065 16.1047 16.6231C16.0332 16.8398 15.9133 17.0398 15.7529 17.2097C15.5925 17.3797 15.3953 17.5158 15.1744 17.6091C14.9535 17.7023 14.714 17.7504 14.4717 17.7504H2.96498C2.72266 17.7504 2.48311 17.7023 2.26221 17.6091C2.04131 17.5158 1.84413 17.3797 1.68374 17.2097C1.52335 17.0398 1.40343 16.8398 1.33193 16.6231C1.26044 16.4065 1.239 16.178 1.26905 15.953L1.60225 13.4552C1.67974 12.8749 1.98109 12.3411 2.44965 11.9542C2.9182 11.5672 3.52167 11.3538 4.14657 11.354H4.44646"
                                            stroke="white" stroke-width="1.06607" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <input type="text" class="form-control border-0  bg-transparent" placeholder="User Name"
                                name="name" id="name" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="input-group dms-input-group">
                            <div class="input-group-prepend">
                                <span class="bg-transparent border-0  input-group-text h-100" id="inputGroupPrepend2">
                                    <svg width="18" height="23" viewBox="0 0 18 23" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.1426 9.08248H13.619V5.92501C13.619 3.16636 11.3742 0.921631 8.61559 0.921631C5.85693 0.921631 3.6122 3.16636 3.6122 5.92501V9.08277H2.08855C1.04142 9.08277 0.189453 9.93473 0.189453 10.9819V20.9746C0.189453 22.0217 1.04142 22.8737 2.08855 22.8737H15.1426C16.1898 22.8737 17.0417 22.0217 17.0417 20.9746V10.9816C17.0417 9.93444 16.1898 9.08248 15.1426 9.08248ZM4.48871 5.92501C4.48871 3.64961 6.34018 1.79814 8.61559 1.79814C10.891 1.79814 12.7425 3.64961 12.7425 5.92501V9.08277H4.48871V5.92501ZM16.1652 20.9743C16.1652 21.5382 15.7065 21.9969 15.1426 21.9969H2.08855C1.52466 21.9969 1.06596 21.5382 1.06596 20.9743V10.9816C1.06596 10.4177 1.52466 9.95898 2.08855 9.95898H15.1426C15.7065 9.95898 16.1652 10.4177 16.1652 10.9816V20.9743ZM8.61559 13.437C7.80307 13.437 7.14189 14.0981 7.14189 14.9106C7.14189 15.5698 7.57956 16.1223 8.17733 16.3101V18.3743C8.17733 18.6162 8.37367 18.8126 8.61559 18.8126C8.8575 18.8126 9.05384 18.6162 9.05384 18.3743V16.3101C9.65161 16.1223 10.0893 15.5698 10.0893 14.9106C10.0893 14.0978 9.42811 13.437 8.61559 13.437ZM8.61559 15.5075C8.28631 15.5075 8.01839 15.2396 8.01839 14.9104C8.01839 14.5811 8.28631 14.3132 8.61559 14.3132C8.94486 14.3132 9.21278 14.5811 9.21278 14.9104C9.21278 15.2396 8.94486 15.5075 8.61559 15.5075Z"
                                            fill="white" />
                                    </svg>
                                </span>
                            </div>
                            <input type="password" class="form-control border-0  bg-transparent" placeholder="Password"
                                id="password" name="password" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="dms-login_overlay-item-text"><a class="text-decoration-none text-white"
                                href="/forget-password">Forget Password?</a></div>
                        <div class="d-flex align-items-center">
                            <label class="dms-login_overlay-item-text mb-0 mr-1 me-1" for="remember-me">Remember
                                Me</label>
                            <input class="login-checkbox" type="checkbox" name="login-remember" id="remember-me">
                        </div>
                    </div>
                    <div>
                        <button class="dms-custom-btn">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
