<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Customer extends Authenticatable implements HasMedia

{

    // first time login status = 0
    // else status = 1

    use Notifiable, InteractsWithMedia;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'verification_code_expires_at' => 'datetime',
    ];
}
