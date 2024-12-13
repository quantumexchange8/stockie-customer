<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class  Ranking extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = "rankings";

    protected $fillable = [
        'name',
        'min_amount',
        'reward',
        'icon',
    ];


    public function rankingRewards(): HasMany
    {
        return $this->hasMany(RankingReward::class, 'ranking_id');
    }
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'ranking');
    }
}
