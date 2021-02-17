<div class="header-area another-home">
    <!-- Header Top -->
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-top-bar">
                        <div class="row">
                            <div class="col-md-5">
                                <!-- Header Top Left-->
                                <div class="header-top-right">
                                    <!-- Header Link Area -->
                                    <div class="header-link-area">
                                        <div class="header-link">
                                            <ul>
                                                @if (!Auth::check())
                                                <li>
                                                    <a href="{{ url('login')}}">
                                                        <i class="fa fa-key"></i>
                                                        تسجيل
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('login')}}">
                                                        <i class="fa fa-unlock-alt"></i>
                                                        دخول
                                                    </a>
                                                </li>
                                                @else
                                                <li>
                                                    <a>
                                                        <i class="fa fa-key"></i>
                                                        حسابي
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul>
                                                        <li><a href="{{ url('profile')}}">اعدادت الحساب</a></li>
                                                        <li><a href="{{ url('cart')}}">عربة التسوق</a></li>
                                                        <li><a href="{{ url('orders')}}">طلباتي</a></li>
                                                        <li><a href="{{ url('favorites')}}">المفضلة</a></li>
                                                        <li><a href="{{ url('logout')}}">تسجيل خروج</a></li>
                                                    </ul>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div><!-- End Header Link Area -->
                                </div>
                                <!-- End Header Top Left-->
                            </div>
                            <div class="col-md-7">
                                <div class="header-top-left">
                                    <div class="call-header">
                                        <p>
                                            رقم الاتصال السريع
                                            <i class="fa fa-phone"></i>
                                            <span dir="ltr">{{ $settings->contact_no}}</span>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div><!-- End Header Top Bar-->

                </div>
            </div>
        </div>
    </div><!--                                                                                                                                                                                                         End Header Top -->
    <!-- Header Bottom -->
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Header Bottom Inner-->
                    <div class="header-bottom-inner">

                        <div class="row">
                            <div class="col-md-3">
                                <!-- Header Logo -->
                                <div class="header-logo">
                                    <a href="{{ url('/')}}"><img style="height: 50!important;" src="{{url('assets/site/images/logo.png')}}" alt="logo"></a>

                                </div>
                            </div>
                            <div class="col-md-9">
                                <!-- Header Bottom Right -->
                                <div class="header-bottom-right hidden-xs hidden-sm">
                                    <!-- All Categorie -->
                                    <div class="all-categories">
                                        <div class="search-cat">
                                            <select id="product-categori">
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?= $cat->id ?>"><?= $cat->name_ar ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div><!-- End All Categorie -->
                                    <div class="header-search">
                                        <form action="{{url('search')}}" method="post">
                                            <input type="text" class="input-text" name="name" id="search" placeholder="البحث في الموقع">
                                            <button type="submit"><i class="fa fa-search"></i></button>
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                    <!-- Header Cart Area-->
                                    <div class="header-cart-area">
                                        <div class="header-cart">
                                            <ul>
                                                <li>
                                                    <a href="{{ url('cart')}}" dir="rtl">
                                                        <i class="fa fa-shopping-cart"></i>
                                                        <span class="my-cart">عربة التسوق</span> ( {{ Auth::check()?CountCartItems():0 }} )
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- End Header Cart Area                                                                                                                                                                                                        -->
                                </div><!-- End Header Bottom Right -->
                            </div>
                        </div>
                    </div><!-- End Header Bottom Inner-->
                </div>
            </div>
        </div>
    </div><!-- End Header Bottom -->
</div><!-- End Header Area -->
<!-- Main Menu Area -->
<div class="main-menu-area another-home">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Main Menu -->
                <div class="main-menu hidden-sm hidden-xs">
                    <nav>
                        <ul>
                            <li><a class="active" href="{{url('/') }}">الرئيسية</a></li>
                            <li><a href="#"><span>الأقسام</span></a>
                                <ul class="mega-menu-ul">
                                    <li>
                                        <div class="mega-menu">
                                            <?php foreach ($categories as $cat): ?>
                                                <div class="single-mega-menu category1">
                                                    <h2><a href="{{ url('category/'.$cat->id)}}" style="color:#<?= $cat->color ?>"><?= $cat->name_ar ?></a></h2>
                                                    <?php foreach ($cat->subcategory as $caaT): ?>
                                                        <?php
                                                        //check if has main product to replace it
                                                        $pro = check_main_products($caaT->id);
                                                        if ($pro) {
                                                            ?>
                                                            <a href="{{ url('product/'.$pro->id)}}"><?= $caaT->name_ar ?></a>
                                                        <?php } else { ?>
                                                            <a href="{{ url('subcategory/'.$caaT->id)}}"><?= $caaT->name_ar ?></a>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{url('special') }}">طلب خاص</a></li>
                            <li><a href="{{url('offers') }}">عروضنا</a></li>
                            <li><a href="{{url('about') }}">من نحن</a></li>
                            <li><a href="{{url('blogs') }}">مقالات</a></li>
                            <li><a href="{{url('contact') }}">اتصل بنا</a></li>
                        </ul>
                    </nav>
                </div><!-- End Manin Menu -->
                <!-- Start Mobile Menu -->
                <div class="mobile-menu hidden-md hidden-lg">
                    <nav>
                        <ul>
                            <li><a href="{{url('/') }}">الرئيسية</a></li>
                            <li><a href="#"><span>الأقسام</span></a>
                                <ul class="">
                                    <?php foreach ($categories as $cat): ?>
                                        <li>
                                            <a href="{{ url('category/'.$cat->id)}}"><?= $cat->name_ar ?></a>
                                            <ul>
                                                <?php foreach ($cat->subcategory as $caaT): ?>
                                                    <?php
                                                    //check if has main product to replace it
                                                    $pro = check_main_products($caaT->id);
                                                    if ($pro) {
                                                        ?>
                                                        <li>
                                                            <a href="{{ url('product/'.$pro->id)}}"><?= $caaT->name_ar ?></a>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li>
                                                            <a href="{{ url('subcategory/'.$caaT->id)}}"><?= $caaT->name_ar ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li><a href="{{url('special') }}">طلب خاص</a></li>
                            <li><a href="{{url('offers') }}">عروضنا</a></li>
                            <li><a href="{{url('about') }}">من نحن</a></li>
                            <li><a href="{{url('blogs') }}">مقالات</a></li>
                            <li><a href="{{url('contact') }}">اتصل بنا</a></li>
                        </ul>
                    </nav>
                </div><!-- End Mobile Menu -->
            </div>
        </div>
    </div>
    <div class="row hidden-lg hidden-md"  style="background: #0091d5">
        <div class="col-md-12">
            <!-- Header Top Bar-->
            @if (!Auth::check())
            <div class="header-top-bar">
                <div class="row">
                    <div class="col-md-5">
                        <!-- Header Top Left-->
                        <div class="header-top-left">
                            <div class="header-link-area">
                                <div class="header-link">
                                    <ul>
                                        <li><a style="color: white !important;" class="account" href="{{ url('login')}}">دخول</a></li>
                                    </ul>
                                </div>
                            </div><!-- End Header-->
                        </div><!-- End Header Top Left-->
                    </div>
                    <div class="col-md-6">
                        <!-- Header Top Right-->
                        <div class="header-top-right">
                            <!-- Header Link Area -->
                            <div class="header-link-area">
                                <div class="header-link">
                                    <ul>
                                        <li><a style="color: white !important;" class="account" href="{{ url('login')}}">تسجيل</a></li>
                                    </ul>
                                </div>
                            </div><!-- End Header Link Area -->
                        </div><!-- End Header Top Right-->
                    </div>
                </div>
            </div><!-- End Header Top Bar-->
            @else
            <div class="header-top-bar">
                <div class="row">
                    <div class="col-md-6 ">
                        <!-- Header Top Left-->
                        <div class="header-top-left">
                            <div class="header-login">
                                <a style="color: white !important;" href="{{ url('logout')}}">تسجيل خروج</a>
                            </div>
                        </div><!-- End Header Top Left-->
                    </div>
                    <div class="col-md-6">
                        <!-- Header Top Right-->
                        <div class="header-top-right">
                            <!-- Header Link Area -->
                            <div class="header-link-area">
                                <div class="header-link">
                                    <ul>
                                        <li><a  class="account"  style="color: white !important;" href="#">حسابي<i class="fa fa-angle-down"></i></a>
                                            <ul>
                                                <li><a href="{{ url('profile')}}">اعدادت الحساب</a></li>
                                                <li><a href="{{ url('cart')}}">عربة التسوق</a></li>
                                                <li><a href="{{ url('orders')}}">طلباتي</a></li>
                                                <li><a href="{{ url('favorites')}}">المفضلة</a></li>
                                                <li><a href="{{ url('logout')}}">تسجيل خروج</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- End Header Link Area -->
                        </div><!-- End Header Top Right-->
                    </div>
                </div>
            </div><!-- End Header Top Bar-->
            @endif
        </div>
    </div>
</div>
@section('javascript')

    <script>
        var availableTags = {!! json_encode($keywords) !!};
      /*  $( "#search" ).autocomplete({
            source: availableTags
        });*/
        $("#search").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(availableTags, request.term);

                response(results.slice(0, 4));
            }
        });
        $('.dd-option').click(function (){
            window.location.href = "https://colorswindow.com/category/"+$('.dd-selected-value').val();
        })
    </script>

@stop
