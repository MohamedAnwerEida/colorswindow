<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name='description' content="{{ $settings->description}}" />
<meta name='keywords' content="{{ $settings->tags}}" />
<meta name="viewport" content="width=device-width, initial-scale=1">
@if($home==1)
<link rel="canonical" href="{{url('/') }}">
<meta property="og:site_name" content="{{$settings->title}}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@PDCentre_org">
<meta property="og:locale" content="ar_AR">
<meta property="og:url" content="{{url('/') }}">
<meta property="og:description" content="{{ $settings->description }}">
<title>{{$settings->title}}</title>
@endif
@if($home==0)
<?php
$cimg = $post_news->image;
if (substr($cimg, 0, 1) != '/') {
    $cimg = '/' . $cimg;
}
$nimg = 'assets/site/images/default.jpg';
$img = File::exists(public_path() . $cimg) ? $cimg : $nimg;
?>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="@PDCentre_org"/>

<meta property="fb:app_id"        content="2115061775266110" /> 
<meta property="og:type"          content="article" />
<meta property="og:url"           content="{{url('blogs/'.$post_news->id) }}" />
<meta property="og:title"         content="{{$post_news->title}}" />
<meta property="og:description"   content="{{ $post_news->sub }}" />
<meta property="og:image"         content="{{ url($img) }}" />
<title>{{$post_news->title}}</title>
@endif
<!-- favicon
============================================ -->
<link rel="shortcut icon" href="{{url('assets/site/images/favicon/favicon.ico')}}" type="image/x-icon" />
<link rel="apple-touch-icon" href="{{url('assets/site/images/favicon/apple-touch-icon.png')}}" />
<link rel="apple-touch-icon" sizes="57x57" href="{{url('assets/site/images/favicon/apple-touch-icon-57x57.png')}}" />
<link rel="apple-touch-icon" sizes="72x72" href="{{url('assets/site/images/favicon/apple-touch-icon-72x72.png')}}" />
<link rel="apple-touch-icon" sizes="76x76" href="{{url('assets/site/images/favicon/apple-touch-icon-76x76.png')}}" />
<link rel="apple-touch-icon" sizes="114x114" href="{{url('assets/site/images/favicon/apple-touch-icon-114x114.png')}}" />
<link rel="apple-touch-icon" sizes="120x120" href="{{url('assets/site/images/favicon/apple-touch-icon-120x120.png')}}" />
<link rel="apple-touch-icon" sizes="144x144" href="{{url('assets/site/images/favicon/apple-touch-icon-144x144.png')}}" />
<link rel="apple-touch-icon" sizes="152x152" href="{{url('assets/site/images/favicon/apple-touch-icon-152x152.png')}}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{url('assets/site/images/favicon/apple-touch-icon-180x180.png')}}" />

<!-- Bootstrap CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{url('assets/site/css/bootstrap-rtl.css')}}">
<!-- Font Awesome CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/font-awesome.min.css')}}">
<!-- Mean Menu CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/meanmenu.min.css')}}">
<!-- owl.carousel CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/owl.carousel.css?s=1')}}">
<link rel="stylesheet" href="{{url('assets/site/css/owl.theme.css')}}">
<link rel="stylesheet" href="{{url('assets/site/css/owl.transitions.css')}}">
<!-- nivo-slider css
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/nivo-slider.css')}}">
<!-- Price slider css
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/vendor/jqueryui/jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{url('assets/site/css/jquery-ui-slider.css')}}">
<!-- Simple Lence css 
============================================ -->
<link rel="stylesheet" type="text/css" href="{{url('assets/site/css/jquery.simpleLens.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/site/css/jquery.simpleGallery.css')}}">
<!-- normalize CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/normalize.css')}}">
<!-- main CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/main.css')}}">
<!-- style CSS
============================================ -->

<link rel="stylesheet" href="{{url('assets/site/style.css?v=14')}}">
<!-- responsive CSS
============================================ -->
<link rel="stylesheet" href="{{url('assets/site/css/responsive.css')}}">
<!-- modernizr JS
============================================ -->
<script src="{{url('assets/site/js/vendor/modernizr-2.8.3.min.js')}}"></script>
<link rel="stylesheet" href="{{url('assets/site/css/hamzaaktaa.css')}}"/>
<meta name="google-site-verification" content="D9reJkPRUuiJjCThCb_SnmDTji5OTHUKT085IfMEhII" />
@yield('css')
