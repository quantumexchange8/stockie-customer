<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.Customer::class,
            'phone' => 'required|string|max:255|unique:'.Customer::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verificationCode = rand(1000, 9999);

        // $user = Customer::create([
        //     'full_name' => $request->full_name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'password' => Hash::make($request->password),
        //     'verification_code' => $verificationCode,
        //     'verification_code_expires_at' => Carbon::now()->addMinutes(10),
        //     'ranking' => '0',
        //     'point' => '0',
        // ]);

        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));

        Session::put('verification_code', $verificationCode);
        Session::put('user_data', $request->only(['full_name', 'email', 'phone', 'password']));

        return redirect(route('verifyOtp'));

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
    }

    public function verifyOtp()
    {
        $verificationCode = Session::get('verification_code');
        $userData = Session::get('user_data');

        // Use the data as needed
        return Inertia::render('Auth/VerifyOtp', [
            'verificationCode' => $verificationCode,
            'userData' => $userData,
        ]);
    }
}
