@extends('admin.layout.master')

@section('title')
تقرير استخدام الكوبون
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
        <a href="{{ route('coupons.view') }}">تقرير كوبون الخصم</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $info->name }}</strong>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('coupons.uses',['id' => Crypt::encrypt($info->id)]) }}">تقرير كوبون الخصم</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> تقرير كوبون الخصم
    <small>تقرير كوبون الخصم</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>تقرير كوبون الخصم </div>
    </div>
    <div class="portlet-body form">
        @include('admin.layout.error')
        <form role="form" method="post" id="" action="" class="form-horizontal">
            <div class="form-body">
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ البداية <span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-4">
                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" readonly name="coupon_from" value="{{ old('coupon_from')}}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ النهاية <span style="color: #FF6D80"> *</span></label>
                        <div class="col-md-4">
                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" readonly name="coupon_to" value="{{ old('coupon_to')}}">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn default {{ $btn_class }}">بحث</button>
                    <a href="{{ route('coupons.view') }}" type="button" class="btn default">إلغاء</a>
                    {{ csrf_field() }}
                </div>
            </div>
        </form>

    </div>
</div>
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>تقرير كوبون الخصم </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-advance table-hover">
            <thead>
                <tr>
                    <th>
                        <i class="fa fa-briefcase"></i> التاريخ </th>
                    <th><i class="fa fa-question"></i> الفاتورة </th>
                    <th><i class="fa fa-question"></i> قيمة الفاتورة </th>
                    <th><i class="fa fa-question"></i> الخصم </th>
                    <th><i class="fa fa-question"></i> المجموع </th>
                    <th>
                        <i class="fa fa-bookmark"></i> الحالة </th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @foreach($results as $result)
                <tr>
                    <td>
                        <?= $result->created_at ?>
                    </td>
                    <td><?= $result->invoice->invoice_title ?> </td>
                    <td><?= $result->invoice->amount ?> دولار</td>
                    <td><?= $result->invoice->discount ?> دولار</td>
                    <td><?= round($result->invoice->amount - $result->invoice->discount) ?> دولار</td>
                    <td> 
                        <?php if ($result->invoice->is_paid) { ?>
                            <span class="label label-sm label-success label-mini"> Paid </span>
                            <?php $total += round($result->invoice->amount - $result->invoice->discount) ?> 
                        <?php } ?>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td>
                        المجموع الكلي المدفوع
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?= $total ?> دولار</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@stop
@section('js')
<script src="{{asset('assets/admin/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$('.date-picker').datepicker();
</script>
@stop