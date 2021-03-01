@extends('layouts.frontend_app')

@section('frontend_content')
<!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcumb-wrap text-center">
          <h2>Shopping Cart</h2>
          <ul>
            <li><a href="{{url('/')}}">Home</a></li>
            <li><span>Shopping Cart</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- .breadcumb-area end -->
<!-- cart-area start -->
<div class="cart-area ptb-100">
  <div class="container">
    <div class="row">
      <div class="col-12">
        @if (session('remove_status'))
        <div class="alert alert-warning">
          {{ session('remove_status') }}
        </div>
        @endif

        @if (session('update_status'))
        <div class="alert alert-success">
          {{ session('update_status') }}
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
        @endif

        @if ($error_massage != '')
        <div class="alert alert-danger">
          {{ $error_massage }}
        </div>
        @endif

        <form action="{{route('card.update') }}" method="post">
          @csrf
          <table class="table-responsive cart-wrap d-table">
            <thead>
              <tr>
                <th class="images">Image</th>
                <th class="product">Product</th>
                <th class="ptice">Price</th>
                <th class="quantity">Quantity</th>
                <th class="total">Total</th>
                <th class="remove">Remove</th>
              </tr>
            </thead>
            <tbody>
              @php
              $sub_total = 0;
              $flag = 0;
              @endphp
              @forelse (CardItems() as $CardItem)
              @if ($CardItem->relationProductName->product_quantity < $CardItem->product_quantity)
                @php
                $flag = 1;
                @endphp
                @endif
                <tr>
                  <td class="images"><img src="{{ asset('uploads/product_photos') }}/{{$CardItem->relationProductName->product_thumnail_photo}}" alt=""></td>
                  <td class="product"><a class="{{ ($CardItem->relationProductName->product_quantity < $CardItem->product_quantity)?'text-danger font-weight-bold':'' }}" href="{{ url('product_details') }}/{{$CardItem->relationProductName->slug}}">
                      {{$CardItem->relationProductName->product_name}}
                      <br>
                      @if ($CardItem->relationProductName->product_quantity < $CardItem->product_quantity)
                        <div class="alert alert-danger mt-3">
                          {{ 'This product Aviable is '.$CardItem->relationProductName->product_quantity }}
                        </div>
                        @endif
                    </a></td>
                  <td class="ptice">${{$CardItem->relationProductName->product_price}}</td>
                  <td class="quantity cart-plus-minus">
                    <input type="text" class="{{ ($CardItem->relationProductName->product_quantity < $CardItem->product_quantity)?'text-danger font-weight-bold':'' }}" value="{{ $CardItem->product_quantity }}" name="product_info[{{ $CardItem->id }}]" />
                  </td>
                  <td class="total">${{ $CardItem->relationProductName->product_price * $CardItem->product_quantity }}</td>
                  <td class="remove">
                    <a href="{{ route('card.remove', $CardItem->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                  </td>
                </tr>
                @php
                $sub_total += $CardItem->relationProductName->product_price * $CardItem->product_quantity
                @endphp
                @empty
                <tr>
                  <td colspan="50" class="alert alert-danger">Nothing to show Product</td>
                </tr>
                @endforelse

            </tbody>
          </table>
          <div class="row mt-60">
            <div class="col-xl-4 col-lg-5 col-md-6 ">
              <div class="cartcupon-wrap">
                <ul class="d-flex">
                  <li>
                    <button type="submit">Update Cart</button>
        </form>
        </li>
        <li><a href="{{url('shop')}}">Continue Shopping</a></li>
        </ul>
        <h3>Cupon</h3>
        <p>Enter Your Cupon Code if You Have One</p>
        <div class="cupon-wrap">
          <input type="text" placeholder="Cupon Code" id="apply_coupon_input" value="{{ $coupon_name }}">
          <button id="apply_coupon_btn" type="button">Apply Cupon</button>
        </div>
        <div class="mt-3">
          @foreach($valid_coupons as $valid_coupon)
          <button value="{{ $valid_coupon->coupon_name }}" type="button" class="badge aviable_coupon_btn"> {{ $valid_coupon->coupon_name }} -- Minimum Purchase ammount ${{ $valid_coupon->minimum_purchase_amount}}</button>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
      <div class="cart-total text-right">
        <h3>Cart Totals</h3>
        <ul>
          <li><span class="pull-left">Subtotal </span>${{ $sub_total }}</li>
          @php
          session(['sub_total' => $sub_total]);
          @endphp
          <li><span class="pull-left"> Discount(%) </span>{{ $discount_ammount }}%</li>
          <li><span class="pull-left"> Discount Ammount({{ ($coupon_name) ? $coupon_name : '-'}}) </span> ${{ ($sub_total * $discount_ammount)/100 }}</li>
          @php
          session(['total_discount_ammount' => (($sub_total * $discount_ammount)/100)]);
          session(['coupon_name' => (($coupon_name) ? $coupon_name : '-')]);
          @endphp
          <li><span class="pull-left"> Total </span>${{ $sub_total - (($sub_total * $discount_ammount)/100) }}</li>
        </ul>
        @if ($flag == 1 || $sub_total <= 0) <a href="#" class="btn disabled">Proceed to Checkout</a>
          @else
          <a href="{{ url('checkout') }}">Proceed to Checkout</a>
          @endif
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- cart-area end -->
@endsection

@section('frontend_footer_script')
<script>
  $(document).ready(function() {

    $('#apply_coupon_btn').click(function() {
      var apply_coupon_input = $('#apply_coupon_input').val();
      var go_to_link = "{{ url('card') }}/" + apply_coupon_input;
      window.location.href = go_to_link;
    });

    $('.aviable_coupon_btn').click(function() {
      $('#apply_coupon_input').val($(this).val());
    });

  });
</script>
@endsection