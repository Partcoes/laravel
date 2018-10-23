<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;

class GoodsController extends Controller
{
    public function getGoodsList(Request $request)
    {
        $goodsList = Goods::getGoodsList();
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        return view('goods.goods_list',['goods' => $goodsList,'alones' => $buttons['alone'],'buttons' => $buttons['group']]);
    }
}
