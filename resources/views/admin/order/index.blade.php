@extends('layouts.dashboard_app')
@section('order')
active
@endsection
@section('dashboard_content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
        <span class="breadcrumb-item active">Order</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Order page</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-default text-center">Order List (active)</div>
                    {{-- @if (session('category_delete'))
                    <div class="alert alert-danger text-center">
                        {{ session('category_delete') }}
                    </div>
                    @endif
                    @if (session('product_add'))
                    <div class="alert alert-success">
                        {{ session('product_add') }}
                    </div>
                    @endif --}}
                    <div class="card-body">
                        <table class="table table-striped" id="categoryDataTable">
                            <thead>
                                <tr>
                                    <th>S.L</th>
                                    <th>Order id</th>
                                    <th>Order at</th>
                                    <th>Order Name</th>
                                    <th>Payment Typed</th>
                                    <th>Payment status</th>
                                    <th>Price</th>
                                    <th>discount ammount</th>
                                    <th>coupon name</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td> 
                                    <td>{{$order->user_id}}</td>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->userrelation->name}}</td>
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
                                    @elseif($order->payment_status == 2)
                                        <span class="badge badge-success">Paid</span> 
                                    @else
                                        <span class="badge badge-warning">Cencel</span> 
                                    @endif

                                    </td>
                                    <td>{{$order->sub_total}}</td>
                                    <td>{{$order->discount_ammount}}</td>
                                    <td>{{$order->coupon_name}}</td>
                                    <td>{{$order->total}}</td>
                                    <td>
                                        @if($order->payment_status == 1)
                                        <form action="{{ route('order.update', $order->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Paid</button>
                                        </form>                                         
                                        @endif
                                        @if($order->payment_status != 3)    
                                        <a href="{{ route('order.cencel', $order->id) }}" class="btn btn-danger btn-sm">Cancel</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="50" class="text-center text-danger">Content is not aviable</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
@endsection

@section('footer_script')
<script type="text/javascript">
    $(document).ready(function() {
        'use strict';

        $('#categoryDataTable').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
        $('#categoryDataTable1').DataTable({
            bLengthChange: false,
            searching: false,
            responsive: true
        });
    });
</script>
@endsection
