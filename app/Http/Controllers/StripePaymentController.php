<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    public function stripe()
    {
        if (session('order_id_form_checkout')) {
            return view('test.stripe');
        } else {
            abort(404);
        }
    }

    public function stripePost(Request $request)
    {
        $payTotalAmmount = session('sub_total') - session('total_discount_ammount');

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $payTotalAmmount * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Payment from AtLand.  Order Id " . session('order_id_form_checkout'),
        ]);
        Session::flash('success', 'Payment successful!');
        Order::find(session('order_id_form_checkout'))->update([
            'payment_status' => 2,
        ]);
        session([
            'sub_total'              => '',
            'total_discount_ammount' => '',
            'coupon_name'            => '',
            'order_id_form_checkout' => '',
        ]);
        return redirect('card');
    }
}
