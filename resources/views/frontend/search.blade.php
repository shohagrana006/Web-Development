@extends('layouts.frontend_app')

@section('frontend_content')
    <!-- product-area start -->
    <div class="product-area">
        <div class="fluid-container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Search Product ({{ $search_results->count() }})</h2>
                        <img src="{{ asset('fontend_asset') }}/images/section-title.png" alt="">
                    </div>
                </div>
            </div>
            @if ($search_results->count() != 0)
            <ul class="row">
                @foreach ($search_results as $active_product)
                <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                    <div class="product-wrap">
                        <div class="product-img">
                            <span>Sale</span>
                            <img src="{{ asset('uploads/product_photos') }}/{{ $active_product->product_thumnail_photo }}" alt="">
                            <div class="product-icon flex-style">
                                <ul>
                                    <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                    <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
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
            @else
               <h2 class="text-danger text-center">Search doesn't match</h2> 
            @endif
            
        </div>
    </div>
    <!-- product-area end -->
@endsection