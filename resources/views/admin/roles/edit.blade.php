@extends('admin.layout.master')

@section('title')
تعديل صلاحية
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
        <a href="{{ route('roles.view') }}">إدارة الصلاحيات</a>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <strong> {{ $info->name }}</strong>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <a href="{{ route('roles.edit',['id' => Crypt::encrypt($info->id)]) }}">تعديل صلاحية</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> إدارة الصلاحيات
    <small></small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-direction"></i>تعديل صلاحية </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" action="" class="form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">إسم المجموعة</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->name }}" name="name" id="name" class="form-control" placeholder="Role">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">ترتيب المجموعة</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->role_order }}" name="role_order" id="name" class="form-control" placeholder="ترتيب المجموعة">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">ايقونة المجموعة</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->role_icon }}" name="role_icon" id="role_icon" class="form-control" placeholder="ايقونة المجموعة">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">لون المجموعة</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->role_color }}" name="role_color" id="role_color" class="form-control" placeholder="لون المجموعة">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">يظهر في المهام</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="tasks_status" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->tasks_status == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">حالة القسم في المهام</label>
                        <div class="col-md-6">
                            <select name="status_id" class="form-control" id="status_id">
                                @foreach($order_staus as $item)
                                <option value="{{ $item->id }}" {{ $info->status_id == $item->id ? 'selected' : '' }}> {{ $item->name1 }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تظهر اشعارات المخزن</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="status_stock" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->status_stock == 1 ? 'checked' : '' }}>
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
                    <a href="{{ route('roles.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop