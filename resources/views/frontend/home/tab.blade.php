<div class="row">
    <div class="col-md-12">
        <!-- Single Product Tab -->
        <div class="single-product-tab custom-tab">
            <!-- Tabs Bar -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#bestseller" data-toggle="tab">افضل مبيعاَ</a></li>
                <li><a href="#random" data-toggle="tab">الأحدث</a></li>
            </ul><!-- End Tabs Bar -->
            <!-- Tab Content-->
            <div class="tab-content">
                <!-- Tab Pane-->
                <div class="tab-pane active" id="bestseller">
                    <!-- Bestsell Carousel -->
                    <div id="bestsell-carousel-2" class="owl-carousel custom-carousel">
                        <!-- Single Product -->
                        <?php foreach ($products as $product): ?>
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
                            }*/
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
                                    </div>*/?>
                                    <!-- Single Product Actions -->
                                    <!-- End Single Product Actions -->
                                </div><!-- End Single Product Content -->
                                <div class="product-actions">
                                    <a href="{{ url('product/'.$product->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                                    <div class="add-to-link">
                                        <ul class="">
                                            <li class="quic-view">
                                                <a href="{{ url('favorite/'.$product->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- End Single Product -->
                    </div><!-- Bestsell Carousel -->
                </div><!-- End Tab Pane-->
                <!-- Tab Pane-->
                <!-- Tab Pane-->
                <div class="tab-pane" id="random">
                    <!-- Random Carousel -->
                    <div id="random-carousel-2" class="owl-carousel custom-carousel">
                        <?php foreach ($new_products as $product): ?>
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
                            }*/
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
                                    </div>*/?>
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
                        <?php endforeach; ?>
                        <!-- End Single Product -->
                    </div><!-- Random Carousel -->
                </div><!-- End Tab Pane-->
            </div><!-- End Tab Content-->
        </div><!-- End Single Product Tab -->
    </div>
</div>