<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','image_url','sku','slug','is_active','description', 'price','sale_price', 'brand_id', 'subfamily_id','is_on_sale' ,'discount_value','discount_type'];
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeOnSale($query)
    {
        return $query->where('is_on_sale', 1);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(Subfamily::class);
    }

}
