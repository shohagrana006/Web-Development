<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use Mail;
use Auth;
use App\Mail\NewsLetter;
use App\Contact;
use App\Order;
use App\Product;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('checkroll');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    // $users = User::orderBy('id', 'desc')->get();

    // $users      = User::latest()->paginate(2);
    // $totalUsers = User::count();
    // return view('home', compact('users', 'totalUsers'));

    // return view('home')->with('users', User::latest()->paginate(2))->with('totalUsers', User::count());
    $totalStockPrice = 0;
    foreach (Product::all() as $product) {
      $totalStockPrice += $product->product_quantity * $product->product_price;
    }
    return view('home', [
      'users'           => User::latest()->paginate(3),
      'totalUsers'      => User::count(),
      'paidStatus'      => Order::where('payment_status', 2)->count(),
      'unpaidStatus'    => Order::where('payment_status', 1)->count(),
      'cencalStatus'    => Order::where('payment_status', 3)->count(),
      'totalSale'       => Order::where('payment_status', 2)->sum('total'),
      'totalStockPrice' => $totalStockPrice,
    ]);
  }

  public function userNewsletter()
  {
    foreach (User::all()->pluck('email') as $email) {
      Mail::to($email)->queue(new NewsLetter(Auth::user()->name));
    }
    return back()->with('send_status', "Mail Send Successfully");
  }

  public function contactShow()
  {
    return view('admin.contact.index', [
      'contacts' => Contact::all(),
    ]);
  }

  public function contactDownload($contact_id)
  {
    return Storage::download(Contact::findOrFail($contact_id)->contact_attachment);
  }
}
