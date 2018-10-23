<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
//    protected $primaryKey = 'type_id';
    protected $primaryKey = 'goods_id';
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

    /**
     * @param $type_id 类型id
     * @return mixed 返回当前分类下所有商品信息
     */
    public static function getGoodsListForType($type_id)
    {
        $goodsList = self::where(['type_id'=>$type_id]) -> get() -> toArray();
        return $goodsList;
    }

    public static function getGoodsList($isUp = 1 , $isHot = 0 , $isPage = true,$pageSize = 8)
    {
        $pageSize = empty($pageSize)?6:$pageSize;
        $base = self::where(['is_up' => $isUp]);
        if($isHot == 1){
            $base = $base -> where(['is_hot' => $isHot]);
        }elseif(!$isPage){
            $goodsList = $base -> get();
        }else{
            $goodsList = $base -> paginate($pageSize);
        }
        return $goodsList;
    }


}
