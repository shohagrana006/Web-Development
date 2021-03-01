<?php

namespace App\Http\Controllers;

use App\Billing;
use App\City;
use App\Country;
use App\Mail\PurchaseConfirm;
use App\Order;
use App\Order_detail;
use App\Product;
use App\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('frontend.checkout', [
            'countries' => Country::all(),
        ]);
    }

    public function getCityListAjax(Request $request)
    {
        $city_names = City::where('country_id', $request->country_id)->get();
        $stringToSend = '';
        foreach ($city_names as $city_name) {
            $stringToSend .= "<option value='" . $city_name->id . "'>" . $city_name->name . "</option>";
        }
        return $stringToSend;
    }

    public function checkoutPost(Request $request)
    {
        if (isset($request->check_different_address)) {
            $shipping_id = Shipping::insertGetId([
                'name'         => $request->shipping_name,
                'email'        => $request->shipping_email,
                'phone_number' => $request->shipping_phone_number,
                'country_id'   => $request->shipping_country_id,
                'city_id'      => $request->shipping_city_id,
                'address'      => $request->shipping_address,
                'created_at'   => Carbon::now(),
            ]);
        } else {
            $shipping_id = Shipping::insertGetId([
                'name'         => $request->name,
                'email'        => $request->email,
                'phone_number' => $request->phone_number,
                'country_id'   => $request->country_id,
                'city_id'      => $request->city_id,
                'address'      => $request->address,
                'created_at'   => Carbon::now(),
            ]);
        }
        $billing_id = Billing::insertGetId([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'country_id'   => $request->country_id,
            'city_id'      => $request->city_id,
            'address'      => $request->address,
            'notes'        => $request->notes,
            'created_at'   => Carbon::now(),
        ]);
        $order_id = Order::insertGetId([
            'user_id'          => Auth::user()->id,
            'sub_total'        => session('sub_total'),
            'discount_ammount' => session('total_discount_ammount'),
            'coupon_name'      => session('coupon_name'),
            'total'            => (session('sub_total') - session('total_discount_ammount')),
            'payment_methode'  => $request->payment_methode,
            'billing_id'       => $billing_id,
            'shipping_id'      => $shipping_id,
            'created_at'       => Carbon::now(),
        ]);

        foreach (CardItems() as $cardItem) {
            Order_detail::insert([
                'order_id'         => $order_id,
                'user_id'          => Auth::id(),
                'product_id'       => $cardItem->product_id,
                'product_quantity' => $cardItem->product_quantity,
                'product_price'    => $cardItem->relationProductName->product_price,
                'created_at'       => Carbon::now(),
            ]);
            Product::find($cardItem->product_id)->decrement('product_quantity', $cardItem->product_quantity);
            $cardItem->forceDelete();
        }
        $ordershow = Order_detail::where('order_id', $order_id)->get();
        Mail::to($request->email)->send(new PurchaseConfirm($ordershow));
        if ($request->payment_methode == 2) {
            session(['order_id_form_checkout' => $order_id]);
            return redirect('stripe');
        } else {
            return redirect('card');
        }
    }

    public function emailTest()
    {
        // Mail::to($request->email)->send(new PurchaseConfirm);
        $ordershow = Order_detail::where('order_id', 4)->get();

        return (new PurchaseConfirm($ordershow))->render();
    }
}
