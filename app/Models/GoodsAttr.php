<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsAttr extends Model
{
    //
    protected $table = 'goods_attr';
    protected $primaryKey = 'goods_attr_id';


    public static function getAttrValById($attrId,$isToArray = false,$column = ['*'])
    {
        $attrVal = self::where($attrId) -> get($column);
        if($isToArray == true && $attrVal != ''){
            $attrVal = $attrVal -> toArray();
        }
        return $attrVal;
    }

    public static  function insertGoodsAttr($goodsAttr)
    {
        $result = self::insert($goodsAttr);
        return $result;
    }
}
