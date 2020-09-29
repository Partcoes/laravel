<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/16
 * Time: 19:08
 */

namespace App\Services;
use App\Models\AdminResource;
use App\Models\Type;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminUser;
use Illuminate\Support\Facades\DB;
use App\Models\AdminShip;
use App\Services\UserService;
use App\Models\AdminRole;
use App\Models\AdminMenu;
use App\Models\AdminButton;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    /**
     * 无限极分类
     * @param $menu 菜单栏
     * @param int $parent_id 父级id
     * @return array 处理好的数组
     */
    public static function tree($datas,$primaryKey,$parent_id = 0)
    {
        unset($datas['buttonIds']);
        $newDatas = [];
        //$i是reid,这里采用了重新生成下标的需求
        if ($datas){
            foreach($datas as $key => $data)
            {
//                dd($type['parent_id']);
                $newData = self::doSlideBar($data);
                if ($data['parent_id'] == $parent_id){
                    $newData = self::doSlideBar($data);
                    $newDatas[$key] = $newData;
                    $newDatas[$key]['submenu'] = self::tree($datas,$primaryKey,$data[$primaryKey]);
                }
                if(empty($newDatas[$key]['submenu']))
                {
                    unset($newDatas[$key]['submenu']);
                }
            }
        }
        return $newDatas;
    }

    /**处理按钮的种类
     * @param $buttons
     * @return array
     */
    public static function dealButton($buttons)
    {
        if($buttons){
            $alone = [];
            $group = [];
            foreach($buttons as $k => $button)
            {
                if($button -> button_group == 0){
                    $alone[] = $button;
                }elseif($button -> button_group == 1){
                    $group[] = $button;
                }

            }
            return [
                'alone'=>$alone,
                'group'=>$group
            ];
        }
    }

    /**处理左边栏的下标方便注入到adminlet配置
     * @param $menus
     * @return bool
     */
    public static function doSlideBar($menus)
    {
//        echo 1;
        if($menus){
            $configMenu['text'] = $menus['menu_name'];
            $configMenu['url'] = $menus['menu_url'];
            if($menus['icon_status'] == 0)
            {
                $configMenu['icon'] = $menus['icon'];
            }elseif($menus['icon_status'] == 1){
                $configMenu['icon_color'] = $menus['icon'];
            }
            $configMenu['parent_id'] = $menus['parent_id'];
            $configMenu['menu_id'] = $menus['menu_id'];
            if(isset($menus['button'])){
                $configMenu['button'] = $menus['button'];
            }
            return $configMenu;
        }
        return false;

    }

    /**添加按钮
     * @param $formInfo
     * @return bool
     */
    public static function insertMenu($formInfo)
    {
        $rule = [
            'menu_name' => 'required|unique:admin_menu',
            'menu_url' => 'unique:admin_menu',
            'parent_id' => 'required',
            'icon_status' => 'required',
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            unset($formInfo['_token']);
            $formInfo['menu_url'] = empty($formInfo['menu_url'])?'#':$formInfo['menu_url'];
            $pathAndParentId = explode('|',$formInfo['parent_id']);
            $formInfo['parent_id'] = $pathAndParentId[0];
            $formInfo['path'] = isset($pathAndParentId[1])?$pathAndParentId[1]:0;
            $menuObj = new AdminMenu();
            $result = $menuObj -> insertMenu($formInfo);
            return $result;

        }else{
            return false;
        }
    }
    /**添加管理员
     * @param $formInfo 表单信息
     * @return int
     */
    public static function insertAdmin($formInfo)
    {
        unset($formInfo['_token']);
        $rule = [
            'admin_name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:admin_user',
            'password_confirmation' => 'required|same:password',
            'role_id' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            unset($formInfo['password_confirmation']);
            $role_id = $formInfo['role_id'];
            unset($formInfo['role_id']);
            $formInfo['create_time'] = time();
            $formInfo['update_time'] = time();
            $formInfo['password'] = UserService::passwordByMd5($formInfo['password']);
            $formInfo['operator'] = session('admin_login')['admin_name'];
            $roles = [];
            $roleses = [];
            //通过事务为添加管理员并绑定角色
            DB::beginTransaction();
            try {
                $resultForUser = AdminUser::insertAdmin($formInfo);
                foreach($role_id as $k => $role)
                {
                    $roles['admin_id'] = $resultForUser;
                    $roles['role_id'] = $role;
                    $roleses[] = $roles;
                }
//                dd($roleses);
                $resultForShip = AdminShip::insertRoleForAdmin($roleses);
                if($resultForUser && $resultForShip){
                    DB::commit();
                    return true;
                }else{
                    DB::rollBack();
                    return false;
                }
            }catch (\Exception $e){
                DB::rollBack();
                return false;
            }

        }else{
            return false;
        }
    }

    /**删除管理员
     * @param $adminId
     * @return bool
     */
    public static function deleteAdminById($adminId)
    {
        if(empty($adminId)){return false;}
        DB::beginTransaction();
        try{
            $resultForUser = AdminUser::deleteAdminById($adminId);
            $adminId = ['admin_id'=>$adminId];
            $resultForShip = AdminShip::destroyShipByAdminId($adminId);
            if($resultForUser && $resultForShip){
                DB::commit();
                return true;
            }else{
                DB::rollBack();
                return false;
            }
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    /**添加角色
     * @return bool
     */
    public static function insertRole($formInfo)
    {
        $rule = [
            'role_name' => 'required',
            'role_status' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);

        if($vail -> passes()){
            unset($formInfo['_token']);
            $formInfo['create_time'] = time();
            $formInfo['update_time'] = time();
            $result = AdminRole::insertRole($formInfo);
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    /**添加按钮
     * @param $formInfo
     * @return bool
     */
    public static function insertButton($formInfo)
    {
        $rule = [
            'button_name' => 'required',
            'button_url' => 'unique:admin_button',
            'menu_id' => 'required',
            'button_group' =>'required',
            'code' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);
//        dd($formInfo);
        if($vail -> passes()){
            unset($formInfo['_token']);
            $formInfo['button_url'] = empty($formInfo['button_url'])?'#':$formInfo['button_url'];
//            dd($formInfo);
            $result = AdminButton::insertButton($formInfo);
            return $result;
        }else{
            return false;
        }

    }

    public static function updateButton($formInfo)
    {
        $rule = [
            'button_name' => 'required',
            'button_url' => 'required',
            'menu_id' => 'required',
            'button_group' =>'required',
            'code' => 'required',
            'button_id' => 'required'
        ];
        $button_url = AdminButton::getButton($formInfo['button_id']) -> button_url;
        if($button_url != $formInfo['button_url']){
            $rule['button_url'] = 'required|unique:admin_button';
        }
        $vail = Validator::make($formInfo,$rule);
        if(isset($formInfo['rand'])){
            unset($formInfo['rand']);
        }
        if($vail -> passes()){
            $result = AdminButton::updateButton($formInfo,$formInfo['button_id']);
            return $result;
        }else{
            return false;
        }
    }

    /**更新按钮
     * @param $formInfo
     * @param $menuDetail
     * @return bool
     */
    public static function updateMenu($formInfo,$menuDetail)
    {
        $rule = [
            'menu_name' => 'required|unique:admin_menu',
            'menu_url' => 'required|unique:admin_menu',
            'parent_id' => 'required',
            'icon_status' => 'required',
        ];
        $rule['menu_name'] = ($menuDetail -> menu_name == $formInfo['menu_name'])?'required':'required|unique:admin_menu';
        $rule['menu_url'] = ($menuDetail -> menu_url == $formInfo['menu_url'])?'required':'required|unique:admin_menu';
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            unset($formInfo['_token']);
            $pathAndParentId = explode('|',$formInfo['parent_id']);
            $formInfo['parent_id'] = $pathAndParentId[0];
            $formInfo['path'] = isset($pathAndParentId[1])?$pathAndParentId[1]:0;
            $menuObj = new AdminMenu();
            $menuId = $formInfo['menu_id'];
            unset($formInfo['menu_id']);
            if(isset($formInfo['id'])){
                unset($formInfo['id']);
            }
            $result = $menuObj -> updateMenu($formInfo,$menuId);
            return $result;
        }else{
            return false;
        }
    }
    /**修改角色信息
     * @param $request
     * @return bool
     */
    public static function updateRole($request)
    {
        $formInfo = $request -> input();
        $roleId = $formInfo['id'];
        $rule = [
            'role_name' => 'required',
            'role_status' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);

        if($vail -> passes()){
            unset($formInfo['_token']);
            unset($formInfo['id']);
            $formInfo['update_time'] = time();
            $result = AdminRole::updateRoleById($formInfo,$roleId);
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**修改管理员信息
     * @param $request
     * @return bool
     */
    public static function updateAdmin($request)
    {
        $formInfo = $request -> input();
        $file = $request -> file('admin_thumb');
        $thumbSrc = empty($file)?'':self::uploadSingle($file);
        $formInfo['admin_thumb'] = $thumbSrc;
        $rule = [
            'admin_name' => 'required',
            'password' => 'required|min:6|max:16',
            'email' => 'required',
            'role_id' => 'required',
            'admin_status' => 'required',
            'admin_id' => 'required'
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $adminId = $formInfo['admin_id'];
//            $relationShip = $formInfo['role_id'];
            $ship = [];
            $relationShip = [];
            foreach ($formInfo['role_id'] as $k => $role)
            {
                $ship['admin_id'] = $adminId;
                $ship['role_id']  = $role;
                $relationShip[] = $ship;
            }
            $formInfo['password'] = UserService::passwordByMd5($formInfo['password']);
            $formInfo['operator'] = session('admin_login')['admin_name'];
            $formInfo['update_time'] = time();
            unset($formInfo['role_id'],$formInfo['_token'],$formInfo['admin_id']);
            DB::beginTransaction();
            try{
                $resultForAdmin = AdminUser::updateAdminInfo($formInfo,$adminId);
                $resultForShip = AdminShip::updateShip($relationShip,$adminId);
                if($resultForAdmin && $resultForShip){
                    DB::commit();
                    return true;
                }else{
                    echo 3;
                    DB::rollBack();
                    return false;
                }
            }catch (\Exception $e){
                DB::rollBack();
                return false;
            }

        }else{
            echo 2;
            return false;
        }

    }

    /**更新resource资源关系表
     * @param $formInfo
     * @return bool
     */
    public static function updateResourceById($formInfo)
    {
        $rule = [
            'role_id' => 'required',
            'resource_id' => 'required',
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            unset($formInfo['_token']);
            $shipIds = [];
            $roleId = $formInfo['role_id'];
            foreach($formInfo['resource_id'] as $menuId)
            {
                $formInfo['resource_id'] = $menuId;
                $shipIds[] = $formInfo;
            }
            $result = AdminResource::updateShipByRole($shipIds,$roleId);
            if($result){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    /**
     * @param $file 上传的文件 $returnType 返回类型 默认是6
     * @return bool|string 1、成功返回文件名 2、返回源文件名 3、返回扩展名 4、返回临时路径 5、返回上传文件类型
     * 6、 返回文件的路径 例如 /admin/***.jpg
     */
    public static function uploadSingle($file,$returnType = 6,$path = '')
    {
        if(!empty($path)){
            $path = public_path(str_replace('/',"\\\\",$path));
            if(!file_exists($path)){
                $bool = mkdir($path,0777);
                if(!$bool){
                    return false;
                }
            }
//            $path = '"'.$path . '"';
//            config('filesystems.disks.uploads.root',$path);
        }
        if ($file->isValid()) {

            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();     // image/jpeg

            // 上传文件
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            //这里的uploads是配置文件的名称
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            //用config函数读取update配置然后拼接上filename;
            if($bool){
                $fileSrc = str_replace(public_path(),'',config('filesystems.disks.uploads.root'));
//                dd($fileSrc);
                $fileSrc = str_replace("\\",'/',$fileSrc) ."/" . $filename;
                switch ($returnType)
                {
                    case 1 : return $filename;
                    case 2 : return $originalName;
                    case 3 : return $ext;
                    case 4 : return $realPath;
                    case 5 : return $type;
                    case 6 : return $fileSrc;
                    default : return $filename;
                }
            }
            return false;

        }
        return false;
    }

    /**按钮赋权
     * @param $formInfo
     * @return bool
     */
    public static function givePowerForRoleByBtn($formInfo)
    {
        $rule = [
            'role_id' => 'required',
            'resource_id' => 'required',
        ];
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $resources = [];
            unset($formInfo['_token']);
            foreach($formInfo['resource_id'] as $k => $resource)
            {
                $resources[$k]['resource_id'] = $resource;
                $resources[$k]['role_id'] = $formInfo['role_id'];

            }
            $result = AdminResource::updateShipByRole($resources,$formInfo['role_id'],1);
            return $result;
        }else{
            return false;
        }
    }

    /**类似按钮分组
     * @param $buttons
     * @param $menus
     * @return array
     */
    public static function sameMenuIdGroup($buttons,$menus)
    {
        $item = [];
        $menusName = array_column($menus,'menu_name');
        $menuId = array_column($menus,'menu_id');
        $menus = array_combine($menuId,$menusName);
        foreach($buttons as $k=>$v){
            if(!isset($item[$v['menu_id']])){
                $item[$v['menu_id']][]=$v;
            }else{
                $item[$v['menu_id']][]=$v;
            }
        }
        $menusId = array_keys($menus);
        $buttonAndMenu = [];
        foreach($item as $kt => $vt)
        {
            if(in_array($kt,$menusId)){
                $buttonAndMenu[$menus[$kt]] = $vt;
            }
        }
        return $buttonAndMenu;
    }

    public static function insertType($request)
    {
        $rule = [
            'type_name' => 'required|unique:type',
            'type_status' => 'required',
            'parent_id' => 'required'
        ];
        $formInfo = $request -> except('_token');
        $icon = $request -> file('icon') -> store('test');
        $formInfo['icon'] = empty($icon) ?'':$icon;
        $vail = Validator::make($formInfo,$rule);
        if($vail -> passes()){
            $result = Type::insertType($formInfo);
            return $request;
        }else{
            return false;
        }
    }
}