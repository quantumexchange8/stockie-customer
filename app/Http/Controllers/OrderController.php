<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    //

    public function orderListing()
    {

        return Inertia::render('Order/Order');
    }

    public function getOrderHistory()
    {

        $user = Auth::user();

        $order = Order::where('customer_id', $user->id)->where('status', 'Order Completed')->get();

        return response()->json($order);
    }
}
