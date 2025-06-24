<!DOCTYPE html>
<html lang="en">


<!-- errors-404.html  21 Nov 2019 04:05:02 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>404 - Error</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ 'backend/assets/css/app.min.css' }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ 'backend/assets/css/style.css' }}">
    <link rel="stylesheet" href="{{ 'backend/assets/css/components.css' }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ 'backend/assets/css/custom.css' }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ 'backend/>assets/img/favicon.ico' }}" />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        <div class="col-md-12 mt-5 mb-5">
                            <img src="{{ asset('backend/assets/img/restrict.jpg') }}">
                        </div>
                        <div class="page-search">
                            <div class="mt-3">
                                <a
                                    href="{{ Auth::user()->role_id == App\Enums\Roles::CRM ? route('dashboard') : route('order') }}">Back
                                    to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ 'backend/assets/js/app.min.js' }}"></script>
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ 'backend/assets/js/scripts.js' }}"></script>
    <!-- Custom JS File -->
    <script src="{{ 'backend/assets/js/custom.js' }}"></script>
</body>
<!-- errors-404.html  21 Nov 2019 04:05:02 GMT -->

</html>
