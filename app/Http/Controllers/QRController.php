<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class QRController extends Controller
{
    public function qr()
    {

        $user = Auth::user();

        return Inertia::render('Qr/Qr', [
            'uuid' => $user->uuid
        ]);
    }
}
