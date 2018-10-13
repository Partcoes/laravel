<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin/login', function(){
	return view('admin.login');
});

Route::get('/', 'IndexController@index');
Route::get('welcome/test','WelcomeController@test');
Route::resource('Welcome','WelcomeController');
// Route::resource('User','UserController');
/**
 * 这是一个控制器对应多个方法的路由
 */
// Route::get('User/{action}', function(App\Http\Controllers\UserController $index, $action){
//     return $index->$action();
// });
Route::get('user/memberlogin',['as' => 'login','uses' => 'UserController@memberLogin']);
Route::post('user/memberlogin',['as' => 'login','uses' => 'UserController@memberLogin']);
Route::get('user/register',['as' => 'register','uses' => 'UserController@memberRegister']);
Route::post('user/register',['as' => 'register','uses' => 'UserController@memberRegister']);
Route::get('user/regtel',['as'=>'regtel','uses'=>'UserController@memberRegisterByMobile']);
Route::post('user/regtel',['as'=>'regtel','uses'=>'UserController@memberRegisterByMobile']);
/**
 * 这是首页控制器的路由
 */
Route::resource('index','IndexController');
Route::get('user/logout',['uses'=>'UserController@logout']);
Route::get('index/getdetailbyid/id/{id?}','IndexController@getdetailbyid');
Route::resource('cart','CartController');

