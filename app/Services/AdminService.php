<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/16
 * Time: 19:08
 */

namespace App\Services;


class AdminService
{
    /**
     * 无限极分类
     * @param $menu 菜单栏
     * @param int $parent_id 父级id
     * @return array 处理好的数组
     */
    public static function tree($typeInfo,$parent_id = 0)
    {
        $newTypeInfo = [];
        //$i是reid,这里采用了重新生成下标的需求
        if ($typeInfo){
            foreach($typeInfo as $key => $type)
            {
//                dd($type['parent_id']);
//                dump($type);
                if ($type['parent_id'] == $parent_id){
                    $newTypeInfo[$key] = $type;
                    $newTypeInfo[$key]['submenu'] = self::tree($typeInfo,$type['type_id']);
                }
            }
        }
        return $newTypeInfo;
    }
}