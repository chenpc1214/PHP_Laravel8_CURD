<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            更新商品<b></b>

        </h2>

    </x-slot>

        <div class="container">
        <div class="row">

            <div class="col-md-8 mt-5">
            <div class="card">

                @if(session('success'))          <!--後端有新增成功，代表session會出現後端自行所設置的'success'訊息-->

                <div class="alert alert-success" role="alert">{{session('success')}}</div>

                @endif

                <div class="card-header">更新商品</div>

            </div>

            

            <form action="{{ url('category/update/'.$categories->id) }}" method="POST">    <!--進入到修改頁面，後的更新按鈕-->
            @csrf                                                                        <!--laravel有設定csrf-->
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">商品名稱</label>
                    <input type="text" name="category_name" class="form-control" value="{{$categories->category_name}}" id="exampleInputEmail1" aria-describedby="emailHelp">
                    
                <button type="submit" class="btn btn-primary mt-3">更新</button>

                @error('category_name')                                            <!--顯示錯誤訊息，$message是系統自己的-->
                    <span class="text-danger">{{$message}}</span>
                @enderror

            </form>

            </div>

        </div>
        </div>
        

        


</x-app-layout>