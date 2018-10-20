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
Route::get('index/index',['uses'=>'IndexController@index']);
Route::get('index/show/{id?}',['uses'=>'IndexController@show']);
Route::get('user/logout',['uses'=>'UserController@logout']);
Route::get('index/getdetailbyid/{id?}','IndexController@getdetailbyid');
Route::resource('cart','CartController');

//namespace 是你控制器命名空间的前缀
//Route::group(['middleware' => ['test'], ['namespace' => 'AdminUser']], function () {
//通过中间件的方式写路由，以分组的形式
Route::get('admin/login',['uses'=>'AdminController@login']);
Route::post('admin/login',['uses'=>'AdminController@login']);
Route::get('admin/logout',['uses'=>'AdminController@logout']);
Route::get('admin/upcache',['uses' => 'AdminController@updateCache']);
Route::group(['middleware' => ['rbac']], function () {
    Route::get('admin/index',['uses'=>'AdminController@index']);
    Route::get('order/show',['uses'=>'OrderController@show']);
    Route::get('order/index',['uses'=> 'OrderController@index']);
    Route::get('admin/manager',['as'=>'manager','uses'=>'AdminController@getAdminList']);
    Route::get('admin/detail/{id?}',['as'=>'detail','uses'=>'AdminController@adminDetail']);
    Route::get('admin/remove/{id?}',['as'=>'delete','uses'=>'AdminController@deleteAdminById']);
    Route::get('admin/insert',['as'=>'admin.insert','uses'=>'AdminController@insertAdmin']);
    Route::post('admin/insert',['as'=>'admin.insert','uses'=>'AdminController@insertAdmin']);
    Route::get('admin/update',['uses' => 'AdminController@updateAdminById']);
    Route::post('admin/update',['uses' => 'AdminController@updateAdminById']);
    Route::get('role/manager',['as'=>'role.manager','uses'=>'RoleController@getRoleList']);
    Route::get('role/add',['uses'=>'RoleController@insertRole']);
    Route::post('role/add',['uses'=>'RoleController@insertRole']);
    Route::get('role/remove',['uses'=>'RoleController@deleteRoleById']);
    Route::get('role/update',['uses'=>'RoleController@updateRoleById']);
    Route::post('role/update',['uses'=>'RoleController@updateRoleById']);
    Route::get('role/give',['uses' => 'RoleController@givePowerForRole']);
    Route::post('role/give',['uses' => 'RoleController@givePowerForRole']);
    Route::get('menu/add',['uses'=>'MenuController@insertMenu']);
    Route::post('menu/add',['uses'=>'MenuController@insertMenu']);
    Route::post('menu/update',['uses'=>'MenuController@updateMenuById']);
    Route::get('menu/remove',['uses'=>'MenuController@updateMenuById']);
    Route::get('menu/update',['uses'=>'MenuController@updateMenuById']);
    Route::get('menu/manager',['uses'=>'MenuController@getMenuList']);
});

