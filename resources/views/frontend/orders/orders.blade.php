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
            <div class="col-md-12">
                <table class="col-md-12" dir="rtl">
                    <thead>
                    <th>رقم الطلب</th>
                    <th>التاريخ والوقت</th>
                    <th>المجموع</th>
                    <th>الحالة</th>
                    <th>عرض</th>
                    </thead>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>
                            تم الانشاء في  {{$order->created_at}} GMT
                            <?= empty($order->cancel_date) ? '' : '<div>تاريخ الغاء الطلب ' . $order->cancel_date . ' GMT' . '</div>' ?>
                            <?= empty($order->done_date) ? '' : '<div>تاريخ التنفيذ ' . $order->done_date . ' GMT' . '</div>' ?>
                            <?= empty($order->received_date) ? '' : '<div>تاريخ الاستلام ' . $order->received_date . ' GMT' . '</div>' ?>
                            <?= empty($order->delivery_date) ? '' : '<div>تاريخ التوصيل ' . $order->delivery_date . ' GMT' . '</div>' ?>
                        </td>
                        <td>{{ $order->total }} ريال</td>
                        <td>{{ $order->mystatus->name }}</td>
                        <td>
                            <a href="orders/{{$order->id}}" class="btn btn-info" style="margin: 10px 0;"><i class="fa fa-search"></i> عرض التفاصيل</a>
                            <a href="orders/invoice/{{$order->id}}" class="btn btn-info" style="margin: 10px 0;" target="_blank"><i class="fa fa-address-book"></i> عرض الفاتورة</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>



        </div>
    </div>
</div>
</section>
<style>
    .table td{ text-align: center}
    .table th{ text-align: center}
</style>
<!--  end of my orders section  -->
@endsection