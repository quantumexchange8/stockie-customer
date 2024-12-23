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
                ->with(['orderItemSubitem.productItem.product:id,product_name'])
                ->get();
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
                ->with(['orderItemSubitem.productItem.product:id,product_name'])
                ->get();

        return response()->json($keeps);

    }
}
