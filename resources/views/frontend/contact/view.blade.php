@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<style>
        .social-sharing {
            border: 1px solid #e8e8e9;
            float: left;
            margin: 30px 0;
            padding: 10px;
            width: 100%;
        }
        .social-sharing h3{
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            color: #909295;
            float: right;
            font-size: 16px;
            line-height: 30px;
            margin: 0 0 0 20px;
            text-transform: none;
            width: auto;}
        .social-sharing .sharing-icon{float: right;}
        .social-sharing .sharing-icon a{display:inline-block}
        .social-sharing .sharing-icon a i{
            border: 1px solid #e8e8e9;
            color: #909295;
            font-size: 18px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            transition: all 0.3s ease 0s;
            width: 35px;}
        .social-sharing .sharing-icon a i{}
        .social-sharing .sharing-icon a i.fa-facebook:hover {
            background: #3b579d none repeat scroll 0 0;
            border: 1px solid #3b579d;
        }
        .social-sharing .sharing-icon a i.fa-twitter:hover {
            background: #3acaff;
            border: 1px solid #3acaff;
        }
        .social-sharing .sharing-icon a i.fa-pinterest:hover {
            background: #CB2027;
            border: 1px solid #CB2027;
        }
        .social-sharing .sharing-icon a i.fa-google-plus:hover {
            background: #D11717;
            border: 1px solid #D11717;
        }
        .social-sharing .sharing-icon a i.fa-linkedin:hover {
            background: #0097BD;
            border: 1px solid #0097BD;
        }
        .social-sharing .sharing-icon a i:hover {
            color:#fff;
        }
        .social-sharing .sharing-icon a i.fa-whatsapp:hover {
            background: #3FE028;
            border: 1px solid #3FE028;
        }
        .social-sharing {
            border: 1px solid #e8e8e9;
            float: left;
            margin: 30px 0;
            padding: 10px;
            width: 100%;
        }
    </style>
<div class="container">
    <!-- top_nav-->
    <img src="{{ url('assets/site/images/contact.png')}}" style="width: 100%;" class="text-center" alt="" />
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <center>                        
                    @include('frontend.layouts.error')
                </center>
                <div class="well well-sm">
                    <form class="form-horizontal" method="post">
                        <fieldset>
                            <div class="form-group">
                                <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                                <div class="col-md-8">
                                    <input id="fname" name="name" type="text" placeholder="الاسم" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                                <div class="col-md-8">
                                    <input id="email" name="email" type="text" placeholder="البريد الالكتروني" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-phone-alt bigicon"></i></span>
                                <div class="col-md-8">
                                    <input id="phone" name="phone" type="text" placeholder="الهاتف" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-pencil bigicon"></i></span>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="message" name="message" placeholder="أدخل رسالتك لنا هنا. سنعود إليك في غضون يومي عمل." rows="7"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">ارسال</button>
                                </div>
                            </div>
                        </fieldset>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="contact-info">
                    <h3>بيانات التواصل</h3>
                    <ul>
                        <li>
                            <i class="fa fa-map-marker"></i> <strong>العنوان</strong>
                            {{ $settings->contact_address}}
                        </li>
                        <li>
                            <i class="fa fa-mobile"></i> <strong>الهاتف</strong>
                            <span style="direction: ltr; display: inline-block;">{{ $settings->contact_no}}</span>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i> <strong>البريد الالكتروني</strong>
                            <a href="mailto:{{ $settings->contact_email}}">{{ $settings->contact_email}}</a>
                        </li>
                        <li><div style="width: 100%"><iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=%D8%B4%D8%A7%D8%B1%D8%B9%20%D8%A7%D9%84%D8%A7%D9%85%D9%8A%D8%B1%20%D9%86%D8%A7%D8%B5%D8%B1%20%D8%A8%D9%86%20%D9%81%D8%B1%D8%AD%D8%A7%D9%86%20-%20%D8%A7%D9%84%D8%B1%D9%8A%D8%A7%D8%B6%20-%20%D8%A7%D9%84%D9%85%D9%85%D9%84%D9%83%D8%A9%20%D8%A7%D9%84%D8%B9%D8%B1%D8%A8%D9%8A%D8%A9%20%D8%A7%D9%84%D8%B3%D8%B9%D9%88%D8%AF%D9%8A%D8%A9+(Color)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href="https://www.maps.ie/route-planner.htm">Driving Route Planner</a></div></li>  
                    </ul>
                </div>
            </div>
 <div class="social-sharing">
                            <h3>مشاركة هذه الصفحة</h3>
                            <?php
                            $title = "اتصل بنا";
                            $url = urlencode(Request::url());
                            ?>
                            <div class="sharing-icon">
                                <a data-toggle="tooltip" title="Facebook" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a data-toggle="tooltip" title="Twitter" onClick="window.open('https://twitter.com/intent/tweet?text=<?= $title ?>&url=<?= $url ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a data-toggle="tooltip" title="Linkedin" onClick="window.open('https://www.linkedin.com/sharing/share-offsite/?url=<?= $url ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                                <a data-toggle="tooltip" title="whatsup" href="https://wa.me/?text=<?= $url ?>" target="_blank">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
        </div><!--Main Content-->
    </div>
</div>
@stop