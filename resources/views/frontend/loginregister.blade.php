 @extends('layouts.frontend_app')

 @section('frontend_content')

 <!-- .breadcumb-area start -->
 <div class="breadcumb-area bg-img-4 ptb-100">
     <div class="container">
         <div class="row">
             <div class="col-12">
                 <div class="breadcumb-wrap text-center">
                     <h2>Account</h2>
                     <ul>
                         <li><a href="{{ url('/') }}">Home</a></li>
                         <li><span>Register</span></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- .breadcumb-area end -->
 <!-- checkout-area start -->
 <div class="account-area ptb-100">
     <div class="container">
         <div class="row">
             <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                 <form action="{{ url('customer/register/post') }}" method="post">
                     @csrf
                     <div class="account-form form-style">
                         <p>Name *</p>
                         <input type="text" name="name">
                         <p>Email Address *</p>
                         <input type="email" name="email">
                         <p>Password *</p>
                         <input type="Password" name="password">
                         <button type="submit">Register</button>
                        <a href="{{ url('login/github') }}" class="btn btn-dark d-block py-2"><i class="fa fa-github"></i> login with GitHub</a>
                        <a href="#" class="btn btn-warning my-3 d-block py-2"><i class="fa fa-google"></i> login with Google</a>
                         <div class="text-center">
                             <a href="{{ url('login') }}">Or Login</a>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- checkout-area end -->

 @endsection