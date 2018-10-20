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

class AdminButton extends Model
{
    protected $table = 'Admin_button';
    protected $primaryKey = 'button_id';

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
    public static function getAllButton()
    {
        $buttons = self::get() -> toArray();
        return $buttons;
    }

    public static function getButtonHad($menuId)
    {
        $buttons = self::where(['menu_id'=>$menuId]) -> get();
        return $buttons;
    }
}