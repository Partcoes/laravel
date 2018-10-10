<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Service\UserService;
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
    public static function memeberLogin($memUserinfo,$request)
    {
    	$memUserinfo['password'] = UserService::passwordByMd5($memUserinfo['password']);
    	$memUserinfo['mobile'] = $memUserinfo['acount'];

    	$memUserinfo2['password'] = $memUserinfo['password'];
    	$memUserinfo2['email'] = $memUserinfo['acount'];
    	$memUserinfo3['password'] = $memUserinfo['password'];
    	$memUserinfo3['username'] = $memUserinfo['acount'];
    	unset($memUserinfo['acount']);
    	unset($memUserinfo2['acount']);
    	unset($memUserinfo3['acount']);
    	unset($memUserinfo['validate']);
    	// dd($memUserinfo2,$memUserinfo3,$memUserinfo);die;
    	//where中的数组是并且的关系，and
    	//涉及到手机号和账户和邮箱都可以登录所以用orWhere();
    	// DB::connection()->enableQueryLog();
        $result = self::where($memUserinfo) -> first();
        $result1 = self::where($memUserinfo2) -> first();
        $result2 = self::where($memUserinfo3) -> first();
        if ($result || $result1 || $result2) {
        	
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
            }elseif($result1){
                $u_id = $result1 -> u_id;
            }elseif($result2){
                $u_id = $result2 -> u_id;
            }
            $log = ['city'=>$city,'u_id'=>$u_id,'u_ip'=>$ip,'login_way'=>$loginWay,'login_time'=>date('Y-m-d H:i:s',time())];
            DB::table('userlog') -> insert($log);
        	return ['result'=>$result,'result1'=>$result1,'result2'=>$result2];
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