<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CartController extends Controller
{
	/**
	 * [show 购物车列表展示]
	 * @return [type] [description]
	 */
    public function show()
    {

    	return view('cart.cart_list');
    }
}
