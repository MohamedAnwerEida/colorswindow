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
                                        <label> <h4>قسم <?= $category_info->name_ar; ?></h4> </label>
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
                                    <?php foreach ($products as $product): ?>
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
                                        <div class="singel-product single-product-col">
                                            <?= $percentage ?>
                                            <!-- Single Product Image -->
                                            <div class="single-product-img">
                                                <a title="<?= $product->name_ar ?>" href="{{ url('product/'.$product->id)}}">
                                                <img src="{{ $product->image}}"  alt="">
                                                </a>
                                            </div>

                                            <!-- Single Product Content -->
                                            <div class="single-product-content">
                                                <h2 class="product-name">
                                                    <a title="<?= $product->name_ar ?>" href="{{ url('product/'.$product->id)}}">
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
                                                @if(isset($category_info->id))
                                                @if($category_info->id != 1 && $category_info->id != 8)
                                                <div class="product-price">
                                                    <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                                                </div>
                                                @endif
                                                    @else
                                                    <div class="product-price">
                                                        <p><span>  <?= $oldPrice ?></span>  ريال  <?= $product->price ?></p>
                                                    </div>
                                                @endif

                                                <div class="product-actions">
                                                    <a style="margin-left: -4px;" href="{{ url('product/'.$product->id)}}"><button  class="button" title="اضافة إلى المفضلة" type="button"><span><i class="fa fa-heart">&nbsp;</i></span></button></a>
                                                    <a href="{{ url('product/'.$product->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
<!--                                                    <div class="add-to-link">
                                                        <ul class="">
                                                            <li class="quic-view">
                                                                <a href="{{ url('favorite/'.$product->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                                            </li>
                                                        </ul>
                                                    </div>-->
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
                        @if ($category_info->name_ar != 'البحث')
                        <div class="tab-bar tab-bar-bottom">
                            <div class="toolbar">
                                <div class="pages">
                                    <ol>
                                        {{ $products->appends(request()->query())->links() }}
                                    </ol>
                                </div>
                            </div>
                        </div><!-- End Tab Bar -->
                        @endif
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
