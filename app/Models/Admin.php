<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin_user';
    protected  $primaryKey = 'admin_id';

    public static function loginForAdmin($userInfo,$status = 1)
    {
        $userInfo['admin_status'] = $status;
        $result = self::where($userInfo) -> first();
        if ($result) {
            $result = $result -> toArray();
            return $result;
        }
        return false;
    }
}
