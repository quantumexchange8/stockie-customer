<?php

namespace App\Http\Controllers;

use App\Models\ConfigPromotion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PromotionController extends Controller
{
    public function promotion()
    {

        $promotions = ConfigPromotion::get();

        return Inertia::render('Promotion/Promotion', [
            'promotions' => $promotions,
        ]);
    }

    public function promotionDetails($id)
    {

        $promotion = ConfigPromotion::find($id);

        return Inertia::render('Promotion/Partials/PromotionDetails', [
            'promotion' => $promotion
        ]);
    }
}
