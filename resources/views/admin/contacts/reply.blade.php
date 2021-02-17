@extends('admin.layout.master')

@section('title')
عرض الرسالة
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
        <a href="{{ route('contacts.view') }}">إدارة اتصل بنا</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <strong> {{ $info->name }}</strong>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('contacts.reply',['id' => Crypt::encrypt($info->id)]) }}">عرض الرسالة</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> إدارة اتصل بنا
    <small></small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>عرض الرسالة </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">الاسم</label>
                        <div class="col-md-6">
                            <label class="control-label">{{ $info->name }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">البريد الالكتروني</label>
                        <div class="col-md-6">
                            <label class="control-label">{{ $info->email }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الرسالة</label>
                        <div class="col-md-6">
                            <label class="control-label">{{ $info->details }}</label>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <a href="{{ route('contacts.view') }}" type="button" class="btn default">عودة</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')

@stop