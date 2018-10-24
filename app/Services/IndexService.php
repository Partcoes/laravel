<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/10
 * Time: 10:07
 */
namespace App\Services;

use App\Models\Type;
use App\Models\Goods;

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
     * 根据分类id 获取列表
     * @param $type_id 分类id
     * @return mixed 获取的商品列表
     */
    public static function getListForTypeId($type_id)
    {
        $goodsList = Goods::getGoodsListForType($type_id);
        $goodsList = self::groupByNum($goodsList,5);
        return $goodsList;
    }

    public static function getTypeList()
    {
//        $types = self::tree(Type::getTypeList('',false,false),'type_id');
        $types = self::createPath(Type::getTypeList('',true,true)['data'],'type_id',true,'-');
        dd($types);
        return $types;
    }
    /**
     * 无限极分类方法
     * @param $typeInfo 要进行无限极分类的数据
     * @param int $parent_id 数据中的父级id
     * @return array 返回值是处理好的数组
     */
    public static function tree($typeInfo,$primaryKey = 'type_id',$parent_id = 0)
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
                    $newTypeInfo[$key]['son'] = self::tree($typeInfo,$primaryKey,$type[$primaryKey]);
                    $i++;
                }
            }
        }
        return $newTypeInfo;
    }

    /**
     * @param $datas 要分组的数据
     * @param int $num 分组的长度
     * @return 分好组的数组
     */
    public static function groupByNum($datas,$num = 5)
    {
        if(!$datas){
            return false;
        }
        $newArr = array_chunk($datas,$num);
        return $newArr;
    }

    /**处理path排序
     * @param $typeInfo
     * @param string $primaryKey
     * @param int $parent_id
     * @return array
     */
    public static function createPath($typeInfo,$primaryKey = 'type_id',$path = '',$pathDelimit = '-',$parent_id = 0)
    {
        $newTypeInfo = [];
        //$i是reid,这里采用了重新生成下标的需求
        $i = 0;
        if ($typeInfo){
            foreach($typeInfo as $key => $type)
            {
                if(!empty($path) && $type['parent_id'] != 0)
                {
                    $type['path'] = $type['parent_id'].$pathDelimit.$type['type_id'];
                }elseif($type['parent_id'] == 0){
                    $type['path'] = $type['parent_id'];
                }
                $newTypeInfo[] = $type;
            }
        }
        array_multisort(array_column($newTypeInfo,'path'),SORT_ASC,$newTypeInfo);
        return $newTypeInfo;
    }

}