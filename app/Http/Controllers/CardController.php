<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CardController extends Controller
{
  public function index($coupon_name = '')
  {
    $error_massage = '';
    $discount_ammount = 0;
    if ($coupon_name == '') {
      $error_massage = '';
    } else {
      $coupon_query = Coupon::where('coupon_name', $coupon_name);
      if (!$coupon_query->exists()) {
        $error_massage = 'this coupon does not match!!';
      } else {
        if (Carbon::now()->format('Y-m-d') > $coupon_query->first()->validity_till) {
          $error_massage = 'your coupon is expired';
        } else {
          $sub_total = 0;
          foreach (CardItems() as $CardItem) {
            $sub_total += $CardItem->relationProductName->product_price * $CardItem->product_quantity;
          }
          if ($coupon_query->first()->minimum_purchase_amount > $sub_total) {
            $error_massage = 'you hove to Minimum purchase ' . $coupon_query->first()->minimum_purchase_amount;
          } else {
            $discount_ammount = $coupon_query->first()->discount_amount;
          }
        }
      }
    }
    $valid_coupons = Coupon::whereDate('validity_till', '>=', Carbon::now()->format('Y-m-d'))->get();
    return view('frontend.card', compact('error_massage', 'discount_ammount', 'coupon_name', 'valid_coupons'));
  }

  public function cardStore(Request $request)
  {
    if (Cookie::get('g_card_id')) {
      $generated_card_id = Cookie::get('g_card_id');
    } else {
      $generated_card_id = Str::random(7) . rand(10, 100);
      Cookie::queue('g_card_id', $generated_card_id, 1440);
    }
    if (Card::where('generated_card_id', $generated_card_id)->where('product_id', $request->product_id)->exists()) {
      Card::where('generated_card_id', $generated_card_id)->where('product_id', $request->product_id)->increment('product_quantity', $request->product_quantity);
    } else {
      Card::insert([
        'generated_card_id' => $generated_card_id,
        'product_id'        => $request->product_id,
        'product_quantity'  => $request->product_quantity,
        'created_at'        => Carbon::now(),
      ]);
    }
    return back();
  }

  public function remove($card_id)
  {
    Card::find($card_id)->delete();
    return back()->with('remove_status', 'Product remove successfully!!');
  }

  public function update(Request $request)
  {
    foreach ($request->product_info as $card_id => $product_quantity) {
      Card::find($card_id)->update([
        'product_quantity' => $product_quantity,
      ]);
    }
    return back()->with('update_status', 'Updated successfully!!');
  }
}
