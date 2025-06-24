@php
    $role_name = App\Models\User::join('roles', 'roles.id', 'users.role_id')
        ->where('users.id', Auth::user()->id)
        ->value('roles.role_name');
    $setting = App\Models\Settings::first();
    $products = App\Models\Product::groupBy('keywordtags')->pluck('keywordtags')->toArray();
    // Decode HTML entities before encoding JSON
    $encodedProducts = json_encode(array_map('htmlspecialchars_decode', $products));
@endphp
<section class="header">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container" style="flex-wrap: nowrap;overflow:visible;">
            <input type="hidden" name="suggestion" id="suggestion" value="{{ $encodedProducts }}">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" aria-controls="navbarScroll"
                aria-expanded="false" aria-label="Toggle navigation">
                <svg width="28" height="21" viewBox="0 0 28 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.6365 2.00024H2.00007" stroke="black" stroke-width="2.4977" stroke-linecap="round" />
                    <path d="M26.6365 19.4841H2.00007" stroke="black" stroke-width="2.4977" stroke-linecap="round" />
                    <path d="M18.6658 10.7422H1.99997" stroke="black" stroke-width="2.4977" stroke-linecap="round" />
                </svg>
            </button>

            <a class="navbar-brand" href="{{ route('landing') }}">
                <picture>
                    <source media="(min-width:650px)" srcset="{{ asset($setting->company_logo) }}">
                    <source media="(max-width:650px)" srcset="{{ asset($setting->company_logo) }}">
                    <img class="img-fluid" height="50" width="160"
                        src="{{ asset('frontend/img/mobile-logo.png') }}" alt="Flowers">
                </picture>
            </a>

            <div class="d-block d-lg-none">
                <ul class="d-flex align-items-center list-unstyled m-auto">

                    <li class="nav-item me-2">
                        <a class="nav-link" aria-current="page" href="#" data-bs-toggle="modal"
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
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('wishlist') }}" data-bs-toggle="tooltip"
                            data-placement="bottom" data-bs-title="Wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-heart">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="position-relative me-2">
                        <a class="nav-link" href="{{ route('cart') }}" data-bs-toggle="tooltip" data-placement="bottom"
                            data-bs-title="Cart">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28"
                                    viewBox="0 0 24 28" fill="none">
                                    <path
                                        d="M23.994 25.7391L22.7879 10.3393C22.7032 9.25208 21.767 8.40009 20.6568 8.40009H17.701V5.60006C17.701 2.51247 15.1437 0 12.0003 0C8.85717 0 6.29952 2.51216 6.29952 5.60006V8.40009H3.34377C2.23361 8.40009 1.29714 9.2519 1.21239 10.339L0.00628876 25.7388C-0.0394404 26.3201 0.165843 26.8988 0.569208 27.3267C0.972821 27.7549 1.54417 28 2.1379 28H21.8624C22.4559 28 23.0277 27.7546 23.4308 27.3269C23.8334 26.8992 24.0395 26.3203 23.9937 25.739L23.994 25.7391ZM7.72493 5.60056C7.72493 3.28465 9.64285 1.40067 12.0003 1.40067C14.3578 1.40067 16.2758 3.28471 16.2758 5.60056V8.40059L7.7248 8.40035L7.72493 5.60056ZM22.3856 26.376C22.2494 26.5205 22.0635 26.6003 21.8627 26.6003H2.13825C1.93769 26.6003 1.75179 26.5205 1.6151 26.376C1.47866 26.2314 1.41205 26.0434 1.42771 25.8467L1.58801 23.8003H14.1383C14.3349 23.8003 14.4947 23.6436 14.4947 23.4502C14.4947 23.2571 14.3352 23.1001 14.1383 23.1001L1.64272 23.1004L2.63359 10.4468C2.66192 10.084 2.97408 9.80026 3.34388 9.80026H6.29962V13.3002C6.29962 13.6867 6.61898 14.0001 7.01214 14.0001C7.40556 14.0001 7.72466 13.6864 7.72466 13.3002L7.7249 9.80026H16.2759V13.3002C16.2759 13.6867 16.5952 14.0001 16.9884 14.0001C17.3818 14.0001 17.7009 13.6864 17.7009 13.3002L17.7011 9.80026H20.6569C21.0272 9.80026 21.3391 10.0842 21.3674 10.4468L22.358 23.1004H16.9884C16.7918 23.1004 16.632 23.2571 16.632 23.4505C16.632 23.6436 16.7915 23.8006 16.9884 23.8006H22.413L22.5733 25.8469C22.5887 26.0434 22.5221 26.2309 22.3856 26.376ZM15.9196 23.4502C15.9196 23.6433 15.76 23.8003 15.5632 23.8003C15.3666 23.8003 15.2068 23.6436 15.2068 23.4502C15.2068 23.2571 15.3664 23.1001 15.5632 23.1001C15.7598 23.1004 15.9196 23.2571 15.9196 23.4502Z"
                                        fill="#3F3F3F"></path>
                                </svg>
                            </span>
                            @php
                                $cartcount = App\Models\Cart::where('user_id', Auth::user()->id)->count();
                            @endphp
                            <span id="cartCount" class="mobile-cart-badge">
                                {{ $cartcount }}</span>
                        </a>
                    </li>

                    <a class="nav-link d-flex align-items-center dropdown-toggle profile-nav-link" href="#"
                        id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-pic">
                            <img class="rounded-5" width="28" height="28"
                                src="{{ Auth::user()->user_image == null ? asset('frontend/img/no-profile.jpg') : asset(Auth::user()->user_image) }}"
                                alt="Profile Picture">
                            {{-- <img class="rounded-5" width="30" height="30"
                                    src="https://source.unsplash.com/250x250?boy" alt="Profile Picture"> --}}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">
                            <div>
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <div><small>{{ strtoupper($role_name) }}</small></div>
                            </div>
                        </li>
                        @if (Auth()->user()->role_id != App\Enums\Roles::Admin)
                            <li class="dropdown-item"><a class="nav-link" href="{{ route('dealerdashboard') }}"><i
                                        class="fas fa-user fa-fw"></i> My Account</a></li>
                            <li class="dropdown-item"><a class="nav-link" href="{{ route('myprofile') }}"><i
                                        class="fas fa-user-circle fa-fw"></i> My
                                    Profile</a></li>
                            <li class="dropdown-item"><a class="nav-link" href="{{ route('orders') }}"><i
                                        class="fas fa-shopping-cart fa-fw"></i> Orders</a></li>
                            <li class="dropdown-item"><a class="nav-link" href="{{ route('logout') }}"><i
                                        class="fas fa-sign-out-alt fa-fw"></i> Log
                                    Out</a>
                            </li>
                        @endif
                    </ul>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <!-- <div class="ms-auto d-none d-lg-block flex-grow-1">
                    <div id="search-container">
                        <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group nav-search-input">
                                {{-- <div class=" input-group-append">
                                    <select aria-describedby="searchDropdownDescription" class="form-select"
                                        id="search-bar-dropdown">
                                        <option value="">All</option>
                                        <option value="">Idols</option>
                                        <option value="">Rings</option>
                                        <option value="">Earrings</option>
                                        <option value="">Pendants</option>
                                        <option value="">Braclets</option>
                                        <option value="">Necklace</option>
                                    </select>
                                </div> --}}

                                <input placeholder="Search for Emerald Products" class="form-control" type="search"
                                    name="search" id="main-search-input" />
                                <div class="input-group-append">

                                    <button class="btn btn-warning" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22"
                                            viewBox="0 0 23 23" fill="none">
                                            <path
                                                d="M18.1048 16.2301L17.9986 16.3692L18.1224 16.4929L22.5262 20.8968C22.7777 21.1941 22.8629 21.5978 22.7526 21.9713C22.6413 22.3472 22.3472 22.6413 21.9712 22.7526C21.5975 22.8629 21.1937 22.7779 20.8966 22.5265L16.4927 18.1226L16.369 17.9989L16.2299 18.1051C13.5223 20.1721 9.94761 20.7149 6.74879 19.5447C3.54997 18.3746 1.16944 15.6532 0.4349 12.3273L0.239685 12.3704L0.434899 12.3273C-0.299628 9.00155 0.713692 5.53048 3.1219 3.12195C5.53009 0.713444 9.00116 -0.29961 12.3271 0.434938L12.3702 0.239892L12.3271 0.434938C15.653 1.16948 18.3743 3.55004 19.5445 6.74889C20.7146 9.94791 20.1718 13.5226 18.1048 16.2301ZM4.76584 4.76655L4.76584 4.76656C3.32891 6.20358 2.5216 8.15242 2.5216 10.1847C2.5216 12.217 3.32883 14.1658 4.76584 15.6028L4.90726 15.4614L4.76584 15.6028C6.20285 17.0398 8.15175 17.8471 10.1839 17.8471C12.2162 17.8471 14.165 17.0399 15.602 15.6028L15.4606 15.4614L15.602 15.6028C17.0389 14.1658 17.8462 12.217 17.8462 10.1847C17.8462 8.15242 17.039 6.20358 15.602 4.76655L15.4606 4.90797L15.602 4.76655C14.165 3.3296 12.2162 2.52228 10.1839 2.52228C8.15168 2.52228 6.20285 3.32952 4.76584 4.76655Z"
                                                fill="#ffffff" stroke="#F8EDE3" stroke-width="0.4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div id="suggestions-container"></div>
                    </div>
                </div> -->
                <ul
                    class=" d-none d-lg-flex top-main-nav navbar-nav navbar-right align-items-center ms-auto my-2 my-lg-0">
                    @php
                        $projects = App\Models\Project::where('is_active', 1)->whereNull('deleted_at')->get();
                    @endphp
                    <li class="d-flex gap-3 me-3">
                        <div>
                            <a class="spinner-button btn new-arrivals-btn px-4" href="{{ route('newarrivals') }}">
                                <span>New
                                    Arrivals</span> <span class="d-none spinner">
                                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                    <span role="status">Loading...</span>
                                </span></a></a>
                        </div>
                        {{-- <div>
                            <a class="spinner-button btn btn-warning px-4" href="{{ route('readystock') }}">
                                <span>Ready Stock</span> <span class="d-none spinner">
                                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                    <span role="status">Loading...</span>
                                </span></a>
                        </div> --}}
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('wishlist') }}" data-bs-toggle="tooltip"
                            data-placement="down" data-bs-title="Wishlist">
                            <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.2738 11.4159L11.6068 19.203L3.94681 11.4159C-2.82263 4.54604 4.85018 -3.23181 11.6138 3.638C18.4766 -3.33219 26.1436 4.44566 19.2808 11.4252L19.2738 11.4159Z" stroke="#2D2D2D" stroke-width="1.18569" stroke-linejoin="round"/>
                            </svg>
                            <div class="mt-1">WISHLIST</div>
                        </a>
                    </li>
                    <li class="position-relative me-3">
                        <a class="nav-link" href="{{ route('cart') }}" data-bs-toggle="tooltip"
                            data-placement="down" data-bs-title="Cart">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33"
                                    viewBox="0 0 33 33" fill="none">
                                    <g clip-path="url(#clip0_2604_2358)">
                                        <path
                                            d="M8.82057 19.5635H28.0706C28.1871 19.5632 28.3001 19.5238 28.3914 19.4514C28.4827 19.3791 28.5469 19.2781 28.5738 19.1648L30.9182 9.20288H6.79932"
                                            stroke="#F78D1E" stroke-width="1.5"></path>
                                        <path
                                            d="M12.0272 28.8599C12.5982 28.8599 13.0612 28.3969 13.0612 27.8259C13.0612 27.2548 12.5982 26.7919 12.0272 26.7919C11.4561 26.7919 10.9932 27.2548 10.9932 27.8259C10.9932 28.3969 11.4561 28.8599 12.0272 28.8599Z"
                                            stroke="#F78D1E" stroke-width="1.5"></path>
                                        <path
                                            d="M24.7308 28.8599C25.3018 28.8599 25.7648 28.3969 25.7648 27.8259C25.7648 27.2548 25.3018 26.7919 24.7308 26.7919C24.1597 26.7919 23.6968 27.2548 23.6968 27.8259C23.6968 28.3969 24.1597 28.8599 24.7308 28.8599Z"
                                            stroke="#F78D1E" stroke-width="1.5"></path>
                                        <path
                                            d="M27.2633 24.7225H10.3041C10.1861 24.7223 10.0719 24.6811 9.98102 24.6058C9.89017 24.5305 9.82841 24.4259 9.80634 24.31L6.26022 6.62612C6.23647 6.50977 6.17329 6.40519 6.08135 6.33003C5.98941 6.25487 5.87434 6.21376 5.75559 6.21362H2.08984"
                                            stroke="#F78D1E" stroke-width="1.5"></path>
                                    </g>
                                    <defs>
                                        <clippath id="clip0_2604_2358">
                                            <rect width="33" height="33" fill="white"></rect>
                                        </clippath>
                                    </defs>
                                </svg>
                            </span>
                            <div class="mt-1">Cart</div>
                            <span id="cartCount" class="cart-badge">
                                {{ $cartcount }}</span>
                        </a>
                    </li>
                    <a class="nav-link d-flex align-items-center dropdown-toggle"
                        style=" color: #2D2D2D !important; border-left: 1px solid #D3D3D3;padding-left:10px;"
                        href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="profile-pic">
                            <img class="rounded-5" width="50" height="50"
                                src="{{ Auth::user()->user_image == null ? asset('frontend/img/no-profile.jpg') : asset(Auth::user()->user_image) }}"
                                alt="Profile Picture">
                            {{-- <img class="rounded-5" width="50" height="50"
                                    src="https://source.unsplash.com/250x250?boy" alt="Profile Picture"> --}}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">
                            <div>
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
                                <div><small>{{ strtoupper($role_name) }}</small></div>
                            </div>
                        </li>
                        @if (Auth()->user()->role_id != App\Enums\Roles::Admin)
                            <li class="dropdown-item"><a class="nav-link"
                                    style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                                    href="{{ route('dealerdashboard') }}"><i class="fas fa-user fa-fw"></i> My
                                    Account</a></li>
                            <li class="dropdown-item"><a class="nav-link"
                                    style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                                    href="{{ route('myprofile') }}"><i class="fas fa-user-circle fa-fw"></i> My
                                    Profile</a></li>
                            <li class="dropdown-item"><a class="nav-link"
                                    style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                                    href="{{ route('orders') }}"><i class="fas fa-shopping-cart fa-fw"></i>
                                    Orders</a>
                            </li>
                            <li class="dropdown-item"><a class="nav-link"
                                    style="color: #2D2D2D !important; text-align: left;padding-left: 0px;"
                                    href="{{ route('logout') }}"><i class="fas fa-sign-out-alt fa-fw"></i> Log
                                    Out</a></li>
                        @endif
                    </ul>
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul id="mobile-main-menu" class="sm sm-blue">
                @foreach ($projects as $project)
                    <li><a href="{{ route('projects', encrypt($project->id)) }}" id="project-link"
                            class="project-link"
                            data-project-id="{{ $project->id }}">{{ str_replace('SIL ', '', $project->project_name) }}</a>
                        <ul>
                            @php
                                $categories = App\Models\Category::where('project_id', $project->id)
                                    ->where('is_active', 1)
                                    ->whereNull('deleted_at')
                                    ->get();
                            @endphp
                            @foreach ($categories as $category)
                                <li data-category-id="{{ $category->id }}"
                                    data-category-name="{{ $category->category_name }}">
                                    @php
                                        session()->put('selected_project_id', $project->id);
                                        session()->put('selected_category_id', $category->id);
                                    @endphp
                                    <a class="category-link" data-category-id="{{ $category->id }}"
                                        href="{{ route('shop', encrypt($category->id)) }}">{{ $category->category_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


</section>


<!-- <section class="section d-none d-lg-block bottom-menu">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="d-flex gap-2 justify-content-between align-items-center">
                    <nav id="main-nav" class="main-mega-nav my-3">
              
                        <ul id="main-menu" class="sm sm-blue">
                            @foreach ($projects as $project)
                                <li>
                                    <a href="{{ route('projects', encrypt($project->id)) }}" id="project-link"
                                        class="project-link"
                                        data-project-id="{{ $project->id }}">{{ str_replace('SIL ', '', $project->project_name) }}</a>
                                    <ul>
                                        @php
                                            $categories = App\Models\Category::where('project_id', $project->id)
                                                ->where('is_active', 1)
                                                ->whereNull('deleted_at')
                                                ->get();
                                        @endphp
                                        @foreach ($categories as $category)
                                            <li data-category-id="{{ $category->id }}"
                                                data-category-name="{{ $category->category_name }}">
                                                @php
                                                    session()->put('selected_project_id', $project->id);
                                                    session()->put('selected_category_id', $category->id);
                                                @endphp
                                                <a class="category-link" data-category-id="{{ $category->id }}"
                                                    href="{{ route('shop', encrypt($category->id)) }}">{{ $category->category_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section> -->

<div class="modal" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #F8F9FA;">
            <div class="modal-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group nav-search-input p-0">
                            <input placeholder="Search for Emerald Products" class="form-control" type="search"
                                name="search" id="search">
                            {{-- need to add above for suggestion onkeyup="showSuggestions()" --}}
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22"
                                        viewBox="0 0 23 23" fill="none">
                                        <path
                                            d="M18.1048 16.2301L17.9986 16.3692L18.1224 16.4929L22.5262 20.8968C22.7777 21.1941 22.8629 21.5978 22.7526 21.9713C22.6413 22.3472 22.3472 22.6413 21.9712 22.7526C21.5975 22.8629 21.1937 22.7779 20.8966 22.5265L16.4927 18.1226L16.369 17.9989L16.2299 18.1051C13.5223 20.1721 9.94761 20.7149 6.74879 19.5447C3.54997 18.3746 1.16944 15.6532 0.4349 12.3273L0.239685 12.3704L0.434899 12.3273C-0.299628 9.00155 0.713692 5.53048 3.1219 3.12195C5.53009 0.713444 9.00116 -0.29961 12.3271 0.434938L12.3702 0.239892L12.3271 0.434938C15.653 1.16948 18.3743 3.55004 19.5445 6.74889C20.7146 9.94791 20.1718 13.5226 18.1048 16.2301ZM4.76584 4.76655L4.76584 4.76656C3.32891 6.20358 2.5216 8.15242 2.5216 10.1847C2.5216 12.217 3.32883 14.1658 4.76584 15.6028L4.90726 15.4614L4.76584 15.6028C6.20285 17.0398 8.15175 17.8471 10.1839 17.8471C12.2162 17.8471 14.165 17.0399 15.602 15.6028L15.4606 15.4614L15.602 15.6028C17.0389 14.1658 17.8462 12.217 17.8462 10.1847C17.8462 8.15242 17.039 6.20358 15.602 4.76655L15.4606 4.90797L15.602 4.76655C14.165 3.3296 12.2162 2.52228 10.1839 2.52228C8.15168 2.52228 6.20285 3.32952 4.76584 4.76655Z"
                                            fill="#F78D1E" stroke="#F8EDE3" stroke-width="0.4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="suggestions"></div>
                </div>
                <!-- Add other search bar elements as needed -->
                <div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <!-- Add additional modal content or buttons if necessary -->
        </div>
    </div>
</div>
@section('scripts')
    <script src="{{ asset('frontend/js/smartmenu.js') }}"></script>
   
   <script>
        function addClickEventToMenuLinks() {
            // Get all the links inside the main-menu
            let menuLinks = document.querySelectorAll('#main-menu a');

            // Loop through each link
            menuLinks.forEach(function(link) {
                // Add click event listener to each link
                link.addEventListener('click', function() {
                    // console.log("clicked")
                    // Get the preloader element
                    let preloader = document.getElementById('preloader');

                    // Set its display style to 'flex'
                    preloader.style.display = 'flex';
                });
            });
        }

        // Call the function to add click events to menu links
        addClickEventToMenuLinks();

        function addClickEventToMobileMenuLinks() {
            // Get all the links inside the main-menu
            let menuLinks = document.querySelectorAll('#mobile-main-menu a');

            // Loop through each link
            menuLinks.forEach(function(link) {
                // Add click event listener to each link
                link.addEventListener('click', function() {
                    // console.log("clicked")
                    // Get the preloader element
                    let preloader = document.getElementById('preloader');

                    // Set its display style to 'flex'
                    preloader.style.display = 'flex';
                });
            });
        }

        addClickEventToMobileMenuLinks()
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

