@extends('layouts.dashboard_app')

@section('dashboard_content')
<div class="sl-mainpanel">
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="index.html">Starlight</a>
    <a class="breadcrumb-item" href="index.html">Pages</a>
    <span class="breadcrumb-item active">Blank Page</span>
  </nav>

  <div class="sl-pagebody">
    <div class="sl-page-title">
      <div class="card">
        <div class="card-header">
          <h2>Your Purchase Products</h2>
        </div>
        <div class="card-body">
          <table class="table table-striped">
              <thead>
                <tr>
                  <th>s.l</th>
                  <th>date</th>
                  <th>Payment method</th>
                  <th>Payment status</th>
                  <th>Subtotal</th>
                  <th>discount ammount</th>
                  <th>coupon name</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($orders as $order)
                  <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>
                      @if ($order->payment_methode == 1)
                        Cash on delivery                             
                      @else
                        Card    
                      @endif
                    </td>
                    <td>
                      @if ($order->payment_status == 1)
                        <span class="badge badge-danger">Unpaid</span>
                      @else
                        <span class="badge badge-success">Paid</span> 
                      @endif
                    </td>
                    <td>{{$order->sub_total}}</td>
                    <td>{{$order->discount_ammount}}</td>
                    <td>{{$order->coupon_name}}</td>
                    <td>{{$order->total}}</td>
                    <td>
                      <a href="{{ url('incvoice/customer/download') }}/{{ $order->id }}"><i class="fa fa-download"></i> Download invoice</a>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="50">
                        @foreach ($order->relationOrderDetail as $orderProduct)  
                        <p>
                          {{$orderProduct->OrderdetailToProduct->product_name}}
                        </p>
                        @endforeach
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="50" class="alert alert-danger">Nothing to show Product</td>
                  </tr>
                  @endforelse
              </tbody>
            </table>
        </div>
      </div>
    </div>
    {{-- write here --}}
  </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
@endsection