<?php

namespace App\Http\Controllers;

use App\Order;
use App\Order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CustomerController extends Controller
{
    public function home()
    {
        return view('customer.home', [
            'orders' => Order::with('relationOrderDetail')->where('user_id', Auth::id())->get(),
        ]);
    }

    public function incvoiceCustomerDownload($order_id)
    {
        $order_info = Order::find($order_id);
        $pdf = PDF::loadView('pdf.invoice', compact('order_info'));
        // pdf download kora
        return $pdf->download('invoice Id(' . $order_id . ').pdf');
        // pdf ei page ei dekha
        // return $pdf->stream();
    }
}
