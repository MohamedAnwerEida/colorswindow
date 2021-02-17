<!-- BEGIN TOP NAVIGATION MENU -->

<div class="top-menu">
    <ul class="nav navbar-nav pull-right">
        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
        @if(Auth::guard('admin')->user()->myrole->status_stock==1 || Auth::guard('admin')->user()->myrole->id==2)
        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="icon-bell"></i>
                <span class="badge badge-default"> {{ getEmptyProducts() }} </span>
            </a>
        </li>
        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <i class="icon-bell"></i>
                <span class="badge badge-default"> {{ getNewOrders() }} </span>
            </a>
        </li>
        @endif
        <li class="dropdown dropdown-user">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                @if(Auth::guard('admin')->user()->avatar && Auth::guard('admin')->user()->avatar!='')
                <img  class="img-circle" src="{{ url(Auth::guard('admin')->user()->avatar) }}" alt="">
                @else
                <img  class="img-circle" src="{{ url('assets/admin/layouts/layout2/img/avatar3_small.jpg') }}" alt="">
                @endif
                <span class="username username-hide-on-mobile"> {{ Auth::guard('admin')->user()->name}} </span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li>
                    <a href="{{ route('dashboard.profile') }}">
                        <i class="icon-user"></i> الملف الشخصي </a>
                </li>
                <?php /* <li>
                  <a href="{{ route('dashboard.password') }}">
                  <i class="icon-lock"></i> تغيير كلمة المرور </a>
                  </li> */ ?>
                <li class="divider"> </li>
                <li>
                    <a href="{{ route('app.logout') }}">
                        <i class="icon-key"></i> تسجيل الخروج </a>
                </li>
            </ul>
        </li>
        <!-- END USER LOGIN DROPDOWN -->
    </ul>
</div>
<!-- END TOP NAVIGATION MENU -->
