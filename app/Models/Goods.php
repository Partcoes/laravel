<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey = 'type_id';

    /**
     * 获取小米明星榜的商品
     * @return 返回最贵的5件商品
     */
    public static function getTop4()
    {
        $topForGoods = self::orderBy('shop_price','desc')-> limit(5) -> get();
        return $topForGoods;
    }

    public static function getDetail($id)
    {
        $goodsDetail = self::where(['goods_id'=>$id]) -> get();
//        dd($goodsDetail);
    }


}
