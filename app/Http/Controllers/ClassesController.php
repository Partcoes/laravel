<?php

namespace App\Http\Controllers;

use App\Services\IndexService;
use App\Services\TypeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClassType;

class ClassesController extends Controller
{
    public function getClassesList(Request $request)
    {
        $classesList = ClassType::getClassesList();
        $buttons = IndexService::getButtonsByPage($request);
        return view('classes.classes_list',['classes' => $classesList,'alones' => $buttons['alone'],'buttons' => $buttons['group']]);
    }

    public function updateClassStatus(Request $request)
    {
        if(!($request -> ajax())){
            return false;
        }
        $idAndStatus = $request -> except('_token');
        $result = ClassType::updateClassStatus($idAndStatus);
        return $result;
    }

    public function insertClass(Request $request)
    {
        if($request -> except('_token')){
            $result = TypeService::insertClass($request);
            if($result){
                return redirect('typeof/manager');
            }
        }
        return view('classes.insert_class');
    }
    public function updateClass(Request $request)
    {
        if($request -> except('_token')){
            $result = TypeService::updateClass($request);
            if($result){
                return redirect('typeof/manager');
            }
        }
        $class = ClassType::getDetail($request -> get('id'));
        return view('classes.update_class',['class'=>$class]);
    }
}
