<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home - Emerald OMS</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/bootstrap.min.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/owlCarousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/lib/css/sumoselect.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('frontend/img/favicon.ico') }}' />
    <!-- Latest compiled and minified CSS -->
    <!---- Toaster ----->
    <link href="{{ asset('frontend/lib/css/toastr.css') }}" rel="stylesheet" />
    @yield('header')
</head>

{{-- <body oncontextmenu="return false;"> --}}

<body>
    <header class="mb-0">
        <!-- ======== Preloader =========== -->
        <div id="preloader">
            <div class="spinner"></div>
        </div>
        <!-- ======== Preloader =========== -->
        {{-- navbar --}}
        @include('frontend.panel.navbar')
    </header>
    {{-- content --}}
    @yield('content')
    <input type="hidden" name="auth" id="auth" value="{{ Auth::user()->role_id }}">
    <footer>
        {{-- footer --}}
        @include('frontend.panel.footer')
    </footer>
    <script src="{{ asset('frontend/lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/owlCarousel.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/splide.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/dataTables.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/checkboxes.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/sumoselect.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('frontend/js/smartmenu.js') }}"></script>
    <script src="{{ asset('frontend/js/custom.js') }}"></script>
    <script src="{{ asset('frontend/lib/js/toastr.js') }}"></script>
    <!-- Common js -->
    <script src="{{ asset('common/common.js') }}"></script>
    {{-- <script>
        // disable right click
        document.addEventListener("contextmenu", (event) => event.preventDefault());

        document.onkeydown = function(e) {
            // disable F12 key
            if (e.keyCode == 123) {
                return false;
            }

            // disable I key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                return false;
            }

            // disable J key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                return false;
            }

            // disable U key
            if (e.ctrlKey && e.keyCode == 85) {
                return false;
            }

            if (event.code === "KeyP" && (event.ctrlKey || event.metaKey)) {
                // Display a message or take some action to prevent the screenshot
                alert("Screenshots are not allowed on this website.");
                event.preventDefault();
            }
        };
    </script> --}}
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

        $(document).ready(function() {
            var projectLink = document.getElementById('project-link');

            if (projectLink) {
                var projectLinks = document.querySelectorAll('.project-link');
                projectLinks.forEach(function(projectLink) {
                    projectLink.addEventListener('click', function(event) {
                        event.preventDefault();
                        var projectId = projectLink.getAttribute('data-project-id');
                        document.cookie = 'currentProjectId=' + projectId + '; path=/';
                        document.cookie =
                            'currentCategoryId=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'; // Set currentCategoryId to null
                        window.location.href = projectLink.getAttribute('href');
                    });
                });
            }

            var categoryLinks = document.querySelectorAll('.category-link');
            categoryLinks.forEach(function(categoryLink) {
                categoryLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    var categoryId = categoryLink.getAttribute('data-category-id');
                    document.cookie = 'currentCategoryId=' + categoryId + '; path=/';
                    document.cookie =
                        'currentProjectId=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'; // Set currentProjectId to null
                    window.location.href = categoryLink.getAttribute('href');
                });
            });

            function getCookie(name) {
                var value = "; " + document.cookie;
                var parts = value.split("; " + name + "=");
                if (parts.length == 2) return parts.pop().split(";").shift();
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
