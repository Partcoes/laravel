<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/26
 * Time: 16:53
 */

namespace App\Services;




use App\Models\Attribute;
use App\Models\ClassType;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Models\Photo;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Type;

class TypeService
{
    public static function insertAttr($request)
    {
        $formInfo = $request -> except('_token');
        $rule = [
            'attr_name' => 'required|unique:attribute',
            'attr_status' => 'required',
            'typeof_id' =>'required',
            'attr_value' => 'required',
        ];
//        dd($formInfo);
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $formInfo['attr_value'] = str_replace('，',',',$formInfo['attr_value']);
            $result = Attribute::insertAttr($formInfo);
            return $result;
        }else{
            return false;
        }
    }

    public static function updatetAttr($request)
    {
        $formInfo = $request -> except('_token');
        $rule = [
            'attr_name' => 'required',
            'attr_status' => 'required',
            'typeof_id' =>'required',
            'attr_type' => 'required',
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $formInfo['attr_value'] = str_replace('，',',',$formInfo['attr_value']);
            $result = Attribute::updateAttr($formInfo);
            return $result;
        }else{
            return false;
        }
    }

    public static function updateClass($request)
    {
        $formInfo = $request -> except('_token');
        $rule = [
            'typeof_name' => 'required',
            'typeof_num' =>'required|alpha_num',
            'typeof_status' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $id = $formInfo['id'];
            unset($formInfo['id']);
            $result = ClassType::updateClass($formInfo,$id);
            return $request;
        }else{
            return false;
        }
    }
    public static function insertClass($request)
    {
        $formInfo = $request -> except('_token');
        $rule = [
            'typeof_name' => 'required',
            'typeof_num' =>'required|alpha_num',
            'typeof_status' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $result = ClassType::insertClass($formInfo);
            return $request;
        }else{
            return false;
        }
    }

    public static function updateType($request)
    {
        $rule = [
            'type_name' => 'required',
            'type_status' => 'required',
            'parent_id' => 'required',
            'type_id' => 'required'
        ];
        $formInfo = $request -> except(['_token','rand']);
        if(isset($formInfo['icon'])) {
            $icon = $request->file('icon')->store('test');
            $formInfo['icon'] = empty($icon) ? '' : $icon;
        }
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $result = Type::updateType($formInfo['type_id'],$formInfo);
            return $request;
        }else{
            return false;
        }
    }

    public static function dealAttr($goodsId,$attrValue,$attrPrice ,$attrId)
    {
        if ($attrValue) {
            foreach ($attrValue as $key => $value) {
                if ($value && is_array($value)) {
                    foreach ($value as $k => $v) {
                        $data[] = [
                            'goods_id'=>$goodsId,
                            'attr_id'=>$key,
                            'attr_value'=>$value[$k],
                            'add_price'=>$attrPrice[$key][$k],
                        ];
                    }
                }else{
                        $data[] = [
                            'goods_id'=>$goodsId,
                            'attr_id'=>$attrId[1],
                            'attr_value'=>$value,
                            'add_price'=>0,
                        ];
                }
            }
        }
        return $data;
    }

    public static function insertGoods($formInfo)
    {
        $formInfo['goods_sn'] = self::createSn('NUM-');
        $formInfo['is_hot'] = empty($formInfo['is_hot'])?0:$formInfo['is_hot'];
        $formInfo['is_up'] = empty($formInfo['is_up'])?0:$formInfo['is_up'];
        $formInfo['goods_img'] = $formInfo['goods_img'] -> store('goods');
        $rule = [
            'goods_name' => 'required',
            'goods_desc' => 'required',
            'shop_price' => 'required',
            'goods_number' => 'required|alpha_num',
            'is_hot' => 'required|alpha_num',
            'is_up' => 'required|alpha_num',
            'brand_id' => 'required|alpha_num',
            'type_id' => 'required|alpha_num',
            'attr_value_list' => 'required',
            'attr_price_list' => 'required',
            'photo_desc' => 'required',
            'photo_src' => 'required',
            'goods_img' => 'required',
            'goods_sn' => 'required|unique:goods',

        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $formInfo['create_time'] = time();
            $formInfo['update_time'] = time();
            $files = $formInfo['photo_src'];
            $filesDesc = $formInfo['photo_desc'];
            $attrValList = $formInfo['attr_value_list'];
            $attrPriceList = $formInfo['attr_price_list'];
            $attrId = '';
            if(isset($formInfo['attr_id_list'])){
                $attrId = array_unique($formInfo['attr_id_list']);
                unset($formInfo['attr_id_list']);
            }
            unset($formInfo['photo_src'],$formInfo['photo_desc'],$formInfo['attr_value_list'],$formInfo['attr_price_list']);
            DB::beginTransaction();
            try{
                $goodsId = Goods::insertGoods($formInfo);
                $uploadFiles = self::groupUploads($files,$filesDesc,$goodsId);
                $dealAttr = self::dealAttr($goodsId,$attrValList,$attrPriceList,$attrId);
                $resultPhoto = Photo::insertPhoto($uploadFiles);
                $resultGoodsAttr = GoodsAttr::insertGoodsAttr($dealAttr);

                if($goodsId && $resultPhoto && $resultGoodsAttr){
                    DB::commit();
                    return true;
                }else{
                    DB::rollBack();
                    return false;
                }
            }catch (\Exception $e){
//                dd(3);
                dd($e -> getMessage());
                DB::rollBack();
                return false;
            }
        }
    }

    /**生成唯一编号或货号
     * @param string $Identification
     * @return string
     */
    public static function createSn($Identification = 'SN-')
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $Identification . $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    public static function groupUploads($files,$filesDesc,$goodsId)
    {
        if($files){
            $goodsSrc = [];
            foreach( $files as $k => $file)
            {
                if(is_object($file)){
                    $goodsSrc[$k]['photo_src'] = $file -> store('goods');
                }else{
                    $goodsSrc[$k]['photo_src'] = $file;
                }
                $goodsSrc[$k]['photo_desc'] = $filesDesc[$k];
                $goodsSrc[$k]['goods_id'] = $goodsId;
            }
            return $goodsSrc;
        }
    }

    /**笛卡尔积
     * @param $sets
     * @return array
     */
    public static function CartesianProduct($sets){

        // 保存结果
        $result = array();

        // 循环遍历集合数据
        for($i=0,$count=count($sets); $i<$count-1; $i++){

            // 初始化
            if($i==0){
                $result = $sets[$i];
            }

            // 保存临时数据
            $tmp = array();

            // 结果与下一个集合计算笛卡尔积
            foreach($result as $res){
                foreach($sets[$i+1] as $set){
                    $tmp[] = $res.$set;
                }
            }

            // 将笛卡尔积写入结果
            $result = $tmp;

        }

        return $result;

    }

    public static function groupForSame($data,$primary = 'menu_id')
    {
        $item = [];
        foreach($data as $k=>$v)
        {
            if(!isset($item[$v[$primary]])){
                $item[$v[$primary]][]=$v;
            }else{
                $item[$v[$primary]][]=$v;
            }
        }
        return $item;
    }


}