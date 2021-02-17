@extends('admin.layout.master')

@section('title')
الصفحة الرئيسية - الملف الشخصي
@stop

@section('page-title')
<h3 class="page-title"> الصفحة الرئيسية
    <small>الملف الشخصي</small>
</h3>
@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{ route('dashboard.view') }}"> الصفحة الرئيسية</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('dashboard.profile') }}"> الملف الشخصي</a>
    </li>
</ul>
@stop

@section('page-content')

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    @if($info->avatar && $info->avatar!='')
                    <img src="{{ url($info->avatar) }}" class="img-responsive" alt=""> 
                    @else
                    <img src="{{ url('assets/admin/layouts/layout2/img/profile_user.jpg') }}" class="img-responsive" alt=""> 
                    @endif
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $info->name }} </div>
                    <div class="profile-usertitle-job"> {{ $info->myrole->name }} </div>
                </div>
                <br>
                <br>
                <!-- END SIDEBAR USER TITLE -->
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">الملف الشخصي</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">الملف الشخصي</a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab">تغير الصورة الشخصية</a>
                                </li>
                                <li>
                                    <a href="#tab_1_3" data-toggle="tab"> تغيير كلمة المرور </a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                @include('admin.layout.error')
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <form role="form" action="#">
                                        <div class="form-group">
                                            <label class="control-label">إسم المستخدم</label>
                                            <input type="text" value="{{ $info->username }}" class="form-control" readonly="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">الإسم الكامل</label>
                                            <input type="text" value="{{ $info->name }}" class="form-control" readonly="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">البريد الالكتروني</label>
                                            <input type="text" value="{{ $info->email }}" class="form-control" readonly="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">رقم الموبايل</label>
                                            <input type="text" value="{{ $info->mobile }}" class="form-control" readonly="" />
                                        </div>
                                    </form>
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <form method="post" action="{{ route('users.avatar') }}" role="form"  enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    @if($info->avatar && $info->avatar!='')
                                                    <img src="{{ url($info->avatar) }}" alt=""> 
                                                    @else
                                                    <img src="{{ url('assets/admin/layouts/layout2/img/profile_user.jpg') }}" alt=""> 
                                                    @endif
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                <div>
                                                    <span class="btn default btn-file">
                                                        <span class="fileinput-new"> أختر الصورة </span>
                                                        <span class="fileinput-exists">تغير</span>
                                                        <input type="file" name="image"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">حذف</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="margin-top-10">
                                            <button type="submit" class="btn green">تغير الصورة</button>
                                        </div>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->
                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_3">
                                    <form method="post" action="{{ route('dashboard.password') }}" >
                                        <div class="form-group">
                                            <label class="control-label">كلمة المرور القديمة</label>
                                            <input  name="old_password" value="" type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">كلمة المرور الجديدة</label>
                                            <input  name="password" value="" type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">اعادة كلمة المرور الجديدة</label>
                                            <input  name="password_confirmation" value="" type="password" class="form-control">
                                        </div>
                                        <div class="margin-top-10">
                                            <button type="submit" class="btn green">تغير كلمة المرور</button>
                                        </div>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
@stop
@section('css')
<link href="{{ url('assets/admin/pages/css/profile-rtl.min.css') }}" rel="stylesheet" type="text/css"/>
@stop