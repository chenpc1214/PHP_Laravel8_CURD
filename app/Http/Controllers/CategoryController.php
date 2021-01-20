<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AllCat()                          
    {
        /*$categories=Category::all();                                     //顯示資料方式(一)
        return view('admin.category.index',compact('categories'));*/

        /*$categories= DB::table('categories')->latest()->get();          //顯示資料方式(二)
        return view('admin.category.index',compact('categories'));*/

        /*$categories= DB::table('categories')->latest()->paginate(5);          //顯示資料方式(三)，latest()是將資料表中的資料按照"created_at"
                                                                              //由最新到最舊排序
        return view('admin.category.index',compact('categories'));*/

        /*$categories=Category::latest()->paginate(5);                         //在Category Model資料庫中打造1對1關係
        return view('admin.category.index',compact('categories'));*/

        $categories=Category::latest()->paginate(5);
        $trash = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index',compact('categories','trash'));



    }


    public function AddCat(Request $request)          //前端表單是運用post方式傳來，參數就要用Request型別
    {
        $ValidateData = $request->validate([
            'category_name'=>'required|unique:categories|max:255',  //使用者填入的資料，這邊unique:categories代表此料庫，只能有這一商品
        ],

        [
            'category_name.required'=>'請輸入商品名稱',             //自訂錯誤訊息，不打算田系統會幫你用好
            'category_name.max'=>'字數必須少於255個字',
        ]);

        Category::insert([                                      //插入資料方式(一)
            'category_name'=>$request->category_name,
            'user_id'=>Auth::user()->id,
            'created_at'=>Carbon::now()
        ]);

        /*$category = new Category;                                 //插入資料方式(二)
        $category->category_name=$request->category_name;
        $category->user_id=Auth::user()->id;
        $category->save();*/

        /*$data=[];                                                 //插入資料方式(三)
        $data['category_name']=$request->category_name;
        $data['user_id']=Auth::user()->id;
        DB::table('categories')->insert($data);*/


        return redirect()->back()->with('success','成功新增一筆資料');   //成功插入資料時，會重新導向前一頁，並將'success'和
                                                                        //'成功新增一筆資料'加道session中
    }

    //----------------------------------------------------------------------------------------------------------------------

    public function Edit($id)
    {
        /*$categories=Category::find($id);*/                                   //找尋資料方式(一)
                                                                               //資料的編輯頁面，在資料表中找到從路由來的資料

        $categories=DB::table('categories')->where('id',$id)->first();        //找尋資料方式(二)query builder
        return view('admin.category.edit',compact('categories'));
    }

    public function Update(Request $request ,$id)                         //同時取得的路由參數($request)和id
    {
        /*$categories=Category::find($id)->update([                      //更新資料方式(一)
            'category_name'=>$request->category_name,               
            'user_id'=>Auth::user()->id
        ]);*/

        $data=[];                                                        //更新資料方式(一)query builder
        $data['category_name']=$request->category_name;                 
        $data['user_id']=Auth::user()->id;
        DB::table('categories')->where('id',$id)->update($data);


        return Redirect()->route('all.category')->with('success','成功更新一筆資料');
        
    }
   
    //-------------------------------------------------------------------------------------------------------------------

    public function SoftDeleted($id)
    {
        $categories=Category::find($id)->delete();
        return redirect()->back()->with('success','成功刪除一筆資料');
    }

    public function Restore($id)
    {
        $deleted = Category::withTrashed()->find($id)->restore();          //搜尋垃圾桶，withTrashed 方法， 強迫被軟刪除的模型出現在查詢結果
        return Redirect()->back()->with('success','成功救回一筆資料');    
    }

    public function HarDeleted($id)
    {
        $deleted = Category::onlyTrashed()->find($id)->forceDelete();          //搜尋垃圾桶，onlyTrashed 方法會只取得被軟刪除的模型
        return Redirect()->back()->with('success','資料永久刪除了');
    }

}