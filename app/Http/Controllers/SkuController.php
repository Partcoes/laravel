<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkuController extends Controller
{
    public function insertSku(Request $request)
    {
        $formInfo = $request -> except('_token');
        if($formInfo){
            dd($formInfo);
        }
        return view('sku.insert_sku');
    }
}
