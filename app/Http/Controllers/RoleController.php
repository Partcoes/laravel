<?php

namespace App\Http\Controllers;

use App\Models\AdminResource;
use App\Models\AdminRole;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**角色列表
     * @param Request $request
     * @return
     */
   public function getRoleList(Request $request)
   {
       $roleList = AdminRole::getRoleList();
       $menuUri = $request -> path();
       $menuId = AdminMenu::getMenuIdForNow($menuUri);
       $buttons = AdminButton::getButtonHad($menuId);
       $buttons = AdminService::dealButton($buttons);
       return view('role.role_list',['roles'=>$roleList,'buttons'=>$buttons['group'],'alones'=>$buttons['alone']]);
   }

   public function insertRole(Request $request)
   {
        $formInfo = $request -> input();
        if($formInfo){
            $result = AdminService::insertRole($formInfo);
            return redirect('role/manager');
        }
        return view('role.insert_role');
   }

    /**
     * 删除角色
     * @param Request $request
     * @return
     */
    public function deleteRoleById(Request $request)
    {
        $adminId = $request -> get('id');
        if(empty($adminId) || $request -> ajax() == false){return redirect('admin/index');}
        $result = AdminRole::deleteRoleById($adminId);
        if($result)
        {
            return  1;
        }else{
            return 0;
        }
    }

    /**修改角色
     * @param Request $request
     * @return
     */
    public function updateRoleById(Request $request)
    {
        $formInfo = $request -> input();
        if ($formInfo && count($formInfo) > 1) {
            $result = AdminService::updateRole($request);
            if($result) {
                return redirect('role/manager');
            }
        }
        if(isset($formInfo['id']) == false || empty($formInfo))
        {
            return redirect('admin/manager');
        }
        $role = AdminRole::getRoleById($formInfo['id']);
        return view('role.update_role',['role'=>$role]);
    }

    public function givePowerForRole( Request $request)
    {
        $formInfo = $request -> post();
        if($request -> ajax() && isset($request -> post()['role_id'])){
            $roleId =  $request -> post()['role_id'];
            $menusById = AdminResource::roleGetResource([$roleId]);
            if(isset($menusById['type0'])){
                $menuIds = json_encode($menusById['type0']);
                return $menuIds;
            }

            return false;
        }elseif($formInfo && count($formInfo) > 1){
            $result = AdminService::updateResourceById($formInfo);
            return redirect('role/manager');
        }
        $roleList = AdminRole::getRoleList();
        $menuList = AdminMenu::getAllMenu('false');

//        dd($menuList);
        $menus = AdminService::tree($menuList,'menu_id');
        return view('menu.give_power',['roles' => $roleList,'menus' => $menus]);
    }
}
