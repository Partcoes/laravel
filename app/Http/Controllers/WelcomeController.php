<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
class WelcomeController extends Controller
{
    public function index()
    {
    	$data = DB::table('goods') -> where('good_id','<=',4) -> get();
    	return view('welcome.index',['data'=>$data]);
    }

  //   public function test()
  //   {
		// $data = DB::select("select *from goods");
  //   	return view('welcome.test',['data'=>$data]);	
  //   }
}
