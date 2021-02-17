
<div class="product-view-area fix" style="    margin-top: 135px;">
    <div class="single-product-category">
        <div class="head-title">
            <p><a href="{{ url('category/1')}}">المنتجات المميزة</a></p>
        </div>
        <div class="product-view">
            <div id="carousel-feature_product" class="owl-carousel custom-carousel">
                <?php foreach ($feature_products as $feature_product): ?>
                <?php
                /*
                  if ($product->old_price == 0) {
                  $percentage = '';
                  $oldPrice = '';
                  } else {
                  $percent = $product->price / $product->old_price * 100;
                  $finel_percent = ceil($percent);
                  $percentage = '<div class="label-pro-sale">' . $finel_percent . '%</div>';
                  $oldPrice = $product->old_price;
                  } */
                ?>
                <div class="singel-product single-product-col" style="padding: 20px!important;">
                    <div class="single-product-img">
                        <a title="{{$feature_product->name_ar}}" href="{{ url('product/'.$feature_product->id)}}">
                        <img src="{{ $feature_product->image}}" height="500" alt="">
                        </a>
                    </div>
                    <div class="single-product-content">
                        <h2 class="product-name">
                            <a title="{{$feature_product->name_ar}}" href="{{ url('product/'.$feature_product->id)}}">
                                <?= $feature_product->name_ar ?>
                            </a>
                        </h2>
                        <div class="ratings">
                            <div class="rating-box">
                                <div class="">
                                    @include('frontend.home.rating')
                                </div>
                            </div>
                        </div>
                    <?php /*
                              <div class="product-price">
                              <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                              </div>
                             *
                             */ ?>
                    <!-- Single Product Actions -->
                        <div class="product-actions">
                            <a href="{{ url('product/'.$feature_product->id)}}"><button  class="button btn-cart" title="اضافة إلى السلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                            <a style="margin-left: -4px;" href="{{ url('favorite/'.$feature_product->id)}}"><button  class="button" title="اضافة إلى المفضلة" type="button"><span><i class="fa fa-heart">&nbsp;</i></span></button></a>
<!--                            <div class="add-to-link">
                                <ul class="">
                                    <li class="quic-view">
                                        <a href="{{ url('favorite/'.$feature_product->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                    </li>
                                </ul>
                            </div>-->
                        </div><!-- End Single Product Actions -->
                    </div><!-- End Single Product Content -->
                </div>
                <?php endforeach; ?>
            </div><!-- End Product View Carousel -->
        </div><!-- End Product View-->
    </div><!-- End Single Product Category -->
</div>

<!--
<div class="product-view-area fix">
    <div class="single-product-category">
        <div class="head-title">
            <p><a href="{{ url('category/1')}}">صفقة اليوم</a></p>
        </div>
        <div class="product-view">
            <div id="carousel-dealofday" class="owl-carousel custom-carousel">
                <?php foreach ($dealofdays as $dealofday): ?>
                <?php
                /*
                  if ($product->old_price == 0) {
                  $percentage = '';
                  $oldPrice = '';
                  } else {
                  $percent = $product->price / $product->old_price * 100;
                  $finel_percent = ceil($percent);
                  $percentage = '<div class="label-pro-sale">' . $finel_percent . '%</div>';
                  $oldPrice = $product->old_price;
                  } */
                ?>
                <div class="singel-product single-product-col" style="padding: 20px!important;">
                    <div class="single-product-img">
                        <img src="{{ $dealofday->image}}" height="500" alt="">
                    </div>
                    <div class="single-product-content">
                        <h2 class="product-name">
                            <a title="Proin lectus ipsum" href="{{ url('product/'.$dealofday->id)}}">
                                <?= $dealofday->name_ar ?>
                            </a>
                        </h2>
                        <div class="ratings">
                            <div class="rating-box">
                                <div class="">
                                    @include('frontend.home.rating')
                                </div>
                            </div>
                        </div>
                    <?php /*
                              <div class="product-price">
                              <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                              </div>
                             *
                             */ ?>
                    &lt;!&ndash; Single Product Actions &ndash;&gt;
                        <div class="product-actions">
                            <a href="{{ url('product/'.$dealofday->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                            <div class="add-to-link">
                                <ul class="">
                                    <li class="quic-view">
                                        <a href="{{ url('favorite/'.$dealofday->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                    </li>
                                </ul>
                            </div>
                        </div>&lt;!&ndash; End Single Product Actions &ndash;&gt;
                    </div>&lt;!&ndash; End Single Product Content &ndash;&gt;
                </div>
                <?php endforeach; ?>
            </div>&lt;!&ndash; End Product View Carousel &ndash;&gt;
        </div>&lt;!&ndash; End Product View&ndash;&gt;
    </div>&lt;!&ndash; End Single Product Category &ndash;&gt;
</div>
-->

<!--
<div class="product-view-area fix">
    <div class="single-product-category">
        <div class="head-title">
            <p><a href="{{ url('category/1')}}">خدمات الطباعة والاعلان</a></p>
        </div>
        <div class="product-view">
            <div id="laptop-carousel" class="owl-carousel custom-carousel">
                <?php foreach ($stker_products as $product): ?>
                    <?php
                    /*
                      if ($product->old_price == 0) {
                      $percentage = '';
                      $oldPrice = '';
                      } else {
                      $percent = $product->price / $product->old_price * 100;
                      $finel_percent = ceil($percent);
                      $percentage = '<div class="label-pro-sale">' . $finel_percent . '%</div>';
                      $oldPrice = $product->old_price;
                      } */
                    ?>
                    <div class="singel-product single-product-col" style="padding: 20px!important;">
                        <div class="single-product-img">
                            <img src="{{ $product->image}}" height="500" alt="">
                        </div>
                        <div class="single-product-content">
                            <h2 class="product-name">
                                <a title="Proin lectus ipsum" href="{{ url('product/'.$product->id)}}">
                                    <?= $product->name_ar ?>
                                </a>
                            </h2>
                            <div class="ratings">
                                <div class="rating-box">
                                    <div class="">
                                        @include('frontend.home.rating')
                                    </div>
                                </div>
                            </div>
                            <?php /*
                              <div class="product-price">
                              <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                              </div>
                             *
                             */ ?>
                            &lt;!&ndash; Single Product Actions &ndash;&gt;
                            <div class="product-actions">
                                <a href="{{ url('product/'.$product->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                                <div class="add-to-link">
                                    <ul class="">
                                        <li class="quic-view">
                                            <a href="{{ url('favorite/'.$product->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>&lt;!&ndash; End Single Product Actions &ndash;&gt;
                        </div>&lt;!&ndash; End Single Product Content &ndash;&gt;
                    </div>
                <?php endforeach; ?>
            </div>&lt;!&ndash; End Product View Carousel &ndash;&gt;
        </div>&lt;!&ndash; End Product View&ndash;&gt;
    </div>&lt;!&ndash; End Single Product Category &ndash;&gt;
</div>
-->

@section('js')
    <script>
        $("#carousel-feature_product").owlCarousel({
            autoPlay: true,
            slideSpeed: 2000,
            pagination: false,
            navigation: true,
            addClassActive: true,
            items: 4,
            /* transitionStyle : "fade", */    /* [This code for animation ] */
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsMobile: [479, 1],
        });
    </script>
    <script>
        $("#carousel-dealofday").owlCarousel({
            autoPlay: true,
            slideSpeed: 2000,
            pagination: false,
            navigation: true,
            addClassActive: true,
            items: 4,
            /* transitionStyle : "fade", */    /* [This code for animation ] */
            navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsMobile: [479, 1],
        });
    </script>
@endsection
