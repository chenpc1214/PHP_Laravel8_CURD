<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;


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
    return view('welcome');
});

Route::get('/home',function(){
    echo"this is my homepage";
});

//---------------------------------將參數經過middle(中介層)------------------------------------------------------------

Route::get('/about',function(){        

    return view('about');

})->middleware('check');   //打過來的check參數


//---------------------------------路由中拿取資料庫模型(方法一)--------------------------------------------------------------


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users = User::all();                                          //在路由中拿取資料庫模型
    return view('dashboard' , compact('users'));                   //用compact()傳送到前端網頁，compact中的不用有$    
})->name('dashboard');

//------------------------------路由中拿取資料庫模型(方法二)--------------------------------------

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users = DB::table('users')->get();                            //在路由中拿取資料庫模型
    return view('dashboard' , compact('users'));                   //用compact()傳送到前端網頁，compact中的不用有$    
})->name('dashboard');*/


//-----------------------------category_連結------------------------------------------------------

Route::get('/category/all',[CategoryController::class ,'AllCat']) ->name('all.category');          //獲取整筆資料
Route::post('/category/add',[CategoryController::class ,'AddCat']) ->name('store.category');       //添加一筆資料

Route::get('/category/edit/{id}',[CategoryController::class,'Edit']);                              //編輯一筆資料的頁面
Route::post('/category/update/{id}',[CategoryController::class,'Update']);                         //更新一筆資料的按鈕

Route::get('/softdelete/category/delete/{id}',[CategoryController::class,'SoftDeleted']);         //刪除一筆資料
Route::get('/category/restore/{id}',[CategoryController::class,'Restore']);                      //回復一筆資料
Route::get('/hardelete/category/restore/{id}',[CategoryController::class,'HarDeleted']);        //永久刪除

//------------------------------brand---------------------------------------------------------------

Route::get('/brand/all',[BrandController::class ,'AllBrand']) ->name('all.brand');
Route::post('/brand/add',[BrandController::class ,'StoreBrand']) ->name('store.brand');       //添加圖片

Route::get('/brand/edit/{id}',[BrandController::class,'Edit']);                              //編輯一筆資料的頁面
Route::post('/brand/update/{id}',[BrandController::class,'Update']);                         //更新一筆資料的按鈕

Route::get('/brand/delete/{id}',[BrandController::class,'Deleted']);                         //刪除一筆資料

//------------------------------批次上傳圖檔-------------------------------------------------------------------

Route::get('/multi/image',[BrandController::class ,'Multpic']) ->name('multi.image');       
Route::post('/multi/add',[BrandController::class ,'StoreImg']) ->name('store.image');



Route::get('/', function () {
    return view('welcome');
});

