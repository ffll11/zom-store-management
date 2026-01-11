<?php

namespace App\Models;

use App\Traits\UuidSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subfamily extends Model
{
    use HasFactory,UuidSet;
    protected $fillable = ['name', 'slug', 'description', 'family_id'];
    public function family(){
        return $this->belongsTo(Family::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

}
