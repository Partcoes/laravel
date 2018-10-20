<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show()
    {
        $userInfo = session('admin_login');
        return view('order.show',['user' => $userInfo]);
    }
    public function index()
    {
        echo 2;die;
    }
}
