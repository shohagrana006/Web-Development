<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'FrontendController@index');
Route::get('product_details/{slug}', 'FrontendController@productDetails');
Route::get('contact', 'FrontendController@contact');
Route::post('contact/insert', 'FrontendController@contactInsert');
Route::get('about', 'FrontendController@about');
Route::get('our/service', 'FrontendController@ourservice');
Route::get('shop', 'FrontendController@shop');
Route::get('login/register', 'FrontendController@loginRegister');
Route::post('customer/register/post', 'FrontendController@customerRegisterPost');
Route::post('review/post', 'FrontendController@reviewPost');
Route::get('search', 'FrontendController@search');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('user/newsletter', 'HomeController@userNewsletter');
Route::get('contact/show', 'HomeController@contactShow');
Route::get('contact/download/{contact_id}', 'HomeController@contactDownload');


// category controller
Route::get('add/category', 'CategoryController@addCategory');
Route::post('add/category/post', 'CategoryController@addCategoryPost');
Route::get('edit/category/{category_id}', 'CategoryController@editCategory');
Route::post('edit/category/post/', 'CategoryController@editCategoryPost');
Route::get('delete/category/{category_id}', 'CategoryController@deleteCategory');
Route::get('restore/category/{category_id}', 'CategoryController@restoreCategory');
Route::get('force/delete/category/{category_id}', 'CategoryController@forceDeleteCategory');

// profile controller
Route::get('profile/edit', 'ProfileController@editProfile');
Route::post('edit/name', 'ProfileController@editName');
Route::post('password/change', 'ProfileController@changePassword');
Route::post('change/profile/image', 'ProfileController@changeProfileImage');

//Product Controller Routes
Route::resource('product', 'ProductController');

//Card Controller routes
Route::get('card', 'CardController@index')->name('card.index');
Route::get('card/{coupon_name}', 'CardController@index')->name('card.coupon');
Route::post('card/store', 'CardController@cardStore')->name('card.store');
Route::get('card/remove/{card_id}', 'CardController@remove')->name('card.remove');
Route::post('card/update', 'CardController@update')->name('card.update');

//Coupon Controller Routes
Route::resource('coupon', 'CouponController');

//Order Controller Routes
Route::resource('order', 'OrderController');
Route::get('order/cencel/{order_id}', 'OrderController@cencel')->name('order.cencel');

//Checkout Controller Routes
Route::get('checkout', 'CheckoutController@index');
Route::post('checkout/post', 'CheckoutController@checkoutPost');
Route::post('/get/city/list/ajax', 'CheckoutController@getCityListAjax');

//Customer Controller Routes
Route::get('customer/home', 'CustomerController@home');
Route::get('incvoice/customer/download/{order_id}', 'CustomerController@incvoiceCustomerDownload');

//Github Controller Routes
Route::get('login/github', 'GithubController@redirectToProvider');
Route::get('login/github/callback', 'GithubController@handleProviderCallback');

// payment getway
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

// text controller
Route::get('/email/test', 'CheckoutController@emailTest');
