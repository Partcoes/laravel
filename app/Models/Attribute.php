<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attribute';
    protected $primaryKey = 'attr_id';
    public $guarded = [];
    public $timestamps = false;

    /**获取属性列表
     * @param string $where
     * @param bool $isPage
     * @param bool $isToArray
     * @param int $pageSize
     * @return mixed
     */
    public static function getAttrList($where = '',$isPage = true,$isToArray = false, $pageSize = 6)
    {
        if(!empty($where)){
            $base = self::where($where);
        }
        if($isPage){
            if(isset($base)){
                $attrList = $base -> paginate($pageSize);
            }else{
                $attrList = self::paginate($pageSize);
            }
        }else{
            if(isset($base) && $isToArray != true){
                $attrList = $base -> get();
            }elseif(isset($base) && $isToArray == true){
                $attrList = $base -> get() -> toArray();
            }elseif(!isset($base) && $isToArray == true){
                $attrList = self::get() -> toArray();
            }else{
                $attrList = self::get();
            }
        }
        return $attrList;
    }

    /**添加属性
     * @param $formInfo
     * @return mixed
     */
    public static function insertAttr($formInfo)
    {
        $isExist = self::where(['attr_name'=>$formInfo['attr_name'],'typeof_id'=>$formInfo['typeof_id']]) -> get() -> toArray();
        if(empty($isExist)){
            return false;
        }
        $result = self::insert($formInfo);
        return $result;
    }

    /**更改属性状态
     * @param $idAndStatus
     * @return mixed
     */
    public static function updateAttrStatus($idAndStatus)
    {
        $status = $idAndStatus['attr_status'];
        if($status == 1)
        {
            $status = 0;
        }else{
            $status = 1;
        }
        $result = self::where(['attr_id' => $idAndStatus['attr_id']]) -> update(['attr_status' => $status]);
        return $result;
    }

    public static function findOne($attrId)
    {
        $attr = self::find($attrId);
        return $attr;
    }

    public static function updateAttr($formInfo)
    {
        $result = self::find($formInfo['attr_id']) -> update($formInfo);
        return $result;
    }
}
