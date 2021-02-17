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
                    <h3>نسيت كلمة المرور؟</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="resestered-customers customer">
                    <form class="form-horizontal product-form" method="post">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>نسيت كلمة المرور الخاصة بك؟<i class="fa fa-file-text"></i></h2>
                            </div>
                            <div class="user-content">
                                <p>اذا كانت نسيت كلمة المرور فادخل البريد الالكتروني الخاص بك.</p>
                            </div>
                            <div class="account-form">
                                <div class="form-goroup">
                                    <label>البريد الالكتروني<sup>*</sup></label>
                                    <input type="text" name="email" required="required" class="form-control">
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