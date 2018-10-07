<?php
namespace App\Service;
/**
 * 
 * @authors Your Name (you@example.org)
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

    /**
     * [passwordByMd5 密码加密的方法]
     * @return [type] [description]
     */
    public static function passwordByMd5($password = "")
    {
    	if (!empty($password)) {
    		return md5($password);
    	}
    	return false;
    }

}