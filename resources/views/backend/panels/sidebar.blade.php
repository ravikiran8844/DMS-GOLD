@php
    if (Auth::user()->role_id == 1) {
        $getMenuId = App\Models\Menu::pluck('id as menu_id')->toArray();
    } else {
        $getMenuId = App\Models\RolePermissions::where('role_id', '=', Auth::user()->role_id)
            ->pluck('menu_id')
            ->toArray();
    }

    if ($getMenuId) {
        if (Auth::user()->id == 1) {
            $menu = App\Models\Menu::where('is_mainmenu', '=', 1)
                ->whereIn('id', $getMenuId)
                ->where('is_visible', 1)
                ->where('show_superadmin', 1)
                ->orderBy('menu_order', 'ASC')
                ->get();
        } elseif (Auth::user()->role_id == App\Enums\Roles::Dealer) {
            $menu = App\Models\User::select(
                'menus.*',
                'user_role_permissions.user_id',
                'user_role_permissions.is_edit',
                'user_role_permissions.is_delete',
                'user_role_permissions.is_view',
                'user_role_permissions.is_print',
            )
                ->join('user_role_permissions', 'users.id', 'user_role_permissions.user_id')
                ->join('menus', 'menus.id', 'user_role_permissions.menu_id')
                ->whereIn('menus.id', $getMenuId)
                ->where('menus.is_mainmenu', '=', 1)
                ->where('menus.group_name', '!=', null)
                ->where('menus.is_visible', '=', 1)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('menu_order', 'ASC')
                ->get();
        } else {
            $menu = App\Models\User::select(
                'menus.*',
                'user_role_permissions.user_id',
                'user_role_permissions.is_edit',
                'user_role_permissions.is_delete',
                'user_role_permissions.is_view',
                'user_role_permissions.is_print',
            )
                ->join('user_role_permissions', 'users.id', 'user_role_permissions.user_id')
                ->join('menus', 'menus.id', 'user_role_permissions.menu_id')
                ->whereIn('menus.id', $getMenuId)
                ->where('menus.is_mainmenu', '=', 1)
                ->where('menus.is_visible', '=', 1)
                ->where('users.id', '=', Auth::user()->id)
                ->orderBy('menu_order', 'ASC')
                ->get();
        }
    }
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ Auth::user()->role_id == App\Enums\Roles::CRM ? route('dashboard') : route('order') }}"> <img
                alt="image" src="{{ asset('backend/assets/img/logo.png') }}" class="header-logo" />
        </a>
    </div>
    <ul class="sidebar-menu">
        @if (isset($menu))
            @foreach ($menu as $item)
                <li class="dropdown">
                    @php
                        if (Auth::user()->role_id == App\Enums\Roles::SuperAdmin) {
                            $getSubMenuId = App\Models\Menu::pluck('id as menu_id')->toArray();
                        } else {
                            $getSubMenuId = App\Models\RolePermissions::where('role_id', '=', Auth::user()->role_id)
                                ->pluck('menu_id')
                                ->toArray();
                        }
                        if ($getSubMenuId) {
                            if (Auth::user()->id == 1) {
                                $submenu = App\Models\Menu::where('parent_id', $item->id)
                                    ->whereIn('id', $getSubMenuId)
                                    ->where('is_visible', 1)
                                    ->where('show_superadmin', 1)
                                    ->orderBy('menu_order', 'ASC')
                                    ->get();
                            } else {
                                $submenu = App\Models\User::select(
                                    'menus.*',
                                    'user_role_permissions.user_id',
                                    'user_role_permissions.is_edit',
                                    'user_role_permissions.is_delete',
                                    'user_role_permissions.is_view',
                                    'user_role_permissions.is_print',
                                )
                                    ->join('user_role_permissions', 'users.id', 'user_role_permissions.user_id')
                                    ->join('menus', 'menus.id', 'user_role_permissions.menu_id')
                                    ->whereIn('menus.id', $getSubMenuId)
                                    ->where('menus.is_visible', '=', 1)
                                    ->where('menus.parent_id', $item->id)
                                    ->where('users.id', '=', Auth::user()->id)
                                    ->orderBy('menu_order', 'ASC')
                                    ->get();
                            }
                        }
                    @endphp
                    <a href="@if ($submenu->count() > 0) #@else{{ $item->menu_url }} @endif"
                        class="@if ($submenu->count() > 0) menu-toggle has-dropdown @else nav-link @endif"><i
                            data-feather="{{ $item->icon }}"></i><span>{{ $item->menu_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($submenu as $submenuitem)
                            <li><a class="nav-link"
                                    href="{{ $submenuitem->menu_url }}">{{ $submenuitem->menu_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        @endif
    </ul>
</aside>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function getUrl(url) {
            var baseUrl = window.location.origin;
            var newUrl = url.replace(new RegExp("^" + baseUrl), "");
            return newUrl;
        }

        //Active menu selection
        var baseUrl = window.location.origin;
        var loc = getUrl(window.location.href);
        $("a[href='" + loc + "']")
            .parent()
            .addClass("active");

        $("a[href='" + loc + "']")
            .parent()
            .parent()
            .parent()
            .addClass("active");

        $("a[href='" + loc + "']")
            .parent()
            .parent()
            .show();

        if (
            $("a[href='" + loc + "']")
            .parent()
            .offset() != undefined
        ) {
            if (
                $("a[href='" + loc + "']")
                .parent()
                .offset().top > $(window).height()
            ) {
                var elem = document.getElementsByClassName(
                    $("a[href='" + loc + "']").parent()[0].className
                );
                elem[0].scrollIntoView();
            }
        }
    });
</script>
