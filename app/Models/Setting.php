<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "settings";

    protected $fillable = [
        'name',
        'type',
        'value',
        'value_type',
        'point',
    ];

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()->logAll();
    // }
}
