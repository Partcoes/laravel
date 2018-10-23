<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminButton;
use App\Models\AdminMenu;
use App\Services\AdminService;

class ButtonController extends Controller
{
    public function getButtonList(Request $request)
    {
        $buttons = AdminButton::getAllButtonAndMenu();
        $menuUri = $request -> path();
        $menuId = AdminMenu::getMenuIdForNow($menuUri);
        $buttonGroup = AdminButton::getButtonHad($menuId);
        $buttonsGroup = AdminService::dealButton($buttonGroup);
//        dd($buttonsGroup);
        return view('button.button_list',['buttons' => $buttons,'groups'=>$buttonsGroup['group'],'alones' => $buttonsGroup['alone']]);
    }

    public function insertButton(Request $request)
    {
        $formInfo = $request -> input();
        $menus = AdminMenu::getAllMenu(false);
        $icons = [
            'btn-success',
            'btn-info',
            'btn-danger',
            'btn-warning',
            'btn-primary',
            'btn-default',
            'btn-bitbucket'
        ];
        if($formInfo){
           $result = AdminService::InsertButton($formInfo);
           if($result){
               return redirect('button/manager');
           }
        }
        return view('button.insert_button',['menus'=>$menus,'icons'=>$icons]);
    }

    public function deleteButtonById(Request $request)
    {
        $adminId = $request -> get('id');
        if(empty($adminId) || $request -> ajax() == false){return redirect('admin/index');}
        $result = AdminButton::deleteButtonById($adminId);
        if($result)
        {
            return  1;
        }else{
            return 0;
        }
    }
}
