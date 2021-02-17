@extends('admin.layout.master')

@section('title')
تفاصيل العميل
@stop
@section('page-breadcrumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard.view') }}">الرئيسية</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('customers.view') }}">ادارة العملاء</a>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <strong> {{ $customer->name }}</strong>
        <i class="fa fa-angle-left"></i>
    </li>
    <li>
        <a href="{{ route('customers.viewdetails',['id' => $customer->id]) }}">عرض التفاصيل</a>
    </li>
</ul>
@stop

@section('page-title')
<h1 class="page-title"> ادارة العملاء
    <small>عرض طلب</small>
</h1>
@stop

@section('page-content')
<div class="portlet box {{ $form_class }}">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-grid"></i>عرض طلب </div>
    </div>
    <div class="portlet-body" style="overflow: hidden;">
        <br>
        <div class="col-md-6 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>بيانات الزبون </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-5 name"> الاسم: </div>
                        <div class="col-md-7 value"> {{$customer->name}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> البريد الالكتروني: </div>
                        <div class="col-md-7 value"> {{$customer->email}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> الهاتف: </div>
                        <div class="col-md-7 value"> {{$customer->phone}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> الجنس: </div>
                        <div class="col-md-7 value"> {{$customer->sex}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> تاريخ الميلاد: </div>
                        <div class="col-md-7 value"> {{$customer->dob}} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="portlet green-meadow box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-map-o"></i>عنوان الشحن </div>
                </div>
                <div class="portlet-body">

                    <div class="row static-info">
                        <div class="col-md-5 name"> الحي: </div>
                        <div class="col-md-7 value"> {{$customer->neighborhood}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> الشارع: </div>
                        <div class="col-md-7 value"> {{$customer->street}} </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-5 name"> المنزل: </div>
                        <div class="col-md-7 value"> {{$customer->building}} </div>
                    </div>
                </div>
            </div>
        </div>



        @if($customer->orders)
        <div class="col-md-12 col-sm-12">
            <div class="portlet grey-cascade box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list-alt"></i>الطلبات </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>رقم الطلب</th>
                            <th>حالة الطلب</th>
                            <th>السعر</th>
                            <th>التفاصيل</th>

                            </thead>
                            <tbody
                                @foreach($customer->orders as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><?= $item->id ?> </td>
                                    <td><?= $item->mystatus->name ?></td>
                                    <td><?= $item->total ?> ريال</td>
                                    <td>
                                        <a href="{{ route('orders.edit',[ 'id' => Crypt::encrypt($item->id)]) }}">
                                            <i class="fa fa-pencil"></i> عرض التفاصيل </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($favs)
        <div class="col-md-12 col-sm-12">
            <div class="portlet grey-cascade box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-heart-o"></i>المفضلة </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>المنتج</th>


                            </thead>
                            <tbody
                                @foreach($favs as $item)
                                <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><?= get_product($item->product_id)->name_ar ?> </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
        @endif
        @if($customer->carts)
        <div class="col-md-12 col-sm-12">
            <div class="portlet grey-cascade box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i>السلة </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <th>#</th>
                            <th>المنتج</th>


                            </thead>
                            <tbody
                                @foreach($customer->carts as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><?= get_product($item->product_id)->name_ar ?> </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <label class="control-label col-md-2">ملاحظات</label>
                            <div class="col-md-8">
                                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3">{{ $customer->admin_notes }}</textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="col-md-offset-3 col-md-6">
                        <button type="submit" class="btn default {{ $btn_class }}">حفظ</button>
                        <a href="{{ route('customers.view') }}" type="button" class="btn default">إلغاء</a>
                        {{ csrf_field() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
