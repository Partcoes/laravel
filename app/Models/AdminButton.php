<?php
/**
 * Created by PhpStorm.
 * User: 青彦
 * Date: 2018/10/17
 * Time: 9:27
 */

namespace App\Models;

//use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminButton extends Model
{
    protected $table = 'Admin_button';
    protected $primaryKey = 'button_id';
    protected $guarded = [];
    public $timestamps = false;

    /**
     * @param $button_id 对应的button数组
     * @return mixed
     */
    public static function reIdGetButton($button_id)
    {
        $button = self::whereIn('button_id' , $button_id) -> get() -> toArray();
//        echo 1;die;
        return $button;
    }

    /**\
     * @return mixed 所有的button
     */
    public static function getAllButton($isPage = false)
    {
        if($isPage == false){
            $buttons = self::get() -> toArray();
        }elseif($isPage == true){
            $buttons = self::paginate(6);
        }
        return $buttons;
    }

    public static function getAllButtonAndMenu()
    {
        //要查询的字段
        $column = [
            'button_id',
            'button_name',
            'class',
            'admin_button.menu_id',
            'menu_name'
        ];
        $buttons =  self::join('admin_menu','admin_button.menu_id','=','admin_menu.menu_id') -> orderBy('admin_button.menu_id','asc') -> paginate(6);
        return $buttons;
    }
    public static function getButtonHad($menuId)
    {
        $buttons = self::where(['menu_id'=>$menuId]) -> get();
        return $buttons;
    }

    public static function insertButton($formInfo)
    {
        $result = self::insert($formInfo);
        return $result;
    }

    public static function deleteButtonById($buttonId)
    {
        $result = self::find($buttonId) -> delete();
        return $result;
    }

    public static function getButton($buttonId)
    {
        $button = self::find($buttonId);
        return $button;
    }
    public static function updateButton($formInfo,$buttonId)
    {
        $result = self::find($buttonId) -> update($formInfo);
        return $result;
    }
}