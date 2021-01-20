<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            全部商品<b></b>

        </h2>
        

    </x-slot>

    <div class="container">
        <div class="row">
        <div class="col-md-8 mt-5">
        <div class="card">

            @if(session('success'))          <!--後端有新增成功，代表session會出現後端自行所設置的'success'訊息-->

            <div class="alert alert-success" role="alert">{{session('success')}}</div>

            @endif

            <div class="card-header">全部商品</div>

        </div>
        
        
        <table class="table">

        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">商品名稱</th>
            <th scope="col">使用者ID</th>
            <th scope="col">使用者名稱</th>
            <th scope="col">創建時間</th>
            <th scope="col">編輯/刪除</th>
            </tr>
        </thead>

        

        <tbody>


        <!--@php($i=1)-->
        @foreach($categories as $category)

            <tr>
            <th scope="row">{{$categories->firstItem()+$loop->index}}</th>   <!-- 獲取結果集中第一條數據的結果編號，分頁後繼續迭代-->
            <td>{{$category->category_name}}</td>
            <td>{{$category->user_id}}</td>
            <td>{{$category->user->name}}</td>                              <!--在Category Model資料庫中打造1對1關係
                                                                                 會依循資料庫中categories表單的user_id
                                                                                去對應user資料庫中的user表單-->

            <td>
                @if($category->created_at==NULL)                       <!--這邊會這樣用是因為diffForHumans()不接受null數值-->
                <span class="text-danger">無資料</span>

                @else
                {{Carbon\Carbon::parse($category->created_at)->diffForHumans()}}   <!--與上方不同的是這邊使用，顯示資料方式(二)
                                                                                   是用query builder方式和資料方式(三)，資料型態是string，但diffForHumans()
                                                                                   不接受字串所以要用Carbon\Carbon::parse-->

                @endif
            </td>

            <td>
                <a href="{{url('/category/edit/'.$category->id)}}"><button type="button" class="btn btn-success">編輯</button></a>
                <a href="{{url('/softdelete/category/delete/'.$category->id)}}"><button type="button" class="btn btn-danger">刪除</button></a>
            </td>

            </tr>

        @endforeach

        </tbody>

        </table>
        {{$categories->links()}}                                                <!--自動判斷是否需要生成頁面頁數選項-->

        </div>

        <div class="col-md-4 mt-5">
        <div class="card">
            <div class="card-header">全部商品</div>
        </div>

        <form action="{{ route('store.category') }}" method="POST">             <!--要進行資料驗證，必先傳送，傳送就要加上這一行-->
        @csrf                                                                   <!--laravel有設定csrf-->
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">商品名稱</label>
                <input type="text" name="category_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                
            <button type="submit" class="btn btn-primary mt-3">加入商品</button>

            @error('category_name')                                            <!--顯示錯誤訊息，$message是系統自己的-->
                <span class="text-danger">{{$message}}</span>
             @enderror

        </form>

        </div>

        </div>


    </div>

    <!--垃圾桶-->

    <div class="container">
        <div class="row">
        <div class="col-md-8 mt-5">
        <div class="card">

            
            <div class="card-header">垃圾桶</div>

        </div>
        
        
        <table class="table">

        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">商品名稱</th>
            <th scope="col">使用者ID</th>
            <th scope="col">使用者名稱</th>
            <th scope="col">創建時間</th>
            <th scope="col">編輯/刪除</th>
            </tr>
        </thead>

        

        <tbody>


        <!--@php($i=1)-->
        @foreach($trash as $category)

            <tr>
            <th scope="row">{{$categories->firstItem()+$loop->index}}</th>   <!-- 獲取結果集中第一條數據的結果編號，分頁後繼續迭代-->
            <td>{{$category->category_name}}</td>
            <td>{{$category->user_id}}</td>
            <td>{{$category->user->name}}</td>                              <!--在Category Model資料庫中打造1對1關係
                                                                                 會依循資料庫中categories表單的user_id
                                                                                去對應user資料庫中的user表單-->

            <td>
                @if($category->created_at==NULL)                       <!--這邊會這樣用是因為diffForHumans()不接受null數值-->
                <span class="text-danger">無資料</span>

                @else
                {{Carbon\Carbon::parse($category->created_at)->diffForHumans()}}   <!--與上方不同的是這邊使用，顯示資料方式(二)
                                                                                   是用query builder方式和資料方式(三)，資料型態是string，但diffForHumans()
                                                                                   不接受字串所以要用Carbon\Carbon::parse-->

                @endif
            </td>

            <td>
                <a href="{{url('/category/restore/'.$category->id)}}"><button type="button" class="btn btn-info">復原</button></a>
                <a href="{{url('/hardelete/category/restore/'.$category->id)}}"><button type="button" class="btn btn-warning">永久刪除</button></a>
            </td>

            </tr>
            
        @endforeach

        </tbody>

        </table>
        {{$trash->links()}}                                                <!--自動判斷是否需要生成頁面頁數選項-->

        </div>

        <div class="col-md-4 mt-5">
        

        </div>

        </div>


    </div>

</x-app-layout>