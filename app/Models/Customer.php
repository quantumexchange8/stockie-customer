<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable

{

    use Notifiable;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'verification_code_expires_at' => 'datetime',
    ];
}
