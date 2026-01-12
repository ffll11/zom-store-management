<?php

namespace App\Models;

use App\Traits\UuidSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, UuidSet;

    protected $fillable = ['name' , 'slug','description','country_id'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function country(){
    return $this->belongsTo(Country::class);
    }

    public function Props (){
        return $this->belongsTo(Product::class ,'brand_id');
    }
}
