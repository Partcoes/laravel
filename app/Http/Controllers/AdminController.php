<?php

namespace App\Http\Controllers;

use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Models\AdminRole;
use App\Models\AdminShip;
use App\Services\AdminService;
use App\Services\UserService;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * 后台登录
     */
    public function login(Request $request)
    {
        if ($request -> input())
        {
            $result = UserService::userVerify($request);
            if (is_array($result)){
                session(['admin_login'=>$result]);
                echo "<script>alert('登录成功！')</script>";
                return redirect('admin/index');
            }
        }
        return view('admin.login');
    }

    /**
     * 后台管理的首页
     */
    public function index()
    {
//        $menu = session('menu');
//        dd($menu);
        $user = session('admin_login');
        if (!$user){
            return redirect('admin/login');
        }

//        dd($menu);

//        dd($menus);
//        dd(\Route::current());

//        dd($menus);

//        dd(config('adminlte'));

        return view('admin/index');
    }

    /**
     * @param Request $request
     * @return 管理员列表
     */
    public function getAdminList(Request $request)
    {
        $adminList = AdminUser::getAdminList();
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        return view('admin.admin_list',['users'=>$adminList,'buttons'=>$buttons['group'],'alones'=>$buttons['alone']]);
    }

    /**
     * @param Request $request
     * @return 管理员添加
     */
    public function insertAdmin(Request $request)
    {
        $formInfo = $request -> input();
        if ($formInfo){
            $result = AdminService::insertAdmin($formInfo);
            if($result) {
                return redirect('admin/manager');
            }
        }
        $roleList = AdminRole::getRoleList();
        return view('admin.insert_admin',['roles'=>$roleList]);
    }
    /**
     * @param Request $request
     * @param $adminId 管理员id
     * @return
     */
    public function updateAdminById(Request $request)
    {
        $formInfo = $request -> input();
        if ($formInfo && count($formInfo) > 1) {
            $result = AdminService::updateAdmin($request);
            if($result) {
                return redirect('admin/detail');
            }
        }
        $roleList = AdminRole::getRoleList();
        if(isset($formInfo['id']) == false || empty($formInfo))
        {
            return redirect('admin/manager');
        }
        $adminInfo = AdminUser::getAdminDetail($formInfo['id']);
        $shipDetail = AdminShip::adminGetRole($formInfo['id']);
        return view('admin.update_admin', ['roles' => $roleList,'admin'=>$adminInfo,'ship'=>$shipDetail]);
    }
    /**
     * @param Request $request
     * @return 管理员详情页
     */
    public function adminDetail(Request $request)
    {
        $adminId = $request -> get('id');
        $adminDetail = AdminUser::getAdminDetail($adminId);

        if($adminDetail){
            return view('admin.detail',['detail'=>$adminDetail]);
        }else{
            return redirect('admin/manager');
        }
    }

    /**注意请求方式是ajax
     * @param $adinId
     * @return 返回列表页
     */
    public function deleteAdminById(Request $request)
    {
        $adminId = $request -> get('id');
        if(empty($adminId) || $request -> ajax() == false){return redirect('admin/index');}
        $result = AdminService::deleteAdminById($adminId);
        if($result)
        {
            return  1;
        }else{
            return 0;
        }
    }
    /**
     * 退出登录
     */
    public function logout(Request $request)
    {
        $request -> session() -> forget('admin_login');
        return redirect('admin/login');
    }

    /**
     * 更新缓存
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCache(){
        $useInfo = session('admin_login');
        $result = AdminUser::loginForAdmin($useInfo,1,true);
        return back();
    }
}
