<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/17
 * Time: 9:28
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//use Zizaco\Entrust\EntrustRole;

class AdminShip extends Model
{
    protected $table = 'admin_ship';
    protected $primaryKey = false;
    public $timestamps = false;
    protected $guarded = [];
    /**获取管理员所拥有的权限
     * @param $adminId 管理员id
     * @return array 角色id
     */
    public static function adminGetRole($adminId)
    {
//        dd($adminId);
        $roles = self::where(['admin_id' => $adminId]) -> get(['role_id']) -> toArray();
        $roleIds = array_column($roles,'role_id');

        sort($roleIds);
        return $roleIds;
    }

    /**为管理员绑定角色
     * @param $roleId 管理员拥有的角色id
     * @return mixed
     */
    public static function insertRoleForAdmin($roleId){

        $result = self::insert($roleId);
        return $result;
    }

    /**
     * 为管理员解除关系
     * @param $adminId 要解除的关系
     * @return mixed
     */
    public static function destroyShipByAdminId($adminId)
    {
        $result = self::where($adminId) -> delete();
        if($result == 0){
            return false;
        }
        return $result;
    }

    /**修改管理员与角色的关系
     * @param $relation 管理员对应的角色关系
     * @param $adminId 管理员id
     * @return mixed
     */
    public static function updateShip($relation,$adminId)
    {
        DB::beginTransaction();
        try {
            $batchDelete = self::where(['admin_id' => $adminId])->delete();
            $batchInsert = self::insert($relation);
            if ($batchDelete && $batchInsert) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }

}