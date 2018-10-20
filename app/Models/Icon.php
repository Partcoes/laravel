<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    protected $table = 'icon';
    protected $primaryKey = 'icon_id';
    public static function getAllIcon()
    {
        $icon = self::get();
        return $icon;
    }
}
