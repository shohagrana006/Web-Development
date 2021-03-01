@extends('layouts.dashboard_app')
@section('product')
active
@endsection
@section('dashboard_content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
        <span class="breadcrumb-item active">Category</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Product page</h5>
        </div>
        <div class="row">
                <div class="col-md-8 px-0">
                    <div class="card">
                        <div class="card-header card-header-default text-center">Product List (active)</div>
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
                                        <th>Category id</th>
                                        <th>Product name</th>
                                        <th>Product price</th>
                                        <th>Product quantity</th>
                                        <th>Product alert quantity</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                            
                                <tbody>                                 
                                    @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $product->relationCategoryTable->category_name }}</td>
                                        {{-- <td>{{ App\category::find($product->category_id)->category_name }}</td> --}}
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->product_price }}</td>
                                        <td class="{{ ($product->product_quantity <= $product->product_alert_quantity) ? 'bg-danger' : '' }}"><span class="{{ ($product->product_quantity <= $product->product_alert_quantity) ? 'text-white font-weight-bold text-center' : '' }}">{{ $product->product_quantity }}</span></td>
                                        <td>{{ $product->product_alert_quantity }}</td>
                                        <td>
                                          <img class="img-fluid w-100" src="{{ asset('uploads/product_photos') }}/{{ $product->product_thumnail_photo }}" alt="{{ $product->product_thumnail_photo }}">
                                        </td>
                                        <td>
                                          <a href="{{ route('product.edit', $product->id ) }}" type="button" class="btn btn-secondary btn-sm">Edit</a>
                                          <form method="post" action="{{ route('product.destroy', $product->id ) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" name="button" class="btn btn-danger btn-sm">delete</button>
                                          </form>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header-default text-center">
                            <h4>Add Product</h4>
                        </div>
                        <div class="card-body">
                            @if (session('product_add'))
                            <div class="alert alert-success">
                                {{ session('product_add') }}
                            </div>
                            @endif
                            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category Name</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">--Select one--</option>
                                        @foreach ($activeCategories as $activeCategory)
                                        <option value="{{ $activeCategory->id }}">{{ $activeCategory->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error ('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input class="form-control" type="text" name="product_name">
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Short Description</label>
                                    <textarea name="product_short_description" class="form-control" rows="3">{{ old('category_description') }}</textarea>
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product long Description</label>
                                    <textarea name="product_long_description" class="form-control" rows="3">{{ old('category_description') }}</textarea>
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Price</label>
                                    <input type="text" name="product_price" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product quantity</label>
                                    <input type="text" name="product_quantity" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Alert quantity</label>
                                    <input type="text" name="product_alert_quantity" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Thumnail Image</label>
                                    <input type="file" name="product_thumnail_photo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Multiple Image</label>
                                    <input type="file" name="product_multiple_photo[]" class="form-control" multiple>
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Add Product</button>
                            </form>
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
