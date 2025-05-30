<?php

namespace App\Http\Controllers;

use App\Models\KeepItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class KeepController extends Controller
{
    //

    public function keepListing()
    {

        $user = Auth::user();
        $today = Carbon::today();
        $threshold = $today->copy()->addDays(10);

        $keeps = KeepItem::where('customer_id', $user->id)
                ->where('status', 'keep')
                ->with([
                    'orderItemSubitem.productItem.product:id,product_name', 
                    'waiter:id,name',
                    'orderItemSubitem.productItem.inventoryItem:id,inventory_id,item_name'
                ])
                ->get();

        // Filter only those with upcoming expiry within 10 days
        $filteredKeeps = $keeps->filter(function ($keep) use ($threshold, $today) {
            if (!$keep->expired_to) {
                return false;
            }

            $expiry = Carbon::parse($keep->expired_to);
            return $expiry->greaterThanOrEqualTo($today) && $expiry->lessThanOrEqualTo($threshold);
        });

        $keeps->each(function ($keep) {
            $product = $keep->orderItemSubitem->productItem->product;
            if ($product) {
                $product->product_image_url = $product->getFirstMediaUrl('product');
            }

            // upcoming expiry
            $keep->upcoming_expiry = $keep->expired_to;
        });

        $filteredKeeps->each(function ($keep) {
            $keep->expired_status = 'upcoming';
            $keep->upcoming_expiry = $keep->expired_to;
        });
        
        $countKeep = KeepItem::where('customer_id', $user->id)->where('status', 'keep')->count();
        

        return Inertia::render('Keep/Keep', [
            'keeps' => $keeps,
            'countKeep' => $countKeep,
        ]);
    }

    public function keepHistory()
    {


        return Inertia::render('Keep/ViewHistory');
    }

    public function getKeepHistory()
    {

        $user = Auth::user();

        $keeps = KeepItem::where('customer_id', $user->id)
                ->with(['orderItemSubitem.productItem.product' => function ($query) {
                    $query->select('id', 'product_name')->with('media'); 
                }, 'keepHistories:keep_item_id,qty,cm,keep_date,status,remark,user_id,kept_from_table,redeemed_to_table',
                   'keepHistories.waiter:id,name',
                   'orderItemSubitem.productItem.inventoryItem:id,inventory_id,item_name',
                   'waiter:id,name'
                ])
                ->get();

        $keeps->each(function ($keep) {
            $product = $keep->orderItemSubitem->productItem->product;
            if ($product) {
                $product->product_image_url = $product->getFirstMediaUrl('product');
            }

            $userProfile = $keep->waiter;
            if ($userProfile) {
                $userProfile->profile_image = $userProfile->getFirstMediaUrl('user');
            }

            if (!empty($keep->keepHistories)) {
                foreach ($keep->keepHistories as $history) {
                    if ($history->waiter) {
                        $history->waiter->profile_image = $history->waiter->getFirstMediaUrl('user');
                    }
                }
            }
        });



        return response()->json($keeps);

    }
}
