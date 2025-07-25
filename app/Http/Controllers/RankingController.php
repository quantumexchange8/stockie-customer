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

        $nextRank = Ranking::where('id', '>', $rank->id)
                   ->orderBy('id')
                   ->first();

        $nextSpending = $nextRank->min_amount - $user->total_spending;

        $allRank = Ranking::get();

        return Inertia::render('Ranking/Ranking', [
            'user' => $user,
            'rank' => $rank,
            'nextRank' => $nextRank,
            'nextSpending' => $nextSpending,
            'allRank' => $allRank,
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
