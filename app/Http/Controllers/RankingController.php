<?php

namespace App\Http\Controllers;

use App\Models\CustomerReward;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RankingController extends Controller
{
    public function ranking()
    {

        $user = Auth::user();
        $rank = Ranking::find($user->ranking);
        $rank->image = $rank->getFirstMediaUrl('ranking');

        return Inertia::render('Ranking/Ranking', [
            'rank' => $rank
        ]);
    }

    public function getReward()
    {

        $user = Auth::user();

        $ranking = CustomerReward::where('customer_id', $user->id)
        ->with(['rankingReward:id,reward_type,min_purchase,discount,min_purchase_amount'])        
        ->get();

        return response()->json($ranking);
    }
}
