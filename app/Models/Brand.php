<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table  = 'brand';
    protected $primaryKey = 'brand_id';

    public static function getBrandList($isEnable = 1 ,$isPage = true,$pageSize = 8,$column = ['*'])
    {
        $base = self::where(['brand_status' => $isEnable]);
        if($isPage == true){
            $brandList = $base -> paginate($pageSize);
        }elseif($isPage != true){
            $brandList = $base -> get(empty($column)?['*']:$column);
        }else{
            $brandList = self::get();
        }
        return $brandList;
    }
}
