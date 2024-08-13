<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>API View</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center">
                <h1>
                    API 狀態
                </h1>
            </div>
            
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">API 名稱</th>
                        <th scope="col">傳入值</th>
                        <th scope="col">狀態</th>
                        <th scope="col">訊息</th>
                        <th scope="col">建立時間</th>
                        <th scope="col">更新時間</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $datas)
                        <tr>
                            <th scope="row"> {{ $datas->id }}</th>
                            <td>{{ $datas->name }}</td>
                            <td>{{ $datas->input_data }}</td>
                            <td>{{ $datas->status }}</td>
                            <td>{{ $datas->message }}</td>
                            <td>{{ $datas->created_at }}</td>
                            <td>{{ $datas->updated_at }}</td>
                            <td>
                                @if($datas->status && $datas->name == "cre_order" )
                                    <button onclick="cre_order({{ $datas->input_data }})">
                                        更新
                                    </button>
                                @endif
                                @if($datas->status && $datas->name == "cre_member" )
                                    <button onclick="cre_member({{ $datas->input_data }})">
                                        更新
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        共:{{ $data->total() }}
                        <button onclick="get_stock('max=3500&mix=3000')">
                            庫存同步max=3500&mix=3000
                        </button>

                        <button onclick="get_stock('max=3000&mix=2500')">
                            庫存同步max=3000&mix=2500
                        </button>

                        <button onclick="get_stock('max=2500&mix=2000')">
                            庫存同步max=2500&mix=2000
                        </button>

                        <button onclick="get_stock('max=2000&mix=1500')">
                            庫存同步max=2000&mix=1500
                        </button>

                        <button onclick="get_stock('max=1500&mix=1000')">
                            庫存同步max=1500&mix=1000
                        </button>

                        <button onclick="get_stock('max=1000&mix=500')">
                            庫存同步max=1000&mix=500
                        </button>

                        <button onclick="get_stock('max=500&mix=1')">
                            庫存同步max=500&mix=1
                        </button> 
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="/remaapi/api_view?page={{ $data->hasMorePages() }}">回第一頁</a></li>
                        <li class="page-item"><a class="page-link" href="{{ $data->previousPageUrl() }}">上一頁</a></li>                   
                        @if($data->currentPage() != 1)
                            <li class="page-item"><a class="page-link" href="/remaapi/api_view?page={{ $data->currentPage()-1 }}">{{ $data->currentPage()-1 }}</a></li>
                        @endif
                            <li class="page-item active"><a class="page-link" href="/remaapi/api_view?page={{ $data->currentPage() }}">{{ $data->currentPage() }}</a></li>
                        @if($data->currentPage() != $data->lastPage())
                            <li class="page-item"><a class="page-link" href="/remaapi/api_view?page={{ $data->currentPage()+1 }}">{{ $data->currentPage()+1 }}</a></li>
                        @endif
                        <li class="page-item"><a class="page-link" href="{{ $data->nextPageUrl() }}">下一頁</a></li>
                        <li class="page-item"><a class="page-link" href="/remaapi/api_view?page={{ $data->lastPage() }}">最後一頁</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </body>
    <script>
        function cre_order(status = ""){
            let url = "http://new.rema-sports.com/remaapi/cre_order?orderid="+status;
            $.ajax({ 
                type:"get",
                url:url, 
                success: function(data){
                    alert("完成");
                },
                complete:function(){},
                error:function(){}
            });
        }
        function cre_member(status = ""){
            let url = "http://new.rema-sports.com/remaapi/cre_member_one?orderid="+status;
            $.ajax({ 
                type:"get",
                url:url, 
                success: function(data){
                    alert("完成");
                },
                complete:function(){},
                error:function(){}
            });
        }
        function get_stock(data){
            window.open('http://new.rema-sports.com/remaapi/get_stock?'+data);
        }
    </script>
</html>
