@extends('admin.layout.master')

@section('title')
تفاصيل الطلب
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
        <a href="{{ route('orders.view') }}">ادارة الطلبات</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $order->name }}</strong>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('orders.edit',['id' => Crypt::encrypt($order->id)]) }}">عرض التفاصيل</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> ادارة الطلبات
    <small>عرض طلب</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>عرض طلب </div>
    </div>
    <div class="portlet-body form" style="overflow: hidden;">
        @include('admin.layout.error')
        <br>
        <div class="col-md-6 col-sm-12">
            <div class="portlet yellow-crusta box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>تفاصيل الطلب </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-5 name"> رقم الطلب: </div>
                        <div class="col-md-7 value"> {{$order->id}}
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> تاريخ وقت الطلب: </div>
                        <div class="col-md-7 value"> {{$order->created_at}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> حالة الطلب: </div>
                        <div class="col-md-7 value">
                            <span class="label label-success"> {{$order->mystatus->name}} </span>
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> المبلغ الكلي: </div>
                        <div class="col-md-7 value"> {{$order->total}} ريال </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>بيانات الزبون </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-5 name"> الاسم: </div>
                        <div class="col-md-7 value"> {{$order->name}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> البريد الالكتروني: </div>
                        <div class="col-md-7 value"> {{$order->email}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> الهاتف: </div>
                        <div class="col-md-7 value"> {{$order->telephone}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> ملاحظات: </div>
                        <div class="col-md-7 value"> {{$order->notes}} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="portlet green-meadow box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>عنوان الشحن </div>
                </div>
                <div class="portlet-body">

                    <div class="row static-info">
                        <div class="col-md-5 name"> الحي: </div>
                        <div class="col-md-7 value"> {{$order->neighborhood}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> الشارع: </div>
                        <div class="col-md-7 value"> {{$order->street}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> المنزل: </div>
                        <div class="col-md-7 value"> {{$order->building}} </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="portlet grey-cascade box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>منتجات الطلبية </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>المنتج</th>
                            <th>التفاصيل</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>المجموع</th>

                            </thead>
                            <tbody
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><?php
                                        $product = get_product($item->name);
                                        if ($product)
                                            echo $product->name_ar;
                                        else
                                            echo 'تم حذف المنتج';
                                        ?>
                                    </td>
                                    <td>
                                        @if($item->meter_width>0)
                                        <b>الطول</b>:<?= $item->meter_width ?> متر<br>
                                        <b>العرض</b>:<?= $item->meter_height ?> متر<br>
                                        @endif

                                        <?php $item_specs = json_decode($item->spec) ?>
                                        @if($item_specs)
                                        @foreach($item_specs as $key=>$value)
                                        <?php $specs = get_specs($key, $value) ?>
                                        <?php if ($specs) { ?>
                                            <b><?= $specs->catspectype->name ?></b>:<?= $specs->name ?><br>
                                        <?php } ?>
                                        @endforeach
                                        @endif
                                        <b>تفاصيل التصميم</b>:<?= $item->design_data ?><br>
                                    </td>
                                    <td><?= round($item->price / $item->quantity, 1) ?> ريال</td>
                                    <td><?= $item->quantity ?></td>
                                    <td><?= $item->price ?> ريال</td>
                                </tr>
                                @endforeach
                                <?php if ($order->pay_value != 0) { ?>
                                    <tr style=" border-bottom: 1px solid #ddd;">
                                        <td colspan="3" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">رسوم الدفع عند الاستلام</td>
                                        <td style=" text-align: center;color:#cc3399;" colspan="3"><?= $order->pay_value ?> ريال</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($order->discount != 0) { ?>
                                    <tr style=" border-bottom: 1px solid #ddd;">
                                        <td colspan="3" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">خصم</td>
                                        <td style=" text-align: center;color:#cc3399;" colspan="3"><?= $order->discount ?> ريال</td>
                                    </tr>
                                <?php } ?>
                                <?php if ($order->tax != 0) { ?>
                                    <tr style=" border-bottom: 1px solid #ddd;">
                                        <td colspan="3" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">الضريبة</td>
                                        <td style=" text-align: center;color:#cc3399;" colspan="3"><?= $order->tax ?> ريال</td>
                                    </tr>
                                <?php } ?>
                                <tr style=" border-bottom: 1px solid #ddd;">
                                    <td colspan="3" style="background-color: #fff;color: #4d4b3f;line-height: 36px;text-indent: 15px;">المجموع الكلي</td>
                                    <td style=" text-align: center;color:#cc3399;"  colspan="3"><?= $order->total ?> ريال</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($order->ratings)
        <div class="col-md-6 col-sm-12">
            <div class="portlet green-meadow box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>تقييم الطلب </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-5 name"> التقييم</div>
                        <div class="col-md-7 value"> <?PHP
                            if ($order->ratings == 1) {
                                echo 'نجمة';
                            } elseif ($order->ratings == 2) {
                                echo 'نجمتين';
                            } else {
                                echo $order->ratings . ' ' . 'نجوم';
                            }
                            ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 name"> ملاحظة التقيم: </div>
                        <div class="col-md-7 value"> {{ $order->rate_note }} </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <form role="form" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="row">                 
                        <div class="form-group">
                            <label class="control-label col-md-2">حالة الطلب</label>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    @foreach($statuss as $status)
                                    <option value="{{$status->id}}" {{ $order->status==$status->id?'selected':'' }}>{{ $status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-md-2">حالة الدفع</label>
                            <div class="col-md-3">
                                <select name="is_paid" class="form-control">
                                    <option value="0" {{ $order->is_paid==0?'selected':'' }}>غير مدفوع</option>
                                    <option value="1" {{ $order->is_paid==1?'selected':'' }}>مدفوع</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">ملاحظات</label>
                            <div class="col-md-8">
                                <textarea name="notes_admin" id="notes_admin" class="form-control" rows="3">{{ $order->notes_admin }}</textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="col-md-offset-3 col-md-6">
                        <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                        <a href="{{ route('orders.view') }}" type="button" class="btn default">إلغاء</a>
                        {{ csrf_field() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
