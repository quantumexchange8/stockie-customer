<?php

namespace App\Http\Controllers;

use App\Models\PointHistory;
use App\Models\Product;
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
        ])->get();

        return response()->json($pointLog);
    }
}
