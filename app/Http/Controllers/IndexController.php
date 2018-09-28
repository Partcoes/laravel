<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class IndexController extends Controller
{
    /**
     * [index 前台首页]
     * @return [type] [get]
     */
    public function index()
    {
    	dd(session('test'));return;
    	return view('index.index');
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
