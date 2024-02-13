<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = "settings";
    protected $guarded = [];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    public static function sync($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function valueByKey($key)
    {
        return self::where('key', $key)->first()?->value;
    }
}
