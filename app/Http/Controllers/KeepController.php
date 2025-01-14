<?php

namespace App\Http\Controllers;

use App\Models\KeepItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class KeepController extends Controller
{
    //

    public function keepListing()
    {

        $user = Auth::user();

        $keeps = KeepItem::where('customer_id', $user->id)
                ->where('status', 'keep')
                ->with(['orderItemSubitem.productItem.product:id,product_name', 'waiter:id,name'])
                ->get();

        $keeps->each(function ($keep) {
            $product = $keep->orderItemSubitem->productItem->product;
            if ($product) {
                $product->product_image_url = $product->getFirstMediaUrl('product');
            }
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
                }, 'keepHistories:keep_item_id,qty,cm,keep_date,status,remark'])
                ->get();

        $keeps->each(function ($keep) {
            $product = $keep->orderItemSubitem->productItem->product;
            if ($product) {
                $product->product_image_url = $product->getFirstMediaUrl('product');
            }
        });

        return response()->json($keeps);

    }
}
