<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QRController extends Controller
{
    public function qr()
    {

        $user = Auth::user();

        $profileImage = Customer::find($user->id);

        $profileImage->profile = $profileImage->getFirstMediaUrl('customer');

        return Inertia::render('Qr/Qr', [
            'uuid' => $user->uuid,
            'profileImage' => $profileImage
        ]);
    }
}
