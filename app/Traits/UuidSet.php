<?php

namespace App\Traits;
trait UuidSet{
    protected static function bootUuidSet()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}