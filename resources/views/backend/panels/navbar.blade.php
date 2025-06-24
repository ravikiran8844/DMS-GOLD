<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                    <i data-feather="align-justify"></i></a>
            </li>
            <li><a data-bs-toggle="tooltip" data-placement="top" title="Max View" href="#" href="#"
                    class="nav-link nav-link-lg fullscreen-btn">
                    <i data-feather="maximize"></i>
                </a>
            </li>
            <li><a data-bs-toggle="tooltip" data-placement="top" href="{{ route('landing') }}" title="Live Site"
                    target="_blank" class="nav-link nav-link-lg">
                    <i data-feather="globe"></i>
                </a>
            </li>
            <li><a data-bs-toggle="tooltip" data-placement="top"
                    href="https://emeraldcm.brightbridge.co/" title="Catelogue Maker"
                    class="btn btn-sm"
                    style="background-color: #f78e32;
    font-family: sans-serif;
    font-size: 14px;
    border-radius: 50px;
    padding: 5px 12px;
    margin-left: 12px;"
                    target="_blank" class="nav-link nav-link-lg">
                    <b>Catalogue Maker</b>
                </a>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        {{-- <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i
                    data-feather="message-square"></i>
                <span class="badge headerBadge1 bg-danger">
                    1 </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                <div class="dropdown-header">
                    Messages
                    <div class="float-right">
                        <a>Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('backend/assets/img/users/user-1.png') }}"
                                class="rounded-circle">
                        </span> <span class="dropdown-item-desc"> <span class="message-user">John
                                Deo</span>
                            <span class="time messege-text">Please check your mail !!</span>
                            <span class="time">2 Min Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('backend/assets/img/users/user-2.png') }}"
                                class="rounded-circle">
                        </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                Smith</span> <span class="time messege-text">Request for leave
                                application</span>
                            <span class="time">5 Min Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('backend/assets/img/users/user-5.png') }}"
                                class="rounded-circle">
                        </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                                Ryan</span> <span class="time messege-text">Your payment invoice is
                                generated.</span> <span class="time">12 Min Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('backend/assets/img/users/user-4.png') }}"
                                class="rounded-circle">
                        </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                                Smith</span> <span class="time messege-text">hii John, I have upload
                                doc
                                related to task.</span> <span class="time">30
                                Min Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('backend/assets/img/users/user-3.png') }}"
                                class="rounded-circle">
                        </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                                Joshi</span> <span class="time messege-text">Please do as specify.
                                Let me
                                know if you have any query.</span> <span class="time">1
                                Days Ago</span>
                        </span>
                    </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                            <img alt="image" src="{{ asset('backend/assets/img/users/user-2.png') }}"
                                class="rounded-circle">
                        </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                Smith</span> <span class="time messege-text">Client Requirements</span>
                            <span class="time">2 Days Ago</span>
                        </span>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('order') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li> --}}

        <li class="dropdown dropdown-list-toggle">
            @php
                $orders = App\Models\Order::where('is_viewed', 0)->get();
                $orderIds = $orders->pluck('id')->toArray(); // Get an array of order IDs
            @endphp
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i data-feather="bell"
                    @if (count($orders) != 0) class="bell" @endif></i>
                <span class="badge headerBadge1 bg-danger">{{ count($orders) }}</span>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">

                <div class="dropdown-header">
                    Notifications
                    @if (count($orders) != 0)
                        <div class="float-right">
                            <a id="markAllAsReadBtn" style="cursor: context-menu;">Mark All As Read</a>
                        </div>
                    @endif

                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @if (count($orders) == 0)
                        <a href="#" class="dropdown-item dropdown-item-unread">
                            <img alt="image" src="{{ asset('preview.gif') }}" height="200px" class="rounded-circle">
                        </a>
                    @else
                        @foreach ($orders as $order)
                            <a href="#" class="dropdown-item dropdown-item-unread">
                                <span class="dropdown-item-icon bg-primary text-white"><i class="fa fa-shopping-basket"
                                        aria-hidden="true"></i></span>
                                <span class="dropdown-item-desc">{{ $order->order_no }} <span class="time">
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                            {{ str_replace(' after', '', now()->diffForHumans($order->updated_at)) }}
                                            ago</p>
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    @endif
                </div>
                @if (count($orders) != 0)
                    <div class="dropdown-footer text-center">
                        <a href="{{ route('order') }}">View All <i class="fas fa-chevron-right"></i></a>
                    </div>
                @endif
            </div>


        </li>

        {{-- <li class="mx-3">
            <ul class="list-unstyled avatar-tooltip-images_wrapper order-list m-b-0 m-b-0">
                <li class="team-member team-member-sm"><img class="rounded-circle"
                        src="{{ asset('backend/assets/img/users/user-3.png') }}" alt="user"
                        data-toggle="tooltip" title="" data-original-title="Wildan Ahdian">
                </li>
                <li class="team-member team-member-sm"><img class="rounded-circle"
                        src="{{ asset('backend/assets/img/users/user-4.png') }}" alt="user"
                        data-toggle="tooltip" title="" data-original-title="John Deo"></li>
                <li class="team-member team-member-sm"><img class="rounded-circle"
                        src="{{ asset('backend/assets/img/users/user-5.png') }}" alt="user"
                        data-toggle="tooltip" title="" data-original-title="Sarah Smith"></li>
                <li class="avatar avatar-sm bg-danger text-white">
                    <div class="avatar-text-center">+16</div>
                </li>
            </ul>
        </li> --}}
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-user">
                <div class="d-flex align-items-center">
                    <div class="mr-3 header-user-profile-logo_wrapper"><img class="header-user-profile-logo"
                            alt="image"
                            src="{{ Auth::user()->user_image ? Auth::user()->user_image : asset('backend/assets/img/user-profile.png') }}"
                            class="img-fluid"></div>
                    <div>
                        @php
                            $role_name = App\Models\User::join('roles', 'roles.id', 'users.role_id')
                                ->where('users.id', Auth::user()->id)
                                ->value('roles.role_name');
                        @endphp
                        <div class="user-profile_name">{{ Auth::user()->name }} </div>
                        <div class="user-profile_caption">{{ strtoupper($role_name) }}</div>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i>
                    Profile
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"> <i
                            class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
            </div>
        </li>
    </ul>
</nav>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#markAllAsReadBtn').click(function(e) {
            e.preventDefault();

            // Perform AJAX request
            $.ajax({
                type: 'POST',
                url: '{{ route('markAllAsRead') }}', // Use the correct route name
                data: {
                    order_ids: @json($orderIds), // Pass order IDs to the controller
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                dataType: 'json',
                success: function(response) {
                    // Handle success (optional)
                    console.log(response.message);
                    // $('.dropdown-list-icons').empty();

                    $('.headerBadge1').text('0');
                    $('.dropdown-list-content').html(
                        '<img  src="{{ asset('preview.gif') }}" alt="image" height="200px">'
                    );
                    // You can also hide the dropdown after marking all as read if desired
                    $('.dropdown-menu').removeClass('show');
                    $('.dropdown-footer').hide();
                },
                error: function(error) {
                    // Handle error (optional)
                    console.error('Error marking all as read:', error);
                }
            });
        });
    });
</script>
