<?php

namespace App\Http\Controllers;

use App\Models\ConfigMerchant;
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

        $order = Order::where('customer_id', $user->id)
            ->where('status', 'Order Completed')
            ->with(['orderTable:order_id,table_id', 'orderTable.table:id,table_no', 
                    'orderItems:order_id,product_id,amount_before_discount,discount_id', 'orderItems.product:id,product_name',
                    'payment:order_id,receipt_end_date,total_amount,grand_total,sst_amount,service_tax_amount,point_earned,discount_id',
                    'customer:id,point'
                    ])
            ->latest()
            ->get();

        // dd($order);

        return response()->json($order);
    }
    
    public function getMerchant()
    {

        $merchants = ConfigMerchant::first();

        if ($merchants) {
            $merchants->merchant_settings = $merchants->hasMedia('merchant_settings') 
                ? $merchants->getFirstMediaUrl('merchant_settings') 
                : null;
        }
    

        return response()->json($merchants);
    }
}
