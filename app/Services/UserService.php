<?php
namespace App\Services;

use App\Jobs\SendEmail;
use App\Models\Login;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

/**
 * 
 * @authors 青彦 (you@example.org)
 * @date    2018-09-29 10:20:08
 * @version $Id$
 */

class UserService {
    /**
     * [addScoreByLogin 登录增加积分]
     * @param [type] $string [description]
     */
	public static function addScoreByLogin($string)
	{
		return;
	}

	/**
	 * [addScoreByRegister 注册增加积分]
	 */
	public static function addScoreByRegister($string)
	{
		return;
	}

	public static function userVerify($request)
    {
        $userLogin = $request -> input();
        $acount = $userLogin['acount'];
        $loginInfo['password'] = self::passwordByMd5($userLogin['password']);
        $regEmail = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/';
        $regMobile = '/^((1[358][0-9])|(14[57])|(17[0678])|(19[7]))\d{8}$/';
        if (preg_match($regEmail,$acount)) {
            $loginInfo['email'] = $acount;
        }elseif(preg_match($regMobile,$acount)) {
            $loginInfo['mobile'] = $acount;
        }else{
            $loginInfo['admin_name'] = $userLogin['acount'];
        }
        $column = array_keys($loginInfo)[1];
        $rule = [
            $column=>'required',
            'password'=>'required'
        ];
        $message = [
            $column.'.required'=>'邮箱/手机号/账户不能为空！',
            'password.required'=>'密码不能为空',
        ];
        $vail = Validator::make($loginInfo,$rule,$message);
        if ($vail -> passes()) {
            $result = Admin::loginForAdmin($loginInfo);
            return $result;
        }else{
            return back() -> withErrors($vail);
        }
    }

    /**
     * 队列发送邮件的方法
     * @param $user 邮件的接受方
     * @return \Illuminate\Foundation\Bus\PendingDispatch 返回bool
     */
	public static function sendEmail($user)
    {
        return dispatch( new SendEmail($user));
    }
    public static function dealUserinfo($userinfo)
    {
        $telRule = '/^1[3578]\d{9}$/';
        $emailRule = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/';
        if (preg_match($telRule,$userinfo['acount'])){
            $userinfo['mobile'] = $userinfo['acount'];
        }elseif(preg_match($emailRule,$userinfo['acount'])){
            $userinfo['email'] = $userinfo['acount'];
        }else{
            $userinfo['username'] = $userinfo['acount'];
        }
        unset($userinfo['acount']);
        $userinfo['password'] = self::passwordByMd5($userinfo['password']);
        return Login::memeberLogin($userinfo);
    }
    /**
     * [passwordByMd5 密码加密的方法]
     * @return [type] [字符串为空则返回false 不为空返回加密后的字符串]
     */
    public static function passwordByMd5($password = "")
    {
    	if (!empty($password)) {
    		return md5($password);
    	}
    	return false;
    }

    /**
     * 加密算法
     * @param $str 加密的字符串
     * @param $key 加密需要的秘钥
     * @return string 返回加密后的字符串
     */
    public static function base63_encode($str, $key){
        $block = mcrypt_get_block_size('des', 'nofb');
        // echo $block;die;
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        $enc_str = mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
        return base64_encode($enc_str);
    }

    /**
     * @param $str 解密的字符串
     * @param $key 解密需要的秘钥
     * @return bool|string 如果解密失败返回bool false 成功返回解密后的字符串
     */
    public static function base63_decode($str, $key){
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        return substr($str, 0, strlen($str) - $pad);
    }        

}