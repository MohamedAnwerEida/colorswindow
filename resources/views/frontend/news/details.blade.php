@extends('frontend.layouts.master')
@section('title', 'Page Title')
@section('content')
<div class="main-blog-page single-blog blog-post-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- single-blog start -->
                <article class="blog-post-wrapper">
                    <div class="post-thumbnail">
                        <?php
                        $cimg = $post_news->image;
                        if (substr($cimg, 0, 1) != '/') {
                            $cimg = '/' . $cimg;
                        }
                        $nimg = 'assets/site/images/default.jpg';
                        $img = File::exists(public_path() . $cimg) ? $cimg : $nimg;
                        ?>      
                        <img src="{{ url($img) }}" alt="" class="">
                    </div>
                    <div class="post-information">
                        <h2>{{$post_news->title}}</h2>
                        <div class="entry-meta">
                            <span><i class="fa fa-clock-o"></i> {{ date('Y-m-d',strtotime( $post_news->pub_date))}}</span>
                            <span>
                                <i class="fa fa-tags"></i>
                                <?php $tags = explode(',', $post_news->tags) ?>
                                @foreach($tags as $tag)
                                <a href="#">{{ $tag }}</a> @if (!$loop->last),@endif
                                @endforeach
                            </span>
                        </div>
                        <div class="entry-content">
                            {!! $post_news->descs !!}
                        </div>
                    </div>
                </article>
                <div class="social-sharing">
                    <h3>مشاركة هذه الصفحة</h3>
                    <?php
                    $title = urlencode($post_news->title);
                    $url = urlencode(url('blogs/' . $post_news->id));
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
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet"> 
<style>
    .entry-content{ font-family: 'Almarai', sans-serif;}
    .single-blog .entry-content p {
        font-size: 16px;     
        line-height: 40px;
    }
    .single-blog .social-sharing .sharing-icon a i.fa-whatsapp:hover {
        background: #3FE028;
        border: 1px solid #3FE028;
    }
</style>
@stop