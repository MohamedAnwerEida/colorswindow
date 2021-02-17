@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<center>                        
    @include('frontend.layouts.error')
</center>
<div class="my-account-area" dir="rtl">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-title">
                    <h3>استعادة كلمة المرور</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="resestered-customers customer">
                    <form class="form-horizontal product-form" method="post">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>استعادة كلمة المرور<i class="fa fa-file-text"></i></h2>
                            </div>
                            <div class="account-form">
                                <div class="form-goroup">
                                    <label>كلمة المرور الجديدة<sup>*</sup></label>
                                    <input name="password" id="password" class="form-control" type="password" required="required" />
                                </div>
                            </div>
                            <div class="account-form">
                                <div class="form-goroup">
                                    <label>تأكيد كلمة المرور الجديدة<sup>*</sup></label>
                                    <input name="password_confirmation" id="password" class="form-control" type="password" required="required" />
                                </div>
                            </div>
                            <p class="reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                        </div>
                        <div class="user-bottom fix">
                            <div class="user-bottom-inner">
                                <a class="pull-left" href="{{ route('frontend.login.view') }}">العودة لتسجيل الدخول</a>
                                <button name="login" class="btn custom-button" type="submit">ارسال</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-6"></div>

        </div>
    </div>
</div>
@stop
@section('css')
<style>
    sup{color: red !important}
</style>
@stop
@section('js')
@stop