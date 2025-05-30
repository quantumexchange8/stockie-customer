<?php

namespace App\Http\Controllers;

use App\Models\PointHistory;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PointController extends Controller
{
    public function point()
    {
        $user = Auth::user();

        return Inertia::render('Point/Point', [
            'point' => $user->point,
        ]);
    }

    public function getRedemItem()
    {

        $user = Auth::user();

        $products = Product::where('is_redeemable', 1)
                ->whereRaw('CAST(point AS UNSIGNED) <= ?', [$user->point])
                ->whereNot('status', 'Out of stock')
                ->where('availability', 'Available')
                ->get();

        $products->each(function($product){
            $product->image = $product->getFirstMediaUrl('product');
        });

        return response()->json($products);
    }

    public function viewHistory()
    {

        return Inertia::render('Point/ViewHistory');
    }

    public function getPointHistory()
    {

        $user = Auth::user();

        $pointLog = PointHistory::where('customer_id', $user->id)->with([
            'payment:id,order_id',
            'payment.order:id,order_no',
            'product:id,product_name'
        ])->latest()->get();

        return response()->json($pointLog);
    }

    public function getExpiringPoint()
    {

        $user = Auth::user();

        $expiredNotification = Setting::where('name', 'Point Expiration Notification')->first();
        $days = (int) ($expiredNotification->value ?? 0);  // e.g. 7

        $now = now('Asia/Kuala_Lumpur'); // ✅ use correct timezone
        $upcomingExpiration = $now->copy()->addDays($days); // copy to avoid modifying original $now

        $expiringPoints = PointHistory::where('customer_id', $user->id)
            ->where('type', 'Earned')
            ->whereBetween('expired_at', [$now, $upcomingExpiration])
            ->get();

        $expiringTotal = PointHistory::where('customer_id', $user->id)
            ->where('type', 'Earned')
            ->whereBetween('expired_at', [$now, $upcomingExpiration])
            ->sum('expire_balance');

        return response()->json([
            'expiringPoints' => $expiringPoints,
            'total_point' => $expiringTotal,
        ]);
    }
}
