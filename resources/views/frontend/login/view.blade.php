@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<style>
    sup{color: red !important}
</style>
<center>                        
    @include('frontend.layouts.error')
</center>
<!-- My Account Area -->
<div class="my-account-area" dir="rtl">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-title">
                    <h3>سجل دخولك أو أنشئ عضوية جديدة</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="new-customers customer">
                    <form class="form-horizontal product-form" method="post" action="{{ route('frontend.signup.view')}}">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>عضوية جديدة<i class="fa fa-file"></i></h2>
                            </div>
                            <div class="account-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                        <div class="form-goroup">
                                            <label>الاسم كاملا<sup>*</sup></label>
                                            <input type="text" name="name" required="required" value="{{ old('name') }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>رقم الجوال<sup>*</sup>( 10 ارقام)</label>
                                            <input type="text" name="phone" required="required" pattern="\d{10}"  value="{{ old('phone') }}"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>البريد الإلكتروني <sup>*</sup></label>
                                            <input type="text" required="required" name="email" value="{{ old('email') }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>الجنس<sup>*</sup></label>
                                            <div>
                                                <label class="radio-inline">
                                                    <input type="radio" name="sex" id="sex" value="male" checked=""> ذكر
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="sex" id="sex" value="female"> انثى
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>تاريخ الميلاد <sup>*</sup></label>
                                            <input required="required" name="dob" type="text" class="form-control datepicker" value="{{ old('dob') }}" >
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                                        <div class="form-goroup">
                                            <label>كلمة السر<sup>*</sup></label>
                                            <input type="password" name="password" required="required"   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>تأكيد كلمة السر<sup>*</sup></label>
                                            <input type="password" name="password_confirmation" required="required"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="checkbox">
                                            <label style="padding-top: 20px">
                                                <input checked type="checkbox" name="checkbox" value="1">
                                                <span style="padding-right: 20px">الموافقة على  <a target="_blank" href="#">الشروط والقوانين</a> </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <p class="reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                        </div>
                        <div class="user-bottom fix">
                            <div class="user-bottom-inner">
                                <button name="create" class="btn custom-button" type="submit">انشأ حسابك فوراً</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="resestered-customers customer">
                    <form class="form-horizontal product-form" method="post">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>تسجيل دخول<i class="fa fa-file-text"></i></h2>
                            </div>
                            <div class="user-content">
                                <p>اذا كان لديك حساب فيرجى تسجيل الدخول.</p>
                            </div>
                            <div class="account-form">
                                <div class="form-goroup">
                                    <label>اسم المستخدم <sup>*</sup></label>
                                    <input type="text" name="email" required="required" class="form-control">
                                </div>
                                <div class="form-goroup">
                                    <label>كلمة السر<sup>*</sup></label>
                                    <input type="password" name="password" required="required" class="form-control">
                                </div>
                            </div>
                            <p class="reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                        </div>
                        <div class="user-bottom fix">
                            <div class="user-bottom-inner">
                                <a class="pull-left" href="{{ route('frontend.login.forgotPassword') }}">نسيت كلمه السر</a>
                                <a style="margin-right: 5px;" href="{{ url('/redirect') }}">
                                    <button name="login" class="btn custom-button" type="button">Login With Google</button>
                                </a>
                                <button name="login" class="btn custom-button" type="submit">دخول</button>
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
    .ui-datepicker-month,.ui-datepicker-year {
        color: #000;
    }
</style>
@stop
@section('js')
<script>
    $(function () {
        $(".datepicker").datepicker({
            "dateFormat": 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+00"
        });
    });
</script>
@stop