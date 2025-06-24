@php
    $role_name = App\Models\User::join('roles', 'roles.id', 'users.role_id')
        ->where('users.id', Auth::user()->id ?? 0)
        ->value('roles.role_name');
    $cartQty = App\Models\Cart::where('user_id', Auth::user()->id ?? 0)->sum('qty');
    $cartWeight = App\Models\Cart::select(DB::raw('SUM(carts.qty * products.weight) as totalWeight'))
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->where('carts.user_id', Auth::user()->id ?? 0)
        ->value('totalWeight');
@endphp
<div class="container">
    {{-- <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
        aria-controls="offcanvasMenu" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <svg width="28" height="21" viewBox="0 0 28 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M26.6365 2.00024H2.00007" stroke="black" stroke-width="2.4977" stroke-linecap="round" />
            <path d="M26.6365 19.4841H2.00007" stroke="black" stroke-width="2.4977" stroke-linecap="round" />
            <path d="M18.6658 10.7422H1.99997" stroke="black" stroke-width="2.4977" stroke-linecap="round" />
        </svg>
    </button> --}}
    <a class="navbar-brand" href="{{ route('landing') }}">
        <picture>
            <source media="(min-width:650px)" srcset="{{ asset('dealer/img/logo.svg') }}" />
            <source media="(max-width:650px)" srcset="{{ asset('dealer/img/logo.svg') }}" />
            <img class="img-fluid" height="50" width="160" src="{{ asset('dealer/img/logo.svg') }}"
                alt="Emerald Logo" />
        </picture>
    </a>
    <div class="d-block d-xl-none">
        <ul class="d-flex align-items-center list-unstyled m-auto">
            <li class="nav-item me-3">
                <a class="nav-link" aria-current="page" href="" data-bs-toggle="modal"
                    data-bs-target="#searchModal">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.26029 5.71468C6.82903 5.28342 6.14608 5.28342 5.75063 5.71468C4.27685 7.18845 3.4502 9.16545 3.4502 11.2861C3.4502 13.3709 4.27685 15.3479 5.75063 16.8575C5.96625 17.0731 6.25383 17.181 6.50559 17.181C6.75732 17.181 7.04465 17.0731 7.26054 16.8575C7.6918 16.4263 7.6918 15.7433 7.26054 15.3479C6.18215 14.2695 5.57116 12.8318 5.57116 11.3222C5.57116 9.81251 6.18218 8.37461 7.26054 7.29648C7.65569 6.82887 7.65568 6.14594 7.26029 5.71468Z"
                            fill="#EB752C" />
                        <path
                            d="M27.6766 26.167L19.9845 18.439C20.7033 17.5403 21.3144 16.5698 21.7458 15.5275C22.2849 14.1616 22.5725 12.7598 22.5725 11.2862C22.5725 9.81246 22.2849 8.41063 21.7458 7.04495C21.1707 5.64312 20.344 4.38501 19.2656 3.30687C18.1872 2.22848 16.9294 1.40183 15.5275 0.826654C14.1616 0.287593 12.7598 0 11.2862 0C9.81246 0 8.41063 0.287586 7.04494 0.826654C5.64312 1.40182 4.38501 2.22848 3.30687 3.30687C2.22848 4.38526 1.40183 5.64312 0.826653 7.04495C0.287592 8.41089 0 9.81272 0 11.2862C0 12.76 0.287586 14.1618 0.826653 15.5275C1.40182 16.9294 2.22848 18.1875 3.30687 19.2656C4.38526 20.344 5.64312 21.1707 7.04494 21.7458C8.41089 22.2849 9.81272 22.5725 11.2862 22.5725C12.76 22.5725 14.1618 22.2849 15.5275 21.7458C16.6059 21.3146 17.5765 20.7394 18.439 19.9845L26.167 27.6766C26.3826 27.8922 26.6702 28 26.9219 28C27.2095 28 27.461 27.8922 27.6769 27.6766C28.1079 27.2812 28.1079 26.5982 27.6766 26.1669L27.6766 26.167ZM11.286 20.3799C8.8419 20.3799 6.57735 19.4455 4.85196 17.72C1.29341 14.1615 1.29341 8.41044 4.85196 4.85196C6.61329 3.09063 8.9496 2.19202 11.286 2.19202C13.6222 2.19202 15.9588 3.09063 17.72 4.85196C21.2785 8.41051 21.2785 14.1615 17.72 17.72C15.9947 19.4453 13.7302 20.3799 11.286 20.3799Z"
                            fill="#3F3F3F" />
                    </svg>
                </a>
            </li>

            <li class="position-relative me-3">
                <a class="nav-link" href="{{ route('cart') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28" viewBox="0 0 24 28"
                            fill="none">
                            <path
                                d="M23.994 25.7391L22.7879 10.3393C22.7032 9.25208 21.767 8.40009 20.6568 8.40009H17.701V5.60006C17.701 2.51247 15.1437 0 12.0003 0C8.85717 0 6.29952 2.51216 6.29952 5.60006V8.40009H3.34377C2.23361 8.40009 1.29714 9.2519 1.21239 10.339L0.00628876 25.7388C-0.0394404 26.3201 0.165843 26.8988 0.569208 27.3267C0.972821 27.7549 1.54417 28 2.1379 28H21.8624C22.4559 28 23.0277 27.7546 23.4308 27.3269C23.8334 26.8992 24.0395 26.3203 23.9937 25.739L23.994 25.7391ZM7.72493 5.60056C7.72493 3.28465 9.64285 1.40067 12.0003 1.40067C14.3578 1.40067 16.2758 3.28471 16.2758 5.60056V8.40059L7.7248 8.40035L7.72493 5.60056ZM22.3856 26.376C22.2494 26.5205 22.0635 26.6003 21.8627 26.6003H2.13825C1.93769 26.6003 1.75179 26.5205 1.6151 26.376C1.47866 26.2314 1.41205 26.0434 1.42771 25.8467L1.58801 23.8003H14.1383C14.3349 23.8003 14.4947 23.6436 14.4947 23.4502C14.4947 23.2571 14.3352 23.1001 14.1383 23.1001L1.64272 23.1004L2.63359 10.4468C2.66192 10.084 2.97408 9.80026 3.34388 9.80026H6.29962V13.3002C6.29962 13.6867 6.61898 14.0001 7.01214 14.0001C7.40556 14.0001 7.72466 13.6864 7.72466 13.3002L7.7249 9.80026H16.2759V13.3002C16.2759 13.6867 16.5952 14.0001 16.9884 14.0001C17.3818 14.0001 17.7009 13.6864 17.7009 13.3002L17.7011 9.80026H20.6569C21.0272 9.80026 21.3391 10.0842 21.3674 10.4468L22.358 23.1004H16.9884C16.7918 23.1004 16.632 23.2571 16.632 23.4505C16.632 23.6436 16.7915 23.8006 16.9884 23.8006H22.413L22.5733 25.8469C22.5887 26.0434 22.5221 26.2309 22.3856 26.376ZM15.9196 23.4502C15.9196 23.6433 15.76 23.8003 15.5632 23.8003C15.3666 23.8003 15.2068 23.6436 15.2068 23.4502C15.2068 23.2571 15.3664 23.1001 15.5632 23.1001C15.7598 23.1004 15.9196 23.2571 15.9196 23.4502Z"
                                fill="#3F3F3F"></path>
                        </svg>
                    </span>
                    @php
                        $cartcount = App\Models\Cart::where('user_id', Auth::user()->id ?? 0)->count();
                    @endphp
                    <span class="mobile-cart-badge {{ $cartcount > 0 ? 'shake-animation' : '' }}" id="cartCount">
                        {{ $cartcount }} </span>
                </a>
            </li>

            <li
                style="font-size: 12px; padding: 5px; border-radius: 6px; background: #2D2D2D; color: #fff; width: max-content; ">
                <div style="border-bottom: 1px solid #fff;">
                    <span>Qty: </span><span id="navqty-mob">{{ $cartQty }} Pcs</span>
                </div>
                <div>
                    <span>Wt: </span><span id="navweight-mob">{{ $cartWeight ?? 0 }}gms</span>
                </div>
            </li>

        </ul>
    </div>
    <div class="collapse navbar-collapse" id="navbarScroll">
    </div>

    <ul class="d-none d-xl-flex align-items-center top-main-nav navbar-nav gap-2  flex-grow-1">
        <li class="nav-item dropdown me-2 top-nav-drop-down">
            <a class="nav-link dropdown-toggle nav-drop-down-link px-3 fw-semibold" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                Ready Stock
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('efreadystock') }}">Electro Forming</a></li>
                <li><a class="dropdown-item" href="{{ route('sireadystock') }}">Solid Idols</a></li>
                <li><a class="dropdown-item" href="{{ route('jewelleryreadystock') }}">Casting</a></li>
                <li><a class="dropdown-item" href="{{ route('jewelleryreadystock') }}">Indiania</a></li>
                <li><a class="dropdown-item" href="{{ route('jewelleryreadystock') }}">Utensil</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('efstock') }}">Electro Forming</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sistock') }}">Solid Idols</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jewellerystock') }}">Casting</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('indianiastock') }}">Indiania</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('utensilstock') }}">Utensil</a>
        </li>
    </ul>

    <ul
        class="d-none d-xl-flex top-main-nav navbar-nav navbar-right  justify-content-end  align-items-center ms-auto my-2 my-lg-0">
        <!-- <li class="nav-item me-2 me-xxl-3">
            <a class="btn rk-custom-btn px-2 px-xxl-4 efreadystock" href="{{ route('efreadystock') }}">EF Idol Ready
                Stock</a>
        </li>

        <li class="nav-item me-2 me-xxl-3">
            <a class="btn rk-custom-btn px-2 px-xxl-4 sireadystock" href="{{ route('sireadystock') }}">Solid Idol
                Ready
                Stock</a>
        </li>
        <li class="nav-item me-2 me-xxl-5">
            <a class="btn rk-custom-btn px-2 px-xxl-4 jewelleryreadystock" href="{{ route('jewelleryreadystock') }}">Jewellery
                Ready
                Stock</a>
        </li> -->

        <li>
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">

                <svg width="20" height="20" viewBox="0 0 21 22" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.3585 15.1686C16.6905 13.6322 17.5012 11.6318 17.5012 9.44194C17.5012 4.61821 13.5749 0.692383 8.75061 0.692383C3.9263 0.692383 0 4.62071 0 9.44444C0 14.2682 3.9263 18.194 8.75061 18.194C10.9383 18.194 12.9413 17.3859 14.4779 16.0515L19.8211 21.3965L20.7041 20.5136L15.3585 15.1686ZM8.75061 16.9469C4.61478 16.9469 1.24724 13.5823 1.24724 9.44444C1.24724 5.3066 4.61228 1.94196 8.75061 1.94196C12.8889 1.94196 16.254 5.3066 16.254 9.44444C16.254 11.2876 15.583 12.9787 14.4754 14.2856C14.3407 14.4453 14.201 14.5999 14.0539 14.747C13.9067 14.8942 13.752 15.0339 13.5924 15.1686C12.2853 16.276 10.594 16.9469 8.75061 16.9469Z"
                        fill="#2D2D2D" />
                </svg>
                <!-- <div class="mt-1">Search</div> -->
            </a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('wishlist') }}">
                <svg width="28" height="29" viewBox="0 0 28 29" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_7373_10539)">
                        <path
                            d="M21.4515 16.3377L13.8719 24.0361L6.2992 16.3377C-0.393109 9.54612 7.19228 1.85688 13.8788 8.64842C20.6634 1.75765 28.243 9.44688 21.4584 16.3469L21.4515 16.3377Z"
                            stroke="inherit" stroke-width="1.6
                        " stroke-linejoin="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_7373_10539">
                            <rect width="27.6923" height="27.6923" fill="white"
                                transform="translate(0.0384521 0.730713)" />
                        </clipPath>
                    </defs>
                </svg>

                <!-- <div class="mt-1">WISHLIST</div> -->
            </a>
        </li>
        <li class="position-relative me-3">
            <a class="nav-link" href="{{ route('cart') }}">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="30" viewBox="0 0 29 30"
                        fill="none">
                        <g clip-path="url(#clip0_7373_10545)">
                            <path
                                d="M7.9601 17.853H24.6188C24.7196 17.8528 24.8173 17.8186 24.8964 17.756C24.9754 17.6934 25.031 17.606 25.0543 17.5079L27.083 8.88708H6.21094"
                                stroke="inherit" stroke-width="1.29808" />
                            <path
                                d="M10.735 25.898C11.2292 25.898 11.6298 25.4974 11.6298 25.0032C11.6298 24.509 11.2292 24.1084 10.735 24.1084C10.2408 24.1084 9.84021 24.509 9.84021 25.0032C9.84021 25.4974 10.2408 25.898 10.735 25.898Z"
                                stroke="inherit" stroke-width="1.6" />
                            <path
                                d="M21.7285 25.898C22.2227 25.898 22.6234 25.4974 22.6234 25.0032C22.6234 24.509 22.2227 24.1084 21.7285 24.1084C21.2344 24.1084 20.8337 24.509 20.8337 25.0032C20.8337 25.4974 21.2344 25.898 21.7285 25.898Z"
                                stroke="inherit" stroke-width="1.6" />
                            <path
                                d="M23.9204 22.3176H9.24411C9.142 22.3175 9.04314 22.2817 8.96452 22.2166C8.88591 22.1514 8.83245 22.0609 8.81336 21.9606L5.7446 6.65726C5.72405 6.55658 5.66937 6.46607 5.58981 6.40103C5.51024 6.33599 5.41067 6.30041 5.3079 6.30029H2.13562"
                                stroke="inherit" stroke-width="1.6" />
                        </g>
                        <defs>
                            <clipPath id="clip0_7373_10545">
                                <rect width="28.5577" height="28.5577" fill="white"
                                    transform="translate(0.327026 0.923096)" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <!-- <div class="mt-1">Cart</div> -->
                @php
                    $cartcount = App\Models\Cart::where('user_id', Auth::user()->id ?? 0)->count();
                @endphp
                <span class="cart-badge {{ $cartcount > 0 ? 'shake-animation' : '' }}" id="cartCount">
                    {{ $cartcount }} </span>
            </a>
        </li>
        <li class="me-3"
            style="font-size: 12px; padding: 5px; border-radius: 6px; background: #2D2D2D; color: #fff; width: max-content; ">
            <div style="border-bottom: 1px solid #fff;">
                <span>Qty: </span><span id="navqty">{{ $cartQty }} Pcs</span>
            </div>
            <div>
                <span>Wt: </span><span id="navweight">{{ $cartWeight ?? 0 }}gms</span>
            </div>
        </li>
        <li class="nav-item dropdown ps-2 profile-pic-dropdown" style="border-left: 1px solid #D3D3D3;">
            <a class="nav-link d-flex align-items-center dropdown-toggle" style=" color: #2D2D2D !important;"
                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-pic">
                    @auth
                        <img class="rounded-5" width="42" height="42"
                            src="{{ Auth::user()->user_image == null ? asset('no-profile.jpg') : asset(Auth::user()->user_image) }}"
                            alt="Profile Picture">
                    @else
                        <img class="rounded-5" width="42" height="42" src="{{ asset('no-profile.jpg') }}"
                            alt="Profile Picture">
                    @endauth
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li class="dropdown-item">
                    <div>
                        @auth
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <div><small>{{ strtoupper($role_name) }}</small></div>
                        @endauth
                    </div>
                </li>
                <li class="dropdown-item"><a class="nav-link"
                        style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                        href="{{ route('myprofile') }}"><i class="fas fa-user-circle fa-fw"></i> My
                        Profile</a></li>
                <li class="dropdown-item"><a class="nav-link"
                        style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                        href="{{ route('orders') }}"><i class="fas fa-shopping-cart fa-fw"></i>
                        Orders</a>
                </li>
                @auth
                    <li class="dropdown-item"><a class="nav-link"
                            style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                            href="{{ route('retailerlogout') }}"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a>
                    </li>
                @endauth
            </ul>
        </li>
    </ul>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current URL path
        var path = window.location.pathname;

        // Remove leading slash if present
        if (path.charAt(0) === '/') {
            path = path.substr(1);
        }

        // Define a mapping of paths to nav item classes
        var navItems = {
            'efreadystock': 'efreadystock',
            'sireadystock': 'sireadystock',
            'jewelleryreadystock': 'jewelleryreadystock'
        };

        // Iterate over navItems to find a match
        for (var key in navItems) {
            if (path.includes(key)) {
                // Get all elements with the matching class and add the 'active' class
                var elements = document.getElementsByClassName(navItems[key]);
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.add('active');
                }
            }
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" crossorigin="anonymous">
</script>
<script src="https://unpkg.com/html5-qrcode"></script>


<style>
    #reader {
        width: 300px;
        margin: auto;
    }

    #scan-button {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 16px;
    }
</style>

<style>
    .footer-links_link {
        display: flex;
        align-items: center;
    }
</style>
