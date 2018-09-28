<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
    	return view('user.member_register');
    }
}
