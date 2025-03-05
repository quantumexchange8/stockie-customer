<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\Customer;
use App\Models\User;
use App\Models\VerifyOtp;
use App\Services\RunningNumberService;
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
            'phone' => [
                'required', 
                'numeric', 
                'digits_between:9,10', // Malaysia phone numbers are typically 10-11 digits
                'unique:customers,phone', // Ensures phone number is unique
                function ($attribute, $value, $fail) {
                    // Prefix '60' to the input value
                    $phoneNumber = '60' . $value;
                    
                    // Check if the phone number starts with '601' and is followed by 7-8 digits
                    if (!preg_match('/^601[0-9]{7,8}$/', $phoneNumber)) {
                        $fail('The phone number must be a valid Malaysian phone number.');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verificationCode = rand(1000, 9999);
        $uuid = rand(1000, 9999);

        $user = Customer::create([
            'full_name' => $request->full_name,
            'uuid' => RunningNumberService::getID('customer'),
            'email' => $request->email,
            'dial_code' => '+60',
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'ranking' => '1',
            'point' => '0',
            'first_login' => '0',
        ]);

        $storeOtp = VerifyOtp::create([
            'email' => $request->email,
            'otp' => $verificationCode,
            'expired_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode, $request->email));

        session()->flash('verification_code', $verificationCode);
        session()->flash('user_data', $request->only(['full_name', 'email', 'phone', 'password']));


        return to_route('verifyOtp');

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
    }

    public function verifyOtp()
    {
        $verificationCode = session('verification_code');
        $userData = session('user_data');

        if (!$userData) {
            return redirect()->route('profile.create');  // Or wherever the user should be redirected if there's an issue
        }

        $uid = Customer::where('email', $userData['email'])->first();

        if (!$uid) {
            return redirect()->route('profile.create');  // Handle cases where the user can't be found
        }

        // Use the data as needed
        return Inertia::render('Auth/VerifyOtp', [
            'verificationCode' => $verificationCode,
            'userData' => $userData,
            'uid' => $uid->id,
        ]);
    }

    public function validOtp(Request $request)
    {

        $user = Customer::find($request->id);
        $now = Carbon::now();

        $check = VerifyOtp::where('email', $user->email)->orderBy('created_at', 'desc')->first();
        
        if (!$check || $now > $check->expired_at) {
            return redirect()->back()->withErrors(['otp' => 'OTP expired']);
        }
        
        if ($check->otp === $request->otp) {
            $user->email_verified_at = $now;
            $user->status = 'verified';
            $user->first_login = '0';
            $user->save();
    
            // 🔹 Login the user before redirecting
            Auth::guard('web')->login($user);
    
            // 🔹 Remove OTP record to prevent reuse
            $check->delete();
    
            // 🔹 Redirect to the correct page
            return ($user->first_login === '0')
                ? redirect(route('profile.profile_image'))
                : redirect(route('dashboard'));
        }

        return redirect()->back()->withErrors(['otp' => 'Invalid OTP']);
        
    }
}
