@extends('admin.layout.master')

@section('title')
الإعدادات
@stop

@section('css')

@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('settings.view') }}">إعدادات الموقع</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title">الإعدادات
    <small>إعدادات الموقع</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-key"></i>إعدادات الموقع </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form method="post" action="" role="form" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">الإسم</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->title }}" name="title" id="title" class="form-control" placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الوصف</label>
                        <div class="col-md-6">
                            <textarea name="description" id="description" class="form-control" rows="6" style="resize: none">{{ $info->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تعريف اضافي</label>
                        <div class="col-md-6">
                            <textarea name="more_desc" id="more_desc" class="form-control" rows="6" style="resize: none">{{ $info->more_desc }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الكلمات الدلالية</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->tags }}" name="tags" id="tags" class="form-control input-large" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">قيمة الضريبة %</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->tax }}" name="tax" id="tax" class="form-control" placeholder="tax">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">رسوم الدفع عند الاستلام بريال</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->transfer }}" name="transfer" id="transfer" class="form-control" placeholder="transfer">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">هاتف المعرض</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->contact_no }}" name="contact_phone" style="direction: ltr;" id="contact_phone" class="form-control" placeholder="هاتف المعرض">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">بريد التواصل</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->contact_email }}" name="contact_email" id="contact_email" class="form-control" placeholder="بريد التواصل">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الصورة</label>
                        <div class="col-md-6">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="uploads/logos/{{ $info->logo }}" alt="" /> </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> إختيار صورة </span>
                                        <span class="fileinput-exists"> تغيير </span>
                                        <input type="file" name="logo"> </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> إزالة </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
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
