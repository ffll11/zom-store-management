<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'discount_type', 'discount_value', 'is_active', 'start_date', 'end_date' ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());

    }

    public function promotionProducts()
    {
        return $this->hasMany(PromotionProduct::class);
    }
}
