@extends('admin.layout.master')

@section('title')
تعديل الكتب
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
        <a href="{{ route('books.view') }}">إدارة الكتب</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('books.add') }}">إضافة كتاب جديد</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> الكتب
    <small>إضافة الكتب</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>تعديل كتاب جديد </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">العنوان</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('title') }}" name="title" id="title" class="form-control" placeholder="العنوان">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">المؤلف</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('author')  }}" name="author" id="author" class="form-control" placeholder="المؤلف">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الملف</label>
                        <div class="col-md-5">
                            <input id="book" value="{{  old('filename') }}" class="form-control" type="text" name="filename" readonly>
                        </div>
                        <div class="col-md-1">
                            <a id="lfm_file" data-input="book" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-file-o"></i> حدد الملف
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">صورة</label>
                        <div class="col-md-5">
                            <input id="thumbnail" value="{{  old('image_download') }}" class="form-control" type="text" name="image_download" readonly>
                        </div>
                        <div class="col-md-1">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> حدد صورة
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">نبذة</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="description" placeholder="نبذة" name="description">{!! old('description')  !!}</textarea> 
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
                    <a href="{{ route('books.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    #book,#thumbnail {
        direction: ltr;
    }
</style>
@stop

@section('js')
<script src="vendor/laravel-filemanager/js/lfm.js"></script>
<script src="{{asset('assets/admin/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script type="text/javascript">
CKEDITOR.replace('description');
var domain = "{{ asset('/admin').'/file_manager' }}";
$('#lfm').filemanager('image', {prefix: domain});
$('#lfm_file').filemanager('file', {prefix: domain});
</script>
@stop

@section('modals')

@stop
