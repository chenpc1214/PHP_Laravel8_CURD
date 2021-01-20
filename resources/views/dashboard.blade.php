<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            你好....<b>{{Auth::user()->name}}</b>  <!--Auth::user()代表目前登入中，在資料庫中所持有的所有資料-->

            <b style="float:right;">Total Users 
            <span class="badge bg-danger"> {{ count($users) }} </span>
            </b>

        </h2>
        

    </x-slot>

    <div class="container">

        <table class="table">

            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">E-mail</th>
                <th scope="col">create_at</th>
                </tr>
            </thead>

            <tbody>

            <!--資料庫拿資料方法(1)-->

            @php($i=1)
            @foreach($users as $user)

                <tr>
                <th scope="row">{{ $i++}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at->diffForHumans()}}</td>   <!--只想顯示時間(分)用diffForHumans()-->
                </tr>

            @endforeach

             <!--資料庫拿資料方法(2)

             @php($i=1)
            @foreach($users as $user)

                <tr>
                <th scope="row">{{ $i++}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans()}}</td>
                       //.diffForHumans 不能轉換字串，要傳字串，必須先改變型別Carbon\Carbon::parse(  )
                </tr>

            @endforeach-->

            </tbody>

        </table>

    </div>
       

        
    </div>

</x-app-layout>
