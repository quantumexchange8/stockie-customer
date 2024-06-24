<?php

namespace App\Http\Controllers;

use App\Models\ConfigPromotion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //

    public function index()
    {

        $promotions = ConfigPromotion::get();

        return Inertia::render('Dashboard', [
            'promotions' => $promotions,
        ]);
    }
}
