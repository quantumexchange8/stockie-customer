<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Mail\CustomerResetPasswordMail;
use Illuminate\Support\Facades\Mail;

class Customer extends Authenticatable implements HasMedia, CanResetPasswordContract

{

    // first time login status = 0
    // else status = 1

    use Notifiable, InteractsWithMedia, CanResetPassword;

    protected $table = 'customers';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'verification_code',
        'verification_code_expires_at',
        'ranking',
        'point',
        'uuid',
        'first_login',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'verification_code_expires_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));

        // Send the custom email
        Mail::to($this->email)->send(new CustomerResetPasswordMail($token, $this->email));
    }
}
