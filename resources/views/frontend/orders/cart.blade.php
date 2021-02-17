@extends('frontend.layouts.master')
@section('title', 'Page Title')
@section('content')
<div class="main-blog-page blog-post-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                @if(session()->has('paid'))
                @if(Session::get('paid')==1)
                <center>
                    <div class="good-msg">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="hint-msg">
                        شكرا لتسوقك من نافذة الألوان
                        <br>
                        رقم طلبك هو: <?= Session::get('order') ?>
                        <br>
                        جاري تجهيز طلبك وسيتم التواصل معك قريبا!
                    </div>
                </center>
                @else
                <center>
                    <div class="erorr-msg">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="hint-msg">
                        يوجد خطأ في معالجة عملية الدفع، الرجاء المحاولة لاحقاً.
                    </div>
                </center>
                @endif
                @else
                <center>
                    <div class="erorr-msg">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="hint-msg">
                        لم يتم تنفيذ اي طلب جديد شكرا لك
                    </div>
                </center>
                @endif
                <br>
            </div>
        </div>
    </div>
</div>
<div id="root"></div>
@stop
@section('css')
@if($cart)
<link href = "https://goSellJSLib.b-cdn.net/v1.4.1/css/gosell.css" rel = "stylesheet" type = "text/css"/>
<script src = "https://goSellJSLib.b-cdn.net/v1.4.1/js/gosell.js" type = "text/javascript"></script>
@endif
<style>
    .good-msg i {
        color: #5c9820;
        font-size: 60px;
        border: 1px solid #5c9820;
        border-radius: 50%;
        width: 60px;
        margin-bottom: 15px;
    }
    .erorr-msg i {
        color: #f00;
        font-size: 60px;
        border: 1px solid #f00;
        border-radius: 50%;
        width: 60px;
        margin-bottom: 15px;
    }
    .hint-msg {
        font-size: 25px;
        line-height: 70px;
        margin-bottom: 15px;
    }
</style>
@stop
@section('js')
@if($cart)
<script>
    goSell.showResult();
</script>
@endif
@stop 