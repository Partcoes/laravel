<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Zhuzhichao\IpLocationZh\Ip;
// use Illuminate\Http\Request;
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2018-09-29 10:38:06
 * @version $Id$
 */

class Login extends Model {
    
     /**
     * [$table 表名]
     * @var string
     */
    protected $table = 'username';

    /**
     * [$primaryKey 主键]
     * @var string
     */
    protected $primaryKey = 'u_id';

    /**
     * [memeberLogin 登录查询]
     * @param  [type] $memUserinfo [description]
     * @return [type]              [description]
     */
    public static function memeberLogin($memUserinfo,$request='')
    {
        $result = self::where($memUserinfo) -> first();
        if ($result) {
        	
        	$ip = isset($_SERVER['HTTP_X_NATAPP_IP'])?$_SERVER['HTTP_X_NATAPP_IP']:$_SERVER['REMOTE_ADDR'];
        	$city = Ip::find($ip);
            array_pop($city);
            array_unique($city);
            $city = implode($city);
            // var_dump($_SERVER['HTTP_USER_AGENT']);die;
            preg_match_all("#\(.*\)#U",$_SERVER['HTTP_USER_AGENT'],$match);
            $loginWay = rtrim(ltrim(isset($match[0][0])?$match[0][0]:'','('),')');
            if ($result) {
                $u_id = $result -> u_id;
            }
            $log = ['city'=>$city,'u_id'=>$u_id,'u_ip'=>$ip,'login_way'=>$loginWay,'login_time'=>date('Y-m-d H:i:s',time())];
            DB::table('userlog') -> insert($log);
        	return $result;
        }
        
    }

    /**
     * [memberRegister 前台用户邮箱注册]
     * @return [type] [description]
     */
    public static function memberRegister($memUserinfo)
    {
    	$password = UserService::passwordByMd5($memUserinfo['password']);
    	$memUserinfo['password'] = ($password != false)?$password:null;
    	$memUserinfo['register_time'] = time();
    	$result = self::insertGetId($memUserinfo);
    	return $result;
    }

    public static function getEmail($id)
    {
    	$email = self::where(['u_id'=>$id]) -> first();
    	if ($email) {
    		return $email;
    	}
    }

}