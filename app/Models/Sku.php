<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $table = 'sku';
    public $timestamps = false;
    protected $guarded = [];
    protected $primaryKey = 'sku_id';

    public function getSkuList($where = '',$isPage = true,$isToArray = false,$pageSize = 6){
        if(!empty($where)){
            $base = self::where($where);
        }
        if($isPage && $isToArray != true){
            if(isset($base)){
                $skuList = $base -> paginate($pageSize);
            }else{
                $skuList = self::paginate($pageSize);
            }
        }else{
            if(isset($base) && $isToArray != true){
                $skuList = $base -> get();
            }elseif(isset($base) && $isToArray == true){
                $skuList = $base -> get() -> toArray();
            }elseif(!isset($base) && $isToArray == true){
                $skuList = self::get() -> toArray();
            }else{
                $skuList = self::get();
            }
        }
        return $attrList;
    }
}
