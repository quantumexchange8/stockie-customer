<?php

namespace App\Http\Controllers;

use App\Models\KeepItem;
use App\Models\PayoutConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalController extends Controller
{
    public function getPayoutDetails()
    {

        $payouts = PayoutConfig::first();

        return response()->json($payouts);
    }

    public function getTotalKeep()
    {

        $user = Auth::user();

        $keeps = KeepItem::where('customer_id', $user->id)
                ->where('status', 'keep')
                ->with(['orderItemSubitem.productItem.product:id,product_name', 'waiter:id,name'])
                ->count();

        return response()->json($keeps);
    }
}
