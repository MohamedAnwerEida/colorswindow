<div class="product-layout-right">
    <?php /*
      <!-- Timer product -->
      <div class="timer-product">
      <div class="timer-product-title">
      <h2 class="text-right">عروض اليوم</h2>
      </div>
      <!-- Timer product Carousel-->
      <div id="timer-product-carousel" class="owl-carousel custom-carousel">
      <?php foreach ($deal_products as $product): ?>
      <?php
      if ($product->old_price == 0) {
      $percentage = '';
      $oldPrice = '';
      } else {
      $percent = $product->price / $product->old_price * 100;
      $finel_percent = ceil($percent);
      $percentage = '<div class="label-pro-sale">' . $finel_percent . '%</div>';
      $oldPrice = $product->old_price;
      }
      ?>
      <!-- Single Product -->
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
      <?php //include("aria_rateing.php") ?>
      </div>
      </div>
      </div>
      <div class="product-price">
      <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
      </div>
      <!-- Single Product Actions -->
      <div class="product-actions">
      <a href="{{ url('product/'.$product->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
      <div class="add-to-link">
      <ul class="">
      <li class="quic-view">
      <a href="{{ url('favorite/'.$product->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
      </li>
      </ul>
      </div>
      </div><!-- End Single Product Actions -->
      </div><!-- End Single Product Content -->
      </div>
      <!-- End Single Product -->
      <?php endforeach; ?>


      </div><!-- End Timer product Carousel-->
      </div><!-- End Timer product -->
      <div class="featured-product-area hidden-xs hidden-sm">
      <div class="featured-product-title">
      <h2 style="text-align: right; padding-right: 10px">منتجات مميزة</h2>
      </div>
      <?php foreach ($feature_products as $product): ?>
      <?php
      if ($product->old_price == 0) {
      $percentage = '';
      $oldPrice = '';
      } else {
      $percent = $product->price / $product->old_price * 100;
      $finel_percent = ceil($percent);
      $percentage = '<div class="label-pro-sale">' . $finel_percent . '%</div>';
      $oldPrice = $product->old_price;
      }
      ?>
      <!-- Single Product -->
      <div class="featured-products">
      <div class="featured-product-category">
      <div class="featured-product-img">
      <img src="{{ $product->image}}" height="500" alt="">
      </div>
      <div class="featured-product-content">
      <h2 class="product-name">
      <a title="Proin lectus ipsum" href="{{ url('product/'.$product->id)}}">
      <?= $product->name_ar ?>
      </a>
      </h2>
      <div class="ratings">
      <div class="rating-box">
      <div class="rating">
      <?php //include("aria_rateing.php") ?>
      </div>
      </div>
      </div>
      <div class="product-price">
      <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
      </div>
      </div>
      </div>
      </div>
      <!-- End Single Product -->
      <?php endforeach; ?>
      </div><!-- End Featured Product Area -->
     *
     */
    ?>
    <div class="featured-product-area hidden-xs hidden-sm" style="height:776px;     overflow: auto;" >
        <div class="featured-product-title">
            <h2 style="text-align: right; padding-right: 10px">صفقة اليوم</h2>
        </div>
        <?php foreach ($dealofdays as $product): ?>
            <?php
            if ($product->old_price == 0) {
                $percentage = '';
                $oldPrice = '';
            } else {
                $percent = $product->price / $product->old_price * 100;
                $finel_percent = ceil($percent);
                $percentage = '<div class="label-pro-sale">' . $finel_percent . '%</div>';
                $oldPrice = $product->old_price;
            }
            ?>
            <!-- Single Product -->
            <div class="featured-products">
                <div class="featured-product-category">
                    <div class="featured-product-img">
                        <a title="{{$product->name_ar}}" href="{{ url('product/'.$product->id)}}">
                        <img src="{{ $product->image}}" height="500" alt="">
                        </a>
                    </div>
                    <div class="featured-product-content">
                        <h2 class="product-name">
                            <a title="Proin lectus ipsum" href="{{ url('product/'.$product->id)}}">
                                <?= $product->name_ar ?>
                            </a>
                        </h2>
                        <div class="ratings">
                            <div class="rating-box">
                                <div class="rating">
                                    @include('frontend.home.rating')
                                </div>
                            </div>
                        </div>
                        <div class="product-price">
                            <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Product -->
        <?php endforeach; ?>
    </div><!-- End Featured Product Area -->
    <br />
    <br />
</div>
