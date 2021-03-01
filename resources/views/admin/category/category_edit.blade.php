@extends('layouts.dashboard_app')
@section('category')
  active
@endsection
@section('dashboard_content')
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
        <a class="breadcrumb-item" href="{{ url('add/category') }}">Category</a>
        <span class="breadcrumb-item active">{{ $categories->category_name }}</span>
      </nav>

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Category edit Page</h5>
        </div>
        <div class="container">
          <div class="col-md-8 m-auto">
            <div class="card">
              <div class="card-header card-header-default text-center">
                <h3>Update Category</h3>
              </div>
              <div class="card-body">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('add/category') }}">Category List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $categories->category_name }}</li>
                  </ol>
                </nav>
                <form action="{{ url('edit/category/post') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Name</label>
                    <input type="hidden" name="category_id" value="{{ $categories->id }}" class="form-control" placeholder="Category name">
                    <input type="text" name="category_name" value="{{ $categories->category_name }}" class="form-control" placeholder="Category name">
                    @error ('category_name')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category description</label>
                    <textarea name="category_description" class="form-control" rows="3" placeholder="Category description">{{ $categories->category_description }}</textarea>
                    @error ('category_description')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                  <button type="submit" class="btn btn-primary d-block">Update category</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection
