@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<?php $mydiscount = 0; ?>
<!--  checkout section  -->
<section class="checkout">
    <div class="container">
        <div class="row">
            <?php $total = 0 ?>
            <?php $total_without_tax = 0 ?>
            <?php $extra = 0 ?>
            @include('frontend.layouts.error')
            <div class="col-md-12">
                <div class="chart-item table-responsive fix">
                    @if(count($items) > 0 )
                    <table class="col-md-12" dir="rtl">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>التصميم</th>
                                <th nowrap="">بيانات التصميم</th>
                                <th nowrap="">مواصفات المنتج</th>
                                <th>السعر</th>
                                <th>حذف</th>
                        </thead>
                        <tbody>
                            @foreach($items as $k=>$item)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $item->title}}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ property_exists($item, "desgin")?$item->desgin:'-'}}</td>
                                <td>{{ property_exists($item, "desgin_data")?$item->desgin_data:'-'}}</td>
                                <td>
                                    @foreach($item->spec_data as $spec)
                                    @if($spec->spec_title)
                                    <b><?= $spec->cat_title ?></b>:<?= $spec->spec_title ?><br>
                                    @endif
                                    @endforeach
                                </td>
                                <td>{{ $item->total_price}} ريال</td>
                                <?php $total += $item->total_price ?>
                                <td class="tb_item_remove"><button class="btn btn-outline-warning" index="{{$item->id}}" >✖</button></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">المجموع الكلي شامل الضريبة</td>
                                <td>{{ $total}}  ريال</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php $total_without_tax = ($total / (1 + ($settings->tax / 100))) ?>
                </div>
            </div>
        </div>
        <div class="cart-shopping-area fix">
            <!-- Cart Shoping Area -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="chart-all fix">
                        <h2>طلب عاجل</h2>
                        <div class="cart-all-inner">
                            <form action="urgent" method="post">
                                <p>
                                    اذا كنت تريد الحصول على هذه الطلبية بشكل عاجل يمكن النقر على زر طلب عاجل بتكاليف إضافية.
                                    @if($cart->urgent != 0)
                                    <?php $extra = $total_without_tax * .5 ?>
                                    <button class="btn custom-button urgent" type="submit">الغاء طلب عاجل</button>
                                    @else
                                    <button class="btn custom-button urgent" type="submit">طلب عاجل</button>
                                    @endif
                                </p>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-shopping-area fix">
            <form action="order" method="post" id="form1">
                <!-- Cart Shoping Area -->
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="chart-all fix">
                            <h2>كود الخصم</h2>
                            <div class="cart-all-inner">
                                <p>ادخل كود الخصم اذا كان لديك</p>
                                <div class="col-lg-8 col-md-8">
                                    <input type="text" name="discount_code" id="discount_code"  value="{{ $cart->discount_id?$cart->discount_code:'' }}">
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    @if($cart->discount_id != 0)
                                    <button class="btn custom-button" id="code-btn-cancel" type="button">الغاء</button>
                                    @else
                                    <button class="btn custom-button" id="code-btn" type="button">تطبيق</button>
                                    @endif
                                    <?php
                                    if ($cart->discount_id != 0) {
                                        if ($cart->discount_type == 'fixed') {
                                            $mydiscount = $cart->discount_value;
                                        } else {
                                            $mydiscount = ($cart->discount_value / 100) * ($total_without_tax + $extra);
                                        }
                                    } else {
                                        $mydiscount = 0;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="chart-all fix">
                            <h2>طريقة الدفع</h2>
                            <div class="cart-all-inner">
                                <p>اختر طريقة الدفع التي تناسبك</p>
                                <?php
                                $tax = round(($settings->transfer + $total_without_tax + $extra - $mydiscount) * ($settings->tax / 100), 2);
                                $ftola = round(($settings->transfer + $total_without_tax + $extra - $mydiscount) + $tax, 2);
                                ?>
                                <select name="pay_type" id="pay_type">
                                    <option value="0" <?= $cart->pay_type == 0 ? 'selected' : '' ?>>الدفع الالكتروني</option>
                                    @if(round($ftola) <=500)
                                    <option value="{{ $settings->transfer }}" <?= $cart->pay_type == $settings->transfer ? 'selected' : '' ?>>الدفع عند الاستلام</option>
                                    @endif
                                </select>
                                <span style="color: #b53974;margin-top: 12px;display: block;">
                                    الدفع عند الاستلام متاح لطلب بقيمة 500 ريال أو أقل.
                                </span>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-12">
                        <div class="shopping-summary chart-all fix">
                            <div class="shopping-cost-area">
                                <div class="shopping-cost">
                                    <div class="shopping-cost-right">
                                        <p class="floatright">المجموع قبل الضريبة </p>
                                        @if($cart->urgent != 0)
                                        <p>طلب مستعجل</p>
                                        @endif
                                        <p>الخصم</p>
                                        <p>تكاليف اضافية</p>
                                        <p>الضريبة</p>

                                    </div>
                                    <div class="shopping-cost-left">
                                        <p><span id="ptotal">{{ round($total_without_tax,2) }}</span>  ريال</p>
                                        @if($cart->urgent != 0)
                                        <p>{{ round($extra,2) }} ريال</p>
                                        @endif
                                        <p>
                                            <span id="discount">
                                                <?= round($mydiscount, 2) ?>
                                            </span> ريال
                                        </p>
                                        <p><span id = "transfer">0</span> ريال</p>
                                        <p><span id="tax">0</span>  ريال</p>

                                    </div>

                                </div>
                                <div class = "shiping-cart-button" style = "margin-top: 5px;">
                                    <div class = "shopping-cost" style = "color:#b53974 !important; margin-bottom: 0;">
                                        <div class = "shopping-cost-right">
                                            <p>المجموع النهائي</p>
                                        </div>
                                        <div class = "shopping-cost-left">
                                            <p><span id="total">
                                                    <?php
                                                    $tax_final = round(($cart->pay_type + $total_without_tax + $extra - $mydiscount) * ($settings->tax / 100), 2);
                                                    echo $ftola_final = round(($cart->pay_type + $total_without_tax + $extra - $mydiscount) + $tax_final, 2);
                                                    ?>
                                                </span> ريال</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-lg-12 col-md-12">
                        <div class = "calculate-shipping chart-all fix">
                            <h2>
                                <i class = "fa fa-file"></i>
                                بيانات الشحن
                            </h2>
                            <div class = "cart-all-inner">
                                <p>يمكنك تخزين بيانات الشحن بشكل دائما من خلال ملفك الشخصي..</p>

                                <div class = "col-lg-6 col-md-6">
                                    <h3>الحي <sup>*</sup></h3>
                                    <input type = "text" name = "neighborhood" required = "required" value = "{{ $cart->neighborhood!=''?$cart->neighborhood:$user->neighborhood }}" class = "mytext form-control">

                                    <h3>الشارع<sup>*</sup></h3>
                                    <input type = "text" name = "street" required = "required" value = "{{ $cart->street!=''?$cart->street:$user->street }}" class = "mytext form-control">
                                </div>
                                <div class = "col-lg-6 col-md-6">
                                    <h3>رقم العمارة<sup>*</sup></h3>
                                    <input type = "text" name = "building" required = "required" value = "{{$cart->building!=''?$cart->building:$user->building }}" class = "mytext form-control">

                                    <h3>المدينة<sup>*</sup></h3>
                                    <select class="form-control" name="city" id="city">
                                        @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->nameAr }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class = "col-lg-12 col-md-12">
                                    <h3>ملاحظات</h3>
                                    <textarea name="notes" class="form-control">{{ $cart->notes!=''?$cart->notes:$user->notes }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--End Cart Shoping Area-->

                <div class = "form-group" style = "margin-top: 22px;">
                    <div id = "root"></div>
                    <button class="btn custom-button d-block" name="pay" value="1" id="openLightBox" onclick="gopay(); return false">اتمام الدفع</button>
                    <button type="submit" name="save" value="2" class="btn custom-button d-block" style="display: none" id ="btnsave">تنفيذ الطلب</button>
                    <a class = "btn custom-button d-block" href = "{{ url('cart/pdf')}}" target="_blank">عرض سعر</a>
                </div>

                <p class = "reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                {{ csrf_field() }}
            </form>


        </div>
        @else
        <div class = "checkout_items_gen_porp">
            <div class = "chackout_table chackout_table_body" style = " text-align: center;">
                No Items
            </div>
        </div>
        @endif
    </div>
</div>
</section>
<!--end of checkout section-->

@stop
@section('css')
<link href="https://goSellJSLib.b-cdn.net/v1.4.1/css/gosell.css" rel="stylesheet" type="text/css"/>
<script src="https://goSellJSLib.b-cdn.net/v1.4.1/js/gosell.js" type="text/javascript"></script>
<style>
    .chart-all button.urgent {
        float: none;
        margin-right: 15px;
    }
    .table td{ text-align: right}
    .table th{ text-align: center}
    .tb_item_remove .btn {
        margin: auto;
        display: block;
    }
    .btn.btn-outline-warning {
        background-color: #e63671;
        color: #fff;
    }
    .form-control {
        height: 40px;
        line-height: 2;
    }
    .calculate-shipping h3 {
        margin-top: 15px;
    }
</style>
@stop
@section('js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
<script>
                        function gopay() {
                        var e = 0;
                        $('.mytext').each(function(i, obj) {
                        if ($(this).val() == ""){
                        e = 1;
                        }
                        });
                        if (e == 0){
                        goSell.openLightBox();
                        } else{
                        swal("خطأ", 'ادخل كافة بيانات الشحن');
                        }
                        return false;
                        }
                        $(document).ready(function () {
                        $("#code-btn-cancel").click(function () {
                        window.location.href = "<?= route('coupone-remove') ?>";
                        });
                        $("#code-btn").click(function () {
                        var code = $('#discount_code').val();
                        if (code != ''){
                        window.location.href = "<?= url('coupone-add') ?>/" + code;
                        } else{
                        swal("خطأ", 'ادخل كود الخصم');
                        }
                        });
                        $(".mytext").on("focusout", function () {
                        var name = $(this).attr("name");
                        $.post("{{ url('cart/shipping') }}", {  fname:name, fvalue: $(this).val() })
                                .done(function(data) {});
                        });
                        $("#city").on("change", function () {
                        $.post("{{ url('city') }}", {  city: $("#city").val() })
                        });
                        $("#city").trigger("change");
                        $("#pay_type").on("change", function () {
                        $.post("{{ url('cart/pay') }}", {  pay_type: $("#pay_type").val() })
                                .done(function(data) {
                                $("#transfer").text($("#pay_type").val());
                                if ($("#pay_type").val() > 0) {
                                $("#openLightBox").hide();
                                $("#btnsave").show();
                                } else {
                                $("#total").text(total + parseFloat(<?= $extra ?>));
                                $("#openLightBox").show();
                                $("#btnsave").hide();
                                }
                                tax = ((parseFloat($("#pay_type").val()) + parseFloat($("#ptotal").text()) + parseFloat(<?= $extra ?>) - parseFloat($('#discount').text())) *<?= $settings->tax / 100 ?>).toFixed(2);
                                $("#tax").text(tax);
                                ftola = (parseFloat($("#pay_type").val()) + parseFloat($("#ptotal").text()) + parseFloat(<?= $extra ?>) - parseFloat($('#discount').text()) + parseFloat($('#tax').text())).toFixed(2);
                                $("#total").text(ftola);
                                });
                        });
                        $("#pay_type").trigger("change");
                        $(".tb_item_remove button").on("click", function () {
                        swal({
                        title: "حذف منتج",
                                text: 'هل انت متاكد من الحذف',
                                icon: "warning",
                                buttons: {
                                cancel: "لا",
                                        catch : {
                                        text: "نعم",
                                                value: "catch",
                                        }
                                },
                        })
                                .then((value) => {
                                switch (value) {
                                case "catch":
                                        index = $(this).attr('index');
                                console.log(index);
                                $(this).closest('tr').remove();
                                $.ajax({
                                url: "{{ url('cart/remove') }}",
                                        data: {
                                        _token: $('[name="csrf_token"]').attr('content'),
                                                index: index,
                                        },
                                        error: function () {
                                        $('#info').html('<p>An error has occurred</p>');
                                        },
                                        dataType: 'json',
                                        success: function (data) {

                                        //update_pay($("#total").text());
                                        window.location.href = "<?= url('cart') ?>";
                                        },
                                        type: 'GET'
                                });
                                break;
                                }
                                });
                        });
                        });
<?php if ($cart) { ?>
                            goSell.config({
                            containerID: "root",
                                    gateway: {
    <?php // "pk_test_cgEJzPZtL6DXGNm157Q4O8uB",                                      ?>
                                    publicKey:"pk_live_JC2fuQ9SNysMh4ant8ebrXUd",
                                            language: "ar",
                                            contactInfo: true,
                                            supportedCurrencies: "SAR",
                                            supportedPaymentMethods: "all",
                                            saveCardOption: false,
                                            customerCards: true,
                                            notifications: 'standard',
                                            callback: (response) => {
                                    console.log('response', response);
                                    },
                                            onClose: () => {
                                    console.log("onClose Event");
                                    },
                                            backgroundImg: {
                                            url: 'http://colorswindow.com/assets/admin/pages/img/login/Login.png?v=3',
                                                    opacity: '0.5'
                                            },
                                            labels: {
                                            cardNumber: "Card Number",
                                                    expirationDate: "MM/YY",
                                                    cvv: "CVV",
                                                    cardHolder: "Name on Card",
                                                    actionButton: "Pay"
                                            },
                                            style: {
                                            base: {
                                            color: '#535353',
                                                    lineHeight: '18px',
                                                    fontFamily: 'sans-serif',
                                                    fontSmoothing: 'antialiased',
                                                    fontSize: '16px',
                                                    '::placeholder': {
                                                    color: 'rgba(0, 0, 0, 0.26)',
                                                            fontSize: '15px'
                                                    }
                                            },
                                                    invalid: {
                                                    color: 'red',
                                                            iconColor: '#fa755a '
                                                    }
                                            }
                                    },
                                    customer: {
                                    first_name: "<?= $user->name ?>",
                                            middle_name: "",
                                            last_name: "",
                                            email: "<?= $user->email ?>",
                                            phone: {
                                            country_code: "966",
                                                    number: "<?= $user->phone ?>"
                                            }
                                    },
                                    order: {
                                    amount:  <?= round(($total_without_tax + $extra - $mydiscount) * (1 + ($settings->tax / 100)), 2) ?>,
                                            currency: "SAR",
                                            items: [
    <?php $i = 1; ?>
    <?php foreach ($items as $k => $item): ?>
                                                {
                                                id: <?= $i++ ?>,
                                                        name: '<?= $item->title ?>',
                                                        description: '',
                                                        quantity: '<?= $item->qty ?>',
                                                        amount_per_unit: '<?= round($item->total_price / $item->qty, 2) ?>',
                                                        total_amount: '<?= $item->total_price ?>'
                                                },
    <?php endforeach ?>
                                            ],
                                            shipping: null,
                                            taxes: null
                                    },
                                    transaction: {
                                    mode: 'charge',
                                            charge: {
                                            saveCard: false,
                                                    threeDSecure: true,
                                                    description: "شراء منتجات من موقع نافذة الألوان",
                                                    statement_descriptor: "Sample",
                                                    reference: {
                                                    transaction: "txn_<?= $cart->id ?>",
                                                            order: "ord_<?= $cart->id ?>"
                                                    },
                                                    metadata: {},
                                                    receipt: {
                                                    email: false,
                                                            sms: true
                                                    },
                                                    redirect: "https://colorswindow.com/orderComplate",
                                                    post: "https://colorswindow.com/saveOrder",
                                            }
                                    }
                            });
<?php } ?>
</script>
@stop
