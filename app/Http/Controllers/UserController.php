<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{

	/**
	 * [memberLogin 前台用户登录的方法]
	 * @return [type] [description]
	 */
    public function memberLogin()
    {
    	return view('user.member_login');
    }

    /**
     * [memberRegister 前台用户注册的方法]
     * @return [type] [description]
     */
    public function memberRegister()
    {
        $userinfo = Input::post();
        if ($userinfo) {
            dd($userinfo);
        }
    	return view('user.member_register');
    }
}
