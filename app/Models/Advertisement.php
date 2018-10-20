<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisement';
    protected $primaryKey = 'advertise_id';

    /**
     * 获取广告位商品信息
     * @return 返回广告栏商品
     */
    public static function getAdvertise()
    {
        $advertisement = self::get();
//        dd($advertisement);
        return $advertisement;
    }
}
