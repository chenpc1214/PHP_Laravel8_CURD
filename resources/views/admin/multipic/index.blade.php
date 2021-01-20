<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            全部圖片<b></b>

        </h2>
    </x-slot>

    <!--<div class="py-12">
   <div class="container">
    <div class="row">

    <div class="col-md-8">
      <div class="card-group">
      @foreach($images as $multi)

      <div class="col-md-4 mt-5">
            <div class="card">

                <img src="{{ asset($multi->image) }}" alt="">
            
            </div>
        </div>

      @endforeach
      </div>
    
    </div>-->

    <div class="container">
        <div class="row">
        <div class="col-md-8 mt-5">

        <div class="card-group">
        @foreach($images as $multi)
        
        <div class="col-md-4 mt-5">
            <div class="card">

                <img src="{{asset($multi->image)}}" alt="">
            
            </div>
        </div>

        @endforeach

        </div>
        

        </div>

        <div class="col-md-4 mt-5">
        <div class="card">
            <div class="card-header">全部圖片</div>
        </div>

        <form action="{{route('store.image')}}" method="POST" enctype="multipart/form-data">             <!--要進行資料驗證，必先傳送，傳送就要加上這一行-->
        @csrf   

            <div class="form-group">
                <label for="exampleInputEmail1">檔案名稱</label>
                <input type="file" name="image[]" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" multiple="">
                                                                            <!--要批次必須把name設成陣列，並偽標籤加上multiple屬性-->
                
                @error('image')                                            <!--顯示錯誤訊息，$message是系統自己的-->
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