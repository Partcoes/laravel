<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;
use App\Models\Brand;

class BrandController extends Controller
{
    public function getBrandList(Request $request)
    {
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        $brandList = Brand::getBrandList();
        return view('brand.brand_list',['brands' => $brandList,'alones' => $buttons['alone'],'buttons' => $buttons['group']]);
    }
}
