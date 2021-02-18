@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<!--  my orders section  -->
<section class="my_orders">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="portlet yellow">
                    <div class="portlet-title">
                        <i class="fa fa-cogs"></i> تفاصيل الطلب
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-5 name"> رقم الطلب</div>
                            <div class="col-md-7 value"> {{$order->id}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 name"> وقت وتاريخ الطلب: </div>
                            <div class="col-md-7 value"> {{$order->created_at}} GMT</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 name"> حالة الطلب: </div>
                            <div class="col-md-7 value">{{$order->mystatus->name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 name"> المبلغ المطلوب: </div>
                            <div class="col-md-7 value"> {{$order->total}} ريال</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="portlet red">
                    <div class="portlet-title">
                        <i class="fa fa-cogs"></i> تفاصيل الشحن
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-5 name"> الاسم</div>
                            <div class="col-md-7 value"> {{$order->name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 name"> الهاتف: </div>
                            <div class="col-md-7 value"> {{$order->telephone}} </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 name"> العنوان: </div>
                            <div class="col-md-7 value">{{$order->neighborhood.' '.$order->street.' '.$order->building}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 name"> الملاحظات: </div>
                            <div class="col-md-7 value"> {{$order->notes}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet grey">
                    <div class="portlet-title">
                        <i class="fa fa-cogs"></i> منتجات الطلبية
                    </div>
                    <div class="portlet-body">
                        <table class="table ">
                            <thead>
                            <th>#</th>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            </thead>
                            <tbody
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><?php
                                        $product = get_product($item->name);
                                        echo $product->name_ar;
                                        ?></td>
                                    <td><?= $item->quantity ?></td>
                                    <td><?= $item->total ?> ريال</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<!--  end of my orders section  -->

<style>
    .portlet {
        border: 1px solid;
        margin: 15px 0;

    }
    .portlet-title {
        padding: 10px;
        color: #fff;
    }
    .portlet-body {
        padding: 10px;
    }
    .yellow{ border-color: #f3c200;}
    .yellow  .portlet-title{ background-color: #f3c200;}

    .red{ border-color: #E26A6A;}
    .red  .portlet-title{ background-color: #E26A6A;}

    .grey{ border-color: #95A5A6;}
    .grey  .portlet-title{ background-color: #95A5A6;}
    .value {
        font-size: 14px;
        font-weight: 600;
    }
    .name {
        font-size: 14px;
    }
</style>
@endsection
