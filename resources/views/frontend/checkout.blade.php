@extends('layouts.frontend_app')

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Checkout</h2>
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><span>Checkout</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- checkout-area start -->
<div class="checkout-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-form form-style">
                    <h3>Billing Details</h3>
                    <form action="{{ url('checkout/post') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <p>Name *</p>
                                <input type="text" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Email Address *</p>
                                <input type="email" name="email" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Phone No. *</p>
                                <input type="text" name="phone_number">
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>Country *</p>
                                <select id="search_country_id_1" name="country_id">
                                    <option value="">Select a country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-12">
                                <p>City *</p>
                                <select id="search_city_id_1" name="city_id">
                                    <option value="">Select a city</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <p>Your Address *</p>
                                <input type="text" name="address">
                            </div>
                            <div class="col-12">
                                <p>Order Notes </p>
                                <textarea name="notes" placeholder="Notes about Your Order, e.g.Special Note for Delivery"></textarea>
                            </div>
                            <div class="col-12">
                                <input id="toggle1" type="checkbox">
                                <label for="toggle1">Pure CSS Accordion</label>
                                <div class="create-account">
                                    <p>Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                                    <span>Account password</span>
                                    <input type="password">
                                </div>
                            </div>
                            <div class="col-12">
                                <input id="toggle2" type="checkbox" name="check_different_address">
                                <label class="fontsize" for="toggle2">Ship to a different address?</label>
                                <div class="row d-flex" id="open2">
                                    <div class="col-12">
                                        <p>Name *</p>
                                        <input type="text" value="" name="shipping_name">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>Email Address *</p>
                                        <input type="email" value="" name="shipping_email">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>Phone No. *</p>
                                        <input type="text" name="shipping_phone_number">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>Country *</p>
                                        <select id="search_country_id_2" name="shipping_country_id">
                                            <option value="">Select a country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <p>City *</p>
                                        <select id="search_city_id_2" name="shipping_city_id">
                                            <option value="1">Select a city</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <p>Your Address *</p>
                                        <input type="text" name="shipping_address">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="order-area">
                    <h3>Your Order</h3>
                    <ul class="total-cost">
                        @foreach (CardItems() as $CardItem)
                        <li>{{$CardItem->relationProductName->product_name}} x {{$CardItem->product_quantity}}<span class="pull-right">${{ $CardItem->relationProductName->product_price*$CardItem->product_quantity}}</span></li>
                        @endforeach

                        <li>Subtotal <span class="pull-right"><strong>${{ session('sub_total') }}</strong></span></li>
                        <li>Total Discount Ammount ({{ session('coupon_name') }}) <span class="pull-right">${{ session('total_discount_ammount') }}</span></li>
                        <li>Total<span class="pull-right">${{ session('sub_total') - session('total_discount_ammount') }}</span></li>
                    </ul>
                    <ul class="payment-method">
                        <li>
                            <input id="delivery" name="payment_methode" value="1" type="radio" checked>
                            <label for="delivery">Cash on Delivery</label>
                        </li>
                        <li>
                            <input id="card" name="payment_methode" value="2" type="radio">
                            <label for="card">Credit Card</label>
                        </li>

                    </ul>
                    <button type="submit">Place Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- checkout-area end -->
@endsection

@section('frontend_footer_script')
<script>
    $(document).ready(function() {
        // select to search plugin start
        $('#search_country_id_1').select2();
        $('#search_city_id_1').select2();
        $('#search_country_id_2').select2();
        $('#search_city_id_2').select2();
        // select to search plugin end

        $('#search_country_id_1').change(function() {
            var country_id = $(this).val();
            // ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // ajax response start
            $.ajax({
                type: 'POST',
                url: '/get/city/list/ajax',
                data: {
                    country_id: country_id
                },
                success: function(data) {
                    $('#search_city_id_1').html(data);
                },

            });
            // ajax response end
        });
        $('#search_country_id_2').change(function() {
            var country_id = $(this).val();
            // ajax setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // ajax response start
            $.ajax({
                type: 'POST',
                url: '/get/city/list/ajax',
                data: {
                    country_id: country_id
                },
                success: function(data) {
                    $('#search_city_id_2').html(data);
                },

            });
            // ajax response end
        });




    });
</script>
@endsection