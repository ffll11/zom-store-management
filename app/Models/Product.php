<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'price', 'brand_id', 'subfamily_id', , 'image_url'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(Subfamily::class);
    }

}
