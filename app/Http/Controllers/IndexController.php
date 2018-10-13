<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Services\IndexService;

class IndexController extends Controller
{
    /**
     * [index 前台首页]
     * @return [type] [get]
     */
    public function index()
    {
        $user = session('login');
        $typeAndData = IndexService::getTypeOfInfo();
    	return view('index.index',['user'=>$user,'type'=>$typeAndData,'i' =>0]);
    }

    /**
     * [show 商品列表展示]
     * @return [type] [description]
     */
    public function show()
    {

    	return view('index.show');
    }

    /**
     * [getDetailById 商品详情页]
     * @return [type] [description]
     */
    public function getDetailById(Request $request,$id)
    {
    	return view('Index.goods_detail');
    }
}
