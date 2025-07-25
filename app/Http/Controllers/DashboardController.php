<?php

namespace App\Http\Controllers;

use App\Models\ConfigPromotion;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();

        // Check if it's the user's first login
        if ($user->first_login == 0) {
            // Update first_login to 1 after the first login
            // $user->update(['first_login' => 1]);

            // Redirect to the SelectProfile page
            return redirect()->route('profile.profile_image');
        }

        // Fetch promotions for the dashboard
        $promotions = ConfigPromotion::get();
        $rank = Ranking::find($user->ranking);
        $rank->image = $rank->getFirstMediaUrl('ranking');
        $profileImage = Customer::find($user->id);
        $lastOrder = Order::where('customer_id', $user->id)->where('status', 'Order Completed')->latest()->first();

        $profileImage->profile = $profileImage->getFirstMediaUrl('customer');

        return Inertia::render('Dashboard', [
            'promotions' => $promotions,
            'rank' => $rank,
            'profileImage' => $profileImage,
            'lastOrder' => $lastOrder,
        ]);
    }
}
