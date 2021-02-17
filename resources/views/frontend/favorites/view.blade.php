@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<div class="shop-product-area">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <!-- Shop Product View -->
                <div class="shop-product-view">
                    <!--                     Shop Category Image 
                                        <div class="shop-category-image">
                                            <img src="img/banner/banner-grid.png" alt="banner">
                                        </div>-->
                    <!-- Shop Product Tab Area -->
                    <div class="product-tab-area">
                        <!-- Tab Bar -->
                        <div class="tab-bar">
                            <div class="tab-bar-inner">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#shop-product" data-toggle="tab"><i class="fa fa-th-large"></i></a></li>
                                    <li><a href="#shop-list" data-toggle="tab"><i class="fa fa-th-list"></i></a></li>
                                </ul>
                            </div>
                            <div class="toolbar">
                                <div class="sorter">
                                    <div class="sort-by" dir="rtl">
                                        <label> <h4>المفضلة</h4> </label>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Tab Bar -->
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Shop Product-->
                            <div class="tab-pane active" id="shop-product">
                                <!-- Tab Single Product-->
                                <div class="tab-single-product">
                                    <?php foreach ($favs as $pro): ?>
                                        <?php
                                        $product = $pro->product;
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
                                        <div class="singel-product single-product-col">
                                            <?= $percentage ?>
                                            <!-- Single Product Image -->
                                            <div class="single-product-img">
                                                <img src="{{ $product->image}}" height="500" alt="">

                                            </div>
                                            <!-- Single Product Content -->
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
                                                <div class="product-price">
                                                    <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                                                </div>
                                                <div class="product-actions">
                                                    <a href="{{ url('product/'.$product->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                                                    <div class="add-to-link">
                                                        <ul class="">
                                                            <li class="quic-view">
                                                                <a href="{{ url('unfavorite/'.$product->id)}}"><button type="button"><i class="fa fa-heart"></i>الغاء المفضلة</button></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- End Single Product Content -->
                                        </div>
                                        <!-- End Single Product -->
                                    <?php endforeach; ?>
                                </div><!-- End Tab Single Product-->
                            </div><!-- End Shop Product-->
                            <!-- Shop List -->
                        </div><!-- End Tab Content -->
                        <!-- Tab Bar -->
                        <div class="tab-bar tab-bar-bottom">
                            <div class="toolbar">
                                <div class="pages">
                                    <ol>
                                        {{ $favs->appends(request()->query())->links() }}
                                    </ol>
                                </div>
                            </div>
                        </div><!-- End Tab Bar -->
                    </div><!-- End Shop Product Tab Area -->
                </div>
                <!-- End Shop Product View -->
            </div>
            <div class="col-md-3 col-sm-12">
                <!-- Left Sidebar-->
                @include('frontend.home.right')
                <!-- End Left Sidebar -->
            </div>
        </div>
    </div>
</div><!-- End Shop Product Area -->

@stop
@section('css')
@stop
@section('js')

@stop