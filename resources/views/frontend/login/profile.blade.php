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
                    <h3>الملف الشخصي</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="new-customers customer">
                    <form class="form-horizontal product-form" method="post" action="{{ url('profile')}}">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>تعديل الملف الشخصي<i class="fa fa-file"></i></h2>
                            </div>
                            <div class="account-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                        <div class="form-goroup">
                                            <label>الاسم كاملا<sup>*</sup></label>
                                            <input type="text" name="name" required="required" value="{{ $user->name }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>رقم الجوال<sup>*</sup>( 10 ارقام)</label>
                                            <input type="text" name="phone" required="required" pattern="\d{10}" value="{{ $user->phone }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>تاريخ الميلاد<sup>*</sup></label>
                                            <input required="required" name="dob" type="text" class="form-control datepicker" value="{{ $user->dob }}" >

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>الجنس</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="sex" id="sex" value="male" <?= $user->sex == 'male' ? 'checked' : '' ?>> ذكر
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="sex" id="sex" value="female" <?= $user->sex == 'female' ? 'checked' : '' ?>> انثى
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                        </div>
                        <div class="user-bottom fix">
                            <div class="user-bottom-inner">
                                <button name="create" class="btn custom-button" type="submit">تعديل الملف الشخصي</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="new-customers customer">
                    <form class="form-horizontal product-form" method="post" action="{{ url('shopping')}}">
                        <div class="customer-inner">
                            <div class="user-title">
                                <h2>تعديل بيانات الشحن<i class="fa fa-file"></i></h2>
                            </div>
                            <div class="account-form">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                        <div class="form-goroup">
                                            <label>الحي<sup>*</sup></label>
                                            <input type="text" name="neighborhood" required="required" value="{{ $user->neighborhood }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>الشارع<sup>*</sup></label>
                                            <input type="text" name="street" required="required" value="{{ $user->street }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>رقم العمارة<sup>*</sup></label>
                                            <input type="text" name="building" required="required" value="{{ $user->building }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-goroup">
                                            <label>ملاحظات<sup>*</sup></label>
                                            <input type="text" name="notes" required="required" value="{{ $user->notes }}"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="reauired-fields floatright"><sup>*</sup> حقول مطلوبه</p>
                        </div>
                        <div class="user-bottom fix">
                            <div class="user-bottom-inner">
                                <button name="create" class="btn custom-button" type="submit">تعديل بيانات الشحن</button>
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