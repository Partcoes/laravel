<?php

namespace App\Http\Controllers;

use App\Services\IndexService;
use App\Services\TypeService;
use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;
use App\Models\Type;
class TypeController extends Controller
{
    public function getTypeList(Request $request)
    {
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        $typeList = IndexService::getTypeList();
        return view('type.type_list',['alones' => $buttons['alone'],'buttons' => $buttons['group'],'types' => $typeList]);
    }

    public function insertType(Request $request)
    {
        $formInfo = $request -> except('_token');
        if($formInfo){
            $result = AdminService::insertType($request);
            if($result){
                return redirect('type/manager') -> with('status','添加成功');
            }else{
                return redirect('type/add');
            }
        }
        $typeList = IndexService::tree(Type::getTypeList('',false),'type_id',0,true);
        return view('type.insert_type',['types' => $typeList]);
    }
    public function updateTypeStatus(Request $request)
    {
        if(!($request -> ajax())){
            return false;
        }
        $idAndStatus = $request -> except('_token');
        $result = Type::updateTypeStatus($idAndStatus);
        return $result;
    }

    public function updateType(Request $request)
    {
        if($request -> except('_token') && count($request -> except('_token')) > 1){
            $result = TypeService::updateType($request);
            if($result){
                return redirect('type/manager');
            }
        }
        $typeDetail = Type::getOneType($request -> get('rand'));
        $typeList = IndexService::tree(Type::getTypeList('',false),'type_id',0,true);
        return view('type.update_type',['types' => $typeList,'typed' => $typeDetail,'rand' => $request -> get('rand')]);
    }
}
