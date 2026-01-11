<?php

namespace App\Models;

use App\Traits\UuidSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory ;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['name', 'slug', 'description'];
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

}
