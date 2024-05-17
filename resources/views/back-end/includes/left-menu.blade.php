<nav class="mt-2">

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
        <div class="mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(auth()->user()->photo) }}" class="img-circle elevation-2" width="50" height="50"
                    alt="User Image">
            </div>
            <div class="info pl-2">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                <small class="text-muted">Role: {{ auth()->user()->getRoleNames()->first() }}</small>
                <div class="mt-1">
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <hr>
        </div>
        @can('dashboard')
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
        @endcan

        @can('products')
            <li
                class="nav-item has-treeview {{ request()->is('products/add', 'products', 'products/edit*', 'variations','product-gallary*') ? 'menu-open' : '' }}">
                <a href="#"
                    class="nav-link {{ request()->is('products/add', 'products', 'products/edit*', 'variations','product-gallary*') ? 'active' : '' }}">
                    <i class="nav-icon fab fa-product-hunt"></i>
                    <p>
                        Products
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('view-products')
                        <li class="nav-item">
                            <a href="{{ url('products/add') }}"
                                class="nav-link {{ request()->is('products/add') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    @endcan
                    @can('add-new')
                        <li class="nav-item">
                            <a href="{{ url('/products') }}"
                                class="nav-link {{ request()->is('products', 'products/edit*', 'product-gallary*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Products</p>
                            </a>
                        </li>
                    @endcan
                    @can('variations')
                        <li class="nav-item">
                            <a href="{{ url('/variations') }}"
                                class="nav-link {{ request()->is('variations') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Variations</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('orders')
            <li
                class="nav-item has-treeview {{ request()->is('orders*', 'orders/filter/pending', 'orders/filter/processing', 'orders/filter/delivered', 'orders/filter/cancel') ? 'menu-open' : '' }}">
                <a href="#"
                    class="nav-link {{ request()->is('orders*', 'orders/filter/pending', 'orders/filter/processing', 'orders/filter/delivered', 'orders/filter/cancel') ? 'active' : '' }}">
                    <i class="nav-icon fab fa-first-order"></i>
                    <p>
                        Orders
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('all-orders')
                        <li class="nav-item">
                            <a href="{{ url('/orders') }}" class="nav-link {{ request()->is('orders') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Orders</p>
                            </a>
                        </li>
                    @endcan
                    @can('pending-orders')
                        <li class="nav-item">
                            <a href="{{ url('/orders/filter/pending') }}"
                                class="nav-link {{ request()->is('orders/filter/pending') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending Orders</p>
                            </a>
                        </li>
                    @endcan
                    @can('processing-orders')
                        <li class="nav-item">
                            <a href="{{ url('/orders/filter/processing') }}"
                                class="nav-link {{ request()->is('orders/filter/processing') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Processing Orders</p>
                            </a>
                        </li>
                    @endcan
                    @can('delivered-orders')
                        <li class="nav-item">
                            <a href="{{ url('/orders/filter/delivered') }}"
                                class="nav-link {{ request()->is('orders/filter/delivered') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delivered Orders</p>
                            </a>
                        </li>
                    @endcan
                    @can('canceled-orders')
                        <li class="nav-item">
                            <a href="{{ url('/orders/filter/cancel') }}"
                                class="nav-link {{ request()->is('orders/filter/cancel') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Canceled Orders</p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan
        @can('categories')
            <li class="nav-item">
                <a href="{{ url('categories') }}" class="nav-link {{ request()->is('categories') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-sitemap"></i>
                    <p>
                        Categories
                    </p>
                </a>
            </li>
        @endcan

        @can('slider')
            <li class="nav-item">
                <a href="{{ url('sliders-list') }}" class="nav-link {{ request()->is('sliders-list') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-image"></i>
                    <p>
                        Slider
                    </p>
                </a>
            </li>
        @endcan

        @can('pages')
            <li class="nav-item has-treeview {{ request()->is('dynamic-pages/*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('dynamic-pages/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Pages
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (App\Page::all() as $page)
                        <li class="nav-item">
                            <a href="{{ url('dynamic-pages/' . $page->id) }}"
                                class="nav-link {{ collect(request()->segments())->last() == $page->id ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ $page->title }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endcan

        @can('seo-pages')
            <!-- SEO  -->
            <li
                class="nav-item {{ request()->is('add-seo-pages', 'pages-list', 'page-content-update*') ? 'menu-open' : '' }}">
                <a href="#"
                    class="nav-link {{ request()->is('add-seo-pages', 'pages-list', 'page-content-update*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-globe-africa"></i>
                    <p>
                        SEO Pages
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('add-seo-page')
                        <li class="nav-item">
                            <a href="{{ url('add-seo-pages') }}"
                                class="nav-link {{ request()->is('add-seo-pages') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Seo Page</p>
                            </a>
                        </li>
                    @endcan
                    @can('pages-list')
                        <li class="nav-item">
                            <a href="{{ url('pages-list') }}"
                                class="nav-link {{ request()->is('pages-list', 'page-content-update*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pages List</p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        @can('notice-board')
            <li class="nav-item">
                <a href="{{ url('notice-board') }}"
                    class="nav-link {{ request()->is('notice-board') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-exclamation-triangle"></i>
                    <p>
                        Notice Board
                    </p>
                </a>
            </li>
        @endcan

        @can('settings')
            <li
                class="nav-item has-treeview {{ request()->is(
                    'dynamic-info/update',
                    'dynamic-delivery/update',
                    'dynamic-code/update',
                    'dynamic-addRole',
                    'dynamic-reg',
                    'dynamic-changepass',
                    'dynamic-sms_config',
                    'dynamic-payment_config',
                    'user-role',
                    'permission',
                    'give-user-role',
                    'give-user-permission',
                    'child-permission*',
                    'users',
                )
                    ? 'menu-open'
                    : '' }}">
                <a href="#"
                    class="nav-link {{ request()->is(
                        'dynamic-info/update',
                        'dynamic-delivery/update',
                        'dynamic-code/update',
                        'dynamic-addRole',
                        'dynamic-reg',
                        'dynamic-changepass',
                        'dynamic-sms_config',
                        'dynamic-payment_config',
                        'user-role',
                        'permission',
                        'give-user-role',
                        'give-user-permission',
                        'child-permission*',
                        'users',
                    )
                        ? 'active'
                        : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        Settings
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @can('basic-info')
                        <li class="nav-item">
                            <a href="{{ url('dynamic-info/update') }}"
                                class="nav-link {{ request()->is('dynamic-info/update') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Basic info</p>
                            </a>
                        </li>
                    @endcan
                    @can('delivery-details')
                        <li class="nav-item">
                            <a href="{{ url('dynamic-delivery/update') }}"
                                class="nav-link {{ request()->is('dynamic-delivery/update') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delivery Details</p>
                            </a>
                        </li>
                    @endcan
                    @can('custom-code')
                        <li class="nav-item">
                            <a href="{{ url('dynamic-code/update') }}"
                                class="nav-link {{ request()->is('dynamic-code/update') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Custom Code</p>
                            </a>
                        </li>
                    @endcan
                    @can('user-role')
                        <li class="nav-item">
                            <a href="{{ route('user-role') }}"
                                class="nav-link {{ request()->is('user-role') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    User Role
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('users')
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Users
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('user-permission')
                        <li class="nav-item">
                            <a href="{{ route('permission') }}"
                                class="nav-link {{ request()->is('permission', 'child-permission*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    User Permission
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('give-user-role')
                        <li class="nav-item">
                            <a href="{{ route('give-user-role') }}"
                                class="nav-link {{ request()->is('give-user-role') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Give User Role
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('give-user-permission')
                        <li class="nav-item">
                            <a href="{{ route('give-user-permission') }}"
                                class="nav-link {{ request()->is('give-user-permission') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Give User Permission
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('change-password')
                        <li class="nav-item">
                            <a href="{{ url('dynamic-changepass') }}"
                                class="nav-link {{ request()->is('dynamic-changepass') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    @endcan
                    @can('sms-configuration')
                        <li class="nav-item">
                            <a href="{{ url('dynamic-sms_config') }}"
                                class="nav-link {{ request()->is('dynamic-sms_config') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SMS Configuration</p>
                            </a>
                        </li>
                    @endcan
                    @can('payment-configuration')
                        <li class="nav-item">
                            <a href="{{ url('dynamic-payment_config') }}"
                                class="nav-link {{ request()->is('dynamic-payment_config') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payment Configuration</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
    </ul>
</nav>
