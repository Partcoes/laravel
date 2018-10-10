<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Service\UserService;
use App\Models\Login;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmail;
use Zhuzhichao\IpLocationZh\Ip;

class UserController extends Controller
{

    // protected function validateLogin(Request $request){
    //     $this->validate($request, [
    //         $this->loginUsername() => 'required',
    //         'password' => 'required',
    //         'captcha' => 'required|captcha',
    //     ],[
    //         'captcha.required' => trans('validation.required'),
    //         'captcha.captcha' => trans('validation.captcha'),
    //     ]);
    // }


	/**
	 * [memberLogin 前台用户登录的方法]
	 * @return [type] [description]
	 */
    public function memberLogin(Request $request)
    {
        $userinfo = Input::except('_token');
        if ($userinfo) {
            $rule = [
                    'validate'=>'required|captcha',
                    'acount'=>'required',
                    'password'=>'required'
                    ];
            $message = [
                    'validate.required'=>'验证码不为空！',
                    'validate.captcha'=>'验证码不正确！',
                    'acount.required'=>'手机号或邮箱不能为空！',
                    'password.required'=>'密码不能为空！'
                ];
            $vail = Validator::make($userinfo,$rule,$message);
            if ($vail -> passes()) {
                $res = Login::memeberLogin($userinfo,$request);
                if ($res) {
                    foreach ($res as $k => $v) {
                        if (!empty($v)) {
                            $user = $v;
                        }
                    }
                    unset($res);
                    session(['login'=>$user]);
                    return redirect('Index');
                }                
            }else{
                return back() -> withErrors($vail);
            }
            
        }
    	return view('user.member_login');
    }

    /**
     * [memberRegister 前台用户注册的方法]
     * @return [type] [post&&get]
     */
    public function memberRegister(Request $request)
    {

        $userinfo = Input::except('_token');
            if ($userinfo) {
                //数据验证规则
                $rule = [
                        'username'=>'required',
                        'password'=>'required',
                        'repassword'=>'required|same:password',
                        'email'=>'required',
                        'validate'=>'required|captcha'
                    ];
                //数据的错误提示信息
                $message = [
                        'username.required'=>'姓名不能为空！',
                        'password.required'=>'密码不能为空',
                        'repassword.required'=>'确定密码不能为空！',
                        'repassword.same'=>'两次密码不一致！',
                        'email.required'=>'邮箱不能为空',
                        'validate.required'=>'验证码不为空！',
                        'validate.captcha'=>'验证码不正确！'
                    ];
                $vail = Validator::make($userinfo,$rule,$message);
                if ($vail->passes()){
                    //删除掉确认密码不需要的字段
                    
                    unset($userinfo['validate'],$userinfo['repassword']);
                    $res = Login::memberRegister($userinfo);
                    if($res){
                        $user = Login::getEmail($res);
                        $this -> dispatch( new SendEmail($user));
                        return redirect('User/memberlogin');
                    }                   
            } else {
                //这里传入的是变量
                return back()->withErrors($vail);
            }
        }
    	return view('user.member_register');
    }

    /**
     * [memberRegisterByMobile 前台通过手机号方式注册]
     * @param  Request $request [请求实例]
     * @return [type]           [post&&get]
     */
    public function memberRegisterByMobile(Request $request)
    {
        $userinfo = Input::except('_token');
            if ($userinfo) {
                //数据验证规则
                $rule = [
                        'username'=>'required',
                        'password'=>'required',
                        'repassword'=>'required|same:password',
                        'mobile'=>'required|max:11||min:11',
                        'validate'=>'required|captcha'
                    ];
                //数据的错误提示信息
                $message = [
                        'username.required'=>'姓名不能为空！',
                        'password.required'=>'密码不能为空',
                        'repassword.required'=>'确定密码不能为空！',
                        'repassword.same'=>'两次密码不一致！',
                        'mobile.required'=>'手机号码不能为空',
                        'mobile.max'=>'手机号码不规范！',
                        'mobile.min'=>'手机号码不规范！',
                        'validate.required'=>'验证码不为空！',
                        'validate.captcha'=>'验证码不正确！'
                    ];
                $vail = Validator::make($userinfo,$rule,$message);
                if ($vail->passes()){
                    //删除掉确认密码不需要的字段
                    unset($userinfo['validate'],$userinfo['repassword']);
                    $res = Login::memberRegister($userinfo);
                    if($res){
                        return redirect('User/memberlogin');
                    }                   
            } else {
                //这里传入的是变量
                return back()->withErrors($vail);
            }
        }
        return view('user.member_register_mobile');
    }

    /**
     * [logout 退出方法]
     * @return [type] [点击退出则清空登录的session并返回首页]
     */
    public function logout(Request $request)
    {
        $request -> session() -> forget('login');
        return redirect('Index');
    }

}
