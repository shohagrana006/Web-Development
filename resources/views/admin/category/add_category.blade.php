@extends('layouts.dashboard_app')
@section('category')
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
            <h5>Category page</h5>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header card-header-default text-center">Category List (active)</div>
                        @if (session('category_delete'))
                        <div class="alert alert-danger text-center">
                            {{ session('category_delete') }}
                        </div>
                        @endif
                        @if (session('update_category'))
                        <div class="alert alert-success">
                            {{ session('update_category') }}
                        </div>
                        @endif
                        <div class="card-body">
                            <table class="table table-striped" id="categoryDataTable">
                                <thead>
                                    <tr>
                                        <th>Serial no.</th>
                                        <th>Category name</th>
                                        {{-- <th>Category description</th> --}}
                                        <th>User name</th>
                                        <th>Category Image</th>
                                        <th>Create at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        {{-- <td>{{ $category->category_description }}</td> --}}
                                        <td>{{ Str::title(App\User::find($category->user_id)->name) }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/category_photos') }}/{{ $category->category_photo }}" class="img-fluid" alt="not found">
                                        </td>
                                        <td>{{ $category->created_at->format('d/m/Y H:i:s a') }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('edit/category') }}/{{ $category->id }}" type="button" class="btn btn-secondary btn-sm">Edit</a>
                                                <a href="{{ url('delete/category') }}/{{ $category->id }}" type="button" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
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
                    <div class="card mt-5">
                        <div class="card-header text-center bg-danger">Category List (delete)</div>
                        <div class="card-body">
                            <table class="table table-striped" id="categoryDataTable1">
                                <thead>
                                    <tr>
                                        <th>Serial no.</th>
                                        <th>Category name</th>
                                        {{-- <th>Category description</th> --}}
                                        <th>User name</th>
                                        <th>Category Image</th>
                                        <th>Delete at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($softDelete as $delete)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $delete->category_name }}</td>
                                        {{-- <td>{{ $delete->category_description }}</td> --}}
                                        <td>{{ Str::title(App\User::find($delete->user_id)->name) }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/category_photos') }}/{{ $delete->category_photo }}" class="img-fluid" alt="not found">
                                        </td>
                                        <td>{{ $delete->deleted_at->diffForHumans() }}</td>
                                        <td>

                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('restore/category') }}/{{ $delete->id }}" type="button" class="btn btn-success btn-sm">restore</a>
                                                <a href="{{ url('force/delete/category') }}/{{ $delete->id }}" type="button" class="btn btn-danger btn-sm">forc.dlt</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="50" class="text-center text-info">Content is not aviable</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header-default text-center">
                            <h4>Add Category</h4>
                        </div>
                        <div class="card-body">
                            @if (session('dataSave'))
                            <div class="alert alert-success">
                                {{ session('dataSave') }}
                            </div>
                            @endif
                            <form action="{{ url('add/category/post') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category Name</label>
                                    <input type="text" name="category_name" value="{{ old('category_name') }}" class="form-control" placeholder="Category name">
                                    @error ('category_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category description</label>
                                    <textarea name="category_description" class="form-control" rows="3" placeholder="Category description">{{ old('category_description') }}</textarea>
                                    @error ('category_description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category Image</label>
                                    <input type="file" name="category_photo" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary d-block">add category</button>
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
