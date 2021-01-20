<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Support\Carbon;
use Image;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands= Brand::latest()->paginate(5);
        
        return view('admin.brand.index',compact('brands'));
    }

    public function StoreBrand(Request $request)
    {
        $ValidateData = $request->validate([
            'brand_name'=>'required|unique:brands|min:4',  //使用者填入的資料，這邊unique:categories代表此料庫，只能有這一商品
            'bran_image'=>'required|mimes:jpg.jpeg,png',
        ],

        [
            'brand_name.required'=>'請輸入商品名稱',             //自訂錯誤訊息，不打算田系統會幫你用好
            'bran_image.min'=>'字數必須大於4個字',
        ]);

        /*$brand_image=$request->file('bran_image');                             //file 方法取得上傳的檔案
        $name_gen = hexdec(uniqid());                                          //將產生的id，以16進位轉成10進位
        $img_ext = strtolower($brand_image->getClientOriginalExtension());   //擷取副檔名
        $img_name=$name_gen.'.'.$img_ext;                                    //圖片名+副檔名
        $up_location='image/brand/';                                         //設定圖片上傳的路徑
        $last_img = $up_location.$img_name;                                  //路徑+圖片名+副檔名
        $brand_image->move($up_location,$img_name);                          //move 方法。該方法會將檔案從暫存位置（由你的 PHP 設定來決定）
                                                                             //移動至你指定的永久保存位置，move($destinationPath, $fileName)

        Brand::insert([
            'brand_name'=>$request->brand_name,
            'bran_image'=>$last_img,
            'created_at'=>Carbon::now()
        ]);*/

        /*---------------------------使用intervention/image外掛調整圖片大小----------------------------------------------*/

        $brand_image=$request->file('bran_image');                                        //抓取檔案上傳的檔案                           
        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();         //轉換成數字id後，並加上副檔名
        Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);         //使用外掛調整圖片大小，並儲存在特定資料夾中
        $last_img='image/brand/'.$name_gen;                                                  //路徑+檔案名+副檔名

        Brand::insert([
            'brand_name'=>$request->brand_name,
            'bran_image'=>$last_img,
            'created_at'=>Carbon::now()
        ]);

        return redirect()->back()->with('success','圖片新增成功');
    }

    public function Edit($id)
    {
        $brands=Brand::find($id);
        return view( 'admin.brand.edit',compact('brands') );
    }

    public function Update(Request $request,$id)
    {
        $validatedData=$request->validate([
            'brand_name'=>'required|min:4',
        ],

        [
            'brand_name.required'=>'請輸入圖片名稱',            
            'bran_image.min'=>'字數必須4個字以上',

        ]);

        $old_image=$request->old_image;
        $brand_image=$request->file('bran_image');                          //file 方法取得上傳的檔案

        if($brand_image)
        {
            
            $name_gen = hexdec(uniqid());                                          //將產生的id，以16進位轉成10進位
            $img_ext = strtolower($brand_image->getClientOriginalExtension());   //擷取副檔名
            $img_name=$name_gen.'.'.$img_ext;                                    //圖片名+副檔名
            $up_location='image/brand/';                                         //設定圖片上傳的路徑
            $last_img = $up_location.$img_name;                                  //路徑+圖片名+副檔名
            $brand_image->move($up_location,$img_name);                          //move 方法。該方法會將檔案從暫存位置（由你的 PHP 設定來決定）
                                                                                //移動至你指定的永久保存位置，move($destinationPath, $fileName)

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name'=>$request->brand_name,
                'bran_image'=>$last_img,
                'created_at'=>Carbon::now()
            ]);

            return Redirect()->back()->with('success','圖片修改成功');
        }

        else
        {
            Brand::find($id)->update([
                'brand_name'=>$request->brand_name,
                'created_at'=>Carbon::now()
            ]);

            return Redirect()->back()->with('success','圖片修改成功');

        }
    }

    public function Deleted($id)
    {
        $image=Brand::find($id);                                            //刪除資料夾的圖片
        $old_image=$image->bran_image;
        unlink($old_image);
 
        Brand::find($id)->delete();                                        //刪除資料庫的相關資料
        return redirect()->back()->with('success','圖片刪除成功');

    }

    public function Multpic()
    {
        $images=Multipic::all();
        return view('admin.multipic.index',compact('images'));
    }

    public function StoreImg(Request $request)
    {
        $image=$request->file('image');
        foreach($image as $multi_img)
        {

            $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();         
            Image::make($multi_img)->resize(300,300)->save('image/multi/'.$name_gen);          
            $last_img='image/multi/'.$name_gen;

            Multipic::insert([
            
                'image'=>$last_img,
                'created_at'=>Carbon::now()
            ]);

        }

        return redirect()->back()->with('success','圖片新增成功');
    }
}
