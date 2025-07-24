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
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('dealer/img/favicon.ico') }}' />
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/splide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/css/new-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/lib/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dealer/css/login.css') }}">
    <!---- Toaster ----->
    <link href="{{ asset('dealer/lib/css/toastr.css') }}" rel="stylesheet" />
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @yield('header')
</head>

<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div>
            <img class="spinner-image" width="60" height="60" src="{{ asset('dealer/img/loader.png') }}"
                alt="">
        </div>
    </div>
    <!-- ======== Preloader =========== -->
    <header class="mb-0">
        <section class="header">
            <nav class="navbar navbar-expand-xl bg-body-light">
                {{-- navbar --}}
                @include('dealer.panel.navbar')
            </nav>
        </section>
        @php
            use Illuminate\Support\Str;
            $currentUrl = request()->url();
            $containsRetailerCart = Str::contains($currentUrl, 'cart');
            $setting = App\Models\Settings::first();
        @endphp
    </header>
    {{-- content --}}
    @yield('content')
    @auth
        <input type="hidden" name="auth" id="auth" value="{{ Auth::user()->role_id }}">
        <input type="hidden" name="authlog" id="authlog" value="{{ Auth::check() ? true : false }}">
    @endauth
    <div class="mobile-fixed-menu">
        <div class="d-flex justify-content-evenly align-items-center h-100 gap-2">
            <a href="/wishlist">
                <div class="text-center">
                    <div>
                        <svg width="28" height="28" viewBox="0 0 31 31" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.5284 27.8046L13.5754 26.0267C6.63896 19.7368 2.05957 15.5884 2.05957 10.4972C2.05957 6.3488 5.31902 3.08936 9.4674 3.08936C11.811 3.08936 14.0603 4.18033 15.5284 5.90433C16.9965 4.18033 19.2457 3.08936 21.5893 3.08936C25.7377 3.08936 28.9972 6.3488 28.9972 10.4972C28.9972 15.5884 24.4178 19.7368 17.4813 26.0402L15.5284 27.8046Z"
                                stroke="#838383" stroke-width="1.80878" />
                        </svg>
                    </div>
                    <div class="mobile-fixed-menu__link-title">
                        WishList
                    </div>
                </div>
            </a>
            <a href="{{ route('category') }}">
                <div class="text-center">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1 2.98777C1 1.88997 1.88997 1 2.98777 1H10.4236C11.5215 1 12.4114 1.88997 12.4114 2.98777V10.4236C12.4114 11.5215 11.5215 12.4114 10.4236 12.4114H2.98777C1.88997 12.4114 1 11.5215 1 10.4236V2.98777ZM2.98777 2.19266H10.4236C10.8628 2.19266 11.2188 2.54868 11.2188 2.98777V10.4236C11.2188 10.8628 10.8628 11.2188 10.4236 11.2188H2.98777C2.54868 11.2188 2.19266 10.8628 2.19266 10.4236V2.98777C2.19266 2.54868 2.54868 2.19266 2.98777 2.19266Z"
                                fill="#838383" stroke="#838383" stroke-width="0.5" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1 17.7121C1 16.6143 1.88997 15.7244 2.98777 15.7244H10.4236C11.5215 15.7244 12.4114 16.6143 12.4114 17.7121V25.148C12.4114 26.2458 11.5215 27.1358 10.4236 27.1358H2.98777C1.88997 27.1358 1 26.2458 1 25.148V17.7121ZM2.98777 16.917H10.4236C10.8628 16.917 11.2188 17.273 11.2188 17.7121V25.148C11.2188 25.5871 10.8628 25.9431 10.4236 25.9431H2.98777C2.54868 25.9431 2.19266 25.5871 2.19266 25.148V17.7121C2.19266 17.273 2.54868 16.917 2.98777 16.917Z"
                                fill="#838383" stroke="#838383" stroke-width="0.5" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M18.1308 1C17.033 1 16.1431 1.88997 16.1431 2.98777V10.4236C16.1431 11.5215 17.033 12.4114 18.1308 12.4114H25.5667C26.6645 12.4114 27.5545 11.5215 27.5545 10.4236V2.98777C27.5545 1.88997 26.6645 1 25.5667 1H18.1308ZM25.5667 2.19266H18.1308C17.6917 2.19266 17.3357 2.54868 17.3357 2.98777V10.4236C17.3357 10.8628 17.6917 11.2188 18.1308 11.2188H25.5667C26.0058 11.2188 26.3618 10.8628 26.3618 10.4236V2.98777C26.3618 2.54868 26.0058 2.19266 25.5667 2.19266Z"
                                fill="#838383" stroke="#838383" stroke-width="0.5" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M27.5543 21.6141C27.5543 24.7652 24.9998 27.3197 21.8487 27.3197C18.6976 27.3197 16.1431 24.7652 16.1431 21.6141C16.1431 18.4629 18.6976 15.9084 21.8487 15.9084C24.9998 15.9084 27.5543 18.4629 27.5543 21.6141ZM26.3617 21.6141C26.3617 24.1065 24.3411 26.127 21.8487 26.127C19.3563 26.127 17.3357 24.1065 17.3357 21.6141C17.3357 19.1216 19.3563 17.1011 21.8487 17.1011C24.3411 17.1011 26.3617 19.1216 26.3617 21.6141Z"
                                fill="#838383" stroke="#838383" stroke-width="0.5" />
                        </svg>

                    </div>
                    <div class="mobile-fixed-menu__link-title">
                        Categories
                    </div>
                </div>
            </a>
            <a href="/myprofile">
                <div class="text-center">
                    <div>
                        <svg width="28" height="28" viewBox="0 0 31 31" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.592 27.2619L15.592 26.747H15.592L15.592 27.2619ZM5.7003 22.0473L5.18768 21.9988L5.17015 22.1844L5.27546 22.3382L5.7003 22.0473ZM25.4836 22.0473L25.9085 22.3382L26.0138 22.1844L25.9963 21.9987L25.4836 22.0473ZM24.4977 20.2975L24.8494 19.9215H24.8494L24.4977 20.2975ZM21.8836 18.7215L21.6851 19.1966L21.8836 18.7215ZM9.29404 18.7215L9.49272 19.1965L9.29404 18.7215ZM6.68422 20.2972L6.33213 19.9215L6.33213 19.9215L6.68422 20.2972ZM5.14893 22.2001L4.63408 22.1923L4.63168 22.3518L4.71984 22.4847L5.14893 22.2001ZM26.035 22.2001L26.4641 22.4847L26.5523 22.3518L26.5499 22.1923L26.035 22.2001ZM15.592 27.8045L15.592 27.2896H15.592L15.592 27.8045ZM15.5919 4.14689C17.8971 4.14689 19.7559 6.0057 19.7559 8.31088H20.7857C20.7857 5.43696 18.4658 3.11709 15.5919 3.11709V4.14689ZM11.4279 8.31088C11.4279 6.0057 13.2867 4.14689 15.5919 4.14689V3.11709C12.7179 3.11709 10.3981 5.43696 10.3981 8.31088H11.4279ZM15.5919 12.4749C13.2867 12.4749 11.4279 10.6161 11.4279 8.31088H10.3981C10.3981 11.1848 12.7179 13.5047 15.5919 13.5047V12.4749ZM19.7559 8.31088C19.7559 10.6161 17.8971 12.4749 15.5919 12.4749V13.5047C18.4658 13.5047 20.7857 11.1848 20.7857 8.31088H19.7559ZM15.5919 3.60426C18.1967 3.60426 20.2985 5.70601 20.2985 8.31088H21.3283C21.3283 5.13727 18.7655 2.57445 15.5919 2.57445V3.60426ZM10.8852 8.31088C10.8852 5.70601 12.987 3.60426 15.5919 3.60426V2.57445C12.4183 2.57445 9.85544 5.13727 9.85544 8.31088H10.8852ZM15.5919 13.0175C12.987 13.0175 10.8852 10.9158 10.8852 8.31088H9.85544C9.85544 11.4845 12.4183 14.0473 15.5919 14.0473V13.0175ZM20.2985 8.31088C20.2985 10.9158 18.1967 13.0175 15.5919 13.0175V14.0473C18.7655 14.0473 21.3283 11.4845 21.3283 8.31088H20.2985ZM15.592 26.747C11.8028 26.747 8.26193 24.8767 6.12513 21.7563L5.27546 22.3382C7.60407 25.7386 11.4627 27.7768 15.592 27.7768L15.592 26.747ZM25.0588 21.7564C22.922 24.8767 19.3811 26.747 15.592 26.747L15.592 27.7768C19.7212 27.7768 23.5799 25.7386 25.9085 22.3382L25.0588 21.7564ZM24.1459 20.6736C24.6805 21.1736 24.9287 21.6488 24.971 22.0958L25.9963 21.9987C25.9227 21.2223 25.4999 20.5299 24.8494 19.9215L24.1459 20.6736ZM21.6851 19.1966C22.7062 19.6233 23.5605 20.126 24.1459 20.6736L24.8494 19.9215C24.1418 19.2596 23.166 18.6993 22.0821 18.2464L21.6851 19.1966ZM15.592 17.8968C17.1791 17.8968 19.6385 18.3415 21.6851 19.1966L22.0821 18.2464C19.9141 17.3406 17.32 16.867 15.592 16.867V17.8968ZM9.49272 19.1965C11.5366 18.3416 13.9959 17.8968 15.592 17.8968V16.867C13.8553 16.867 11.2612 17.3406 9.09535 18.2464L9.49272 19.1965ZM7.03631 20.6729C7.62034 20.1256 8.47293 19.623 9.49272 19.1965L9.09535 18.2464C8.01251 18.6993 7.03837 19.2596 6.33213 19.9215L7.03631 20.6729ZM6.21292 22.0957C6.25523 21.6479 6.50309 21.1726 7.03631 20.6729L6.33213 19.9215C5.68289 20.5299 5.26104 21.2223 5.18768 21.9988L6.21292 22.0957ZM5.66377 22.2078C5.67403 21.5269 6.019 20.8826 6.66525 20.277C7.31368 19.6693 8.23032 19.1363 9.28333 18.6959C11.3915 17.8141 13.9218 17.3542 15.592 17.3542V16.3244C13.7812 16.3244 11.1161 16.8131 8.88597 17.7458C7.76987 18.2126 6.7317 18.8034 5.96107 19.5255C5.18827 20.2498 4.64993 21.1415 4.63408 22.1923L5.66377 22.2078ZM15.592 17.3542C17.2533 17.3542 19.7837 17.8141 21.8943 18.6959C22.9485 19.1364 23.8668 19.6695 24.5166 20.2773C25.1643 20.8831 25.5099 21.5273 25.5202 22.2078L26.5499 22.1923C26.534 21.141 25.9942 20.2492 25.2201 19.5252C24.4481 18.8031 23.4084 18.2125 22.2913 17.7457C20.0593 16.8131 17.3942 16.3244 15.592 16.3244V17.3542ZM25.606 21.9155C23.3795 25.2718 19.6197 27.2896 15.592 27.2896L15.592 28.3194C19.9648 28.3194 24.0469 26.1287 26.4641 22.4847L25.606 21.9155ZM15.592 27.2896C11.5643 27.2896 7.80443 25.2718 5.57801 21.9155L4.71984 22.4847C7.13706 26.1287 11.2191 28.3194 15.592 28.3194L15.592 27.2896Z"
                                fill="#838383" />
                        </svg>

                    </div>
                    <div class="mobile-fixed-menu__link-title">
                        Profile
                    </div>
                </div>
            </a>
        </div>
    </div>

    <footer class="footer">
        {{-- footer --}}
        @include('dealer.panel.footer')
    </footer>
    <!-- Search Bar Modal -->
    <div class="modal" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #F8F9FA;">
                <div class="modal-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group nav-search-input p-0">
                                <input placeholder="Search for Emerald Products" class="form-control" type="search"
                                    name="search" id="search" required>
                                <div class="input-group-append">
                                    <button class="btn" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22"
                                            viewBox="0 0 23 23" fill="none">
                                            <path
                                                d="M18.1048 16.2301L17.9986 16.3692L18.1224 16.4929L22.5262 20.8968C22.7777 21.1941 22.8629 21.5978 22.7526 21.9713C22.6413 22.3472 22.3472 22.6413 21.9712 22.7526C21.5975 22.8629 21.1937 22.7779 20.8966 22.5265L16.4927 18.1226L16.369 17.9989L16.2299 18.1051C13.5223 20.1721 9.94761 20.7149 6.74879 19.5447C3.54997 18.3746 1.16944 15.6532 0.4349 12.3273L0.239685 12.3704L0.434899 12.3273C-0.299628 9.00155 0.713692 5.53048 3.1219 3.12195C5.53009 0.713444 9.00116 -0.29961 12.3271 0.434938L12.3702 0.239892L12.3271 0.434938C15.653 1.16948 18.3743 3.55004 19.5445 6.74889C20.7146 9.94791 20.1718 13.5226 18.1048 16.2301ZM4.76584 4.76655L4.76584 4.76656C3.32891 6.20358 2.5216 8.15242 2.5216 10.1847C2.5216 12.217 3.32883 14.1658 4.76584 15.6028L4.90726 15.4614L4.76584 15.6028C6.20285 17.0398 8.15175 17.8471 10.1839 17.8471C12.2162 17.8471 14.165 17.0399 15.602 15.6028L15.4606 15.4614L15.602 15.6028C17.0389 14.1658 17.8462 12.217 17.8462 10.1847C17.8462 8.15242 17.039 6.20358 15.602 4.76655L15.4606 4.90797L15.602 4.76655C14.165 3.3296 12.2162 2.52228 10.1839 2.52228C8.15168 2.52228 6.20285 3.32952 4.76584 4.76655Z"
                                                fill="#003836" stroke="#F8EDE3" stroke-width="0.4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Add other search bar elements as needed -->
                    <div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <!-- Add additional modal content or buttons if necessary -->
            </div>
        </div>
    </div>

    <div class="modal fade login-page_card" id="authModal" tabindex="-1" aria-labelledby="authModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card border-0">
                        <div class="card-body  position-relative">
                            <div class="position-absolute end-0 top-0">
                                <button type="button" class="btn btn-icon p-0 border-0" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 41 41" fill="none">
                                        <path
                                            d="M20.5 35.875C18.4809 35.875 16.4816 35.4773 14.6162 34.7046C12.7509 33.932 11.0559 32.7995 9.62823 31.3718C8.20053 29.9441 7.06802 28.2491 6.29535 26.3838C5.52269 24.5184 5.125 22.5191 5.125 20.5C5.125 18.4809 5.52269 16.4816 6.29535 14.6162C7.06802 12.7509 8.20053 11.0559 9.62823 9.62823C11.0559 8.20053 12.7509 7.06802 14.6162 6.29535C16.4816 5.52269 18.4809 5.125 20.5 5.125C22.5191 5.125 24.5184 5.52269 26.3838 6.29535C28.2491 7.06802 29.9441 8.20053 31.3718 9.62824C32.7995 11.0559 33.932 12.7509 34.7046 14.6162C35.4773 16.4816 35.875 18.4809 35.875 20.5C35.875 22.5191 35.4773 24.5184 34.7046 26.3838C33.932 28.2491 32.7995 29.9441 31.3718 31.3718C29.9441 32.7995 28.2491 33.932 26.3838 34.7046C24.5184 35.4773 22.5191 35.875 20.5 35.875L20.5 35.875Z"
                                            stroke="#33363F" stroke-width="2" stroke-linecap="round" />
                                        <path d="M15.375 15.375L25.625 25.625" stroke="#33363F" stroke-width="2"
                                            stroke-linecap="round" />
                                        <path d="M25.625 15.375L15.375 25.625" stroke="#33363F" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                            <div class="position-absolute start-0 top-0">
                                <img width="75" class="img-fluid" src="assets/img/emerald-logo.png" alt>
                            </div>
                            <!-- Login Screen -->
                            <div id="loginScreen" class="screen active">

                                <div class="col-12 d-flex flex-row gap-4 justify-content-center pb-3">
                                    <div class="text-center mt-4">
                                        <div class="fs-6">WELCOME TO </div>
                                        <div class="fs-5 fw-bold mt-2">EMERALD JEWEL INDUSTRY</div>
                                        <div class="fs-4 brittany-font mt-3">Retailer Program</div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>Verification code will be sent to your registered number.</div>
                                </div>

                                <hr>
                                <div class="col-12">
                                    <form id="loginForm" onsubmit="generateOTP(event)">
                                        @csrf
                                        <div class="form-group mt-4">
                                            <label class="form-label fw-medium" for="phoneNumber">Phone Number</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-transparent border-0">
                                                    <svg width="10" height="17" viewBox="0 0 10 17"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.66012 1.1217C9.65985 0.824351 9.54153 0.53926 9.33127 0.328986C9.12087 0.118591 8.83577 0.000403181 8.53841 0H1.45276C1.15541 0.000403836 0.870318 0.118591 0.659906 0.328986C0.449645 0.539247 0.331323 0.824347 0.331055 1.1217V12.979H9.66005L9.66012 1.1217Z"
                                                            fill="#ADADAD" />
                                                        <path
                                                            d="M1.45269 16.4601H8.53835C8.8357 16.4597 9.12079 16.3415 9.3312 16.1311C9.54146 15.9209 9.65978 15.6358 9.66005 15.3384V13.6443H0.331055V15.3384C0.331324 15.6358 0.449645 15.9208 0.659906 16.1311C0.870301 16.3415 1.15541 16.4597 1.45276 16.4601H1.45269ZM4.19601 14.5544H5.79489C5.97863 14.5544 6.1275 14.7033 6.1275 14.887C6.1275 15.0708 5.97863 15.2198 5.79489 15.2198H4.19601C4.01227 15.2198 3.8634 15.0708 3.8634 14.887C3.8634 14.7033 4.01227 14.5544 4.19601 14.5544Z"
                                                            fill="#ADADAD" />
                                                    </svg>
                                                </span>
                                                <input required type="text" 
                                                 id="phoneNumber"
                                                 oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                                 minlength="10" maxlength="10" 
                                                    class="form-control border-0 shadow-none"
                                                    placeholder="Enter phone number" aria-label="Phone Number"
                                                    aria-describedby="login page">
                                            </div>
                                            <div id="phoneError" class="error-message mt-3">
                                                Please enter a valid 10-digit phone number.
                                            </div>
                                        </div>
                                        <button id="loginButton" type="submit"
                                            class="btn login-page_card-btn mt-4 mb-2">
                                            <span class="spinner-border spinner-border-sm" style="display: none;"
                                                aria-hidden="true"></span>
                                            <span class="loginBtn_text">Login</span>
                                        </button>
                                    </form>
                                    <div class="mt-3">Don’t have an account? <a href="#"
                                            class="sign-up-text text-decoration-none fw-medium"
                                            onclick="showSignupScreenFromLogin()">Sign
                                            Up Now</a></div>
                                </div>
                            </div>

                            <!-- OTP Verify Screen -->
                            <div id="otpScreen" class="screen">
                                <div class="col-12 text-center mt-5">
                                    <div class="fs-4 fw-bold mb-3">
                                        Enter OTP
                                    </div>
                                    <input type="hidden" value="{{ print_r(session('mobile')) }}">
                                    <div class="mb-4">Code is sent to
                                        <span>{{ '+91 ' . session('mobile') }}</span>
                                    </div>
                                    <form id="otpForm" action="{{ route('retailerloginverfication') }}"
                                        method="GET">
                                        @php
                                            $role_id = App\Models\User::where('mobile', session('mobile'))->value(
                                                'role_id',
                                            );
                                        @endphp
                                        <input type="hidden" name="hdroleid" value="{{ $role_id }}">
                                        <input type="hidden" name="otpexpiry" id="otpexpiry"
                                            value="{{ $setting->otp_expiry_duration }}">
                                        <input type="hidden" name="authmob" id="authmob"
                                            value="{{ session('mobile') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <div class="otp-input_wrapper">
                                                <input minlength="5" maxlength="5" type="text"
                                                    class="form-control" id="otp" name="otp" required />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <button type="submit" id="loginVerifyBtn"
                                                class="btn login-page_card-btn">
                                                <span class="spinner-border spinner-border-sm" style="display: none;"
                                                    aria-hidden="true"></span>
                                                <span class="loginBtn_text">Submit</span>
                                            </button>
                                        </div>
                                        <div>Didn't receive the OTP? <span id="resendLinkContainer">
                                                <a class="resend-text text-decoration-none fw-medium"
                                                    onclick="restartTimer()">Resend</a></span></div>
                                    </form>
                                </div>
                            </div>
                            <!-- Signup Screen -->
                            <div id="signupScreen" class="screen">
                                <div class="col-12 d-flex flex-row gap-4 justify-content-center pb-3">
                                    <div class="text-center mt-4">
                                        <div class="fs-6">WELCOME TO </div>
                                        <div class="fs-5 fw-bold mt-2">EMERALD JEWEL INDUSTRY</div>
                                        <div class="fs-4 brittany-font mt-3">Retailer Program</div>
                                    </div>
                                </div>
                                <form id="signupForm" action="{{ route('retailerregisterstore') }}" method="POST">
                                    @csrf
                                    <div class="col-12 mt-4">
                                        <div class="row gy-3">
                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="name">Name<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your name" class="form-control"
                                                    type="text" name="name" id="name" />
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="shopName">Shop Name<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your shop name"
                                                    class="form-control" type="text" name="shopName"
                                                    id="shopName" />
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="signupPhoneNumber">Phone
                                                    Number<span class="text-danger">*</span></label>
                                                <input required placeholder="Enter your phone number"
                                                    class="form-control" type="text"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                                    minlength="10" maxlength="10" 
                                             name="signupPhoneNumber" id="signupPhoneNumber" />
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="email">Email<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your email" class="form-control"
                                                    type="email" name="email" id="email" />
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="address">Address<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your address" class="form-control"
                                                    type="text" name="address" id="address" />
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="pincode">Pincode<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your pincode" class="form-control"
                                                    type="number" name="pincode" id="pincode" />
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-semibold" for="">District<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your district" class="form-control"
                                                    type="text" name="district" id="district" readonly>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label class="form-label fw-medium" for="state">State<span
                                                        class="text-danger">*</span></label>
                                                <input required placeholder="Enter your state" class="form-control"
                                                    type="text" name="state" id="state" readonly />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-medium" for="gst">GST</label>
                                                <input placeholder="Enter your GST" class="form-control"
                                                    type="text" name="gst" id="gst" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-medium" for="dealerName">If you are
                                                    currently purchasing from any
                                                    existing AUTHORISED EMERALD DEALERS, Please enter their name</label>
                                                <textarea class="form-control" style="height: 100px" type="text" name="dealerName" id="dealerName"></textarea>
                                            </div>
                                        </div>
                                        <!-- End of form fields -->

                                        <!-- Error message for all inputs -->
                                        <div id="signupErrorMessage" class="error-message mt-3"
                                            style="display: none">
                                            Please fill out all required fields.
                                        </div>

                                        <div class="col-12 text-center">
                                            <div class="mt-4 mb-3">
                                                <button type="button" class="btn sign-up-page_btn mt-4"
                                                    onclick="handleSignup()">
                                                    Save
                                                </button>
                                            </div>
                                            <div>Already Registered?
                                                <a href="#" class="sign-up-text text-decoration-none fw-medium"
                                                    onclick="showLoginScreen()"> Sign In.</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Thank You Screen -->
                            <div id="thankYouScreen" class="screen">
                                <div class="col-12 py-5 text-center">
                                    <h5 class="mb-3">Thank You!</h5>
                                    <div>Your account has been created.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="no-login-required" style=" position: fixed; bottom: 30px; right: 10px; z-index: 9999; "
        target="_blank"
        href="https://api.whatsapp.com/send?phone=919791714333&text=I%20have%20questions%20regarding%20Retailer%20Management%20System">
        <img src="{{ asset('dealer/img/whatsapp.png') }}" width="62" height="62" alt="whatsapp icon">
    </a>

    <script src="{{ asset('dealer/lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('dealer/lib/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dealer/lib/js/splide.min.js') }}"></script>
    <script src="{{ asset('dealer/js/smartmenu.js') }}"></script>
    <script src="{{ asset('dealer/js/custom.js') }}"></script>
    <script src="{{ asset('dealer/js/login/login.js') }}"></script>
    <script src="{{ asset('common/common.js') }}"></script>
    <script src="{{ asset('dealer/lib/js/toastr.js') }}"></script>
    <script src="{{ asset('dealer/lib/js/moment.min.js') }}"></script>
    <script src="{{ asset('dealer/lib/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('dealer/lib/js/dataTables.js') }}"></script>
    <!-- Include SweetAlert2 JavaScript -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			var splide1 = new Splide('.home-main-img-slider-section', {
				type: 'slide',
				pagination: true,
				arrows: false,
				perPage: 1,
			}).mount();
			var splide2 = new Splide('#accreditations-slider', {
				type: 'slide',
				gap: '1rem',
				pagination: false,
				arrows: false,
				perPage: 6,
				perMove: 1,
				drag: 'free',
				
				breakpoints: {
					1640: {
						perPage: 6,
					},
					1340: {
						perPage: 6,
					},
					1040: {
						perPage: 6,
					},
					740: {
						perPage: 5,
					},
					640: {
						perPage: 4,
					},
					340: {
						perPage: 3,
					},
					250: {
						perPage: 2,
					},
				}
				
			}).mount();
		</script> --}}
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
        };
    </script> --}}

    @yield('scripts')
</body>

</html>
