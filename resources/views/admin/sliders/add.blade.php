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
                    <div id="image" class="form-group">
                        <label class="control-label col-md-3">صورة</label>
                        <div class="col-md-5">
                            <input id="thumbnail" value="{{ old('photo') }}" class="form-control" type="text" name="photo" readonly>
                        </div>
                        <div class="col-md-1">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> حدد صورة
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">الرابط</label>
                        <div class="col-md-6">
                            <input type="text" value="{{ old('url') }}" name="url" id="url" class="form-control" placeholder="الرابط">
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
    <script src='<?= asset("vendor/laravel-filemanager/js/stand-alone-button.js") ?>'></script>
    <script src="{{asset('assets/admin/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('custom/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(".js-multiple").select2({
            tags: true
        });
        CKEDITOR.replace('text_ar');
    </script>
    <script type="text/javascript">
        $('#lfm').filemanager('image');
        var stdHtml = $("#imageContainer").children(".imageTemplate").first().clone('.addProductImage');
        $("#imageContainer").html('');
        var counter = 0;
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
        /////////////////////////////////////////////
        append_image_controller();
    </script>
@stop
