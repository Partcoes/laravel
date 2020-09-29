<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photo';
    public $timestamps = false;
    protected $primaryKey = 'photo_id';
    protected $guarded = [];

    public static function insertPhoto($photos)
    {
        $result = self::insert($photos);
        return $result;
    }
}
