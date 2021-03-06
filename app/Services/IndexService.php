<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/10
 * Time: 10:07
 */
namespace App\Services;

use App\Models\Type;

class IndexService
{
    /**
     * 处理类型数据的方法
     * @return 处理好的分类数据 否则返回false
     */
    public static function getTypeOfInfo()
    {
        $typeInfo = Type::getTypeOfInfo();
        return self::tree($typeInfo);

    }

    /**
     * 无限极分类方法
     * @param $typeInfo 要进行无限极分类的数据
     * @param int $parent_id 数据中的父级id
     * @return array 返回值是处理好的数组
     */
    public static function tree($typeInfo,$parent_id = 0)
    {
        $newTypeInfo = [];
        //$i是reid,这里采用了重新生成下标的需求
        $i = 0;
        if ($typeInfo){
            foreach($typeInfo as $key => $type)
            {
//                dd($type['parent_id']);
//                dump($type);
                if ($type['parent_id'] == $parent_id){
                    $type['reid'] = $i;
                    $newTypeInfo[$key] = $type;
                    $newTypeInfo[$key]['son'] = self::tree($typeInfo,$type['type_id']);
                    $i++;
                }
            }
        }
        return $newTypeInfo;
    }

}