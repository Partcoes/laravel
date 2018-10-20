<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/17
 * Time: 9:25
 */

namespace App\Models;

//use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminMenu extends Model
{
    protected $table = 'admin_menu';
    protected $primaryKey = 'menu_id';
    public $timestamps = false;
    protected $guarded = [];

    /**根据menuIds获取所有的菜单
     * @param $menu_id 数组menuIds
     * @return mixed
     */
    public static function resourGetMenu($menu_id)
    {
        $menu = self::whereIn('menu_id',$menu_id) -> get() -> toArray();
        return $menu;
    }

    /**获取所有的菜单
     * @param bool $isToArray 是否转为数组 默认是true
     * @return mixed
     */
    public static function getAllMenu($isToArray = true,$isPage = false,$pageSize = 6,$sort = true)
    {
        $pageSize = empty($pageSize)?6:$pageSize;
       if($isToArray && $sort == true){
           $menus = self::orderBy('path','asc') ->get() -> toArray();
       }elseif($isPage == true && $pageSize){
           $menus = self::paginate($pageSize);
       }elseif($sort == false && $isToArray == true){
            $menus = self::get() -> toArray();
       }
       return $menus;
    }

    /**根据当前uri获取当前的menuId
     * @param $uri uri
     * @return mixed
     */
    public static function getMenuIdForNow($uri)
    {
        $nowMenuId = self::where(['menu_url'=>$uri]) -> first(['menu_id']) -> toArray();
        return $nowMenuId;
    }

    public static function getMenuByParentId($parentId,$isToArray = true)
    {
        self::insert() -> after();
        $menuId = self::where(['menu_id' => $parentId]) -> get(['menu_id']);
        if($isToArray){
            $menuId = $menuId -> toArray();
        }
        return $menuId;
    }

    /**通过menuId查找菜单
     * @param $menuId
     * @return mixed
     */
    public static function getMenuById($menuId){
        $menu = self::find($menuId);
        return $menu;
    }
    public function insertMenu($formInfo)
    {
        DB::beginTransaction();
        try{
            $menuId = self::insertGetId($formInfo);
            $path = ['path'=> $formInfo['path'] . '-' . $menuId];
            $UpdateForPath = self::where(['menu_id' => $menuId]) -> update($path);
            if($menuId && $UpdateForPath){
                DB::commit();
                return true;
            }else{
                DB::rollBack();
                return false;
            }
        }catch (\Exception $e){

            Log::error($e -> getMessage());
            DB::rollBack();
            return false;
        }
    }
    public static function updateMenu($formInfo,$menuId)
    {
        DB::beginTransaction();
        try{
            $resultForUpdate = self::find($menuId) -> update($formInfo);
            $path = ['path'=> $formInfo['path'] . '-' . $menuId];
            $UpdateForPath = self::where(['menu_id' => $menuId]) -> update($path);
            if($UpdateForPath && $UpdateForPath){
                DB::commit();
                return true;
            }else{
                DB::rollBack();
                return false;
            }
        }catch (\Exception $e){
            dd($e -> getMessage());
            Log::error($e -> getMessage());
            DB::rollBack();
            return false;
        }
    }
}