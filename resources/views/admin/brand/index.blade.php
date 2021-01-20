<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            全部圖片<b></b>

        </h2>
        

    </x-slot>

    <div class="container">
        <div class="row">
        <div class="col-md-8 mt-5">
        <div class="card">

            @if(session('success'))          <!--後端有新增成功，代表session會出現後端自行所設置的'success'訊息-->

            <div class="alert alert-success" role="alert">{{session('success')}}</div>

            @endif

            <div class="card-header">全部圖片</div>

        </div>
        
        
        <table class="table">

        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">圖片名稱</th>
            <th scope="col">圖示</th>
            <th scope="col">創建時間</th>
            <th scope="col">編輯/刪除</th>
            </tr>
        </thead>

        

        <tbody>


        <!--@php($i=1)-->
        @foreach($brands as $brand)

            <tr>
            <th scope="row">{{$brands->firstItem()+$loop->index}}</th>   <!-- 獲取結果集中第一條數據的結果編號，分頁後繼續迭代-->
            <td>{{ $brand->brand_name }}</td>
            <td><img src="{{asset($brand->bran_image)}}" style="height:40px; width:70px;"></td>       <!--asset()是靜態配置-->                                                         
            <td>
                @if($brand->created_at==NULL)                       <!--這邊會這樣用是因為diffForHumans()不接受null數值-->
                <span class="text-danger">無資料</span>

                @else
                {{Carbon\Carbon::parse($brand->created_at)->diffForHumans()}}   <!--與上方不同的是這邊使用，顯示資料方式(二)
                                                                                   是用query builder方式和資料方式(三)，資料型態是string，但diffForHumans()
                                                                                   不接受字串所以要用Carbon\Carbon::parse-->

                @endif
            </td>

            <td>
                <a href="{{url('brand/edit/'.$brand->id)}}"><button type="button" class="btn btn-success">編輯</button></a>
                <a href="{{url('brand/delete/'.$brand->id)}}"><button type="button" class="btn btn-danger" onclick="return confirm('確定要刪除?')">刪除</button></a>
            </td>

            </tr>

        @endforeach

        </tbody>

        </table>
        {{$brands->links()}}

        </div>

        <div class="col-md-4 mt-5">
        <div class="card">
            <div class="card-header">新增圖片</div>
        </div>

        <form action="{{ route('store.brand') }}" method="POST" enctype="multipart/form-data">           <!--要進行資料驗證，必先傳送，傳送就要加上這一行-->
        @csrf                                                                                            <!--laravel有設定csrf-->
            <div class="form-group">

                <label for="exampleInputEmail1" class="form-label">圖片名稱</label>
                <input type="text" name="brand_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">


                @error('brand_name')                                            <!--顯示錯誤訊息，$message是系統自己的-->
                    <span class="text-danger">{{$message}}</span>
                @enderror

            </div>

            <div class="form-group">

                <label for="exampleInputEmail1" class="form-label">圖片名稱</label>
                <input type="file" name="bran_image" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">


                @error('bran_image')                                            <!--顯示錯誤訊息，$message是系統自己的-->
                    <span class="text-danger">{{$message}}</span>
                @enderror

            </div>

            <button type="submit" class="btn btn-primary mt-3">加入圖片</button>

        </form>

        </div>

        </div>


    </div>

    </div>

</x-app-layout>