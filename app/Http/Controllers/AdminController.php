<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * 后台登录
     */
    public function login(Request $request)
    {
        if ($request -> input())
        {
            $result = UserService::userVerify($request);
            if (is_array($result)){
                session(['admin_login'=>$result]);
                echo "<script>alert('登录成功！')</script>";
                return redirect('admin/index');
            }
        }
        return view('admin.login');
    }

    /**
     * 后台管理的首页
     */
    public function index()
    {
        $user = session('admin_login');
        if (!$user){
            return redirect('admin/login');
        }
        dd(\Route::current());
//        config(['adminlte.menu'=>$menu]);
//        dd(config('adminlte'));
        return view('admin/index',['user'=>$user]);
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session() -> forget('admin_login');
        return redirect('admin/login');
    }
}
