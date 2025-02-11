<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\VerificationCodeMail;
use App\Models\Customer;
use App\Models\User;
use App\Models\VerifyOtp;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {

        // $customer = Auth::user();

        $profileImage = Customer::find(Auth::user()->id);

        $profileImage->profile = $profileImage->getFirstMediaUrl('customer');

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'profileImage' => $profileImage,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function profileImage()
    {

        return Inertia::render('SelectProfile');
    }

    public function getProfileImage()
    {
        $files = File::files(public_path('assets/profile_image'));
        $images = array_map(function ($file) {
            return [
                'url' => asset('assets/profile_image/' . $file->getFilename()),
                'name' => $file->getFilename(),
            ];
        }, $files);

        return response()->json($images);
    }

    public function saveimage(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png|max:2048', // 2MB limit
        ]);

        $auth = Auth::user();

        $user = Customer::find($auth->id);

        if($request->hasfile('image')) {
            $user->addMedia($request->image)->toMediaCollection('customer');
        }

        $user->first_login = '1';
        $user->save();

        return redirect()->route('dashboard');
    }
    
    public function getUserData()
    {

        $users = Customer::where('id', Auth::user()->id)->first();

        return response()->json($users);
    }

    public function updateProfile(Request $request)
    {

        // dd($request->all());

        $customer = Customer::find(Auth::user()->id);

        $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers', 'phone')->ignore(Auth::user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore(Auth::user()->id),
            ],
        ]);

        if ($customer->email !== $request->email) {
            $customer->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'email_verified_at' => null,
                'status' => 'unverified'
            ]);
            
        } else {
            $customer->update([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
        }

        

        if($request->hasfile('image')) {
            $customer->clearMediaCollection('customer');
            $customer->addMedia($request->image)->toMediaCollection('customer');
        }

        return redirect()->back();
    }

    public function verifyOtp()
    {

        $user = Customer::find(Auth::user()->id);
        $now = Carbon::now();

        // Get the latest OTP record for the user
        $latestOtp = VerifyOtp::where('email', $user->email)
        ->orderBy('created_at', 'desc')
        ->first();

        // Check if an OTP record exists and is still valid
        if ($latestOtp && $latestOtp->expired_at > $now) {
            
            return Inertia::render('Auth/VerifyAuthOtp', [
                'message_code' => '429'
            ]);
        }

        $otp = rand(1000, 9999);

        // Insert a new OTP record with a 5-minute expiration
        VerifyOtp::create([
            'email' => $user->email,
            'otp' => $otp,
            'expired_at' => $now->addMinutes(5),
        ]); 


        Mail::to($user->email)->send(new VerificationCodeMail($otp, $user->email));

        return Inertia::render('Auth/VerifyAuthOtp', [
            'message_code' => '200'
        ]);
        
    }

    public function validStoreOtp(Request $request)
    {
        // dd($request->all());
        $user = Customer::find(Auth::user()->id);
        $now = Carbon::now();

        $check = VerifyOtp::where('email', $user->email)->orderBy('created_at', 'desc')->first();

        if ($now > $check->expired_at) {
            return redirect()->back()->withErrors('error', 'otp expired');
        } 

        if ($check->otp === $request->otp) {
            $user->email_verified_at = $now;
            $user->status = 'verified';
            $user->save();

            return redirect(route('dashboard', absolute: false));
        }


        return redirect()->back();
    }
}
