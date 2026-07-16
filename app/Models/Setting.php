<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'school_name',
        'arrival_time',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::first();

        return $setting?->{$key} ?? $default;
    }
}
