<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ClassType;
use App\Models\Goods;
use App\Models\GoodsAttr;
use App\Services\TypeService;
use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;

class GoodsController extends Controller
{
    /**商品列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getGoodsList(Request $request)
    {
        $goodsList = Goods::getGoodsList();
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        return view('goods.goods_list',['goods' => $goodsList,'alones' => $buttons['alone'],'buttons' => $buttons['group']]);
    }

    public function insertGoods(Request $request)
    {
        if($request -> except('_token')){
            $formInfo = $request -> except('_token');
            $result = TypeService::insertGoods($formInfo);
            if($result){
                return redirect('sku/insert');
            }
//            dd($result);
//            dd($request -> file('photo_src'));
        }
        $brands = Brand::getBrandList(1,false);
        $classes = ClassType::getClassesList(false,false);
        return view('goods.insert_goods',['classes' => $classes,'brands' => $brands]);
    }


}
