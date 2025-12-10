<?php

namespace App\Models;

use App\Traits\UuidSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory ,UuidSet;
    protected $fillable = ['name', 'slug', 'description', 'subcategory_id'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function subfamilies(){
        return $this->hasMany(Subfamily::class);
    }
}
