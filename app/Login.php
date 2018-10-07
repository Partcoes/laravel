<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Service\UserService;
use Illuminate\Support\Facades\DB;
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
    public static function memeberLogin($memUserinfo)
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