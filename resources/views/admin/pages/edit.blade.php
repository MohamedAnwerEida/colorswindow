@extends('admin.layout.master')

@section('title')
تعديل صفحة ثابتة
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
        <a href="{{ route('pages.view') }}">إدارة الصفحات الثابتة</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <strong> {{ $info->title }}</strong>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('pages.edit',['id' => Crypt::encrypt($info->id)]) }}">تعديل صفحة ثابتة</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> إدارة الصفحات الثابتة
    <small></small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-layers"></i>تعديل صفحة ثابتة </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">الإسم</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->title }}" name="title" id="title" class="form-control" placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الكلمات الدلالية</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->tags }}" name="tags" id="tags" class="form-control input-large" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">التفاصيل</label>
                        <div class="col-md-6">
                            <textarea name="details" id="details" class="form-control" rows="6" style="resize: none">{{ $info->details }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الصورة</label>
                        <div class="col-md-6">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                    <img src="uploads/image/{{ $info->image }}" alt="" /> </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> إختيار صورة </span>
                                        <span class="fileinput-exists"> تغيير </span>
                                        <input type="file" name="image"> </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> إزالة </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الحالة</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="status" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->status == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                    <a href="{{ route('pages.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script src="{{asset('assets/admin/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script type="text/javascript">
CKEDITOR.replace('details');
</script>
@stop

@section('modals')

@stop
