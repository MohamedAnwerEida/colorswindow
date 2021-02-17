@extends('admin.layout.master')

@section('title')
تعديل خبر
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
        <a href="{{ route('news.view') }}">إدارة الأخبار</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <strong> {{ $info->title }}</strong>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('news.edit',['id' => Crypt::encrypt($info->id)]) }}">تعديل خبر</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> الأخبار
    <small>تعديل خبر</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-book-open"></i>تعديل خبر </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">العنوان</label>
                        <div class="col-md-6">
                            <textarea name="title" class="form-control">{!! $info->title !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">الكاتب</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->onwer }}" name="onwer" id="onwer" class="form-control" placeholder="الكاتب">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">مصدر الخبر</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->source }}" name="source" id="source" class="form-control" placeholder="مصدر الخبر">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">مقدمة</label>
                        <div class="col-md-6">
                            <textarea name="sub"  maxlength="130" id="sub" class="form-control" rows="3">{{ $info->sub }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">التفاصيل</label>
                        <div class="col-md-6">
                            <textarea name="descs" id="descs" class="form-control" rows="3">{!! $info->descs !!}</textarea>
                        </div>
                    </div>
                    <div id="image" class="form-group">
                        <label class="control-label col-md-3">صورة</label>
                        <div class="col-md-5">
                            <input id="thumbnail" value="{{ $info->image }}" class="form-control" type="text" name="image" readonly>
                            <img id="holder" src="{{ asset($info->thumb) }}" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="col-md-1">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> حدد صورة
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الكتابة على الصورة</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->img_notes }}" name="img_notes" id="img_notes" class="form-control" placeholder="الكتابة على الصورة">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">كلمات مفتاحية</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->tags }}" name="tags" id="tags" class="form-control input-large" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ النشر</label>
                        <div class="col-md-6">
                            <input type="text" name="pub_date" id="pub_date" value="{{ $info->pub_date }}" class="form-control rtl" placeholder="تاريخ النشر">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الترتيب</label>
                        <div class="col-md-6">
                            <select name="resort" id="resort" class="form-control">
                                @for($i = 1; $i < 11; $i++)
                                <option value="{{ $i }}"  @if($info->resort == $i ) selected="selected" @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    @can('admin.news.publish')
                    <div class="form-group">
                        <label class="control-label col-md-3">نشر</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="publish" class="make-switch" data-on-text="&nbsp;نعم&nbsp;" data-off-text="&nbsp;لا&nbsp;" {{ $info->publish == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    @endcan
                    <div class="form-group">
                        <label class="control-label col-md-3">مثبت</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="sidebar" class="make-switch" data-on-text="&nbsp;نعم&nbsp;" data-off-text="&nbsp;لا&nbsp;" {{ $info->sidebar == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                    <a href="{{ route('news.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script src='<?= asset("vendor/laravel-filemanager/js/stand-alone-button.js") ?>'></script>
<script src="{{asset('assets/admin/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script type="text/javascript">
CKEDITOR.replace('descs', {
    contentsLangDirection: 'rtl',
    filebrowserUploadUrl: "{{route('news.upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
$('#lfm').filemanager('image');
</script>
@stop