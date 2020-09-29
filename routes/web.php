<?php
use Illuminate\Support\Facades\DB;
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
Route::get('admin/index',['uses'=>'AdminController@index']);
Route::get('admin/upcache',['uses' => 'AdminController@updateCache']);
Route::group(['middleware' => ['rbac']], function () {
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
    Route::get('role/givebtn',['uses'=> 'RoleController@givePowerForRoleByBtn']);
    Route::post('role/givebtn',['uses'=> 'RoleController@givePowerForRoleByBtn']);
    Route::get('menu/add',['uses'=>'MenuController@insertMenu']);
    Route::post('menu/add',['uses'=>'MenuController@insertMenu']);
    Route::post('menu/update',['uses'=>'MenuController@updateMenuById']);
    Route::get('menu/update',['uses'=>'MenuController@updateMenuById']);
    Route::get('menu/remove',['uses'=>'MenuController@deleteMenuById']);
    Route::get('menu/manager',['uses'=>'MenuController@getMenuList']);
    Route::get('button/manager',['uses' => 'ButtonController@getButtonList']);
    Route::get('button/add',['uses' => 'ButtonController@insertButton']);
    Route::post('button/add',['uses' => 'ButtonController@insertButton']);
    Route::match(['get','post'],'button/update',['uses'=>'ButtonController@updateButton']);
    Route::get('button/remove',['uses'=>'ButtonController@deleteButtonById']);
    Route::get('goods/manager',['uses' => 'GoodsController@getGoodsList']);
    Route::match(['get','post'],'goods/add',['uses' => 'GoodsController@insertGoods']);
    Route::get('brand/manager',['uses' => 'BrandController@getBrandList']);
    Route::get('type/manager',['uses' => 'TypeController@getTypeList']);
    Route::get('type/add',['uses' => 'TypeController@insertType']);
    Route::post('type/add',['uses' => 'TypeController@insertType']);
    Route::match(['get','post'],'type/update','TypeController@updateType');
    Route::get('typeof/manager',['uses'=>'ClassesController@getClassesList']);
    Route::match(['get','post'],'typeof/update',['uses' => 'ClassesController@updateClass']);
    Route::get('typeof/remove',['uses' => 'ClassesController@updateClassStatus']);
    Route::match(['get','post'],'typeof/add',['uses'=>'ClassesController@insertClass']);
    Route::get('attr/list',['uses' => 'AttrController@getAttrList']);
    Route::match(['get','post'],'attr/update',['uses'=>'AttrController@updateAttr']);
    Route::match(['get','post'],'attr/add','AttrController@insertAttr');
    Route::get('attr/remove',['uses'=>'AttrController@updateAttrStatus']);
    Route::get('type/remove',['uses'=>'TypeController@updateTypeStatus']);
    Route::match(['get','post'],'sku/add',['uses' => 'SkuController@insertSku']);
    Route::get('goods/child/{attr_id?}',function($id){
        $attrId = ['typeof_id' => $id];
//        dd($attrId);
        $attrInfo = \App\Models\Attribute::getAttrList($attrId,false,true);
        if ($attrInfo) {
            foreach ($attrInfo as $key => $value) {
                if ($value['attr_value']) {
                    $attrInfo[$key]['attr_value'] = explode(",",$value['attr_value']);
                }
            }
        }
        return view('goods.attr_child',['attrInfo'=>$attrInfo]);
    });
});

