@extends('admin.layout.master')

@section('title')
تعديل قسم
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
        <a href="{{ route('categories.view') }}">إدارة الأقسام</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('categories.add') }}">إضافة قسم جديد</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> الأقسام
    <small>إضافة قسم</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>تعديل قسم جديد </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">الإسم</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('name') }}" name="name" id="name" class="form-control" placeholder="الإسم">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-md-3">الترتيب</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('sort') }}" name="sort" id="sort" class="form-control" placeholder="الترتيب">
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="control-label col-md-3">اللون</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('color') }}" name="color" id="color" class="form-control" placeholder="اللون">
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
                    <a href="{{ route('categories.view') }}" type="button" class="btn default">إلغاء</a>
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
