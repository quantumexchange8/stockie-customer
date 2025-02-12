<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigDiscount extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "config_discounts";

    protected $dates = ['discount_from', 'discount_to'];

    protected $casts = [
        'discount_from' => 'datetime',
        'discount_to' => 'datetime',
    ];
    

    protected $fillable = [
        'name',
        'type',
        'rate',
        'discount_from',
        'discount_to',
    ];

    public function discountItems(): HasMany
    {
        return $this->hasMany(ConfigDiscountItem::class, 'discount_id');
    }

    /**
     * Product Model
     * Get the products that has this discount currently.
     */
    public function discountedProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'discount_id');
    }
}
