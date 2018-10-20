<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminShip;
use App\Models\AdminRole;

class AdminUser extends Model
{
    protected $table = 'admin_user';
    protected  $primaryKey = 'admin_id';
    public $timestamps = false;
    //修改的黑名单
    protected $guarded = [];
    //修改的白名单
    //    protected $fillable = [];
    /**
     * @param $userInfo 表单用户信息
     * @param int $status 状态是否是1 即正常使用
     * @return bool 成功返回数组，失败返回false
     */
    public static function loginForAdmin($userInfo,$status = 1,$upMenu = false)
    {
        if($upMenu == false) {
            $userInfo['admin_status'] = $status;
            $result = self::where($userInfo)->first();
        }else{
//            dd($upMenu);
            $result = $userInfo;
        }
        if ($result) {
//            dd($userInfo);
            if(is_object($result)){
                $result = $result -> toArray();
            }
            if(isset($result['admin_id'])){
                if($result['admin_type'] == 1){
                    $menus = AdminMenu::getAllMenu(true,false,6,false);
                    $buttons = AdminButton::getAllButton();
                    $buttonIds = array_column($buttons,'button_id');
                    //当点击这个页面是，点击按钮的时候传入按钮的id，判断这id是否在有权限的id数组里
                    $menus['buttonIds'] = $buttonIds;
                }else {
                    $roleIds = AdminShip::AdminGetRole($result['admin_id']);
                    $resourceIds = AdminResource::roleGetResource($roleIds);
//                dd($resourceIds['type1']);
                    if (isset($resourceIds['type0'])) {
                        $menus = AdminMenu::resourGetMenu($resourceIds['type0']);
                        $menus['buttonIds'] = [];
                    }
                    if (isset($resourceIds['type1'])) {
                        $buttons = AdminButton::reIdGetButton($resourceIds['type1']);
                    }
                }
                    if($buttons && $menus)
                    {
                        $buttonsIds = array_column($buttons,'button_id');
                        $menus['buttonIds'] = $buttonsIds;
                    }
                session(['menu'=>$menus]);
//                dd(session('menu'));
            }
//            dd($result);
            return $result;
        }
        return false;
    }

    /**
     * @return mixed 管理员列表
     */
    public static function getAdminList()
    {
        $adminList = self::paginate(6);
        return $adminList;
    }

    public static function getAdminDetail($adminId){
        $adminDetail = self::find($adminId);
        return $adminDetail;
    }
    /**
     * @param $adminId 管理员id
     * @return mixed 删除结果
     */
    public static function deleteAdminById($adminId)
    {
        $result = self::find($adminId) -> delete();
        return $result;
    }

    /**添加管理员
     * @param $formInfo 表单信息
     * @return mixed 添加进去的最后一条id
     */
    public static function insertAdmin($formInfo)
    {
        $result = self::insertGetId($formInfo);
        return $result;
    }

    /**修改管理员信息
     * @param $formInfo 表单信息
     * @param $adminId 管理员id
     * @return mixed
     */
    public static function updateAdminInfo($formInfo,$adminId)
    {
        $result = self::find($adminId) -> update($formInfo);
        return $result;
    }

}
