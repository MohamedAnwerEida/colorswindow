<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item {{ $active_menu == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard.view') }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">الرئيسية</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @if(Auth::guard('admin')->user()->can('admin.news.view') || Auth::guard('admin')->user()->can('admin.news.add') || Auth::guard('admin')->user()->can('admin.news.edit') || Auth::guard('admin')->user()->can('admin.news.delete') || Auth::guard('admin')->user()->can('admin.news.status'))
            <li class="nav-item {{ $active_menu == 'news' ? 'active' : '' }}">
                <a href="{{ route('news.view') }}" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">الأخبار</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.categories.view') || Auth::guard('admin')->user()->can('admin.categories.add') || Auth::guard('admin')->user()->can('admin.categories.edit') || Auth::guard('admin')->user()->can('admin.categories.delete') || Auth::guard('admin')->user()->can('admin.categories.status'))
            <li class="nav-item {{ $active_menu == 'categories' ? 'active' : '' }}">
                <a href="{{ route('categories.view') }}" class="nav-link nav-toggle">
                    <i class="icon-grid"></i>
                    <span class="title">التصنيفات</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
                <li class="nav-item {{ $active_menu == 'slider' ? 'active' : '' }}">
                    <a href="{{ route('slider.view') }}" class="nav-link nav-toggle">
                        <i class="icon-grid"></i>
                        <span class="title">Slider</span>
                        <span class="arrow"></span>
                    </a>
                </li>
            @if(Auth::guard('admin')->user()->can('admin.files.view') ||  Auth::guard('admin')->user()->can('admin.files.edit'))
            <li class="nav-item {{ $active_menu == 'pages' ? 'active' : '' }}">
                <a href="{{ route('files.view') }}" class="nav-link nav-toggle">
                    <i class="icon-graph"></i>
                    <span class="title">المنتجات</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.stocks.view') ||  Auth::guard('admin')->user()->can('admin.stocks.edit'))
            <li class="nav-item {{ $active_menu == 'stocks' ? 'active' : '' }}">
                <a href="{{ route('stocks.view') }}" class="nav-link nav-toggle">
                    <i class="fa fa-cube"></i>
                    <span class="title">المخزن</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.subcategories.view') ||  Auth::guard('admin')->user()->can('admin.subcategories.edit'))
            <li class="nav-item {{ $active_menu == 'subcategories' ? 'active' : '' }}">
                <a href="{{ route('subcategories.view') }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">اقسام المنتجات</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.orders.view') ||  Auth::guard('admin')->user()->can('admin.orders.edit'))
            <li class="nav-item {{ $active_menu == 'orders' ? 'active' : '' }}">
                <a href="{{ route('orders.view') }}" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">الطلبات</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.tasks.view') ||  Auth::guard('admin')->user()->can('admin.tasks.edit'))
            <li class="nav-item {{ $active_menu == 'tasks' ? 'active' : '' }}">
                <a href="{{ route('tasks.view') }}" class="nav-link nav-toggle">
                    <i class="fa fa-tasks"></i>
                    <span class="title">ادارة المهام</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.customers.view') ||  Auth::guard('admin')->user()->can('admin.customers.details'))
            <li class="nav-item {{ $active_menu == 'customers' ? 'active' : '' }}">
                <a href="{{ route('customers.view') }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">العملاء</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.accounts.view') ||  Auth::guard('admin')->user()->can('admin.accounts.details'))
            <li class="nav-item {{ $active_menu == 'accounts' ? 'active' : '' }}">
                <a href="{{ route('accounts.view') }}" class="nav-link nav-toggle">
                    <i class="icon-credit-card"></i>
                    <span class="title">المالية</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.pages.view') ||  Auth::guard('admin')->user()->can('admin.pages.edit'))
            <li class="nav-item {{ $active_menu == 'pages' ? 'active' : '' }}">
                <a href="{{ route('pages.view') }}" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title">الصفحات الثابته</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif

            @can('admin.settings.view')
            <li class="nav-item {{ $active_menu == 'settings' ? 'active' : '' }}">
                <a href="{{ route('settings.view') }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الإعدادات</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endcan
            @if(Auth::guard('admin')->user()->can('admin.coupons.view') || Auth::guard('admin')->user()->can('admin.coupons.delete') || Auth::guard('admin')->user()->can('admin.coupons.status'))
            <li class="nav-item {{ $active_menu == 'coupons' ? 'active' : '' }}">
                <a href="{{ route('coupons.view') }}" class="nav-link nav-toggle">
                    <i class="icon-film"></i>
                    <span class="title">كوبون الخصم</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @can('admin.social.view')
            <li class="nav-item {{ $active_menu == 'socials' ? 'active' : '' }}">
                <a href="{{ route('socials.view') }}" class="nav-link nav-toggle">
                    <i class="icon-social-twitter"></i>
                    <span class="title">الشبكات الإجتماعية</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endcan
            @can('admin.contact.view')
            <li class="nav-item {{ $active_menu == 'contacts' ? 'active' : '' }}">
                <a href="{{ route('contacts.view') }}" class="nav-link nav-toggle">
                    <i class="icon-call-end"></i>
                    <span class="title">اتصل بنا</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endcan

            @if(Auth::guard('admin')->user()->can('admin.users.view') || Auth::guard('admin')->user()->can('admin.users.add') || Auth::guard('admin')->user()->can('admin.users.edit') || Auth::guard('admin')->user()->can('admin.users.delete') || Auth::guard('admin')->user()->can('admin.users.status') || Auth::guard('admin')->user()->can('admin.users.password'))
            <li class="nav-item {{ $active_menu == 'users' ? 'active' : '' }}">
                <a href="{{ route('users.view') }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">المستخدمين</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
            @if(Auth::guard('admin')->user()->can('admin.roles.view') || Auth::guard('admin')->user()->can('admin.roles.add') || Auth::guard('admin')->user()->can('admin.roles.edit') || Auth::guard('admin')->user()->can('admin.roles.delete') || Auth::guard('admin')->user()->can('admin.roles.status') || Auth::guard('admin')->user()->can('admin.roles.permissions'))
            <li class="nav-item {{ $active_menu == 'roles' ? 'active' : '' }}">
                <a href="{{ route('roles.view') }}" class="nav-link nav-toggle">
                    <i class="icon-directions"></i>
                    <span class="title">المجموعات والصلاحيات</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @endif
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
