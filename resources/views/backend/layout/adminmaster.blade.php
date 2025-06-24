<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emerald DMS Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/jqvmap/dist/jqvmap.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('backend/assets/img/favicon.ico') }}' />
    <!-- Checkbox -->
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
    <!-- Social Icon -->
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/bootstrap-social/bootstrap-social.css') }}">
    <!-- Text Editor -->
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/summernote/summernote-bs4.css') }}">
    <!-- Add SweetAlert CSS (you may use a different CSS file depending on your version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Add SweetAlert JavaScript (you may use a different JS file depending on your version) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- TOASTER -->
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- SELECT2 -->
    <link rel="stylesheet" href="{{ asset('backend/assets/bundles/select2/dist/css/select2.min.css') }}">
    <!-- Img Preview -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <!-- Tags -->
    <link rel="stylesheet"
        href="{{ asset('backend/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Include Bootstrap CSS (assuming you are using Bootstrap) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--Header-->
    @yield('header')
    <!-- /Header-->
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            <div class="navbar-bg"></div>

            <!-- Navbar -->
            @include('backend.panels.navbar')

            <div class="main-sidebar sidebar-style-2 scrollable-container">
                <!--Sidebar Menu -->
                @include('backend.panels.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content"  style="background-color: #F5F6F6;border: 1px solid #E1E1E1" >
                <!-- Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            @include('backend.panels.footer')

        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('backend/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('backend/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/datatables.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('backend/assets/bundles/jquery.sparkline.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/sparkline.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('backend/assets/bundles/chartjs/chart.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/chart-chartjs.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/index.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
    <!-- Text Editor -->
    <script src="{{ asset('backend/assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('backend/assets/bundles/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Common js -->
    <script src="{{ asset('common/common.js') }}"></script>
    <!-- TOASTER -->
    <script src="{{ asset('backend/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('backend/assets/js/page/toastr.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <!-- SELECT 2 -->
    <script src="{{ asset('backend/assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Img Preview -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <!-- TAGS -->
    <script src="{{ asset('backend/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {

            $('input[name="datefilter"]').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                "locale": {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Su",
                        "Mo",
                        "Tu",
                        "We",
                        "Th",
                        "Fr",
                        "Sa"
                    ],
                    "monthNames": [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December"
                    ],
                    "firstDay": 1
                }
            }, function(start, end, label) {
                // console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                //     'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

        });
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert', 'info') }}";
            var message = "{{ Session::get('message') }}";

            function showToast(type, message, color, icon) {
                iziToast.show({
                    message: message,
                    icon: icon,
                    timeout: 3000,
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

    @yield('scripts')
</body>

</html>
