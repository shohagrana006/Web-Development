@extends('layouts.frontend_app')

@section('frontend_content')

<!-- slider-area start -->
<div class="slider-area">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide overlay">
                <div class="single-slider slide-inner slide-inner1">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-lg-9 col-12">
                                <div class="slider-content">
                                    <div class="slider-shape">
                                        <h2 data-swiper-parallax="-500">Amazing Pure Nature Hohey</h2>
                                        <p data-swiper-parallax="-400">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin</p>
                                        <a href="shop.html" data-swiper-parallax="-300">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slide-inner slide-inner7">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-lg-9 col-12">
                                <div class="slider-content">
                                    <div class="slider-shape">
                                        <h2 data-swiper-parallax="-500">Amazing Pure Nature Coconut Oil</h2>
                                        <p data-swiper-parallax="-400">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin</p>
                                        <a href="shop.html" data-swiper-parallax="-300">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slide-inner slide-inner8">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-lg-9 col-12">
                                <div class="slider-content">
                                    <div class="slider-shape">
                                        <h2 data-swiper-parallax="-500">Amazing Pure Nut Oil</h2>
                                        <p data-swiper-parallax="-400">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin</p>
                                        <a href="shop.html" data-swiper-parallax="-300">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<!-- slider-area end -->

<!-- featured-area start -->
@include('frontend.includes.featuredarea')
<!-- featured-area end -->

<!-- start count-down-section -->
<div class="count-down-area count-down-area-sub">
    <section class="count-down-section section-padding parallax" data-speed="7">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 text-center">
                    <h2 class="big">Deal Of the Day <span>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin</span></h2>
                </div>
                <div class="col-12 col-lg-12 text-center">
                    <div class="count-down-clock text-center">
                        <div id="clock">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
</div>
<!-- end count-down-section -->

@include('frontend.includes.bestsellar')

<!-- product-area start -->
<div class="product-area">
    <div class="fluid-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Our Latest Product</h2>
                    <img src="{{ asset('fontend_asset') }}/images/section-title.png" alt="">
                </div>
            </div>
        </div>
        <ul class="row">

            @foreach ($active_products as $active_product)
            <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="product-wrap">
                    <div class="product-img">
                        <span>Sale</span>
                        <img src="{{ asset('uploads/product_photos') }}/{{ $active_product->product_thumnail_photo }}" alt="">
                        <div class="product-icon flex-style">
                            <ul>
                                <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="{{ url('card') }}"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3><a href="{{url('product_details')}}/{{ $active_product->slug }}">{{ $active_product->product_name }}</a></h3>
                        <p class="pull-left">${{$active_product->product_price}}</p>
                        <ul class="pull-right d-flex">
                            @if (average_star($active_product->id) == 0)
                                <span class="text-danger">Not Review Yet </span>
                            @else                                
                                @for ($i = 1; $i <= average_star($active_product->id); $i++)  
                                <li><i class="fa fa-star"></i></li>
                                @endfor
                            @endif                      
                        </ul>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<!-- product-area end -->

<!-- testmonial-area start -->
<div class="testmonial-area testmonial-area2 bg-img-2 black-opacity">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="test-title text-center">
                    <h2>What Our client Says</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <div class="testmonial-active owl-carousel">
                    @for ($i=0; $i < 4; $i++)
                      <div class="test-items test-items2">
                        <div class="test-content">
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical LatinContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
                            </p>
                            <h2>Elizabeth Ayna</h2>
                            <p>CEO of Woman Fedaration</p>
                        </div>
                        <div class="test-img2">
                            <img src="{{ asset('fontend_asset') }}/images/test/1.png" alt="">
                        </div>
                     </div>
                 @endfor
             </div>
         </div>
     </div>
  </div>
</div>
<!-- testmonial-area end -->
@endsection
