@extends('layouts.dashboard_app')
@section('title')
  Profile
@endsection
@section('dashboard_content')
<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
        <span class="breadcrumb-item active">Edit profile</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Profile edit</h5>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Edit name</h3>
                        </div>
                        <div class="card-body">
                            @if (session('nameChange'))
                            <div class="alert alert-danger">
                                {{ session('nameChange') }}
                            </div>
                            @endif
                            <form action="{{ url('edit/name') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="profile_name" value="{{ Auth::user()->name }}" class="form-control">
                                    @error ('profile_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Change name</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Change photo</h3>
                        </div>
                        <div class="card-body">
                            @if (session('imageChange'))
                            <div class="alert alert-success">
                                {{ session('imageChange') }}
                            </div>
                            @endif
                            <form action="{{ url('change/profile/image') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Image</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                    @error ('profile_photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Change Image</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-5">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Change password</h3>
                        </div>
                        <div class="card-body">
                            @if (session('passChange'))
                            <div class="alert alert-danger">
                                {{ session('passChange') }}
                            </div>
                            @endif
                            <form action="{{ url('password/change') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Old password</label>
                                    <input type="password" name="old_password" class="form-control">
                                    @error ('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">New password</label>
                                    <input type="password" name="password" id="myInput" class="form-control">
                                    <button type="button" class="btn-sm mt-2" onclick="myFunction()" name="button">show</button>
                                    <script>
                                        function myFunction() {
                                            var x = document.getElementById("myInput");
                                            if (x.type === "password") {
                                                x.type = "text";
                                            } else {
                                                x.type = "password";
                                            }
                                        }
                                    </script>
                                    @error ('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Confirm password</label>
                                    <input type="password" name="password_confirmation" class="form-control">password
                                </div>
                                <button type="submit" class="btn btn-primary d-block">Change password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
@endsection
