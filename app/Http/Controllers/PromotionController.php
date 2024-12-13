<?php

namespace App\Http\Controllers;

use App\Models\ConfigPromotion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromotionController extends Controller
{
    public function promotion()
    {

        $promotions = ConfigPromotion::where('status', 'Active')->get();

        $promotions->each(function($promotion){
            $promotion->image = $promotion->getFirstMediaUrl('promotion');
        });

        return Inertia::render('Promotion/Promotion', [
            'promotions' => $promotions,
        ]);
    }

    public function promotionDetails($id)
    {

        $promotion = ConfigPromotion::find($id);

        $promotion->image = $promotion->getFirstMediaUrl('promotion');

        return Inertia::render('Promotion/Partials/PromotionDetails', [
            'promotion' => $promotion,
        ]);
    }

    public function getPromotionImage()
    {

        $promotions = ConfigPromotion::where('status', 'Active')->get();

        $promotions->each(function($promotion){
            $promotion->image = $promotion->getFirstMediaUrl('promotion');
        });

        return response()->json($promotions);
    }
}
