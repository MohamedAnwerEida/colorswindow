@extends('admin.layout.master')

@section('title')
Add User
@stop

@section('css')

@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('users.view') }}">إدارة المستخدمين</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('users.add') }}">إضافة مستخدم جديد</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> المستخدمين
    <small>إضافة مستخدم</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-user-follow"></i> إضافة مستخدم جديد </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" id="" action="" class="form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">الإسم<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('username') }}" name="username" id="username" class="form-control" placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الإسم الكامل<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control" placeholder="الإسم الكامل">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">نوع الحساب</label>
                        <div class="col-md-6">
                            <select name="user_type" id="user_type" class="form-control">
                                @foreach($user_type as $key=>$value)
                                <option value="{{ $key }}" {{ old('user_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">البريد الإلكتروني<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('email') }}" name="email" id="email" class="form-control" placeholder="البريد الإلكتروني">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">رقم الموبايل </label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('mobile') }}" name="mobile" id="name" class="form-control" placeholder="رقم الموبايل">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">إدارة الصلاحيات<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <select value="" name="role" id="role" class="form-control bs-select">
                                @foreach($roles as $item)
                                <option value="{{ $item->id }}" {{ old('role') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">كلمة المرور<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تأكيد كلمة المرور<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="تأكيد كلمة المرور">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الحالة</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="status" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ old('status') == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                    <a href="{{ route('users.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')

@stop

@section('modals')

@stop
