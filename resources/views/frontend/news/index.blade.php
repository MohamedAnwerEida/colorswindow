@extends('frontend.layouts.master')
@section('title', 'Page Title')
@section('content')
<style>
    .main-blog-page .blog-post-single-item {
        min-height: 175px;
    }
</style>
<div class="main-blog-page blog-post-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Blog Post Item Area -->
                <div class="blog-post-item-ara">
                    <div class="blog-post-inner-item">
                        <div class="row">
                            @foreach($category_news as $item)
                            <?php
                            $cimg = $item->image;
                            if (substr($cimg, 0, 1) != '/') {
                                $cimg = '/' . $cimg;
                            }
                            $nimg = 'assets/site/images/default.jpg';
                            $img = (File::exists(public_path() . $cimg)) ? $cimg : $nimg;
                            ?>
                            <div class="col-lg-6 col-md-6">
                                <!-- Blog Post Single Item -->
                                <div class="blog-post-single-item">
                                    <div class="single-item-img">
                                        <a href="{{ URL::to('blogs/'.$item->id) }}" rel="bookmark" title=" {{$item->title}}">
                                            <img alt="product" src="{{ url(get_image($img,348,208)) }}">
                                        </a>
                                    </div>
                                    <div class="single-item-content">
                                        <h2>
                                            <a href="{{ URL::to('blogs/'.$item->id) }}" rel="bookmark" title=" {{$item->title}}">
                                                {{$item->title}}
                                            </a>
                                        </h2>
                                        <h3>{{ date('Y-m-d',strtotime($item->pub_date))}}</h3>
                                        <p>{{$item->sub}}...</p>
                                        <div class="blog-action">
                                            <a href="{{ URL::to('blogs/'.$item->id) }}" rel="bookmark" title=" {{$item->title}}">قراءة المزيد</a>
                                        </div>
                                    </div>
                                </div><!-- End Blog Post Single Item -->
                            </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $category_news->appends(request()->query())->links('frontend.news.paging') }}
                    <?php /*
                      <div class="blog-pagination">
                      <ul class="pagination">
                      <li><a href="#">&lt;</a></li>
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">&gt;</a></li>
                      </ul>
                      </div> */ ?>
                </div><!-- End Blog Post Item Area -->
            </div>
        </div>
    </div>
</div>
@stop