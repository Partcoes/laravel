<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ClassType;
use App\Models\GoodsAttr;
use App\Services\IndexService;
use App\Services\TypeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttrController extends Controller
{
    public function getAttrList(Request $request)
    {
        $buttons = IndexService::getButtonsByPage($request);
        $typeof_id = $request -> get('id');
        $attrList = Attribute::getAttrList(['typeof_id' => $typeof_id]);
//        dd($attrList);
        return view('attr.attr_list',['attrs' => $attrList,'alones' => $buttons['alone'],'buttons' => $buttons['group'],'id' => $typeof_id]);
    }

    public function insertAttr(Request $request)
    {
        if($request -> except('_token')){

            $result = TypeService::insertAttr($request);
            if($result){
                return redirect('typeof/manager');
            }
        }
//        dd($request -> except('_token'));
        $attrVal = GoodsAttr::getAttrValById(['attr_id'=>19]);
        $classTypes = ClassType::getClassesList(false,false,'');
        return view('attr.insert_attr',['classes' => $classTypes]);
    }

    public function updateAttrStatus(Request $request)
    {
        if(!($request -> ajax())){
            return false;
        }
        $idAndStatus = $request -> except('_token');
        $result = Attribute::updateAttrStatus($idAndStatus);
        return $result;


    }

    public function updateAttr(Request $request)
    {
        if($request -> except('_token') && count($request -> except('_token')) > 1){
            $result = TypeService::updatetAttr($request);
            if($result){
                return redirect('typeof/manager');
            }
        }
        $classTypes = ClassType::getClassesList(false,false,'');
        $attr = Attribute::findOne($request -> except('_token')['attr_id']);
        return view('attr.update_attr',['classes' => $classTypes,'attr'=>$attr]);
    }
}
