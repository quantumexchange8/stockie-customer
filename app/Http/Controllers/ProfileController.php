<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
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

        return redirect()->route('dashboard');
    }
    
    public function getUserData()
    {

        $users = Customer::where('id', Auth::user()->id)->first();

        return response()->json($users);
    }
}
