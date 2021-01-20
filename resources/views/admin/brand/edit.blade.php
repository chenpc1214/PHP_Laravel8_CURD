<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            編輯圖片<b></b>

        </h2>

    </x-slot>

        <div class="container">
        <div class="row">

            <div class="col-md-8 mt-5">
            <div class="card">

                @if(session('success'))          <!--後端有新增成功，代表session會出現後端自行所設置的'success'訊息-->

                <div class="alert alert-success" role="alert">{{session('success')}}</div>

                @endif

                <div class="card-header">編輯圖片</div>

            </div>

            

            <form action="{{ url('brand/update/'.$brands->id) }}" method="POST" enctype="multipart/form-data" >    <!--進入到修改頁面，後的更新按鈕-->
            @csrf                                                                        <!--laravel有設定csrf-->

                <input type="hidden" name="old_image" value="{{$brands->bran_image}}">      <!--舊的圖片-->

                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">圖片名稱</label>
                    <input type="text" name="brand_name" class="form-control" value="{{$brands->brand_name}}" id="exampleInputEmail1" 
                    aria-describedby="emailHelp" value="{{$brands->brand_name}}">

                @error('brand_name')                                            <!--顯示錯誤訊息，$message是系統自己的-->
                    <span class="text-danger">{{$message}}</span>
                @enderror

                </div>

                <div class="form-group">

                    <label for="exampleInputEmail1" class="form-label">圖片檔案</label>
                    <input type="file" name="bran_image" class="form-control" value="{{$brands->mybran_image}}" id="exampleInputEmail1" aria-describedby="emailHelp">
                    

                @error('bran_image')                                            <!--顯示錯誤訊息，$message是系統自己的-->
                    <span class="text-danger">{{$message}}</span>
                @enderror

                </div>

                <div class="form-group">
                
                    <img src="{{asset($brands->bran_image)}}" class="mt-3" style="height:400px; width:600px; ">
                
                </div>

                <button type="submit" class="btn btn-primary mt-3">更新</button>

            </form>


            </div>

        </div>
        </div>
        

        


</x-app-layout>