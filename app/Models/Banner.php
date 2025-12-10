<?php

namespace App\Models;

use App\Traits\UuidSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory ,UuidSet;
    protected $table = 'banner';
    protected $fillable = ['name', 'image_url', 'description', 'is_active', 'start_date', 'end_date' ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());

    }

}
