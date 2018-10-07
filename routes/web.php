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

Route::get('/', function () {
    return view('index.index');
});
Route::get('welcome/test','WelcomeController@test');
Route::resource('Welcome','WelcomeController');
// Route::resource('User','UserController');
/**
 * 这是一个控制器对应多个方法的路由
 */
// Route::get('User/{action}', function(App\Http\Controllers\UserController $index, $action){
//     return $index->$action();
// });
Route::get('User/memberlogin',['as' => 'login','uses' => 'UserController@memberLogin']);
Route::post('User/memberlogin',['as' => 'login','uses' => 'UserController@memberLogin']);
Route::get('User/register',['as' => 'register','uses' => 'UserController@memberRegister']);
Route::post('User/register',['as' => 'register','uses' => 'UserController@memberRegister']);
Route::get('User/regtel',['as'=>'regtel','uses'=>'UserController@memberRegisterByMobile']);
Route::post('User/regtel',['as'=>'regtel','uses'=>'UserController@memberRegisterByMobile']);
/**
 * 这是首页控制器的路由
 */
Route::resource('Index','IndexController');
Route::get('Index/getdetailbyid/id/{id?}','IndexController@getdetailbyid');
Route::resource('Cart','CartController');

