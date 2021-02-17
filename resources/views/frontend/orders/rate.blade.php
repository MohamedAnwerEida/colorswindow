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
                            <div class="name"> رقم الطلب</div>
                            <div class="col-md-8 value"> {{$order->id}}</div>
                        </div>
                        <div class="row">
                            <div class="name"> وقت وتاريخ الطلب: </div>
                            <div class="col-md-8 value"> {{$order->created_at}} GMT</div>
                        </div>
                        <div class="row">
                            <div class="name"> المبلغ المطلوب: </div>
                            <div class="col-md-8 value"> {{$order->total}} ريال</div>
                        </div>
                        @if($order->ratings)
                        <div class="row">
                            <div class="name"> التقييم</div>
                            <div class="col-md-8 value"> 
                                <?PHP if ($order->ratings == 1) { ?>
                                    <img src="{{ url('assets/site/images/rate/bad.png')}}" style="width: 30px;">
                                <?PHP } elseif ($order->ratings == 2) { ?>
                                    <img src="{{ url('assets/site/images/rate/mid.png')}}" style="width: 30px;">
                                <?PHP } else { ?>
                                    <img src="{{ url('assets/site/images/rate/good.png')}}" style="width: 30px;">
                                <?PHP } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="name"> ملاحظة التقيم: </div>
                            <div class="col-md-8 value"> {{ $order->rate_note }} </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="portlet grey">
                    <div class="portlet-title">
                        <i class="fa fa-list-alt"></i> منتجات الطلبية  
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
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
                                        <td><?= $item->price ?> ريال</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!$order->ratings)
        <div class="row">
            <div class="col-md-6">
                <div class="product-rev-right">
                    <h3><b>كيف تقيم هذا الطلب؟<span>*</span></b></h3>
                    <div class="porduct-rev-right-form">
                        <form action="" method="post" class="form-horizontal product-form">
                            <div class="form-group">
                                <div><label>تقييم الطلب <sup>*</sup></label></div>
                                <div>
                                    <label>
                                        <input type="radio" name="ratings" value="3" checked>
                                        <img src="{{ url('assets/site/images/rate/good.png')}}" style="width: 50px;">
                                    </label>
                                    <label>
                                        <input type="radio" name="ratings" value="2">
                                        <img src="{{ url('assets/site/images/rate/mid.png')}}" style="width: 50px;">
                                    </label>
                                    <label>
                                        <input type="radio" name="ratings" value="1" >
                                        <img src="{{ url('assets/site/images/rate/bad.png')}}" style="width: 50px;">
                                    </label>
                                </div>
                            </div>
                            <div class="form-goroup">
                                <label>ملاحظاتك على الطلب <sup>*</sup></label>
                                <textarea class="form-control" rows="5" required="required" name="rate_note"></textarea>
                            </div>
                            <div class="form-group form-group-button">
                                <button class="btn custom-button" value="submit">ارسال التقييم</button>
                                {{ csrf_field() }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
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
    .yellow{ border-color: #7251a1;}
    .yellow  .portlet-title{ background-color: #7251a1;}


    .grey{ border-color: #7251a1;}
    .grey  .portlet-title{ background-color: #7251a1;}
    .value {
        font-size: 14px;
        font-weight: 600;
        line-height: 30px;

    }
    .name {
        font-size: 14px;
        line-height: 30px;
        float: right;
        margin-right: 15px;
    }
    .radio {
        display: inline-block;
        min-height: 0 !important;
    }
    .nobr {
        display: inline-block;
        margin-left: 10px;
    }
    /* HIDE RADIO */
    [type=radio] { 
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* IMAGE STYLES */
    [type=radio] + img {
        cursor: pointer;
    }

    /* CHECKED STYLES */
    [type=radio]:checked + img {
        outline: 2px solid #f00;
    }
    .porduct-rev-right-form label {
        margin-left: 40px;
        margin-top: 15px;
    }
</style>
@stop