<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';
    protected $primaryKey = 'type_id';
    protected $guarded = [];
    public $timestamps = false;
    /**
     * 获取侧边栏分类信息
     * @return 返回关联查询到的数据 否则返回false
     */
    public static function getTypeOfInfo()
    {
        return self::all() -> toArray();
    }

    public static function getTypeList($typeStatus = '' , $isPage = true, $isToArray = false, $pageSize = 6)
    {
        if(!empty($typeStatus)){
            $base = self::where($typeStatus);
        }
        if($isPage){
            if(isset($base)){
                $typeList = $base -> paginate($pageSize);
            }else{
                $typeList = self::paginate($pageSize);
//                dd($typeList);
            }
        }else{
            if(isset($base)){
                $typeList = $base -> get();
            }else{
                $typeList = self::get();
            }
        }
        if($isToArray){
            $typeList = $typeList -> toArray();
        }
        return $typeList;
    }

    /**添加分类
     * @param $formInfo 表单信息
     * @return mixed
     */
    public static function insertType($formInfo)
    {
        $result = self::insert($formInfo);
        return $result;
    }

    public static function updateTypeStatus($formInfo)
    {
        $result = self::where(['type_id' => $formInfo['rand']]) -> update(['is_delete' => $formInfo['status']]);
        return $result;
    }
    public static function getOneType($typeId)
    {
        $typeOne = self::find($typeId);
        return $typeOne;
    }

    public static function updateType($typeId,$typeInfo)
    {
        $result = self::where(['type_id' => $typeId]) -> update($typeInfo);
        return $result;
    }
}
