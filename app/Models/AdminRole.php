<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/17
 * Time: 8:45
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
//use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRole extends Model
{
    protected $table = 'admin_role';
    protected $primaryKey = 'role_id';
    public $timestamps = false;

    /**获取角色列表
     * @return mixed
     */
    public static function getRoleList()
    {
        $roleList = self::get();
        return $roleList;
    }

    /**添加角色
     * @param $formInfo 表单信息
     * @return mixed
     */
    public static function insertRole($formInfo)
    {
        $result = self::insert($formInfo);
        return $result;
    }

    /**删除单个角色
     * @param $roleId 角色id
     * @return mixed
     */
    public static function deleteRoleById($roleId){
        DB::beginTransaction();
        try {
            $deleteRole = self::find($roleId) -> delete();
            $deleteResource = AdminResource::deleteResourceByRoleId($roleId);
//            dump($deleteResource);
            if ($deleteRole && $deleteResource) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }catch (\Exception $e){
            Log::error($e -> getMessage());
            DB::rollBack();
            return false;
        }
    }

    public static function getRoleById($roleId)
    {
        $role = self::find($roleId);
        return $role;
    }

    public static function updateRoleById($formInfo,$roleId)
    {
        $result = self::where(['role_id'=>$roleId]) -> update($formInfo);
        return $result;
    }
}