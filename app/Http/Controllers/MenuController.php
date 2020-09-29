<?php

namespace App\Http\Controllers;

use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;
use App\Models\Icon;

class MenuController extends Controller
{
    /**菜单列表
     * @param Request $request
     * @return
     */
    public function getMenuList(Request $request)
    {
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        $menuList = AdminMenu::getAllMenu(false,true,7);
        return view('menu.menu_list',['alones'=>$buttons['alone'],'buttons'=>$buttons['group'],'menus'=>$menuList]);
    }

    /**添加菜单
     * @param Request $request
     * @return
     */
    public function insertMenu(Request $request)
    {
        $menuList = AdminMenu::getAllMenu(false);
        $formInfo = $request -> input();
        if($formInfo){
            $result = AdminService::insertMenu($formInfo,$menuList);
            if($result){

//                $rote = file_get_contents(route_path());
                return redirect('menu/manager');
            }else{
                return redirect('menu/add');
            }
        }
        $iconList = Icon::getAllIcon();
        return view('menu.insert_menu',['icons'=>$iconList,'menus'=>$menuList]);
    }

    public function updateMenuById(Request $request)
    {
        $menuList = AdminMenu::getAllMenu(false);
        $formInfo = $request -> input();
        if($formInfo && count($formInfo) > 1){
            $menuDetail = session('menu_detail');
            $result = AdminService::updateMenu($formInfo,$menuDetail);
            if($result){
                return redirect('menu/manager');
            }else{
                return redirect('menu/update?id='.$menuDetail -> menu_id);
            }
        }
//        dd($formInfo);
        $menuDetail = AdminMenu::getMenuById($formInfo['id']);
        session() -> flash('menu_detail',$menuDetail);
        $iconList = Icon::getAllIcon();
        return view('menu.update_menu',['menu'=>$menuDetail,'menus'=>$menuList,'icons'=>$iconList]);
    }

    public function deleteMenuById(Request $request)
    {
        $adminId = $request -> get('id');
        if(empty($adminId) || $request -> ajax() == false){return redirect('admin/index');}
        $result = AdminMenu::deleteMenuById($adminId);
        if($result)
        {
            return  1;
        }else{
            return 0;
        }
    }

}
