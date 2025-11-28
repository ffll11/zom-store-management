<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','image_url','sku','slug','is_active','description', 'price', 'brand_id', 'subfamily_id' ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(Subfamily::class);
    }

    public function promotionProducts()
    {
        return $this->hasMany(PromotionProduct::class);
    }
}
