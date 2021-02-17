@extends('admin.layout.master')

@section('title')
تعديل منتج
@stop

@section('css')

@stop

@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('files.view') }}">إدارة المنتجات</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('files.edit',['id' => Crypt::encrypt($info->id)]) }}">تعديل مواصفات منتج</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $info->name_ar }}</strong>
    </li>

</ul>
@stop

@section('page-title')
<h1 class="page-title"> المنتجات
    <small>تعديل مواصفات منتج</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>تعديل منتج </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post">
            <div class="form-body">
                @foreach($specs as $spec)
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>الاسم</label>
                            <input type="text" value="{{ $spec->name }}" name="name[]" class="form-control">
                            <input type="hidden" value="{{ $spec->id }}" name="id[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>الخاصية</label>
                            <select name="spec_id[]" class="form-control">
                                @foreach($subcategories as $item)
                                <option value="{{ $item->id }}" {{ $spec->spec_id == $item->id ? 'selected' : '' }}> {{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>السعر</label>
                            <input type="text" value="{{ $spec->price }}" name="price[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>سعر التوصيل</label>
                            <input type="text" value="{{ $spec->price1 }}" name="price1[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>سعر مخصص</label>
                            <input type="text" value="{{ $spec->qty }}" name="qty[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>اخفاء مواصفات</label>
                            <input type="checkbox" value="1" name="view_attr[{{ $spec->id }}]" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $spec->view_attr == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>عرض بالمتر</label>
                            <input type="checkbox" value="1" name="view_meter[{{ $spec->id }}]" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $spec->view_meter == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>لا يتكرر</label>
                            <input type="checkbox" value="1" name="view_repeat[{{ $spec->id }}]" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $spec->view_repeat == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                    <a href="{{ route('subcategories.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .col-md-1 {
        width: 11%;
    }
</style>
@stop
@section('js')
<script type="text/javascript">
    $(document).on('click', '.addProductImage', function () {
//        append_image_controller();
    });
    function append_image_controller() {
//        counter++;
//        var objHtml = stdHtml.clone('.addProductImage');
//        objHtml.find("#thumbnail").attr("id", "thumbnail" + counter);
//        objHtml.find("#holder").attr("id", "holder" + counter);
//        objHtml.find("#lfm").attr("data-input", "thumbnail" + counter);
//        objHtml.find("#lfm").attr("data-preview", "holder" + counter);
//        objHtml.find("#lfm").attr("id", "lfm" + counter);
//        $("#imageContainer").append(objHtml);
//        $('#lfm' + counter).filemanager('image', {prefix: domain});
    }
    /////////////////////////////////////////////
    $(document).on("click", ".removeProductImage", function () {
//        if ($('#imageContainer .imageTemplate').length > 1)
//        {
//            $(this).closest(".imageTemplate").remove();
//        } else
//        {
//            toastr.warning("Error, Can't delete last row");
//        }
    });
</script>
@stop