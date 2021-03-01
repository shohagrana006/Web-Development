@extends('layouts.dashboard_app')
@php
error_reporting(0);
@endphp
@section('product')
active
@endsection
@section('dashboard_content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
        <a class="breadcrumb-item" href="{{ route('product.index') }}">Product</a>
        <span class="breadcrumb-item active">{{ $product_info->product_name }}</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Product page</h5>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto">
                    <div class="card">
                        <div class="card-header-default text-center">
                            <h4>Edit Product</h4>
                        </div>
                        <div class="card-body">
                            @if (session('product_add'))
                            <div class="alert alert-success">
                                {{ session('product_add') }}
                            </div>
                            @endif
                            <form action="{{ route('product.update', $product_info->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category Name</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">--Select one--</option>
                                        @foreach ($activeCategories as $activeCategory)
                                        <option {{ ($activeCategory->id == $product_info->category_id) ? "selected":""}} value="{{ $activeCategory->id }}">{{ $activeCategory->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error ('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input class="form-control" type="text" name="product_name" value="{{ $product_info->product_name }}">
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Short Description</label>
                                    <textarea name="product_short_description" class="form-control" rows="3">{{ old('product_short_description') }}{{ $product_info->product_short_description }}</textarea>
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product long Description</label>
                                    <textarea name="product_long_description" class="form-control" rows="3">{{ old('product_long_description') }}{{ $product_info->product_short_description }}</textarea>
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Price</label>
                                    <input type="text" name="product_price" class="form-control" value="{{ $product_info->product_price }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product quantity</label>
                                    <input type="text" name="product_quantity" class="form-control" value="{{ $product_info->product_quantity }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alert quantity</label>
                                    <input type="text" name="product_alert_quantity" class="form-control" value="{{ $product_info->product_alert_quantity }}">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Image</label>
                                    <input type="file" name="product_thumnail_photo" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Update Product</button>
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
