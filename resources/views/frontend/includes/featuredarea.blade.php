<!-- featured-area start -->
<div class="featured-area featured-area2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="featured-active2 owl-carousel next-prev-style">

                  @foreach ($active_categories as $active_category)
                    <div class="featured-wrap">
                        <div class="featured-img">
                            <img src="{{ asset('uploads/category_photos') }}/{{ $active_category->category_photo }}" alt="">
                            <div class="featured-content">
                                <a href="{{ url('shop') }}">{{$active_category->category_name}}</a>
                            </div>
                        </div>
                    </div>
                  @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- featured-area end -->
