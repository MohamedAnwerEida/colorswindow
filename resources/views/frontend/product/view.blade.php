@extends('frontend.layouts.master')
@section('title', 'Page Title')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
    <style>
        .social-sharing {
            border: 1px solid #e8e8e9;
            float: left;
            margin: 30px 0;
            padding: 10px;
            width: 100%;
        }
        .social-sharing h3{
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            color: #909295;
            float: right;
            font-size: 16px;
            line-height: 30px;
            margin: 0 0 0 20px;
            text-transform: none;
            width: auto;}
        .social-sharing .sharing-icon{float: right;}
        .social-sharing .sharing-icon a{display:inline-block}
        .social-sharing .sharing-icon a i{
            border: 1px solid #e8e8e9;
            color: #909295;
            font-size: 18px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            transition: all 0.3s ease 0s;
            width: 35px;}
        .social-sharing .sharing-icon a i{}
        .social-sharing .sharing-icon a i.fa-facebook:hover {
            background: #3b579d none repeat scroll 0 0;
            border: 1px solid #3b579d;
        }
        .social-sharing .sharing-icon a i.fa-twitter:hover {
            background: #3acaff;
            border: 1px solid #3acaff;
        }
        .social-sharing .sharing-icon a i.fa-pinterest:hover {
            background: #CB2027;
            border: 1px solid #CB2027;
        }
        .social-sharing .sharing-icon a i.fa-google-plus:hover {
            background: #D11717;
            border: 1px solid #D11717;
        }
        .social-sharing .sharing-icon a i.fa-linkedin:hover {
            background: #0097BD;
            border: 1px solid #0097BD;
        }
        .social-sharing .sharing-icon a i:hover {
            color:#fff;
        }
        .social-sharing .sharing-icon a i.fa-whatsapp:hover {
            background: #3FE028;
            border: 1px solid #3FE028;
        }
        .social-sharing {
            border: 1px solid #e8e8e9;
            float: left;
            margin: 30px 0;
            padding: 10px;
            width: 100%;
        }
    </style>
    <div class="product-layout-area">
        <div class="container">
            <div class="row">
                <!-- Breadcurb Area -->
                <div class="breadcurb-area">
                    <div class="container">
                        <ul class="breadcrumb" dir="rtl">
                            <li class="home"><a href="{{ url('/')}}">الرئيسيه</a></li>
                            <li class=""><a href="#"><?= $product->category->name_ar; ?></a></li>
                            <li><?= $product->name_ar ?></li>
                        </ul>
                    </div>
                </div>
                <!-- End Breadcurb Area -->
                <!-- Single Product details Area -->
                <div class="single-product-detaisl-area">
                    <!-- Single Product View Area -->
                    <div class="single-product-view-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <!-- Single Product View -->
                                    <div class="single-procuct-view" >
                                        <!-- Simple Lence Gallery Container -->
                                        <div class="simpleLens-gallery-container" id="p-view">
                                            <div class="simpleLens-container tab-content">
                                                <div class="tab-pane active" id="p-view-<?= $product->id ?>">
                                                    <div class="simpleLens-big-image-container">
                                                        <a class="simpleLens-lens-image" data-lens-image="{{ $product->image?url($product->image):''}}">
                                                            <img src="{{ $product->image?url($product->image):''}}" class="simpleLens-big-image" alt="productd">
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php $extra_images = \GuzzleHttp\json_decode($product->extra_images) ?>
                                                @foreach($extra_images as $image)
                                                    <div class="tab-pane" id="p-view-<?= $loop->iteration ?>">
                                                        <div class="simpleLens-big-image-container">
                                                            <a class="simpleLens-lens-image" data-lens-image="{{ url($image) }}">
                                                                <img src="{{ url($image) }}" class="simpleLens-big-image" alt="productd">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- Simple Lence Thumbnail -->
                                            <div class="simpleLens-thumbnails-container">
                                                <div id="single-product" class="owl-carousel custom-carousel">
                                                    <ul class="nav nav-tabs" role="tablist">

                                                        <li class="active">
                                                            <a href="#p-view-<?= $product->id ?>" role="tab" data-toggle="tab">
                                                                <img src="{{ url(get_image($product->image,95,95)) }}" alt="productd">
                                                            </a>
                                                        </li>
                                                        @foreach($extra_images as $image)
                                                            <li>
                                                                <a href="#p-view-<?= $loop->iteration ?>" role="tab" data-toggle="tab">
                                                                    <img src="{{ url(get_image($image,95,95)) }}" alt="productd">
                                                                </a>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div><!-- End Simple Lence Thumbnail -->
                                        </div><!-- End Simple Lence Gallery Container -->
                                    </div><!-- End Single Product View -->
                                </div>
                                <div class="col-md-7">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                        <!-- Single Product Content View -->
                                        <div class="single-product-content-view">
                                            <div class="product-info ">
                                                <h1 class="text-right"><?= $product->name_ar ?></h1>
                                                <h4 class="text-right" style="font-size: 13px;">N<?= $product->id ?>-<?= $product->serial ?> <span style="color: green">الرقم التسلسلي</span> </h4>
                                                <div class=""><p><?= $product->text_ar ?></p></div>

                                                <form id="card_form" method="post" action="{{ url('cart/'. $product->id)}}">
                                                    <div class="product-spec">
                                                        <input  type="hidden" id="qnormal" value="{{$product->qty}}" >


                                                        @if($product->category->id != 1 && $product->category->id != 8)
                                                            @if($product->qty > 0)
                                                                <h2 class="spec-header">الكمية</h2>
                                                                <input id="qty" type="number" name="qty"  value="<?= $product->min_qty ?>" min="<?= ($product->min_qty) ?>" class="qty">
                                                                <span class="remain-qty">الكمية المتبقية :<?= $product->qty ?></span>
                                                            @else
                                                                <input  type="hidden" name="qty" value="0" min="0" class="qty">
                                                                <hr>
                                                                <div class="alert alert-danger" role="alert">
                                                                    المنتج غير متوفر حاليا
                                                                </div>

                                                            @endif
                                                        @else
                                                            <h2 class="spec-header">الكمية</h2>
                                                            <input id="qty" type="number" name="qty" value="<?= $product->min_qty ?>" min="<?= $product->min_qty ?>" class="qty">
                                                        @endif

                                                        <?php $temp_name = ''; ?>
                                                        <?php $i = 0; ?>
                                                        <?php $ok = 0; ?>
                                                        <?php $onetime = 0; ?>
                                                        <?php if (sizeof($product->subcats->spec) > 0) { ?>
                                                        @foreach($product->subcats->spec as $spec)
                                                            <?php if ($temp_name != $spec->catspectype->name) { ?>
                                                            <?= $i != 0 ? '</select>' : '' ?>
                                                            <?php if ($spec->view_meter == 1 && $onetime == 0) { ?>
                                                            <h2 class="spec-header">المقاس بالمتر</h2>
                                                            <label>العرض</label>
                                                            <input type="number" name="product_width" value="0" min="1"  class="product_width" />
                                                            <label>الارتفاع</label>
                                                            <input type="number" name="product_height" value="0" min="1"  class="product_height" />
                                                            <?php
                                                            $onetime++;
                                                            }
                                                            ?>
                                                            <?php if ($spec->spec_id == 15 && $onetime == 0) { ?>
                                                            <h2 class="spec-header"><?= $spec->catspectype->name ?> <span class="small-hint">(يجب ان يكون اىرقم يقبل القسمة على 2)</span></h2>
                                                            <input type="number" name="page_no" value="2" min="1"  class="page_no" />
                                                            <?php
                                                            $onetime++;
                                                            ?>
                                                            @continue
                                                            <?php } ?>
                                                            <h2 class="spec-header"><?= $spec->catspectype->name ?></h2>
                                                            <?php $temp_name = $spec->catspectype->name; ?>
                                                            <?php $i = 1 ?>
                                                            <?php $class_name = $spec->catspectype->class_name ?>
                                                            <?php if ($class_name == 'desgin') $ok = 1 ?>
                                                            <select name="spec[<?= $spec->catspectype->id ?>]" class="form-control spec-select spec_<?= $spec->catspectype->id ?> <?= $class_name ?>">
                                                                <?php } ?>
                                                                <option value='<?= $spec->id ?>' data-repeats='<?= $spec->view_repeat ?>' data-meter='<?= $spec->view_meter ?>' data-view='<?= $spec->view_attr ?>' data-price1='<?= $spec->price1 ?>' data-index='<?= $spec->catspectype->id ?>' data-price='<?= $spec->price ?>' data-one='<?= $spec->one_time ?>' data-qty='<?= $spec->qty ?>'>
                                                                    <?= $spec->name ?>
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <?php } ?>
                                                            <?php if ($ok == 1) { ?>
                                                            <div>
                                                                <div class="no">
                                                                    <h2 class="spec-header">اطلب التصميم الخاص بك</h2>
                                                                    <textarea class="form-control" name="desgin_detail" placeholder="اكتب ما تريد من تفاصيل تخص التصميم المطلوب تجهيز"></textarea>
                                                                </div>
                                                                <div class="yes">
                                                                    <h2 class="spec-header">رابط التصميم</h2>
                                                                    <input type="text" value=""  name="desgin_link" class="form-control" placeholder="أدخل رابط التصميم">
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            <h2 class="spec-header">السعر الكلي <span class="price">0</span> ريال</h2>
                                                    </div>
                                                    <div style="display: none" id="q-alert" class="alert alert-danger" role="alert">
                                                        الرجاء ادخال قيمة أقل او تساوي {{$product->qty}}
                                                    </div>
                                                    <!-- Add to Box -->
                                                    <div class="add-to-box add-to-box2">
                                                        <div class="quick-add-to-cart">
                                                            <div class="product-actions">
                                                                @if($product->category->id != 1 && $product->category->id != 8)
                                                                    <?php if ($product->qty > 0) { ?>
                                                                        <a style="background: #7251a1;width: 75%;"  href="javascript:;" onclick="$('#card_form').submit();" class="button btn-cart" value="اضافه إلى السلة" >اضافه إلى السلة</a>
                                                                    <?php } else { ?>
                                                                    <a class="button btn-cart" title="المنتج غير متوفر حاليا" style="background-color: #6a6a6a;"><span>المنتج غير متوفر حاليا</span></a>
                                                                    <?php } ?>
                                                                @else
                                                                    <a style="background: #7251a1;width: 75%;"  href="javascript:;" onclick="$('#card_form').submit();" class="button btn-cart" value="اضافه إلى السلة" >اضافه إلى السلة</a>
                                                                @endif
                                                                <a href="{{ url('favorite/'.$product->id)}}" class="button btn-cart" title="اضافة الي المفضلة" style="background-color: #7251a1;"><i class="fa fa-heart">&nbsp;</i><span>المفضلة</span></a>

                                                            </div>
                                                        </div>
                                                    </div><!-- End Add to Box -->
                                                    {{ csrf_field() }}
                                                </form>
                                            </div><!-- End Single Product Content View -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Single Product View Area -->
                        <div class="social-sharing">
                            <h3>مشاركة هذه الصفحة</h3>
                            <?php
                            $title = urlencode($product->title);
                            $url = urlencode(url('product/' . $product->id));
                            ?>
                            <div class="sharing-icon">
                                <a data-toggle="tooltip" title="Facebook" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a data-toggle="tooltip" title="Twitter" onClick="window.open('https://twitter.com/intent/tweet?text=<?= $title ?>&url=<?= $url ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a data-toggle="tooltip" title="Linkedin" onClick="window.open('https://www.linkedin.com/sharing/share-offsite/?url=<?= $url ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                                <a data-toggle="tooltip" title="whatsup" href="https://wa.me/?text=<?= $url ?>" target="_blank">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Single Description Tab -->

                    </div><!-- End Single Description Tab -->
                    <div class="product-area ">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Product View Area -->
                                    <div class="product-view-area ">
                                        <!-- Single Product Category Related Products -->
                                        <div class="single-product-category related-products">
                                            <!-- Product Category Title-->
                                            <div class="head-title">
                                                <p>منتجات مشابهة</p>
                                            </div>
                                            <!-- Product View -->
                                            <div class="product-view">
                                                <!-- Product View Carousel -->
                                                <div id="related-products-carousel" class="owl-carousel custom-carousel">
                                                    <!-- Single Product -->
                                                    <?php foreach ($related_product as $item): ?>
                                                    <div class="singel-product single-product-col">
                                                        <div class="label-pro-sale">Hot</div>
                                                        <!-- Single Product Image -->
                                                        <div class="single-product-img">
                                                            <a title="<?= $item->name_ar ?>" href="{{ url('product/'.$item->id)}}">
                                                                <img src="{{ url(get_image($item->image,300,300)) }}" alt="">
                                                            </a>
                                                        </div>
                                                        <!-- Single Product Content -->
                                                        <div class="single-product-content">
                                                            <h2 class="product-name">
                                                                <a title="<?= $item->name_ar ?>" href="{{ url('product/'.$item->id)}}"><?= $item->name_ar ?></a>
                                                            </h2>
                                                            <!-- Single Product Actions -->
                                                            <div class="product-actions">
                                                                <a href="{{ url('product/'.$item->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                                                                <a style="margin-left: -4px;" href="{{ url('product/'.$item->id)}}"><button  class="button" title="اضافة إلى المفضلة" type="button"><span><i class="fa fa-heart">&nbsp;</i></span></button></a>
<!--                                                                <div class="add-to-link">
                                                                    <ul class="">
                                                                        <li class="quic-view">
                                                                            <a href="{{ url('favorite/'.$item->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>-->
                                                            </div><!-- End Single Product Actions -->
                                                        </div><!-- End Single Product Content -->
                                                    </div>
                                                <?php endforeach; ?>
                                                <!-- End Single Product -->
                                                </div><!-- End Product View Carousel -->
                                            </div><!-- End Product View-->
                                        </div><!-- End Single Product Category -->
                                        <!-- Single Product Category UpSell Product -->
<!--                                        <div class="single-product-category upsell-products">
                                            &lt;!&ndash; Product Category Title&ndash;&gt;
                                            <div class="head-title">
                                                <p>منتجات ذات صلة</p>
                                            </div>
                                            &lt;!&ndash; Product View &ndash;&gt;
                                            <div class="product-view">
                                                &lt;!&ndash; Product View Carousel &ndash;&gt;
                                                <div id="upsell-products-carousel" class="owl-carousel custom-carousel">
                                                    &lt;!&ndash; Single Product &ndash;&gt;
                                                    <?php foreach ($products as $item): ?>
                                                    <div class="singel-product single-product-col">
                                                        <div class="label-pro-sale">Hot</div>
                                                        &lt;!&ndash; Single Product Image &ndash;&gt;
                                                        <div class="single-product-img">
                                                            <a title="<?= $item->name_ar ?>" href="{{ url('product/'.$item->id)}}">
                                                                <img src="{{ url(get_image($item->image,300,300)) }}" alt="">
                                                            </a>
                                                        </div>
                                                        &lt;!&ndash; Single Product Content &ndash;&gt;
                                                        <div class="single-product-content">
                                                            <h2 class="product-name"><a title="Proin lectus ipsum" href="{{ url('product/'.$item->id)}}"><?= $item->name_ar ?></a></h2>
                                                            &lt;!&ndash; Single Product Actions &ndash;&gt;
                                                            <div class="product-actions">
                                                                <a href="{{ url('product/'.$item->id)}}"><button  class="button btn-cart" title="اضافة إلى المفضلة" type="button"><i class="fa fa-shopping-cart">&nbsp;</i><span>التفاصيل</span></button></a>
                                                                <a style="margin-left: -4px;" href="{{ url('product/'.$item->id)}}"><button  class="button" title="اضافة إلى المفضلة" type="button"><span><i class="fa fa-heart">&nbsp;</i></span></button></a>
&lt;!&ndash;                                                                <div class="add-to-link">
                                                                    <ul class="">
                                                                        <li class="quic-view">
                                                                            <a href="{{ url('favorite/'.$item->id)}}"><button type="button"><i class="fa fa-heart"></i>المفضلة</button></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>&ndash;&gt;
                                                            </div>&lt;!&ndash; End Single Product Actions &ndash;&gt;
                                                        </div>&lt;!&ndash; End Single Product Content &ndash;&gt;
                                                    </div>
                                                <?php
                                                endforeach;
                                                ?>
                                                &lt;!&ndash; End Single Product &ndash;&gt;
                                                </div>&lt;!&ndash; End Product View Carousel &ndash;&gt;
                                            </div>&lt;!&ndash; End Product View&ndash;&gt;
                                        </div>-->
                                        <!-- End Single Product Category -->
                                    </div><!-- End Product View Area -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .remain-qty {
            font-size: 14px;
            color: #6d629e;
        }
        .small-hint{
            font-size: 12px;
        }
    </style>

@stop

@section('js')
    <script>
        function qNote(){
            let min = parseInt($('#qnormal').val());
            let quantity = parseInt($('#qty').val());
            console.log('min',min);
            console.log('quantity',quantity);

            if(quantity > min){
                console.log('quantity > min');
                $('#q-alert').css('display','block')
                $('.btn-cart').attr('disabled',true)
            }else{
                console.log('quantity <= min');
                $('#q-alert').css('display','none')
                $('.btn-cart').attr('disabled',false)
            }
        }
        var meter = 0;
        var v_meter = 0;
        var sqty = 1;
        var price = 0;
        var install_unit_price = 0;
        var install_price = 0;
        var cprice = new Array();

        $(document).ready(function () {

            $(".desgin").change(function () {
                desgin_price = $(this).find('option:selected').attr("data-price");
                if (desgin_price > 0) {
                    $('.no').show();
                    $('.yes').hide();
                    $("[name='desgin_detail']").attr('required', false);
                    $("[name='desgin_link']").attr('required', false);
                } else {
                    $('.yes').show();
                    $('.no').hide();
                }
            });
            $(".spec-select").change(function () {
                index = $(this).find('option:selected').attr("data-index");
                one = $(this).find('option:selected').attr("data-one");
                meter = $(this).find('option:selected').attr("data-meter");
                repeat = $(this).find('option:selected').attr("data-repeats");
                price = $(this).find('option:selected').attr("data-price");
                install_price = $(this).find('option:selected').attr("data-price1");
                view = $(this).find('option:selected').attr("data-view");
                qty = $(this).find('option:selected').attr("data-qty");
                cprice[index] = {
                    'index': index,
                    'view': view,
                    'one': one,
                    'meter': meter,
                    'repeat': repeat,
                    'price': price,
                    'qty': qty,
                    'sprice': (install_price ? install_price : 0)
                }
                if (parseFloat(meter) == 1) {
                    v_meter = 1;
                    install_unit_price = (install_price ? install_price : 0);
                }
                get_total();
            });
           /* $(".qty").click(function () {
                get_total();
                qNote();
            })*/
            $(".qty").change(function () {
                get_total();
                qNote();
            })
            if ($(".product_width").val()) {
                $(".product_width,.product_height").change(function () {
                    get_total();
                })
            }
            $(".page_no").change(function () {
                page = ($(".page_no").val())
                if (page % 2 != 0) {
                    alert('يجب ان يكون الرقم يقبل القسمة على 2');
                    $(".page_no").val(2);
                }
                get_total();
            })
            $(".custom-type").change(function () {
                ccview = $(this).find('option:selected').attr("data-view");
                if (ccview == 1) {
                    $(".custom").hide();
                } else {
                    $(".custom").show();
                }
                if ($(this).find('.spec_14')) {
                    id = $(this).val();
                    if (id == 1550) {
                        $(".spec_14").children("option[value^=1565]").hide();
                    } else {
                        $(".spec_14").children('option').show();
                    }
                }
                get_total();
            });

            $('.spec-select').trigger("change");
            $('.desgin').trigger("change");
            $('.custom-type').trigger("change");
            get_total();
        });
        function get_total() {
            qty = $(".qty").val();
            page_no = $(".page_no").val();
            qty = page_no ? qty * page_no : qty;
            total_price = <?= $product->price ?> * qty;
            if (v_meter != 1) {
                $.each(cprice, function (index, value) {
                    if (value) {
                        if (parseFloat(value.repeat) == 1) {
                            myprice = value.price;
                        } else {
                            myprice = ((value.price - value.sprice) * qty) + parseFloat(value.sprice);
                        }
                        if (parseFloat(value.index) == 13) {
                            //myprice = cprice[3].qty * qty;
                        }

                        total_price = parseFloat(total_price) + parseFloat(myprice);
                        if (parseFloat(value.view) == 1) {
                            //الغاء سعر المواصفات الخاصة في حالة اخفائها
                            custom_price = $(".custom").find('option:selected').attr("data-price");
                            custom_repeat = $(".custom").find('option:selected').attr("data-repeats");
                            if (parseFloat(custom_repeat) == 1) {
                                ccprice = custom_price;
                            } else {
                                ccprice = custom_price * qty;
                            }
                            total_price = total_price - ccprice;
                        }
                    }
                });
            } else {
                $.each(cprice, function (index, value) {
                    install = 0;
                    if (value) {
                        if (parseFloat(value.meter) == 1) {
                            meter_width = $(".product_width").val();
                            meter_height = $(".product_height").val();
                            myprice = meter_width * meter_height * value.price * qty;
                        } else {
                            if (parseFloat(value.repeat) == 1) {
                                myprice = value.price;
                            } else {
                                myprice = value.price * qty;
                            }
                        }
                        if (parseFloat(index) == 6) {
                            if (parseFloat(value.sprice) == 1) {
                                install = install_unit_price * meter_width * meter_height * qty;
                            }
                        }
                        total_price = parseFloat(total_price) + parseFloat(myprice) + parseFloat(install);
                    }
                });
            }
            $('.price').html(total_price.toFixed(2));
//        }
        }
    </script>
@stop
