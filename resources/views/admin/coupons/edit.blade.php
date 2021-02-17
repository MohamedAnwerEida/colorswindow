@extends('admin.layout.master')

@section('title')
تعديل كوبون الخصم
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
        <a href="{{ route('coupons.view') }}">إدارة كوبون الخصم</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $info->name }}</strong>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('coupons.edit',['id' => Crypt::encrypt($info->id)]) }}">تعديل كوبون الخصم</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> إدارة كوبون الخصم
    <small>تعديل كوبون الخصم</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>تعديل كوبون الخصم </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" id="" action="" class="form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">كود الخصم<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" value="{{ $info->code}}" name="code" id="code" class="form-control" placeholder="كود الخصم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">نوع الكود <span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-9">
                            <div class="mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio" name="type" id="optionsRadios25" value="fixed" checked=""> ثابت
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio" name="type" id="optionsRadios26" value="percent" {{ $info->type == 'percent' ? 'checked' : '' }}> نسبة
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">قيمة الخصم (رقم صحيح)<span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-6">
                            <input type="text" name="value" id="value" value="{{ $info->value }}" class="form-control" placeholder="قيمة الخصم">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ البدء <span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-4">
                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" readonly name="start_date" value="{{ $info->start_date }}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ الانتهاء <span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-4">
                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" readonly name="end_date" value="{{ $info->end_date }}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">النوع</label>
                        <div class="col-md-6">
                            <select name="cat_type" id="cat_type" class="form-control">
                                <option value="0" {{ $info->cat_type == 0 ? 'selected' : '' }}>بدون</option>
                                <?php $types = array(1 => 'قسم', 2 => 'منتج'); ?>
                                @foreach($types as $key=>$item)
                                <option value="{{ $key }}" {{ $info->cat_type == $key ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">المحتوي</label>
                        <div class="col-md-6">
                            <select name="item_id" id="item_id" class="form-control">

                            </select>
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
                    <a href="{{ route('coupons.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script src="{{asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$('.date-picker').datepicker();
$("#cat_type").change(function () {
    var cat_type = $(this).val();
    var cat_item = <?= property_exists('item_id', $info) ? $info->item_id : 0 ?>;
    var token = '{{csrf_token()}}';
    $.ajax({
        url: "<?php echo route('select-ajax') ?>",
        method: 'POST',
        data: {cat_type: cat_type, cat_item: cat_item, _token: token},
        success: function (data) {
            $("#item_id").html('');
            $("#item_id").html(data.options);
        }
    });
});
$("#cat_type").trigger('change');
</script>
@stop