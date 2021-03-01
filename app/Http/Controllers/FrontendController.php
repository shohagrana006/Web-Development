<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category, App\Product, App\Contact;
use App\Order_detail;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Cookie;
use Hash;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;


class FrontendController extends Controller
{
  function index(Request $request)
  {
    // $name = 'name';
    // $value = 'shohag';
    // $minutes = 10;
    //  // Cookie::queue($name, $value, $minitues);
    //  Cookie::queue('name', 'value', $minutes);
    // echo $value = $request->cookie('name');
    $bestSellar = Order_detail::with('OrderdetailToProduct')->select('product_id', DB::raw('count(*) as total'))
      ->groupBy('product_id')
      ->get();
    $bestSellarDesc = $bestSellar->sortByDesc('total')->take(4);

    return view('frontend.index', [
      'active_categories' => Category::all(),
      'active_products'   => Product::latest()->limit(8)->get(),
      'bestSellarDesc'    => $bestSellarDesc,
    ]);
  }

  function productDetails($slug)
  {
    $info_products    =  Product::where('slug', $slug)->firstorfail();
    $related_products = Product::where('category_id', $info_products->category_id)->where('id', '!=', $info_products->id)->get();

    $showReviewForm = 0;
    if (Order_detail::where('user_id', Auth::id())->where('product_id', $info_products->id)->whereNull('review')->exists()) {
      $showReviewForm = 1;
      $orderDetailId = Order_detail::where('user_id', Auth::id())->where('product_id', $info_products->id)->whereNull('review')->first()->id;
    } else {
      $showReviewForm = 2;
      $orderDetailId  = 0;
    }

    $reviews = Order_detail::where('product_id', $info_products->id)->whereNotNull('review')->get();

    return view('frontend.product_details', [
      'info_products'    => $info_products,
      'related_products' => $related_products,
      'showReviewForm'   =>  $showReviewForm,
      'orderDetailId'    => $orderDetailId,
      'reviews'          => $reviews,
    ]);
  }

  function contact()
  {
    return view('frontend.contact', [
      'active_categories' => Category::all(),
    ]);
  }

  function contactInsert(Request $request)
  {
    $contact_id = Contact::insertGetId($request->except('_token') + [
      'created_at' => Carbon::now(),
    ]);
    if ($request->hasFile('contact_attachment')) {
      // $path = $request->file('contact_attachment')->store('contact_uploads');
      $path = $request->file('contact_attachment')->storeAs(
        'contact_uploads',
        $contact_id . '.' . $request->file('contact_attachment')->getClientOriginalExtension(),
      );
      Contact::find($contact_id)->update([
        'contact_attachment' => $path,
      ]);
    }
    return back()->with('uploads_status', 'Successfully submitted your information');
  }

  function about()
  {
    $bestSellar = Order_detail::with('OrderdetailToProduct')->select('product_id', DB::raw('count(*) as total'))
      ->groupBy('product_id')
      ->get();
    $bestSellarDesc = $bestSellar->sortByDesc('total')->take(4);

    return view('frontend.about', [
      'bestSellarDesc'    => $bestSellarDesc,
    ]);
  }

  function ourservice()
  {
    echo "this is our service page";
  }

  function shop()
  {
    return view('frontend.shop', [
      'categories' => Category::all(),
      'products'   => Product::all(),
    ]);
  }

  function loginRegister()
  {
    return view('frontend.loginregister');
  }

  function customerRegisterPost(Request $request)
  {
    User::insert([
      'name'       => $request->name,
      'email'      => $request->email,
      'role'       => 2,
      'password'   => Hash::make($request->password),
      'created_at' => Carbon::now(),
    ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      return redirect('customer/home');
    }
  }

  function reviewPost(Request $request)
  {
    Order_detail::find($request->order_detail_id)->update([
      'stars'  => $request->stars,
      'review' => $request->review,
    ]);
    return back();
  }

  function search()
  {
    $search_results = QueryBuilder::for(Product::class)
      ->allowedFilters(['product_name', 'category_id'])
      ->allowedSorts('product_name')
      ->get();
    return view('frontend.search', compact('search_results'));
  }
}
