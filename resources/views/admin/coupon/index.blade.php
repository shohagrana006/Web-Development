@php
  error_reporting();
@endphp
@extends('layouts.dashboard_app')
@section('coupon')
  active
@endsection
@section('dashboard_content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
        <span class="breadcrumb-item active">Coupon</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Coupon page</h5>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-default text-center">Coupon List (active)</div>
                            @if (session('category_delete'))
                            <div class="alert alert-danger text-center">
                                {{ session('category_delete') }}
                            </div>
                            @endif
                            @if (session('product_add'))
                            <div class="alert alert-success">
                                {{ session('product_add') }}
                            </div>
                            @endif
                        <div class="card-body">
                            <table class="table table-striped" id="categoryDataTable">
                                <thead>
                                    <tr>
                                        <th>Serial no.</th>
                                        <th>Coupon name</th>
                                        <th>Discount Amount</th>
                                        <th>Minimum Purchase Amount</th>
                                        <th>Validity Till</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $coupon->coupon_name }}</td>
                                        <td>{{ $coupon->discount_amount }}</td>
                                        <td>{{ $coupon->minimum_purchase_amount }}</td>
                                        <td>{{ $coupon->validity_till }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="50" class="text-center text-danger">Coupon is not aviable</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header-default text-center">
                            <h4>Add Coupon</h4>
                        </div>
                        <div class="card-body">
                            @if (session('coupon_add'))
                            <div class="alert alert-success">
                                {{ session('coupon_add') }}
                            </div>
                            @endif
                            <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Coupon Name</label>
                                    <input class="form-control" type="text" name="coupon_name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Discount Amount</label>
                                    <input class="form-control" type="text" name="discount_amount">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Minimum Purchase Amount</label>
                                    <input class="form-control" type="text" name="minimum_purchase_amount">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Validity Till</label>
                                    <input class="form-control" type="date" name="validity_till">
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Add Coupon</button>
                            </form>
                        </div>
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
