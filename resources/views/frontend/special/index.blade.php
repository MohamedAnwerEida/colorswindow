@extends('frontend.layouts.master')

@section('title', 'Page Title')
@section('sidebar')
@parent
@stop

@section('content')
<center>                        
    @include('frontend.layouts.error')
</center>
<!-- My Account Area -->
<div class="my-account-area" dir="rtl">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-title">
                    <h3>طلب خاص</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="new-customers customer">
                    <form class="form-horizontal product-form" method="post" action="">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>طلب خاص<i class="fa fa-file"></i></h2>
                            </div>
                            <div class="account-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                        <div class="form-goroup">
                                            <label>تفاصيل الطلب<sup>*</sup></label>
                                            <textarea type="text" name="request" required="required" class="form-control" placeholder="اكتب تفاصيل الطلب الخاص بك"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                        </div>
                        <div class="user-bottom fix">
                            <div class="user-bottom-inner">
                                <button name="create" class="btn custom-button" type="submit">ارسال</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>

</style>
@stop
@section('js')

@stop