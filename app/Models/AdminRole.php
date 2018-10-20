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
        $result = self::find($roleId) -> delete();
        return $result;
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