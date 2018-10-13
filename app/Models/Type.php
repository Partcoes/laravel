<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';
    protected $primaryKey = 'type_id';
    /**
     * 获取侧边栏分类信息
     * @return 返回关联查询到的数据 否则返回false
     */
    public static function getTypeOfInfo()
    {
        return self::all() -> toArray();
    }
}
