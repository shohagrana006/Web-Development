<!-- best sellar product start -->
<div class="product-area product-area-2">
    <div class="fluid-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Best Seller</h2>
                    <img src="{{ asset('fontend_asset') }}/images/section-title.png" alt="">
                </div>
            </div>
        </div>
        <ul class="row">
            @foreach ($bestSellarDesc as $bestSellar)
              <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="product-wrap">
                    <div class="product-img">
                        <img src="{{ asset('uploads/product_photos') }}/{{ $bestSellar->OrderdetailToProduct->product_thumnail_photo }}" alt="">
                        <div class="product-icon flex-style">
                            <ul>
                                <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="{{ url('card')}}"><i class="fa fa-shopping-bag"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3><a href="{{url('product_details')}}/{{ $bestSellar->OrderdetailToProduct->slug }}">{{ $bestSellar->OrderdetailToProduct->product_name }}</a></h3>
                        <p class="pull-left">${{$bestSellar->OrderdetailToProduct->product_price}}</p>
                        <ul class="pull-right d-flex">
                            @if (average_star($bestSellar->OrderdetailToProduct->id) == 0)
                                <span class="text-danger">Not Review Yet </span>
                            @else                                
                                @for ($i = 1; $i <= average_star($bestSellar->OrderdetailToProduct->id); $i++)  
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
<!-- best sellar product end -->