<?php

namespace App\Http\Controllers;

use App\Services\IndexService;
use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;
use App\Models\Type;
class TypeController extends Controller
{
    public function getTypeList(Request $request)
    {
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttons = AdminButton::getButtonHad($menuId);
        $buttons = AdminService::dealButton($buttons);
        $typeList = IndexService::getTypeList();
        return view('type.type_list',['alones' => $buttons['alone'],'buttons' => $buttons['group'],'types' => $typeList]);
    }
}
