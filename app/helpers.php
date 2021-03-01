<?php
function totalProductConut()
{
  echo App\Product::count();
}
function CardConut()
{
  return App\Card::where('generated_card_id', Cookie::get('g_card_id'))->count();
}
function CardItems()
{
  return App\Card::where('generated_card_id', Cookie::get('g_card_id'))->get();
}
function reviewCustomerCount($product_id)
{
  return App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->get()->count();
}
function average_star($product_id)
{
  $countAmmount = App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->count();
  $sumAmmount   = App\Order_detail::where('product_id', $product_id)->whereNotNull('review')->sum('stars');

  if ($sumAmmount == 0) {
    return 0;
  } else {
    return round($sumAmmount / $countAmmount);
  }
}
function alertProductquantity()
{
  return DB::table('products')->whereRaw('product_quantity <= product_alert_quantity')->count();
}
function searchCategories()
{
  return App\Category::all();
}
