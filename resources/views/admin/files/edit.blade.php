@extends('admin.layout.master')

@section('title')
تعديل منتج
@stop

@section('css')
    <link rel="stylesheet" href="{{url('custom/select2/css/select2.min.css')}}" />
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
        <a href="{{ route('files.edit',['id' => Crypt::encrypt($info->id)]) }}">تعديل منتج</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $info->name_ar }}</strong>
    </li>

</ul>
@stop

@section('page-title')
<h1 class="page-title"> المنتجات
    <small>تعديل منتج</small>
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
        <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">الاسم</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->name_ar }}" name="name_ar" id="name_ar" class="form-control" placeholder="الاسم">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">الوصف</label>
                        <div class="col-md-6">
                            <textarea id="text_ar"  name="text_ar" class="form-control">{!! $info->text_ar !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الأقسام</label>
                        <div class="col-md-6">
                            <select name="cat" class="form-control" id="cat">
                                @foreach($categories as $item)
                                <option value="{{ $item->id }}" {{ $info->cat == $item->id ? 'selected' : '' }}> {{ $item->name_ar }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">القسم الفرعي</label>
                        <div class="col-md-6">
                            <select name="scat" class="form-control" id="cat">
                                @foreach($subcategories as $item)
                                <option value="{{ $item->id }}" {{ $info->scat == $item->id ? 'selected' : '' }}> {{ $item->name_ar }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="image" class="form-group">
                        <label class="control-label col-md-3">صورة</label>
                        <div class="col-md-5">
                            <input id="thumbnail" value="{{ $info->image }}" class="form-control" type="text" name="image" readonly>
                            <img id="holder" src="{{ asset($info->image) }}" style="margin-top:15px;max-height:100px;">
                        </div>
                        <div class="col-md-1">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> حدد صورة
                            </a>
                        </div>
                    </div>
                    <div id="imageContainer">
                        <?php $extra_images = \GuzzleHttp\json_decode($info->extra_images) ?>
                        @foreach($extra_images as $image)
                        <div class="row imageTemplate">
                            <label class="control-label col-md-3">Image</label>
                            <div class="col-md-4">
                                <input id="thumbnail{{ $loop->iteration }}" value="{{ $image }}" class="form-control clear" type="text" name="product_images[]">
                                <img id="holder{{ $loop->iteration }}" src="{{ url($image) }}" style="margin-top:15px; max-height:100px;">
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <button id="lfm{{ $loop->iteration }}" data-input="thumbnail{{ $loop->iteration }}" data-preview="holder{{ $loop->iteration }}" type="button" class="btn blue">
                                        <i class="icon-picture"></i> Select</button>
                                    <button type="button" class="btn green addProductImage">
                                        <i class="icon-puzzle"></i> Add</button>
                                    <button type="button" class="btn red removeProductImage">
                                        <i class="icon-trash" style="width: 12px;"></i> Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="row imageTemplate">
                            <label class="control-label col-md-3">Image</label>
                            <div class="col-md-4">
                                <input id="thumbnail0" class="form-control clear" type="text" name="product_images[]">
                                <img id="holder0" style="margin-top:15px;max-height:100px;">
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group">
                                    <button id="lfm0" data-input="thumbnail0" data-preview="holder0" type="button" class="btn blue">
                                        <i class="icon-picture"></i> Select</button>
                                    <button type="button" class="btn green addProductImage">
                                        <i class="icon-puzzle"></i> Add</button>
                                    <button type="button" class="btn red removeProductImage">
                                        <i class="icon-trash" style="width: 12px;"></i> Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">السعر</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->price }}" name="price" id="price" class="form-control" placeholder="السعر">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">السعر القديم</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->old_price }}" name="old_price" id="old_price" class="form-control" placeholder="السعر القديم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الحد الادني للكمية</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->min_qty }}" name="min_qty" id="min_qty" class="form-control" placeholder="الحد الادني للكمية">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الكلمات المفتاحية</label>
                        <div class="col-md-6">
                            <select name="keyword[]" class="js-multiple js-states form-control" id="id_label_multiple" multiple="multiple" >
                                @foreach($info->keyword as $keyword)
                                    <option selected>{{$keyword->keyword}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الحالة</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="active" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->active == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">مميز</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="featured" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->featured == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">صفقة اليوم</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="dealofdays" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->dealofdays == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">يظهر في القائمة</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="main" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->main == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">عرض</label>
                        <div class="col-md-6">
                            <input type="checkbox" value="1" name="offer" class="make-switch" data-on-text="&nbsp;تفعيل&nbsp;" data-off-text="&nbsp;تعطيل&nbsp;" {{ $info->offer == 1 ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                    <a href="{{ route('files.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script src='<?= asset("vendor/laravel-filemanager/js/stand-alone-button.js") ?>'></script>
<script src='<?= asset("assets/admin/ckeditor/ckeditor.js") ?>'></script>
<script src="{{asset('custom/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script>
    $(".js-multiple").select2({
        tags: true
    });
CKEDITOR.replace('text_ar');
</script>
<script type="text/javascript">
    $('#lfm').filemanager('image');
    $('#lfm0').filemanager('image');

    var stdHtml = $("#imageContainer").children(".imageTemplate").first().clone('.addProductImage');
    stdHtml.find("[id^=thumbnail]").attr("id", "thumbnail");
    stdHtml.find("#thumbnail").removeAttr("value");
    stdHtml.find("[id^=holder]").attr("id", "holder");
    stdHtml.find("#holder").removeAttr("src");
    stdHtml.find("[id^=lfm]").attr("data-input", "thumbnail");
    stdHtml.find("[id^=lfm]").attr("data-preview", "holder");
    stdHtml.find("[id^=lfm]").attr("id", "lfm");
    var counter = "{{ count($info->images) }}";
<?php foreach ($extra_images as $k => $row): ?>
        $('#lfm{{ $k+1 }}').filemanager('image');
<?php endforeach; ?>
    $(document).on('click', '.addProductImage', function () {
        append_image_controller();
    });
    function append_image_controller() {
        counter++;
        var objHtml = stdHtml.clone('.addProductImage');
        objHtml.find("#thumbnail").attr("id", "thumbnail" + counter);
        objHtml.find("#holder").attr("id", "holder" + counter);
        objHtml.find("#lfm").attr("data-input", "thumbnail" + counter);
        objHtml.find("#lfm").attr("data-preview", "holder" + counter);
        objHtml.find("#lfm").attr("id", "lfm" + counter);
        $("#imageContainer").append(objHtml);
        $('#lfm' + counter).filemanager('image');
    }
    /////////////////////////////////////////////
    $(document).on("click", ".removeProductImage", function () {
        if ($('#imageContainer .imageTemplate').length > 1)
        {
            $(this).closest(".imageTemplate").remove();
        } else
        {
            toastr.warning("Error, Can't delete last row");
        }
    });
</script>
@stop
