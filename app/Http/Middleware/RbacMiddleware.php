<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\AdminService;
use phpDocumentor\Reflection\Location;

class RbacMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd($request);
        $menus = session('menu');
        $url = empty($menus)?[]:array_column($menus,'menu_url');
        $menus['urls'] = $menus['urls'] == null?[]:$menus['urls'];
        $url = array_merge($url,$menus['urls']);
//        dd($menus);
        unset($menus['urls']);
        $menuses = AdminService::tree($menus,'menu_id');
        config(['adminlte.menu'=>$menuses]);
        $uri = $request -> path();
        $result = session('admin_login');
//        return $next($request);
        if ((!empty($url) && in_array($uri,$url )) || $result['admin_type'] == 1)
        {
//            echo "您没有权限！";die;
            return $next($request);
        }
        echo "<script>alert('您没有权限')</script>";
        if($result){
            return redirect('admin/index');
        }else{
//            return header('url=//www.larval.com/admin/login');
            return redirect('admin/login');
        }

    }
}
