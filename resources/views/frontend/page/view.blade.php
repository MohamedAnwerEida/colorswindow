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
    <img src="{{ url('uploads/image/'.$page->image)}}" style="width: 100%;" class="text-center" alt="" />
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <h4 class="text-center bg-danger"></h4>
            <h1 class="text-right">{{$page->title}}</h1>
            <br />
            <div class="content-post">
                {!!$page->details!!}
            </div>
            <div class="social-sharing">
                            <h3>مشاركة هذه الصفحة</h3>
                            <?php
                            $title = urlencode($page->title);
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
<style>
    .content-post {
        direction: rtl;
    }
</style>
@stop