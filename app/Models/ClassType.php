<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    protected $table = 'class_type';
    protected $primaryKey = 'typeof_id';

    protected $guarded = [];
    public $timestamps = false;

    /**获取类型列表
     * @param bool $isToArray
     * @param bool $isPage
     * @param int $pageSize
     * @param string $typeStatus
     * @return mixed
     */
    public static function getClassesList($isToArray = false,$isPage = true ,$pageSize = 6 ,$typeStatus = '')
    {
        if(!empty($typeStatus)){
            $base = self::where(['type_status' => $typeStatus]);
        }
        if($isPage){
            if(isset($base)){
                $classList = $base -> paginate($pageSize);
            }else{
                $classList = self::paginate($pageSize);
            }
        }else{
            if(isset($base)){
                $classList = $base -> get();
            }else{
                $classList = self::get();
            }
        }
        return $classList;
    }

    /**更改类型状态
     * @param $formInfo
     * @return mixed
     */
    public static function updateClassStatus($formInfo)
    {
        $result = self::where(['typeof_id' => $formInfo['id']]) -> update(['typeof_status' => $formInfo['typeof_status']]);
        return $result;
    }

    /**添加类型
     * @param $formInfo
     * @return mixed
     */
    public static  function insertClass($formInfo)
    {
        $result = self::insert($formInfo);
        return $result;
    }

    public static function getDetail($classId)
    {
        $class = self::find($classId);
        return $class;
    }

    public static function updateClass($formInfo,$typeofId)
    {
        $result = self::find($typeofId) -> update($formInfo);
        return $result;
    }


}
