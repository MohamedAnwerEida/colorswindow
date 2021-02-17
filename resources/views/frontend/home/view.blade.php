@extends('frontend.layouts.master')

@section('title', 'Page Title')

@section('sidebar')
@parent
@stop

@section('content')
<!-- Product Layout Area -->
<div class="product-layout-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Product Layout Left -->
                <div class="product-layout-left">
                    <!-- Main Slider Area -->
                    <div class="main-slider-area another-home hidden-xs hidden-sm">

                        <!-- Main Slider -->
                        <div class="main-slider ">
                            <div class="slider">
                                <div id="mainSlider" class="nivoSlider slider-image">
                                    @foreach($sliders as $slider)
                                    <a href="{{$slider->url}}"><img src="{{ url($slider->photo)}}" alt="main slider"></a>
                                   @endforeach
                                </div>
                            </div>
                        </div><!-- End Main Slider -->
                    </div><!-- End Main Slider Area -->
                    <!-- Single Product Area -->


                    <!-- Product Area -->
                    <div class="product-area">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="single-product-area">
                                    <div class="about-post">
                                        <h1>{{ $about->title }}</h1>
                                        {!! $about->details !!}
                                    </div>
                                </div>
                                <!-- Product View Area -->
                                @include('frontend.home.area')
                                <!-- End Product View Area -->
                            </div>
                            <div class="col-md-3">
                                <!-- Product Layout Right -->
                                @include('frontend.home.right')
                                <!-- End Product Layout Right -->
                            </div>
                        </div>
                    </div><!-- End Product Area -->
                </div><!-- End Product Layout Left -->
            </div>
        </div>
    </div>
</div>
<!-- End Product Layout Area -->
@stop
@section('css')
<style>
    .about-post {
        color: #000;
    }
    .about-post h1 {
        margin-bottom: 15px;
    }
</style>
@stop
